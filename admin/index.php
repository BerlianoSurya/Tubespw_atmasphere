<?php include "includes/admin_header.php"; ?>

<?php

if (admin_logged_in()) {
} else {

    redirect("admin_login.php");
}
?>
<?php include "includes/admin_navigation.php" ?>
<div id="wrapper">
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Selamat Datang Admin Atmasphere Social Media
                        <!-- <small>
                            <small><?php
                                    echo ucwords($row['namaawal']);
                                    echo " ";
                                    echo ucwords($row['namaakhir']);
                                    ?></small>
                        </small> -->
                        <!-- <small class="pull-right" style="color: #000000; margin-top: 15px; text-align: center;">
                            <?php
                            date_default_timezone_set('Asia/Calcutta');
                            echo date('D M d, Y G:i a');
                            ?>
                        </small> -->
                    </h1>
                    <div class="text-center">
                    <img width ="60%" src="https://img.graphicsurf.com/2020/10/social-media-vector-flat-illustration.jpg">
                    </div>
                </div>
            </div>         
            <div class="row">
                <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
</div>
<?php include "includes/admin_footer.php" ?>