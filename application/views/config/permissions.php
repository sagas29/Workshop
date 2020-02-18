<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content">
    <div class="container-fluid">
        <div class="row mt-3 mb-3 ml-1">
            <h3><i class="fe-user-check"></i> Permisos de Usuario<?=$admin?></h3>
        </div>
        <div class="row mt-3 mb-3">
            <div class="form-group col-lg-3">
                <label for="fname">Nombre</label>
                <input type="text" disabled value="<?=$fname?>" class="form-control">
            </div>
            <div class="form-group col-lg-3">
                <label for="username">Usuario</label>
                <input type="text" disabled value="<?=$username?>" class="form-control">
            </div>
            <div class="form-group col-lg-4">
                <label for="admin">Administrador</label>
                <div class="checkbox checkbox-primary mb-2">
                    <?php if($admin==1): ?>
                        <input id="admin_chk" type="checkbox" name="admin_chk" checked>
                    <?php else:?>
                        <input id="admin_chk" type="checkbox" name="admin_chk">
                    <?php endif;?>
                    <label for="admin_chk">
                        Todos los permisos
                    </label>
                </div>
            </div>
            <div class="form-group col-lg-2 mt-2">
                <input type="hidden" id="id_user" name="id_user" value="<?=$id_user?>">
                <button type="button" class="btn btn-blue waves-effect waves-light" id="btn_save"><i class="fe-save"></i> Guardar Cambios</button>
            </div>
        </div>
        <div class="row">
            <?php foreach($menus as $rows):?>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-header bg-blue py-3 text-white">
                            <div class="card-widgets">
                                <a data-toggle="collapse" href="#cardCollpase1" role="button" aria-expanded="false" aria-controls="cardCollpase2"><i class="mdi mdi-minus"></i></a>
                            </div>
                            <h5 class="card-title mb-0 text-white"><?=$rows->name?></h5>
                        </div>
                        <div id="cardCollpase1" class="collapse show">
                            <div class="card-body">
                                <?php foreach ($controller[$rows->id_menu] as $control):?>
                                    <div class="checkbox checkbox-primary mb-2">
                                        <input type="checkbox" id="chbController<?=$control->id_controller?>"
                                               name="chbController" value="<?=$control->id_controller?>" class="checkboxes"
                                               <?php
                                               if($admin==1) echo "checked='true'";
                                               else{
                                                   $has=false;
                                                   if(isset($permissions_user)){
                                                       foreach ($permissions_user as $us){
                                                           if($us->id_controller==$control->id_controller) $has=true;
                                                       }
                                                       if($has==true)echo "checked='true'";
                                                       $has=false;
                                                   }
                                               }
                                               ?>
                                        >
                                        <label for="chbController<?=$control->id_controller?>"> <?=$control->name?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
        <input type="hidden" id="get_csrf_hash" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
    </div><!--end container fluid-->
</div><!--end content-->
