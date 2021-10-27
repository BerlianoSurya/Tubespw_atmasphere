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
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <div class="text-center">
                            Kategori
                        </div>
                    </h1>
                    <div class="table-responsive">
                        <?php display_message();  ?>
                        <?php
                        $sql = "SELECT * FROM kategori";
                        $result = (query($sql));
                        if (row_count($result) <= 0) {
                        ?>
                            <div class="col-md-8 col-md-offset-2">
                                <div class='alert alert-danger text-center'><strong>Tidak Ada</strong></div>

                            </div>
                        <?php
                        } else {
                        ?>
                            <table id="mytable" class="table table-bordred table-striped">
                                <thead>
                                    <th>No</th>
                                    <th>Nama Kategori</th>
                                    <th>Edit</th>
                                    <th>Hapus</th>
                                </thead>
                                <?php
                                $k = 1;
                                while ($row = fetch_array($result)) {
                                    $sub_id = $row['id_kategori'];
                                ?>
                                    <tr class="<?php if (isset($classname)) echo $classname; ?>">
                                        <td>
                                            <?php echo $k; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["namakategori"]; ?>
                                        </td>
                                        <td>
                                            <a class="btn btn-primary btn-xs" href="admineditkategori.php?idkategori=<?php echo $row['id_kategori']; ?>"><span class="glyphicon glyphicon-edit"></span></a>
                                        </td>
                                        <td>
                                            <a href="adminkategori.php?delete_sub=<?php echo $sub_id ?>" onclick="return confirm('Apakah anda yakin ingin menghapusnya ?')">
                                                <p data-placement="top" data-toggle="tooltip" title="delete"><button class="btn btn-danger btn-xs" data-title="delete" data-toggle="modal" type="delete" data-target="#delete"><span class="glyphicon glyphicon-trash"></span></button></p>
                                            </a>
                                        </td>
                                    </tr>
                            <?php
                                    $k++;
                                }
                            }
                            echo "</table>";
                            ?>
                            <?php
                            if (isset($_GET['delete_sub'])) {
                                $del_id = $_GET['delete_sub'];
                                $sql1 = "DELETE FROM answers WHERE id_kategori='$del_id'";
                                query($sql1);
                                $sql2 = "DELETE FROM postingan WHERE id_kategori='$del_id'";
                                query($sql2);
                                $sql = "DELETE FROM kategori WHERE id_kategori='$del_id'";
                                query($sql);
                                header("location: adminkategori.php");
                                set_message("<div class='alert alert-danger'>
            <strong>Berhasil</strong> Menghapus Kategori
            </div>
            <script type='text/javascript'>
                window.setTimeout(function() {
                $('.alert').fadeTo(500, 0).slideUp(500, function(){
                $(this).remove(); 
            }); }, 2000);
            </script>
            "); }
                            ?>
                            </table>
                            <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "includes/admin_footer.php" ?>