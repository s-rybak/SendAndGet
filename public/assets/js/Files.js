let Files = function (Options,sse,$) {

    let Defaults = {
        upload_url:"/files/upload",
        files:[],
        field_id:generateFieldId(),
        permanent:true,
        max_files:0,
    };

    let Uploading = false;

    Options = Object.assign(Defaults,Options);

    function generateFieldId() {

        return "fid_"+((Date.now()+(Math.random())).toString(36).replace(/\./,Math.ceil(Math.random()*100)));

    }

    this.ClearFiles = function () {

        Options.files = [];

    };

    this.SelectFiles = function (multiple=false) {

        multiple = !!multiple;

        let input = document.getElementById(Options.field_id);

        if(!input){

            input = document.createElement('input');
            input.type = 'file';
            input.multiple = multiple;
            input.style.opacity = 0;
            input.style.width = "0px";
            input.style.height = "0px";
            input.style.display = 'none';
            input.id = Options.field_id;

            document.getElementsByTagName('body')[0].appendChild(input);

        }else{

            input.multiple = multiple;
            input.type = 'file';

        }

        input.value = "";
        input.click();

        return new Promise(function (resolve,rej) {

            Options.files = [];

            input.onchange = function () {

                if(input.files.length > 0){

                    Options.files = Options.max_files > 0 && input.files.length > Options.max_files ? [...input.files].slice(input.files.length - Options.max_files) : input.files;

                    resolve(input.files);

                }else{

                    rej(new Error("Nothing selected"));

                }

            };

            document.body.onfocus = function () {

                setTimeout(function () {

                    document.body.onfocus = null;

                    if(input.files.length==0){

                        rej(new Error("Nothing selected"));

                    }

                    if(!Options.permanent){
                        input.remove();
                    }

                },1000);

            };

        });

    };

    this.Upload = function () {

        return  new Promise(function (resolve,rej) {

            if(Uploading){
                rej(new Error("Wait for uploading"));
                return;
            }

            if(Options.files.length > 0){

                let files   = new Array();
                let data    = new FormData();

                Uploading = true;

                data.append('uid', sse.GetUid() );

                $.each( Options.files, function( key, value ){

                    data.append('files[]', value );

                });

                $.ajax({
                    url: Options.upload_url,
                    type: 'POST',
                    data: data,
                    cache: false,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend:function(){

                    },
                    error: function (res) {

                        rej(res);
                        Uploading = false;

                    },
                    success: function( res ){

                        setTimeout(function () { Uploading = false; },2000);

                        if(res.status == "success"){

                            resolve(res);

                        }else{ rej(res); }

                    }

                });

            }else{

                rej(new Error("Please Select Files"));

            }

        })

    }

};