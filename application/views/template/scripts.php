<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- Vendor js -->
<script src="<?=base_url('assets/js/vendor.min.js')?>"></script>

<!-- third party js -->
<script src="<?=base_url()?>assets/libs/autocomplete/jquery.autocomplete.min.js"></script>
<script src="<?=base_url()?>assets/libs/autonumeric/autoNumeric-min.js"></script>
<script src="<?=base_url()?>assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js"></script>
<!--<script src="<?/*=base_url()*/?>assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css"></script>-->
<script src="<?=base_url()?>assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
<script src="<?=base_url()?>assets/libs/bootstrap-select/bootstrap-select.min.js"></script>
<script src="<?=base_url()?>assets/libs/bootstrap-table/bootstrap-table.min.js"></script>
<script src="<?=base_url()?>assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
<script src="<?=base_url()?>assets/libs/c3/c3.min.js"></script>
<script src="<?=base_url()?>assets/libs/chart-js/Chart.bundle.min.js"></script>
<script src="<?=base_url()?>assets/libs/chartist/chartist.min.js"></script>
<script src="<?=base_url()?>assets/libs/chartist/chartist-plugin-tooltip.min.js"></script>
<script src="<?=base_url()?>assets/libs/clockpicker/bootstrap-clockpicker.min.js"></script>
<script src="<?=base_url()?>assets/libs/cropper/cropper.min.js"></script>
<script src="<?=base_url()?>assets/libs/custombox/custombox.min.js"></script>
<!--<script src="<?/*=base_url()*/?>assets/libs/d3/d3.min.js"></script>-->
<script src="<?=base_url()?>assets/libs/dropify/dropify.min.js"></script>
<script src="<?=base_url()?>assets/libs/dropzone/dropzone.min.js"></script>
<script src="<?=base_url()?>assets/libs/flatpickr/flatpickr.min.js"></script>
<script src="<?=base_url()?>assets/libs/footable/footable.all.min.js"></script>
<!--<script src="<?/*=base_url()*/?>assets/libs/fullcalendar/fullcalendar.min.js"></script>-->
<script src="<?=base_url()?>assets/libs/gmaps/gmaps.min.js"></script>
<script src="<?=base_url()?>assets/libs/hopscotch/hopscotch.min.js"></script>
<script src="<?=base_url()?>assets/libs/ion-rangeslider/ion.rangeSlider.min.js"></script>
<script src="<?=base_url()?>assets/libs/jquery-countdown/jquery.countdown.min.js"></script>
<!--<script src="<?/*=base_url()*/?>assets/libs/jquery-mapael/jquery.mapael.min.js"></script>-->
<script src="<?=base_url()?>assets/libs/jquery-mask-plugin/jquery.mask.min.js"></script>
<script src="<?=base_url()?>assets/libs/jquery-mockjax/jquery.mockjax.min.js"></script>
<script src="<?=base_url()?>assets/libs/jquery-nice-select/jquery.nice-select.min.js"></script>
<script src="<?=base_url()?>assets/libs/jquery-scrollto/jquery.scrollTo.min.js"></script>
<script src="<?=base_url()?>assets/libs/jquery-tabledit/jquery.tabledit.min.js"></script>
<script src="<?=base_url()?>assets/libs/jquery-toast/jquery.toast.min.js"></script>
<script src="<?=base_url()?>assets/libs/jquery-ui/jquery-ui.min.js"></script>
<script src="<?=base_url()?>assets/libs/jquery-vectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?=base_url()?>assets/libs/jsgrid/jsgrid.min.js"></script>
<!--<script src="<?/*=base_url()*/?>assets/libs/justgage/justgage.js"></script>
<script src="<?/*=base_url()*/?>assets/libs/katex/katex.min.js"></script>
<script src="<?/*=base_url()*/?>assets/libs/ladda/ladda.js"></script>
<script src="<?/*=base_url()*/?>assets/libs/ladda/spin.js"></script>-->
<script src="<?=base_url()?>assets/libs/magnific-popup/jquery.magnific-popup.min.js"></script>
<script src="<?=base_url()?>assets/libs/moment/moment.min.js"></script>
<script src="<?=base_url()?>assets/libs/morris-js/morris.min.js"></script>
<script src="<?=base_url()?>assets/libs/multiselect/jquery.multi-select.js"></script>
<script src="<?=base_url()?>assets/libs/datatables/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>assets/libs/datatables/dataTables.bootstrap4.js"></script>
<script src="<?=base_url()?>assets/libs/datatables/dataTables.responsive.min.js"></script>
<script src="<?=base_url()?>assets/libs/datatables/responsive.bootstrap4.min.js"></script>
<script src="<?=base_url()?>assets/libs/datatables/dataTables.buttons.min.js"></script>
<script src="<?=base_url()?>assets/libs/datatables/buttons.bootstrap4.min.js"></script>
<script src="<?=base_url()?>assets/libs/datatables/buttons.html5.min.js"></script>
<script src="<?=base_url()?>assets/libs/datatables/buttons.flash.min.js"></script>
<script src="<?=base_url()?>assets/libs/datatables/buttons.print.min.js"></script>
<script src="<?=base_url()?>assets/libs/datatables/dataTables.keyTable.min.js"></script>
<script src="<?=base_url()?>assets/libs/datatables/dataTables.select.min.js"></script>
<script src="<?=base_url()?>assets/libs/pdfmake/pdfmake.min.js"></script>
<script src="<?=base_url()?>assets/libs/pdfmake/vfs_fonts.js"></script>
<!--<script src="<?/*=base_url()*/?>assets/libs/flatpickr/flatpickr.min.js"></script>
<script src="<?/*=base_url()*/?>assets/libs/jquery-knob/jquery.knob.min.js"></script>
<script src="<?/*=base_url()*/?>assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>
<script src="<?/*=base_url()*/?>assets/libs/flot-charts/jquery.flot.js"></script>
<script src="<?/*=base_url()*/?>assets/libs/flot-charts/jquery.flot.time.js"></script>
<script src="<?/*=base_url()*/?>assets/libs/flot-charts/jquery.flot.tooltip.min.js"></script>
<script src="<?/*=base_url()*/?>assets/libs/flot-charts/jquery.flot.selection.js"></script>
<script src="<?/*=base_url()*/?>assets/libs/flot-charts/jquery.flot.crosshair.js"></script>
<script src="<?/*=base_url()*/?>assets/libs/nestable2/jquery.nestable.min.js"></script>-->
<script src="<?=base_url()?>assets/libs/parsleyjs/parsley.min.js"></script>
<script src="<?=base_url()?>assets/libs/pdfmake/pdfmake.min.js"></script>
<!--<script src="<?/*=base_url()*/?>assets/libs/peity/jquery.peity.min.js"></script>
<script src="<?/*=base_url()*/?>assets/libs/quill/quill.min.js"></script>
<script src="<?/*=base_url()*/?>assets/libs/raphael/raphael.min.js"></script>
<script src="<?/*=base_url()*/?>assets/libs/rickshaw/rickshaw.min.js"></script>
<script src="<?/*=base_url()*/?>assets/libs/rwd-table/rwd-table.min.js"></script>-->
<script src="<?=base_url()?>assets/libs/select2/select2.min.js"></script>
<script src="<?=base_url()?>assets/libs/summernote/summernote-bs4.min.js"></script>
<script src="<?=base_url()?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="<?=base_url()?>assets/libs/switchery/switchery.min.js"></script>
<!--<script src="<?/*=base_url()*/?>assets/libs/tablesaw/tablesaw.js"></script>-->
<script src="<?=base_url()?>assets/libs/tippy-js/tippy.all.min.js"></script>
<script src="<?=base_url()?>assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
<script src="<?=base_url()?>assets/libs/x-editable/bootstrap-editable.min.js"></script>
<script src="<?=base_url()?>assets/libs/izitoast/iziToast.min.js"></script>
<script src="<?=base_url()?>assets/libs/typeahead/typeahead.jquery.js"></script>
<script src="<?=base_url()?>assets/libs/typeahead/bloodhound.min.js"></script>
<!-- third party js ends -->
<script>
    var base_url = "<?php echo base_url() ?>";
</script>
<!-- Datatables init -->
<script src="<?=base_url()?>assets/js/page.js"></script>

<!-- App js -->
<script src="<?=base_url()?>assets/js/app.min.js"></script>

<!-- Custom js -->
<?php
if(isset($extra_js)){
 echo "<script src='".base_url('assets/js/funciones/'.$extra_js)."'></script>";
}
?>

</body>
</html>
