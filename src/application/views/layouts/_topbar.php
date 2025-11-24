<header class="main-header">
    <nav class="navbar navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <a href="<?= base_url() ?>" class="navbar-brand hidden-xs"><b>PELNI</b> Visitor &amp; New Normal</a>
                <a href="<?= base_url() ?>" class="navbar-brand visible-xs"><b>PV</b></a>
            </div>

            <div class="collapse navbar-collapse pull-left" id="navbar-collapse"></div>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars fa-fw"></i> Main Menu</a>
                        <ul class="dropdown-menu" role="menu">
                            <?
                            $menu = [];
                            if (isset($_SESSION['access'])) {
                                // load menu id
                                $menu = app_generate_menu(explode(', ', $_SESSION['access']));
                            }
                            ?>
                            <? foreach ($menu as $v) {
                                $ex = explode('|', $v);

                                if ($ex) {
                                    echo '<li><a href="' . $ex[1] . '"><i class="fa ' . $ex[2] . '"></i> ' . $ex[0] . '</a></li>';
                                }
                            }
                            ?>
                        </ul>
                    </li>
                    <li class="user user-menu">
                        <a href="<?= base_url('logout') ?>" title="Logout"><i class="fa fa-user-circle fa-fw"></i><?= $_SESSION['loket_name'] ?> <i class="fa fa-sign-out fa-fw"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>