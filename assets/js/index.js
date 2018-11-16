require('../css/main.css');
let jQuery = require('jquery');
let Files = require('./libs/Files');
let TextLoader = require('./libs/TextLoader');

jQuery(function ($) {

    let $selectFiles = $('#select-files');
    let $getFiles = $('#get-files');
    let $sectionSend = $('.section-send');
    let $sectionGet = $('.section-get');
    let $mainAnd = $('.main-and');

    let Uploader = new Files({},{},$);
    let SelectLoader = new TextLoader($selectFiles);

    $selectFiles.click(function () {

        SelectLoader.setTitle("Selecting files");
        SelectLoader.startLoading();

        Uploader.SelectFiles(true)
            .then(function (files) {

                SelectLoader.setTitle("Uploading");

                sagSdk.uploadFiles(files,function (pers) {
                    console.log(pers);
                });

                showUploadFilesSection();

            })
            .catch(function (e) {

                SelectLoader.stopLoading();
                SelectLoader.showMesage(e.message)
            });

    });

    $getFiles.click(function () {

        showGetFilesSection();

    });

    function showUploadFilesSection() {

        $mainAnd.css({opacity: 0});

        $sectionSend.addClass("col-sm-12 active");
        $sectionGet.addClass("collapsed");
        $sectionSend.find('.show-row').addClass('row');
        $sectionSend.find('.left-side').addClass('col-sm-6');

        setTimeout(function () {

            $sectionGet.hide();
            $sectionSend.find('.right-side').addClass('col-sm-6').fadeIn(500);

        }, 1000);

    }

    function showGetFilesSection() {

        let leftSide = $sectionGet.find('.left-side');
        let rihtSide = $sectionGet.find('.right-side');

        $mainAnd.css({opacity: 0});

        $sectionSend.addClass("collapsed");
        $sectionGet.addClass("col-sm-12 active");
        $sectionGet.find('.show-row').addClass('row');
        leftSide.addClass('col-sm-6').css({'display': 'block'});
        rihtSide.addClass('col-sm-6');

        setTimeout(function () {

            leftSide.css('opacity', 1);
            $sectionSend.hide();

        }, 1000);

    }

});