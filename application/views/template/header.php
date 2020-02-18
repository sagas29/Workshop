<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Upires WorkShop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Sistema Administrativo" name="description" />
    <meta content="Soluciones Ideales" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Plugins css -->
    <link href="<?=base_url();?>assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url();?>assets/libs/animate/animate.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url();?>assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url();?>assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url();?>assets/libs/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url();?>assets/libs/bootstrap-table/bootstrap-table.min.css" rel="stylesheet" type="text/css" />
    <!--<link href="<?/*=base_url();*/?>assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.css" rel="stylesheet" type="text/css" />
    <link href="<?/*=base_url();*/?>assets/libs/c3/c3.min.css" rel="stylesheet" type="text/css" />
    <link href="<?/*=base_url();*/?>assets/libs/chartist/chartist.min.css" rel="stylesheet" type="text/css" />
    <link href="<?/*=base_url();*/?>assets/libs/clockpicker/bootstrap-clockpicker.min.css" rel="stylesheet" type="text/css" />-->
    <link href="<?=base_url();?>assets/libs/cropper/cropper.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url();?>assets/libs/custombox/custombox.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url();?>assets/libs/datatables/buttons.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url();?>assets/libs/datatables/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url();?>assets/libs/datatables/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url();?>assets/libs/datatables/select.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url();?>assets/libs/dropify/dropify.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url();?>assets/libs/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url();?>assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
    <!--<link href="<?/*=base_url();*/?>assets/libs/footable/footable.core.min.css" rel="stylesheet" type="text/css" />
    <link href="<?/*=base_url();*/?>assets/libs/footable/footable.core.min.css" rel="stylesheet" type="text/css" />
    <link href="<?/*=base_url();*/?>assets/libs/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
    <link href="<?/*=base_url();*/?>assets/libs/hopscotch/hopscotch.min.css" rel="stylesheet" type="text/css" />
    <link href="<?/*=base_url();*/?>assets/libs/ion-rangeslider/ion.rangeSlider.css" rel="stylesheet" type="text/css" />-->
    <link href="<?=base_url();?>assets/libs/jquery-nice-select/nice-select.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url();?>assets/libs/jquery-toast/jquery.toast.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url();?>assets/libs/jquery-vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url();?>assets/libs/jsgrid/jsgrid.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url();?>assets/libs/jsgrid/jsgrid-theme.css" rel="stylesheet" type="text/css" />
    <!--link href="<?/*=base_url();*/?>assets/libs/ladda/ladda-themeless.min.css" rel="stylesheet" type="text/css" />
    <link href="<?/*=base_url();*/?>assets/libs/magnific-popup/magnific-popup.css" rel="stylesheet" type="text/css" />
    <link href="<?/*=base_url();*/?>assets/libs/multiselect/multi-select.css" rel="stylesheet" type="text/css" />
    <link href="<?/*=base_url();*/?>assets/libs/nestable2/jquery.nestable.min.css" rel="stylesheet" type="text/css" />
    <link href="<?/*=base_url();*/?>assets/libs/quill/quill.bubble.css" rel="stylesheet" type="text/css" />
    <link href="<?/*=base_url();*/?>assets/libs/quill/quill.core.css" rel="stylesheet" type="text/css" />
    <link href="<?/*=base_url();*/?>assets/libs/quill/quill.snow.css" rel="stylesheet" type="text/css" />
    <link href="<?/*=base_url();*/?>assets/libs/rickshaw/rickshaw.min.css" rel="stylesheet" type="text/css" />
    <link href="<?/*=base_url();*/?>assets/libs/rwd-table/rwd-table.min.css" rel="stylesheet" type="text/css" />-->
    <link href="<?=base_url();?>assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url();?>assets/libs/summernote/summernote-bs4.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url();?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url();?>assets/libs/switchery/switchery.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url();?>assets/libs/tablesaw/tablesaw.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url();?>assets/libs/x-editable/bootstrap-editable.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url();?>assets/libs/izitoast/iziToast.min.css" rel="stylesheet" type="text/css" />


    <!-- App favicon -->
    <link href="<?=base_url();?>assets/images/logo.png" rel="icon" type="image/png">

    <!-- App css -->
    <link href="<?=base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url();?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url();?>assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url();?>assets/css/styles.css" rel="stylesheet" type="text/css" />

</head>
