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
                        <div class="text-center">Daftar User</div>
                    </h1>
                    <?php display_message();  ?>
                    <?php
                    $sql = "SELECT * FROM users";
                    $result = (query($sql));
                    if (row_count($result) <= 0) {
                    ?>
                        <div class="col-md-8 col-md-offset-2">
                            <div class='alert alert-danger text-center'><strong>Tidak Ada !</strong></div>
                        </div>
                    <?php
                    } else {

                    ?>
                        <div class="table-responsive">
                            <table id="mytable" class="table table-bordred table-striped">
                                <thead>
                                    <th>No</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Nama</th>
                                    <th>Hapus</th>
                                </thead>
                                <?php
                                while ($row = fetch_array($result)) {
                                    $id = $row["user_id"];
                                ?>
                                    <tr class="<?php if (isset($classname)) echo $classname; ?>">
                                        <td>
                                            <?php echo $row["user_id"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["username"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["email"]; ?>
                                        </td>
                                        <td>
                                            <?php echo ucwords($row["namaawal"]); ?>
                                            <?php echo ucwords($row["namaakhir"]); ?>
                                        </td>
                                        <td>
                                            <a href="daftaruser.php?delete_user=<?php echo $id ?>" onclick="return confirm('Apakah Anda Yakin ?')">
                                                <p data-placement="top" data-toggle="tooltip" title="delete">
                                                    <button class="btn btn-danger btn-xs" data-title="delete" data-toggle="modal" type="delete" data-target="#delete">
                                                        <span class="glyphicon glyphicon-trash"></span></button>
                                                </p>
                                            </a>
                                        </td>
                                    </tr>

                            <?php
                                }
                            }
                            echo "</table>";
                            ?>
                            <?php
                            if (isset($_GET['delete_user'])) {
                                $del_id = $_GET['delete_user'];
                                $sql2 = "DELETE FROM postingan WHERE idpengupload='$del_id'";
                                query($sql);
                                $sql3 = "DELETE FROM users WHERE user_id='$del_id'";
                                query($sql3);
                                header("location: daftaruser.php");
                                set_message("<div class='alert alert-danger'>
                                <strong>Berhasil</strong> Hapus User</div>
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

        <script type="text/javascript">
            function func(q) {
                document.getElementById('user_id_input').value = q;
            }
        </script>
    </div>
</div>

<script type="text/javascript">
    function fun(p) {
        document.getElementById('q_id_input').value = p;
    }
</script>

<?php include "includes/admin_footer.php" ?>