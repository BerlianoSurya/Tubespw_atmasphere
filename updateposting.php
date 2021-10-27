<?php
include("functions/init.php");
    if (isset($_POST['perbarui'])) {
        $idpostingan = $_POST['idpostingan'];
        $kategori = $_POST['id_kategori'];
        $deskripsi = $_POST['deskripsi'];
        $cekfoto = $_FILES["foto"]["name"];
            if ($cekfoto != "") {  
                $namafoto = $_FILES['foto']['name'];
                $lokasifoto = $_FILES['foto']['tmp_name'];
                move_uploaded_file($lokasifoto, "postingan/" . $namafoto);
                $sql = "UPDATE postingan SET
                idkategori='" . $kategori . "',
                deskripsi='" . $deskripsi . "',
                foto='" . $namafoto . "'
                WHERE idpostingan='" . $idpostingan . "'";
                $result = query($sql);
                confirm($result);
                set_message("<div class='alert alert-success'>
                <strong>Berhasil</strong> Postingan Berhasil Di Ubah</div> 
                <script type='text/javascript'>
                window.setTimeout(function() {
                $('.alert').fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove(); 
                });
                }, 5000);
                </script>
                ");
                redirect("profil.php");
            } else {
                $sql = "UPDATE postingan SET
                idkategori='" . $kategori . "',
                deskripsi='" . $deskripsi . "'
                WHERE idpostingan='" . $idpostingan . "'";
                $result = query($sql);
                confirm($result);
                set_message("<div class='alert alert-success'>
                <strong>Berhasil</strong> Postingan Berhasil Di Ubah</div> 
                <script type='text/javascript'>
                window.setTimeout(function() {
                $('.alert').fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove(); 
                });
                }, 5000);
                </script>
                ");
                redirect("profil.php");
            }
    } else {
        echo "duar";
    }
