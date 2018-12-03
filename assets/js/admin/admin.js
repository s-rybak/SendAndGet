require("admin-lte/bower_components/bootstrap/dist/css/bootstrap.min.css");
require("admin-lte/bower_components/font-awesome/css/font-awesome.min.css");
require('admin-lte/bower_components/Ionicons/css/ionicons.min.css');
require("admin-lte/dist/css/AdminLTE.css");
require("admin-lte/dist/css/skins/_all-skins.css");
require("admin-lte/dist/css/skins/_all-skins.css");
require("admin-lte/bower_components/morris.js/morris.css");
require("admin-lte/bower_components/jvectormap/jquery-jvectormap.css");
require("admin-lte/bower_components/jquery/dist/jquery.min.js");
require("admin-lte/bower_components/jquery-ui/jquery-ui.min.js");
require("admin-lte/bower_components/bootstrap/dist/js/bootstrap.min.js");
require("admin-lte/bower_components/raphael/raphael.min.js");
require("admin-lte/bower_components/morris.js/morris.min.js");
require("admin-lte/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js");
require("admin-lte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js");
require("admin-lte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js");
require("admin-lte/bower_components/jquery-knob/dist/jquery.knob.min.js");
require("admin-lte/bower_components/jvectormap/jquery-jvectormap.js");
require("admin-lte/bower_components/bootstrap-daterangepicker/daterangepicker.js");
require("admin-lte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js");
require("admin-lte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js");
require("admin-lte/bower_components/fastclick/lib/fastclick.js");
require("admin-lte/bower_components/bootstrap-daterangepicker/daterangepicker.js");
require("admin-lte/dist/js/adminlte.min.js");
//require("admin-lte/dist/js/pages/dashboard.js");
require("admin-lte/dist/js/demo.js");
let Files = require('../libs/Files');
let jQuery = require('jquery');


jQuery(function ($) {

    let $pageImageUpload = $('#pageImageUpload');

    let Uploader = new Files({},{},$);

    $pageImageUpload.click(function (e) {
        e.preventDefault();

        Uploader.SelectFiles(false)
            .then(function (files) {

                sagSdk.uploadFiles(files)
                    .then(function (files) {

                    $.post('/admin/page/image/',{
                        id:$pageImageUpload.data('id'),
                        image:files[0].hash
                    },function (resp) {
                        location.reload();
                    });

                })

            });
    })


});