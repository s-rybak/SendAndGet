/**
 * App api object
 *
 * @constructor
 */
const Api = function (options) {

    let Opt = Object.assign({
        host: "",
        onReady: ()=>{},
        onInit: ()=>{},
        presetHeaders: {
            'Content-Type': "application/json",
            'Accept': "application/json"
        }
    }, options);

    let Cache = new AppStorage();

    Opt.onInit.apply(this,[]);

    /**
     * Makes api request
     *
     * @param request
     * @param data
     * @returns {Promise<object>}
     */
    function doRequest(request, data, cache = true) {

        if (request instanceof ApiEndpointList.Request) {

            if (request.cache > 0 && cache) {

                let result = Cache.get("cache.request."+request.name);

                if (result !== null) {
                    return Promise.resolve(JSON.parse(result));
                }

            }

            let req = new Request(Opt.host + request.url, data);

            req.setHeaders(Opt.presetHeaders);

            if (request.preset !== null) {

                req.usePreset(request.preset);

            }

            request.async && req.async() || req.sync();

            return new Promise(function (resolve, reject) {

                req[request.type.toLowerCase()]()
                    .then(async function (result) {

                        if (request.cache > 0) {

                            Cache.set("cache.request."+request.name,result,request.cache);

                        }

                        let res = await request.doProcess(result);

                        resolve(res);

                    }).catch(reject)

            })

        }

        throw new TypeError("request must be instance of ApiEndpointList.Request")

    }

    /**
     * Process endpoint list
     * Saves it to api object
     * adds some api functions
     *
     * @param list
     * @return object
     */
    function processEndpointList(list) {

        let obj = {};

        if(
            typeof list === 'object'
        ){

            for (let endpoint in list) {

                if (list.hasOwnProperty(endpoint)) {

                    if(!(list[endpoint] instanceof ApiEndpointList.Request)){

                        obj[endpoint] = processEndpointList(list[endpoint]);

                        continue;

                    }

                    obj[endpoint] = (data) => {

                        let cache = true;

                        if (
                            typeof list[endpoint].preset !== "undefined" &&
                            typeof list[endpoint].preset === "object" &&
                            list[endpoint].preset !== null
                        ) {

                            data = Object.assign(list[endpoint].preset, data)

                        }

                        if (typeof list[endpoint].cache !== "undefined") {

                            cache = list[endpoint].cache;

                        }

                        if (typeof obj[endpoint].cache !== "undefined") {

                            cache = obj[endpoint].cache;

                        }

                        return doRequest(list[endpoint].makeAsync(), data, cache )

                    };

                    obj[endpoint].presetData = function (data) {

                        if (typeof data === "object") {

                            this.preset = data;

                        }

                    };

                    obj[endpoint].setCache = function (ca) {

                        if(typeof ca === "boolean"){

                            this.cache = ca;

                        }

                    };

                    obj[endpoint].refresh = async function (data) {

                        this.cache  = false;
                        let res = await obj[endpoint](data);
                        this.cache = true;

                        return res;

                    }.bind(obj[endpoint]);

                }

            }

        }

        return obj;

    }

    /**
     * Load endpoints and aliases
     */
    for (let name in Api.endpoints) {

        this[name] = {};

        if (Api.endpoints.hasOwnProperty(name)) {

            this[name] = processEndpointList(Api.endpoints[name].List);

            /*for (let endpoint in Api.endpoints[name].List) {

                if (Api.endpoints[name].List.hasOwnProperty(endpoint)) {

                    this[name][endpoint] = (data) => {

                        let cache = true;

                        if (typeof this[name][endpoint].preset !== "undefined") {

                            data = Object.assign(this[name][endpoint].preset, data)

                        }

                        if (typeof this[name][endpoint].cache !== "undefined") {

                            cache = this[name][endpoint].cache;

                        }

                        return doRequest(Api.endpoints[name].List[endpoint].makeAsync(), data, cache )

                    };

                    this[name][endpoint].presetData = function (data) {

                        if (typeof data === "object") {

                            this.preset = data;

                        }

                    };

                    this[name][endpoint].setCache = function (ca) {

                        if(typeof ca === "boolean"){

                            this.cache = ca;

                        }

                    };

                }

            }*/

            for (let alias in Api.endpoints[name].Aliases) {

                if (Api.endpoints[name].Aliases.hasOwnProperty(alias)) {

                    let Alias = Api.endpoints[name].Aliases[alias];
                    let List = this[name];
                    let Link = this[name];
                    let propName = "";
                    let aliasPath = alias.split(".");
                    let callData = false;

                    let isCallData = function () {

                        callData = true;

                        return new Promise(function (res) {

                           setTimeout(function () {

                               res(callData);

                           },1);

                        })

                    };

                    let Getter = function () {

                        let P = new Promise(async function (res,rej) {

                            if(!(await isCallData())){
                                return "";
                            }

                            let data;
                            let cache = true;
                            let AlEndpoint = List;
                            let AlRequest = Api.endpoints[name].List;

                            Alias.endpoint.split(".").forEach(an=>{
                                AlEndpoint = AlEndpoint[an];
                                AlRequest = AlRequest[an];
                            });

                            if (
                                typeof AlEndpoint !== "undefined" &&
                                typeof AlEndpoint.preset !== "undefined"
                            ) {

                                data = AlEndpoint.preset;

                            }

                            if (
                                typeof AlEndpoint !== "undefined" &&
                                typeof AlEndpoint.cache !== "undefined"
                            ) {

                                cache = AlEndpoint.cache;

                            }
                            try{

                                let resp = await doRequest(AlRequest.makeSync(), data, cache);

                                Alias.prop.split(".").forEach(p => {
                                    resp = resp[p]
                                });

                                if(Alias.transformer instanceof Transformer){

                                    resp = Alias.transformer.setData(resp).getTransformation();

                                }

                                res(resp);

                            }catch (e){
                                rej(e);
                            }

                        });

                        P.presetData = function (data) {

                            callData = false;

                            let AlEndpoint = List;

                            Alias.endpoint.split(".").forEach(an=>{
                                AlEndpoint = AlEndpoint[an];
                            });

                            AlEndpoint.preset = data;

                        };

                        return P;

                    };

                    aliasPath.forEach((an,i)=>{

                        if(i < aliasPath.length-1){
                            Link[an] = typeof Link[an] === "undefined" ? {} : Link[an];
                            Link = Link[an];
                        }

                        propName = an;
                    });

                    Object.defineProperty(Link, propName, {
                        get: Getter
                    });

                    /*Link[propName].presetData = function (data) {

                        let AlEndpoint = List;

                        Alias.endpoint.split(".").forEach(an=>{
                            AlEndpoint = AlEndpoint[an];
                        });

                        AlEndpoint.preset = data;
                    }*/

                }

            }

        }

    }

    Opt.onReady.apply(this,[]);

};

/**
 * Endpoint list
 * List of api requests
 * Makes sync and async requests
 *
 * @param name
 * @param config
 * @constructor
 */
const ApiEndpointList = function (name, list) {

    this.name = name;
    this.List = list;
    this.Aliases = {};
    this.Process = {};

    /**
     * Adds sync request alias to request
     *
     * @param alias
     * @param endpoint
     * @param prop
     * @returns {ApiEndpointList}
     */
    this.addAlias = function (alias, endpoint, prop) {

        if (typeof alias === "string") {

            this.Aliases[alias] = {
                endpoint,
                prop: typeof prop === "string" ? prop : alias,
            };

        }

        return this;

    };

    /**
     * Add function to call after
     * process executed successful
     *
     * @param endpoint
     * @param fn
     */
    this.addProcess = function (endpoint,fn) {

        if (
            typeof endpoint === "string" &&
            typeof fn === "function"
        ) {

            let l = this.List;

            endpoint.split('.').forEach(path=>{
                l = l !== null && typeof l[path] !== "undefined" ? l[path] : null;
            });

            if(l === null){

                throw new Error(`Endpoint with path ${endpoint} not find`);

            }

            /*name = typeof name !== "undefined" ? name : endpoint;*/

            l.addProcess(fn);
        }

        return this;

    };

    /**
     * Adds transformer to alias
     * @param alias
     * @param transformer
     *
     */
    this.addTransformer = function (alias, transformer) {

        if(typeof this.Aliases[alias] === "object"){

            transformer = typeof transformer === "string" ? Transformers.get(transformer) : transformer;

            if( transformer instanceof Transformer ){

                this.Aliases[alias].transformer = transformer;

            }

        }

        return this;

    }

};

/**
 * Api request
 *
 * @constructor
 */
ApiEndpointList.Request = function (opt) {

    let config = Object.assign({
        type: "post",
        url: "",
        preset: null,
        async: true,
        cache: 0,
        name: (Date.now() * Math.random()).toString(32).replace(/\./g, "") // random hash e.g. b9vu7dtfiak
    }, opt);

    this.type = config.type;
    this.url = config.url;
    this.preset = config.preset;
    this.async = config.async;
    this.cache = config.cache;
    this.name = config.name;

    let Processes = [];

    /**
     * Add function to call after
     * request executed success
     *
     * @param fn
     */
    this.addProcess = function (fn) {

        Processes.push(fn);

    };

    /**
     * Call functions array
     *
     * @param res
     */
    this.doProcess = function (res) {

        Processes.forEach(fn=>{

            res = fn(res);

        });

        return res;

    };

    this.makeSync = function () {

        this.async = false;

        return this;

    };

    this.makeAsync = function () {

        this.async = true;

        return this;
    }


};

/**
 * Registers endpoint list
 *
 * @param endpointList
 */
Api.addApiEndpoint = function (endpointList) {

    if (
        endpointList instanceof ApiEndpointList
    ) {

        Api.endpoints = typeof Api.endpoints === "undefined" ? {} : Api.endpoints;

        if (typeof Api.endpoints[endpointList.name] === "undefined") {

            Api.endpoints[endpointList.name] = endpointList;

        } else {

            throw new Error("Trying to redefine registered endpoint list: " + endpointList.name);

        }

    }

};

module.exports = Api;
