<?php
include("functions/init.php");
$id = $_GET['idpostingan'];
$sql = "DELETE FROM postingan WHERE idpostingan='" . $id . "'";
$result = query($sql);
confirm($result);
set_message("<div class='alert alert-success'>
                <strong>Berhasil</strong> Postingan Berhasil Di Hapus</div> 
                <script type='text/javascript'>
                window.setTimeout(function() {
                $('.alert').fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove(); 
                });
                }, 5000);
                </script>
                ");
redirect("profil.php");
