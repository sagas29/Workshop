<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<body>

<!-- Begin page -->
<div id="wrapper">

    <!-- Topbar Start -->
    <div class="navbar-custom">
        <ul class="list-unstyled topnav-menu float-right mb-0">
            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="<?php echo base_url().$picture_session; ?>" alt="user-image" class="rounded-circle">
                    <span class="pro-user-name ml-1">
                        <?php if($admin==1):?>
                            <?=$username_session?> (Administrador)<i class="mdi mdi-chevron-down"></i>
                        <?php else:?>
                            <?=$username_session?> <i class="mdi mdi-chevron-down"></i>
                        <?php endif;?>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                    <!-- item-->
                    <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Bienvenido!</h6>
                    </div>
                    <!-- item-->
                    <a href="<?=base_url('Profile')?>" class="dropdown-item notify-item">
                        <i class="fe-user"></i>
                        <span>Mi Perfil</span>
                    </a>

                    <!-- item-->
                    <a href="<?=base_url('Configuracion')?>" class="dropdown-item notify-item">
                        <i class="fe-settings"></i>
                        <span>Configuración</span>
                    </a>
                    <div class="dropdown-divider"></div>

                    <!-- item-->
                    <a href="<?=base_url()?>Login/logout" class="dropdown-item notify-item">
                        <i class="fe-log-out"></i>
                        <span>Cerrar Sesión</span>
                    </a>

                </div>
            </li>
        </ul>

        <!-- LOGO -->
        <div class="logo-box">
            <a href="<?=base_url("Dashboard")?>" class="logo text-center">
                <span class="logo-lg">
                    <img src="<?=base_url()?>assets/images/logo.png" alt="" height="50">
                 </span>
                <span class="logo-sm">
                    <img src="<?=base_url()?>assets/images/logo.png" alt="" height="24">
                </span>
            </a>
        </div>

        <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
            <li>
                <button class="button-menu-mobile waves-effect waves-light">
                    <i class="fe-menu"></i>
                </button>
            </li>

        </ul>
    </div>
    <!-- end Topbar -->

    <!-- ========== Left Sidebar Start ========== -->
    <div class="left-side-menu">

        <div class="slimscroll-menu">

            <div class="user-box text-center">
                <img src="<?=base_url($picture_session);?>" class="rounded-circle avatar-md">
                <div class="dropdown">
                    <a class="text-dark h5 mt-2 mb-1 d-block">Upires WorkShop</a>
                </div>
                <p class="text-muted"><?=$username_session?></p>
            </div>

            <!--- Sidemenu -->
            <div id="sidebar-menu">

                <ul class="metismenu" id="side-menu">
                    <li>
                        <a href="<?=base_url()?>Dashboard">
                            <i class="fe-star"></i>
                            <span>Inicio</span>
                        </a>
                    </li>

                    <li class="menu-title mt-2">Sistema</li>

                    <?php foreach ($menus as $menu): ?>
                        <li>
                            <a href="javascript: void(0);">
                                <i class="<?=$menu->icon;?>"></i>
                                <span><?=$menu->name;?></span>
                                <span class='menu-arrow'></span>
                            </a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <?php
                                foreach ($controller[$menu->id_menu] as $control):
                                    ?>
                                    <li><a href="<?=base_url().$control->path;?>"><?=$control->name;?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php
                    endforeach;
                    ?>


                </ul>

            </div>
            <!-- End Sidebar -->

            <div class="clearfix"></div>

        </div>
        <!-- Sidebar -left -->

    </div>

    <div class="content-page">