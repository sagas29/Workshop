<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Editar Producto</h4>
                        <?php echo form_open('', array('id' => 'form_edit', 'novalidate' => '','class'=>'mt-2')); ?>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="name">Nombre<span class="text-danger">*</span></label>
                                <input type="text" name="name" required="" placeholder="Ingrese el nombre del producto" class="form-control" value="<?=$name?>"
                                       parsley-trigger="change" data-parsley-error-message="El campo es requerido">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="brand">Marca<span class="text-danger">*</span></label>
                                <input type="text" name="brand" required="" placeholder="Ingrese la marca del producto" class="form-control" id="year" value="<?=$brand?>"
                                       parsley-trigger="change" data-parsley-error-message="El campo es requerido">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="presentation">Presentación<span class="text-danger">*</span></label>
                                <input type="text" name="presentation" required="" placeholder="Ingrese el presentación del producto" class="form-control" value="<?=$presentation?>"
                                       parsley-trigger="change" data-parsley-error-message="El campo es requerido">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="price">Precio <span class="text-danger">*</span></label>
                                <input type="text" name="price" required="" placeholder="Ingrese el precio del producto" class="form-control" value="<?=$price?>"
                                       parsley-trigger="change" data-parsley-error-message="El campo es requerido">
                            </div>
                        </div>
                        <div class="form-group text-right m-b-0">
                            <button class="btn btn-primary waves-effect waves-light" type="submit">Guardar</button>
                            <button type="reset" class="btn btn-secondary waves-effect m-l-5">Cancelar</button>
                            <input type="hidden" value="<?=$id_product?>" name="id_product" id="id_product">
                        </div>
                        <?php echo form_close(); ?>
                        <!--</form>-->
                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div><!-- end col -->
        </div><!--end row-->
    </div><!--end container fluid-->
</div><!--end content-->
