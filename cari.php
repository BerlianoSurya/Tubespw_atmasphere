<?php include("includes/header.php") ?>
<?php include("includes/nav.php") ?>

<div class="col-md-8 col-md-offset-2">
    <div class="well" style="background-color: White;">
        <form action="" method="post">
            <div class="input-group">
                <input name="search" type="text" class="form-control" placeholder="Cari...">
                <span class="input-group-btn">
                    <button name="submit" class="btn btn-default btn-larg" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
    </div>
</div>
<?php
if (isset($_POST['submit'])) {
    $search = $_POST['search'];
    if (!empty($search)) {
        $query = "SELECT * FROM kategori
        JOIN postingan
        ON kategori.id_kategori = postingan.idkategori WHERE postingan.deskripsi LIKE '%$search%' order by idpostingan desc";
        $search = query($query);
        if (!$search) {
            die("QUERY FAILED" . mysqli_error($connection));
        }
        $count = mysqli_num_rows($search);
        if ($count == 0) {
?>
            <div class="col-md-8 col-md-offset-2">
                <div id="text-font">
                    <div class="well" style="background-color: white;">
                        <div class='alert alert-danger text-center'><strong>Postingan Yang Anda Cari Tidak Ada</strong></div>
                        <div class="text-center">
                            <a class="btn btn-primary" href="cari.php" role="button">Ok</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } else {
            $i = 1;
            while ($row = fetch_array($search)) {
                $kategori = $row["namakategori"];
                $ques  = htmlspecialchars_decode($row["deskripsi"]);
                $q_id  = $row["idpostingan"];
                $email = $row["emailpengupload"];
                $dateTime = $row["waktu"];
                $newDate = date('j-F-Y \a\t g:i a', strtotime($dateTime));
                $userID = $row["idpengupload"];
            ?>
                <div class="col-md-8 col-md-offset-2">
                    <div class="well" style="background-color:white;">
                        <?php if (!logged_in()) : ?>
                            <span class="pull-right"><a href="login.php" style="margin-bottom: 0px;" class="">Login</span>
                        <?php endif; ?>
                        <div class="pull-left image">
                            <?php
                            $s = "SELECT * FROM users WHERE email = '$email'";
                            $res = query($s);
                            confirm($res);
                            $r = fetch_array($res);
                            ?>
                            <?php echo "<a href='fotoprofil/$r[foto]' target='_blank'><img src='fotoprofil/" . $r["foto"] . "' id='userpic' class='img-circle' style=' width: 60px; height: 60px; margin: 6px;'  /></a>"; ?>
                        </div>
                        <div style="margin-top: 15px;">
                            <p>
                                Pengupload :
                                <a href="cekprofil.php?user_id=<?php echo $r['user_id']; ?>" style="text-decoration:none;">
                                    <b>
                                        <?php
                                        $sqlUserName = "SELECT * FROM users WHERE user_id = '$userID'";
                                        $resultUserName = query($sqlUserName);
                                        confirm($resultUserName);
                                        $rowUserName = fetch_array($resultUserName);

                                        echo ucwords($rowUserName['namaawal']);
                                        echo " ";
                                        echo ucwords($rowUserName['namaakhir']);
                                        ?>
                                    </b>
                                </a>
                            </p>

                            <h6 class="text-muted time">
                                <p><span class="glyphicon glyphicon-time"></span> Waktu
                                    <?php echo $newDate; ?>
                                </p>
                            </h6>
                        </div>
                        <br>
                        <center>
                            <img src="postingan/<?= $row['foto'] ?>" width="300px">
                        </center>
                        <hr>
                        <h4 style="color:black; font-family: Times New Roman;">
                            <center>
                                <h4 style="color:#1A0DB3; font-family: Arial, Helvetica, sans-serif;">
                                    <?php echo "{$ques}" ?>
                                </h4>
                                <p class="pull-right"><b>Kategori : </b>
                                    <?php echo $row["namakategori"]; ?>
                                </p>
                                <br>
                            </center>
                        </h4>
                    </div>
                </div>

<?php

                $i++;
            }
        }
    }
}
mysqli_close($con);
?>
<script type="text/javascript">
    function refreshPage() {
        if (confirm("Apakah Anda Yakin, want to refresh?")) {
            location.reload();
        }
    }
</script>




<?php include("includes/footer.php") ?>