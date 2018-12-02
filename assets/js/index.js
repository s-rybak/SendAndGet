require('../css/main.css');
require('../css/media.css');
require('sweetalert/dist/sweetalert.min');
let jQuery = require('jquery');
let Files = require('./libs/Files');
let TextLoader = require('./libs/TextLoader');


jQuery(function ($) {

    let $selectFiles = $('#select-files');
    let $getFiles = $('#get-files');
    let $sectionSend = $('.section-send');
    let $sectionGet = $('.section-get');
    let $mainAnd = $('.main-and');
    let $filesList = $('#files_list');
    let $groupLinkCopy = $('#groupLinkCopy');
    let $groupIdCopy = $('#groupIdCopy');
    let $downloadLink = $('#downloadLink');
    let $searchInput = $('#searchInput');
    let $buttonSearch = $('#buttonSearch');
    let $searchResults = $('#searchResults');

    let Uploader = new Files({},{},$);
    let SelectLoader = new TextLoader($selectFiles);

    $selectFiles.click(function () {

        SelectLoader.setTitle("Selecting files");
        SelectLoader.startLoading();

        Uploader.SelectFiles(true)
            .then(function (files) {

                SelectLoader.setTitle("Uploading");

                let html = "";
                let uid  = (Date.now()).toString(32);

                [...files].forEach(file=>{

                    html += `<tr class="files ${uid} file-row">
                                <td>${file.name}</td>
                                <td>
                                    <div class="progress progress-xs progress-striped active">
                                        <div class="progress-bar ${uid} progress-bar-primary"
                                             style="width: 30%"></div>
                                    </div>
                                    <span class="badge bg-light-blue ${uid}" >30%</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button id="btnGroupDrop1" type="button"
                                                class="btn btn-secondary dropdown-toggle send-link-btn"
                                                data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                            <a class="dropdown-item direct-link" href="#">Copy link ( direct )</a>
                                            <a class="dropdown-item direct-id" href="#">Copy file id</a>
                                            <a class="dropdown-item delete-link" href="#">Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>`
                });

                $filesList.append(html);

                sagSdk.uploadFiles(files,function (pers) {
                    $('.badge.'+uid).html(pers + "%");
                    $('.progress-bar.'+uid).width(pers + "%");
                }).then(function (files) {

                    SelectLoader.stopLoading();

                    let $list = $('.files.'+uid);

                    files.forEach((file,i)=>{

                        $list.eq(i).find('.direct-link').attr('href',location.origin+"/f/"+file.hash);
                        $list.eq(i).find('.direct-id').attr('href',file.hash);
                        $list.eq(i).find('.delete-link').attr('href',file.hash);

                    })

                    if(files.length > 0){

                        $downloadLink.val(location.origin+"/g/"+files[0].groupHash);
                        $groupIdCopy.attr('href',files[0].groupHash);

                    }

                }).catch(function (msg) {

                    SelectLoader.stopLoading();
                    SelectLoader.showMesage('Error');

                    swal('Error',msg,'error').then(function () {
                        $('.files.'+uid).remove();
                    });

                });

                showUploadFilesSection();

            })
            .catch(function (e) {

                SelectLoader.stopLoading();
                SelectLoader.showMesage(e.message)
            });

    });

    $buttonSearch.click(function () {

        let val = $searchInput.val();
        $searchResults.html('');

        if(val.length > 0){

            sagSdk
                .query(val)
                .then(function (res) {

                    let html = "";

                    res.forEach(file=>{

                        html += `
                            <tr class="files">
                                <td>${file.name}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button id="btnGroupDrop1" type="button"
                                                class="btn btn-secondary dropdown-toggle send-link-btn"
                                                data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                            <a class="dropdown-item direct-link" href="${location.origin+"/f/"+file.hash}">Copy link ( direct )</a>
                                            <a class="dropdown-item" href="${location.origin+"/f/"+file.hash}">Download</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>`;

                    });

                    $searchResults.html(html.length > 0 ? html : "<p class='simple-text min color-white text-center block-1'>Nothing not found</p>");

            }).catch(function (msg) {

                swal("Error",msg,'error');

            })

        }

    });

    $groupIdCopy.click(function (e) {
        e.preventDefault();

        let input = document.createElement("input");
        document.body.appendChild(input);
        input.value = this.getAttribute('href');
        input.select();
        let res = document.execCommand("copy");

        if(!res){

            swal({
                text: 'Here yor id, you can copy it by clicking ctrl + c',
                content: "input",
                button: {
                    text: "Search!",
                    closeModal: false,
                },
                onOpen:()=>{
                    $('.swal-content__input').val(this.href).focus();
                }
            })

        }else{

            swal('Id copied')

        }

    });

    $groupLinkCopy.click(function () {
        $downloadLink.select();
        let res = document.execCommand("copy");

        if(!res){

            swal({
                text: 'Here yor link, you can copy it by clicking ctrl + c',
                content: "input",
                button: {
                    text: "Search!",
                    closeModal: false,
                },
                onOpen:()=>{
                    $('.swal-content__input').val(this.href).focus();
                }
            })

        }else{

            swal('Link copied')

        }
    });

    $filesList.on('click','.delete-link',function (e) {
        e.preventDefault();

        sagSdk.remove(this.getAttribute('href')).then(()=>{

            $(this).parents('.file-row').remove();

        }).catch(function (msg) {

            swal('Error',msg,'error');

        })


    })

    $filesList.add($searchResults).on('click','.direct-link, .direct-id',function (e) {
        e.preventDefault();

        let input = document.createElement("input");
        document.body.appendChild(input);
        input.value = this.getAttribute('href');
        input.select();
        let res = document.execCommand("copy");

        if(!res){

            swal({
                text: 'Here yor link, you can copy it by clicking ctrl + c',
                content: "input",
                button: {
                    text: "Search!",
                    closeModal: false,
                },
                onOpen:()=>{
                    $('.swal-content__input').val(this.href).focus();
                }
            })

        }else{

            swal('Link copied')

        }

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