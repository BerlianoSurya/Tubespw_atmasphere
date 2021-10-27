<?php
include("functions/admin_init.php");
if (isset($_POST['perbarui'])) {
    $idkategori = $_POST['idkategori'];
    $namakategori = $_POST['kategori_name'];
        $sql = "UPDATE kategori SET
                namakategori='" . $namakategori . "'
                WHERE id_kategori ='" . $idkategori . "'";
        $result = query($sql);
        confirm($result);
        set_message("<div class='alert alert-success'>
                <strong>Berhasil</strong> Kategori Berhasil Di Ubah</div> 
                <script type='text/javascript'>
                window.setTimeout(function() {
                $('.alert').fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove(); 
                });
                }, 5000);
                </script>
                ");
        redirect("adminkategori.php");
}