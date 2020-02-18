<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title"><i class="<?=$page_icon?>"></i> <?=$page_title?></h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <?php if (isset($url_add)): ?>
                                <div class="ibox-title">
                                    <?php if($modal_add==true): ?>
                                        <a href = '<?=base_url($url_add)?>' id="modal_btn_add" role="button" class="btn btn-primary btn-rounded waves-effect waves-light" data-toggle="modal" data-target="#viewModal" data-refresh='true'>
                                            <span class="btn-label"><i class="fe-plus"></i></span><?=$txt_add?>
                                        </a>
                                    <?php else: ?>
                                        <a href="<?=base_url($url_add)?>" class="btn btn-primary btn-rounded waves-effect waves-light">
                                            <span class="btn-label"><i class="fe-plus"></i></span><?=$txt_add?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>


                        </div>
                        <div id="basic-datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="editable" style="width: 100%;" class="table dt-responsive nowrap dataTable no-footer dtr-inline table-hover">
                                        <thead>
                                        <tr>
                                            <?php foreach ($table as $key => $value): ?>
                                                <th class='text-primary' style="width: <?=$value?>%;"><strong><?=$key?></strong></th>
                                            <?php endforeach; ?>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end card body-->
                </div>
            </div>
        </div>
        <!-- end page title -->
    </div> <!-- container -->
</div> <!-- content -->

<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<input type="hidden" id="get_csrf_hash" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
