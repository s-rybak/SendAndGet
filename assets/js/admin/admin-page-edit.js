require('../../css/ckeditor_content.css');

let jQuery = require('jquery');

jQuery(function ($) {

   let editor =  CKEDITOR.replace('page_content');

    editor.config.allowedContent = true;
    editor.config.autoParagraph = false;
    editor.config.contentsCss = '/build/admin_page_edit.css';

});