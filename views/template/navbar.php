<div class="nav-left-sidebar sidebar-dark">
            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 100%;">
            <div class="menu-list" style="overflow: hidden; width: auto; height: 100%;">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" 
                    data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-divider">
                                Menu
                            </li>
                            <?php if (!empty($_SESSION['permisos'][1]['r'])) {?>
                                <li class="nav-item">
                                    <?php if($data['page_id']== 1 ){ ?>
                                        <a class="nav-link active" href="<?php echo server_url;?>dashboard/"><i class="fas fa-home"></i>Dashboard</a>
                                    <?php }else{ ?>
                                        <a class="nav-link" href="<?php echo server_url;?>dashboard/"><i class="fas fa-home"></i>Dashboard</a>
                                    <?php } ?>
                                </li>
                            <?php } ?>
                            
                            <?php if (!empty($_SESSION['permisos'][5]['r'])) {?>
                                <li class="nav-item">
                                    <?php if($data['page_id'] == 5 ){ ?>
                                        <a class='nav-link active' href="<?php echo server_url ?>empleados/"><i class="fas fa-users"></i>Empleados</a>
                                    <?php }else{ ?>
                                        <a class='nav-link' href="<?php echo server_url ?>empleados/"><i class="fas fa-users"></i>Empleados</a>
                                    <?php } ?>
                                </li>
                            <?php } ?>

                            <?php if (!empty($_SESSION['permisos'][8]['r'])) {?>
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" aria-expanded="false"
                                data-target="#submenu-2" aria-controls="submenu-2"><i class="fas fa-id-badge"></i>Nominas</a>
                                <div id="submenu-2" class="submenu collapse" >
                                    <ul class="nav flex-column">
                                    <?php if($data['page_id'] == 8 ){ ?>
                                        <a class='nav-link active' href="<?php echo server_url ?>nominas/">
                                        <i class="fas fa-file"></i>Procesamiento de nominas</a>
                                    <?php }else{ ?>
                                        <a class='nav-link' href="<?php echo server_url ?>nominas/">
                                        <i class="fas fa-file"></i>Procesamiento de nominas</a>
                                    <?php } ?>
                                    </ul>
                                </div>
                            <?php } ?>


                            <?php if (!empty($_SESSION['permisos'][7]['r'])) {?>
                                <li class="nav-item">
                                    <?php if($data['page_id'] == 7 ){ ?>
                                        <a class='nav-link active' href="<?php echo server_url ?>puestos/"><i class="fas fa-clipboard"></i>Puestos</a>
                                    <?php }else{ ?>
                                        <a class='nav-link' href="<?php echo server_url ?>puestos/"><i class="fas fa-clipboard"></i>Puestos</a>
                                    <?php } ?>
                                </li>
                            <?php } ?>


                            <?php if (!empty($_SESSION['permisos'][6]['r'])) {?>
                                <li class="nav-item">
                                <?php if($data['page_id'] == 6 ){ ?>
                                    <a class='nav-link active' href="<?php echo server_url ?>contratos/"><i class="fas fa-book"></i>Tipos de Contratos</a>
                                <?php }else{ ?>
                                    <a class='nav-link' href="<?php echo server_url ?>contratos/"><i class="fas fa-book"></i>Tipos de Contratos</a>
                                <?php } ?>
                                </li>
                            <?php } ?>

                            <?php if ($_SESSION['permisos'][3]['r'] || $_SESSION['permisos'][2]['r'] || $_SESSION['permisos'][4]['r'] ) { ?>
                            <li class="nav-divider">
                                Seguridad
                            </li>
                            <li class="nav-item">
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-3" aria-controls="submenu-3"><i class="fas fa-lock"></i>Administrar Permisos</a>
                                <div id="submenu-3" class="submenu collapse" >
                                    <ul class="nav flex-column">
                                        <?php if (!empty($_SESSION['permisos'][2]['r'])) { ?>
                                        <li class="nav-item">
                                            <?php if($data['page_id']== 2 ){ ?>
                                                <a class="nav-link active" href="<?php echo server_url ?>usuarios/"><i class="fas fa-user"></i>Usuarios</a>
                                            <?php }else{ ?>
                                                <a class="nav-link" href="<?php echo server_url ?>usuarios/"><i class="fas fa-user"></i>Usuarios</a>
                                            <?php } ?>
                                        </li>
                                        <?php } ?>

                                        <?php if (!empty($_SESSION['permisos'][3]['r'])) { ?>
                                        <li class="nav-item">
                                            <?php if($data['page_id']== 3 ){ ?>
                                            <a class="nav-link active" href="<?php echo server_url ?>roles/"><i class="fas fa-list-ul"></i>Roles</a>
                                            <?php }else{ ?>
                                                <a class="nav-link" href="<?php echo server_url ?>roles/"><i class="fas fa-list-ul"></i>Roles</a>
                                            <?php } ?>
                                        </li>
                                        <?php } ?>

                                        <?php if (!empty($_SESSION['permisos'][4]['r'])) { ?>
                                        <li class="nav-item">
                                            <?php if($data['page_id']== 4 ){ ?>
                                                <a class="nav-link active" href="<?php echo server_url ?>respaldo/"><i class="fa fa-database" aria-hidden="true"></i>Respaldos</a>
                                            <?php }else{ ?>
                                                <a class="nav-link" href="<?php echo server_url ?>respaldo/"><i class="fa fa-database" aria-hidden="true"></i>Respaldos</a>
                                            <?php } ?>
                                        </li>
                                        <?php } ?>

                                    </ul>
                                </div>
                            </li>
                            <?php } ?>
                            
                        </ul>
                    </div>
                </nav>
            </div><div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 507px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
        </div>