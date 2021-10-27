<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" >Atmasphere Social Media</a>
         
    </div>
    <ul class="nav navbar-right top-nav">
    <li><a href="../index.php"><img src="https://img.icons8.com/dusk/30/000000/home.png"/></a></li>
        <?php
        if (isset($_SESSION['admin_email'])) {

            $sql = "SELECT * FROM admin WHERE admin_email='$_SESSION[admin_email]'";
            $result = query($sql);
            confirm($result);
            $row = fetch_array($result);
            $post_pic = $row['admin_pic'];
        } elseif (isset($_COOKIE['admin_email'])) {
            $_SESSION['admin_email'] = $_COOKIE['admin_email'];
            $sql = "SELECT * FROM admin WHERE admin_email='$_SESSION[admin_email]'";
            $result = query($sql);
            confirm($result);
            $row = fetch_array($result);
            $post_pic = $row['admin_pic'];
        }
        ?>

        <meta http-equiv="refresh" content="15">

        <?php if (admin_logged_in()) : ?>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>
                    <?php
                    echo ucwords($row['namaawal']);
                    echo " ";
                    echo ucwords($row['namaakhir']);
                    ?>
                    <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li class="divider"></li>
                    <li>
                        <a href="admin_logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                    </li>
                </ul>
            </li>

    </ul>
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li>
                <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
            </li>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#subject_dropdown"><i class="fa fa-fw fa-arrows-v"></i> Kategori <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="subject_dropdown" class="collapse">
                    <li>
                        <a href="adminkategori.php"><i class="glyphicon glyphicon-ok"></i> Daftar Kategori</a>
                    </li>
                    <li>
                        <a href="admintambahkategori.php"><i class="glyphicon glyphicon-plus"></i> Tambah Kategori</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="adminpostingan.php"><i class="fa fa-fw fa fa-book"></i> Postingan</a>
            </li>
            <li>
                <a href="daftaruser.php"><i class="fa fa-fw fa fa-users"></i> Daftar User</a>
            </li>
        </ul>
    </div>
<?php endif; ?>
</nav>