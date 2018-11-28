/**
 * Creates request object
 * makes post and get request
 *
 * @param url
 * @param data
 * @constructor
 *
 */
const Request = function (url, data) {

    if (typeof url === "undefined") {
        throw new URIError("Url must be a string ( link )")
    }

    let headers = {};
    let headersPreset = null;
    let async = true;
    let sendForm = false;

    let xhr = new XMLHttpRequest();
    /**
     * Waits for server response promise
     *
     * Resolves on server responce status=successs
     * Rejects on other server response
     *
     * @type {Promise<string|object>}
     */
    let process = new Promise(function (res, rej) {

        Reject = rej;

        xhr.onreadystatechange = function () {
            if (this.readyState != XMLHttpRequest.DONE) return;

            try {

                let json = JSON.parse(this.responseText);

                if (typeof json.status != "undefined" && json.status == "success") {

                    res.apply(this, [json])

                } else {

                    rej.apply(this, [typeof json.message != "undefined" ? json.message : "Unexpected responce"])

                }

            } catch (e) {

                rej.apply(this, [e.message])

            }

        };

        xhr.onerror = function (e) {

            rej.apply(this, [e])

        }

    });

    /**
     * Serialise object to url request string
     * Used in get request
     *
     * @param obj
     * @param prefix
     * @returns {string}
     */
    let serialize = function (obj, prefix) {
        let str = [], p;

        for (p in obj) {
            if (obj.hasOwnProperty(p)) {
                let k = prefix ? prefix + "[" + p + "]" : p,
                    v = obj[p];
                str.push((v !== null && typeof v === "object") ?
                    serialize(v, k) :
                    encodeURIComponent(k) + "=" + encodeURIComponent(v));
            }
        }
        return str.join("&");
    };


    let getFormData = function (serialiseData, form, prefix) {

        form = typeof form === "undefined" ? new FormData() : form;

        for (let name in serialiseData) {

            if (serialiseData.hasOwnProperty(name)) {

                let data = serialiseData[name];
                let formName = data instanceof File ? "file"+(name) : name;
                formName = prefix ? prefix + "[" + formName + "]" : formName;

                console.log(formName);
                console.log(serialiseData[name]);


                if(
                    data instanceof FileList ||
                    (typeof data === "object" && !(data instanceof File)) ||
                    Array.isArray(data)
                ) {

                    getFormData(data,form,formName);

                }else{

                    form.append(formName, serialiseData[name]);

                }

            }

        }

        return form;

    }

    let prepareData = function (data) {

        if (typeof data !== "undefined") {

            switch (true){
                case sendForm :
                    data = typeof data === "object" ? getFormData(data) : data;
                    break;
                case is_json() :
                    data = typeof data === "object" ? JSON.stringify(data) : data;
                    break;
                case is_json() :
                    data = typeof data === "object" ? serialize(data) : data;
                    break;

            }

        } else {

            data = null;

        }

        return data;

    }

    /**
     * Sends Data
     *
     * @param json
     */
    let send = json => {

        if (headersPreset !== null) {

            if (
                typeof Request.presetHeaders !== "undefined" &&
                typeof Request.presetHeaders[headersPreset] !== "undefined"
            ) {

                this.setHeaders(Request.presetHeaders[headersPreset])

            } else {

                throw new Error("Header preset ( " + headersPreset + " ) is not defined");

            }

        }

        setHeaders();
        xhr.send(json ? json : null);

    };

    /**
     * Sets header in xhr object before request
     */
    let setHeaders = function () {

        for (let name in headers) {

            if (headers.hasOwnProperty(name)) {

                xhr.setRequestHeader(name, getStringValue(headers[name]));

            }

        }

    };

    /**
     * Get string value
     *
     * @param value
     * @returns {string}
     */
    let getStringValue = function (value) {

        return typeof value === "string" ?
            value :
            (typeof value === "function" ? getStringValue(value()) : serialize(value));

    };

    /**
     * Check if json content type presents in request headers
     *
     * @returns {boolean}
     */
    let is_json = function () {

        return (typeof headers['Content-Type'] !== 'undefined' && headers['Content-Type'].toLowerCase() === "application/json") ||
            (typeof headers['Content-type'] !== 'undefined' && headers['Content-type'].toLowerCase() === "application/json");

    };

    /**
     * Check if urlencoded content type presents in request headers
     *
     * @returns {boolean}
     */
    let is_urlEncoded = function () {

        return (typeof headers['Content-Type'] !== 'undefined' && headers['Content-Type'].toLowerCase() === "application/x-www-form-urlencoded") ||
            (typeof headers['Content-type'] !== 'undefined' && headers['Content-type'].toLowerCase() === "application/x-www-form-urlencoded");

    };

    this.onProgress = function (fn) {

        xhr.upload.onprogress = function(e) {
            if (e.lengthComputable) {
                fn((e.loaded / e.total) * 100);
            }
        };

        return this;

    }

    /**
     * Make current request async
     *
     * @returns {Request}
     */
    this.async = function () {

        async = true;

        return this;

    };

    /**
     * Make current request sync
     *
     * @returns {Request}
     */
    this.sync = function () {

        async = false;

        return this;
    };

    /**
     * Send data as form encoded
     */
    this.setFormSerialiser = function () {

        sendForm = true;

        return this;

    }

    /**
     * Set request headers
     *
     * @param newHeaders
     */
    this.setHeaders = function (newHeaders) {

        if (typeof newHeaders === "object") {

            headers = Object.assign(newHeaders, headers);

            return this;

        }

        throw new TypeError("newHeaders must be object name:value");

    };

    /**
     * Removes header
     *
     * @param name
     * @returns {Request}
     */
    this.removeHeader = function (name) {

        if (typeof name === "string") {

            if (typeof headers[name] !== "undefined") {

                delete(headers[name])

            }

            return this;

        }

        throw new TypeError("newHeaders must be object name:value");

    };

    /**
     * Sets json content type header
     *
     * @returns {Request}
     */
    this.setJsonHeaders = function () {

        this.setHeaders({
            'Content-Type': "application/json",
            'Accept': "application/json",
        });

        return this;

    };

    /**
     * Sets urlencoded content type header
     *
     * @returns {Request}
     */
    this.setUrlEncHeaders = function () {

        this.setHeaders({
            'Content-Type': "application/x-www-form-urlencoded",
        });

        return this;
    };

    /**
     * Defines headers preset
     *
     * @param name
     * @returns {Request}
     */
    this.usePreset = function (name) {

        if (typeof name === "string") {

            headersPreset = name;

            return this;

        }

        throw new TypeError("name must be a string");

    };

    /**
     * Make post request
     *
     * @returns {Promise<string|object>}
     */
    this.post = function () {

        xhr.open("POST", url, async);

        send(
            prepareData(data)
        );
        return process;

    };

    /**
     * Make delete request
     *
     * @returns {Promise<string|object>}
     */
    this.delete = function () {

        xhr.open("DELETE", url +
            (typeof data === "undefined" ? "" : "?" + serialize(data))
            , async);

        send();
        return process;

    };

    /**
     * Make get request
     *
     * @returns {Promise<string|object>}
     */
    this.get = function () {

        xhr.open("GET", url +
            (typeof data === "undefined" ? "" : "?" + serialize(data))
            , async);
        send();
        return process;

    };



};

/**
 * Presets headers to all request
 *
 * @param object
 */
Request.setPresetHeaders = function (name, object) {

    if (typeof object === 'object') {

        this.presetHeaders = typeof this.presetHeaders === "undefined" ? {} : this.presetHeaders;
        this.presetHeaders[name] = object;

    }

};

/**
 * Clear preseted headers
 *
 * @param object
 */
Request.clearPresetHeaders = function (name) {

    if (typeof name !== "undefined") {

        delete(this.presetHeaders[name]);

    }

};

module.exports = Request;