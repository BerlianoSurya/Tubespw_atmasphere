<?php include "includes/admin_header.php" ?>
<?php
if (admin_logged_in()) {
} else {
    redirect("admin_login.php");
}
?>
<div id="wrapper">
    <?php include "includes/admin_navigation.php" ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <div class="text-center"> Postingan</div>
                    </h1>
                    <?php display_message(); ?>
                    <?php
                    $sql = "SELECT * FROM kategori
                    INNER JOIN postingan ON kategori.id_kategori=postingan.idkategori  ORDER BY idpostingan DESC";
                    $result = (query($sql));
                    if (row_count($result) <= 0) {
                    ?>
                        <div class="col-md-8 col-md-offset-2">
                            <div class='alert alert-danger text-center'><strong>Tidak Ada !</strong></div>
                        </div>
                    <?php
                    } else {
                        $i = 1;
                    ?>
                        <!-- <div class="table-responsive"> -->
                        <!-- <table id="mytable" class="table table-bordred table-striped"> -->
                        <table class="table table-bordred table-hover">
                            <thead>
                                <tr>
                                    <th>Caption</th>
                                    <th>No Postingan</th>
                                    <th>Kategori</th>
                                    <th>Pengupload</th>
                                    <th>Waktu</th>
                                    <th>Hapus</th>
                                </tr>
                            </thead>
                            <?php
                            while ($row = mysqli_fetch_array($result)) {
                                $id = $row["idpostingan"];
                                $date = $row["waktu"];
                                $idpengupload = $row["idpengupload"];
                                $dt = date("g:i a - d/m/Y", strtotime($date));
                            ?>
                                <tr class="<?php if (isset($classname)) echo $classname; ?>">
                                    <td>
                                        <?php echo htmlspecialchars_decode($row["deskripsi"]); ?>
                                    </td>
                                    <th>
                                        <b><?php echo $row["id_kategori"]; ?></b>
                                    </th>
                                    <td>
                                        <p style="color:#1A0DB3;"><?php echo $row["namakategori"]; ?></p>
                                    </td>
                                    <td>
                                        <?php
                                        $sq = "SELECT * FROM users WHERE user_id = $idpengupload";
                                        $res = query($sq);
                                        confirm($res);
                                        $roww = fetch_array($res);
                                        $firstName = ucwords($roww["namaawal"]);
                                        $lastName = ucwords($roww["namaakhir"]);
                                        echo "{$firstName}";
                                        echo " ";
                                        echo "{$lastName}";
                                        ?>
                                        <br>
                                        <?php
                                        echo $roww["email"];
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo $dt; ?>
                                    </td>
                                    <td>
                                        <a href="adminpostingan.php?delete=<?php echo $id ?>" onclick="return confirm('Apakah anda yakin ingin menghapusnya ?')">
                                            <p data-placement="top" data-toggle="tooltip" title="delete"><button class="btn btn-danger btn-xs" data-title="delete" data-toggle="modal" type="delete" data-target="#delete"><span class="glyphicon glyphicon-trash"></span></button></p>
                                        </a>
                                    </td>
                                </tr>
                        <?php
                                $i++;
                            }
                        }
                        echo "</table>";
                        ?>
                        <?php
                        if (isset($_GET['delete'])) {
                            $delete_id = $_GET['delete'];
                            $sql1 = "DELETE FROM answers WHERE idpostingan='$delete_id'";
                            query($sql1);
                            $sql = "DELETE FROM postingan WHERE idpostingan='$delete_id'";
                            query($sql);
                            header("location: adminpostingan.php");

                            set_message("<div class='alert alert-danger'>
                        <strong>Berhasil</strong> Menghapus Postingan
                            </div>
                                <script type='text/javascript'>
                                window.setTimeout(function() {
                                    $('.alert').fadeTo(500, 0).slideUp(500, function(){
                                    $(this).remove(); 
                                });
                                }, 2000);
                                </script>
                            ");
                        }
                        ?>
                        </table>
                        <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "includes/admin_footer.php" ?>