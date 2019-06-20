<header class="main-header">
    <a href="<?php echo base_url() ?>" class="logo">
        <span class="logo-mini"><b>P</b>V</span>
        <span class="logo-lg"><b>PELNI</b> Visitor</span>
    </a>
    <nav class="navbar navbar-static-top">
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="hidden-xs"><?php echo $_SESSION['loket_name'];?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header" style="height: 81px;">
                            <p>
                                Alexander Pierce - Web Developer
                                <small>Member since Nov. 2012</small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="btn-group btn-block">
                                <a href="#" class="btn btn-default col-lg-6">Profil Pengguna</a>
                                <a href="#" class="btn btn-default col-lg-6">Pengaturan</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li><a href="<?php echo base_url();?>Login/logout"><i class="fa fa-sign-out"></i></a></li>
            </ul>
        </div>
        
    </nav>
</header>