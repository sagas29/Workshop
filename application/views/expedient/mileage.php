<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-12">
                <h2>Kilometraje</h2>
                <!--Car Information-->
                <div class="row mt-3">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header bg-dark py-2 text-white">
                                <div class="card-widgets">
                                    <a data-toggle="collapse" href="#cardCollpase8" role="button" aria-expanded="false" aria-controls="cardCollpase2"><i class="mdi mdi-minus"></i></a>
                                </div>
                                <h5 class="card-title mb-0 text-white">DATOS DEL VEHÍCULO</h5>
                            </div>
                            <div id="cardCollpase8" class="collapse show">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm mb-0">
                                            <tbody>
                                            <tr>
                                                <th width="30%" class="bg-danger text-light"">VEHÍCULO</th>
                                                <td width="70%"><?=$car_name?></td>
                                            </tr>
                                            <tr>
                                                <th class="bg-danger text-light" scope="row">PLACA</th>
                                                <td><?=$p_number?></td>
                                            </tr>
                                            <tr>
                                                <th class="bg-danger text-light" scope="row">PROPIETARIO</th>
                                                <td><?=$client_name?></td>
                                            </tr>
                                            <tr>
                                                <th class="bg-danger text-light" scope="row">RESPONSABLE</th>
                                                <td><?=$driver_name?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header bg-dark py-2 text-white">
                                <div class="card-widgets">
                                    <a data-toggle="collapse" href="#cardCollpase8" role="button" aria-expanded="false" aria-controls="cardCollpase2"><i class="mdi mdi-minus"></i></a>
                                </div>
                                <h5 class="card-title mb-0 text-white">ÚLTIMA REVISIÓN</h5>
                            </div>
                            <div id="cardCollpase8" class="collapse show">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm mb-0">
                                            <tbody>
                                            <tr>
                                                <th width="30%" class="bg-danger text-light"">FECHA</th>
                                                <?php if(isset($service_date)):?>
                                                    <td width="70%"><?=$service_date?></td>
                                                <?php else:?>
                                                    <td width="70%"></td>
                                                <?php endif;?>
                                            </tr>
                                            <tr>
                                                <th class="bg-danger text-light" scope="row">KILOMETRAJE</th>
                                                <?php if(isset($current)):?>
                                                    <td width="70%"><?=$current?></td>
                                                <?php else:?>
                                                    <td width="70%"></td>
                                                <?php endif;?>
                                            </tr>
                                            <tr>
                                                <th class="bg-danger text-light" scope="row">MECÁNICO</th>
                                                <?php if(isset($mechanic_name)):?>
                                                    <td width="70%"><?=$mechanic_name?></td>
                                                <?php else:?>
                                                    <td width="70%"></td>
                                                <?php endif;?>
                                            </tr>
                                            <tr>
                                                <th class="bg-danger text-light" scope="row">RESPONSABLE/MOTORISTA</th>
                                                <?php if(isset($driver_name)):?>
                                                    <td width="70%"><?=$driver_name?></td>
                                                <?php else:?>
                                                    <td width="70%"></td>
                                                <?php endif;?>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Next maintenance-->
                <div class="row mt-3">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-dark py-2 text-white">
                                <div class="card-widgets">
                                    <a data-toggle="collapse" href="#cardCollpase8" role="button" aria-expanded="false" aria-controls="cardCollpase2"><i class="mdi mdi-minus"></i></a>
                                </div>
                                <h5 class="card-title mb-0 text-white">MANTENIMIENTOS PRÓXIMOS</h5>
                            </div>
                            <div id="cardCollpase8" class="collapse show">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm mb-0">
                                            <tbody>
                                            <tr>
                                                <th width="15%" class="bg-danger text-light" scope="row">KILOMETRAJE ACTUAL </th>
                                                <?php if(isset($current)):?>
                                                    <td width="60%" colspan="3"><?=$current?></td>
                                                <?php else:?>
                                                    <td width="60%" colspan="3"></td>
                                                <?php endif;?>
                                                <td width="25%"><a data-id='<?=$id_expedient?>' id='modal_update' role='button' data-toggle='modal' data-target='#viewModal' data-refresh='true' class="btn btn-danger btn-sm text-light"><i class="fe-refresh-cw"></i>Actualizar</a></td>
                                            </tr>
                                            <?php if(isset($current)):?>
                                                <tr>
                                                    <th width="15%" class="bg-danger text-light">KILOMETRAJE A</th>
                                                    <td width="20%"><?php echo $current+$frecuency;?></td>
                                                    <td width="20%" class="bg-danger text-light">FALTANTE: </td>
                                                    <td width="20%"><?php echo ($current+$frecuency)-$current;?></td>
                                                    <td width="25%"><span class="badge badge-primary">Realizar</span></td>
                                                </tr>
                                                <tr>
                                                    <th width="15%" class="bg-danger text-light" scope="row">KILOMETRAJE B</th>
                                                    <td width="20%"><?php echo $current+(2*$frecuency);?></td>
                                                    <td width="20%" class="bg-danger text-light">FALTANTE: </td>
                                                    <td width="20%"><?php echo ($current+(2*$frecuency))-$current;?></td>
                                                    <td width="25%"><span class="badge badge-primary">Realizar</span></td>
                                                </tr>
                                                <tr>
                                                    <th width="15%" class="bg-danger text-light" scope="row">KILOMETRAJE C</th>
                                                    <td width="20%"><?php echo $current+(3*$frecuency);?></td>
                                                    <td width="20%" class="bg-danger text-light">FALTANTE: </td>
                                                    <td width="20%"><?php echo ($current+(3*$frecuency))-$current;?></td>
                                                    <td width="25%"><span class="badge badge-primary">Realizar</span></td>
                                                </tr>
                                            <?php endif;?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Mileage history-->
                <div class="row mt-3">
                    <div class="col-lg-12">
                        <div class="card">
                        <div class="card-header bg-dark py-2 text-white">
                            <div class="card-widgets">
                                <a data-toggle="collapse" href="#cardCollpase8" role="button" aria-expanded="false" aria-controls="cardCollpase2"><i class="mdi mdi-minus"></i></a>
                            </div>
                            <h5 class="card-title mb-0 text-white">ADMINISTRAR KILOMETRAJES</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm mb-0 data_table" >
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>FECHA</th>
                                            <th>RESPONSABLE</th>
                                            <th>KILOMETRAJE</th>
                                            <th>MANTENIMIENTO</th>
                                            <th>ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php  if(isset($mileage_history)):
                                            $i=1;
                                            foreach ($mileage_history as $row): ?>
                                                <tr>
                                                    <td><?=$i?></td>
                                                    <td><?=$row->date?></td>
                                                    <td><?=$row->username?></td>
                                                    <td><?=$row->measure?></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            <?php
                                            $i++;
                                            endforeach;
                                        endif;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>

            </div><!-- end col -->
        </div><!--end row-->
    </div><!--end container fluid-->
</div><!--end content-->

<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

