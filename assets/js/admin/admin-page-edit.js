require('../../css/ckeditor_content.css');
let jQuery = require('jquery');
let Files = require('../libs/Files');
require('grapesjs/dist/css/grapes.min.css');
require('grapesjs-preset-webpage/dist/grapesjs-preset-webpage.min.css');
require('script-loader!grapesjs');
require('script-loader!grapesjs-preset-webpage');

jQuery(function ($) {

    let $submit_form = $("#submit_form");
    let $page_content = $("#page_content");
    let $page_ready_content = $("#page_ready_content");

    let Uploader = new Files({},{},$);

   let ckeEditor =  CKEDITOR.replace('page_ready_content');

    ckeEditor.config.allowedContent = true;
    ckeEditor.config.autoParagraph = false;
    ckeEditor.config.contentsCss = '/build/admin_page_edit.css';

    $page_content.html($page_content.html().replace(/\.page\-content\s?/gm,""))

    const editor = grapesjs.init({
        // Indicate where to init the editor. You can also pass an HTMLElement
        container: '#page_content',
        height: '300px',
        width: 'auto',
        fromElement: true,
        plugins: ['gjs-preset-webpage'],
        pluginsOpts: {
            'gjs-preset-webpage': {
                // options
            }
        },
        storageManager: {
            id: 'gjs-',             // Prefix identifier that will be used on parameters
            type: 'local',          // Type of the storage
            autosave: true,         // Store data automatically
            autoload: false,         // Autoload stored data on init
            stepsBeforeSave: 1,     // If autosave enabled, indicates how many changes are necessary before store method is triggered
        },
        assetManager:{
            upload:"tst",
            uploadFile:function(e){

                let files = e.dataTransfer ? e.dataTransfer.files : e.target.files;

                sagSdk.uploadFiles(files)
                    .then(function (files) {

                        $.post('/admin/file/make/site',{
                            image:files[0].hash
                        },function (resp) {

                            editor.AssetManager.add("/s/"+files[0].hash);

                        });

                    })

            }
        }
    });

    $('body').on('click','.gjs-pn-btn.fa-download',function () {

        let style = `<style>.page-content ${editor.getCss().replace(/(\*|body)\s?{(.*?)}/gm,"").replace(/\.page\-content\s?/gm,"").replace(/}([\.\#])/gm,'}.page-content $1')}</style>`;
        let js = `<script>${editor.getJs()}</script>`;
        let html = editor.getHtml();

        CKEDITOR.instances.page_ready_content.setData(style+html+js);

    });

    console.log(editor);

});