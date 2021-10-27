<?php include("includes/header.php") ?>

<?php include("includes/nav.php") ?>

<?php
if (isset($_GET['sub_id'])) {
    $sub_id = $_GET['sub_id'];
?>
    <div class="text-center">
        <h1>
            <div class="col-md-8 col-md-offset-2" style="color:#4267B2;">
                <div class="panel panel-primary" style="background-color: White;">
                    <div class="panel-body text-center">
                        <?php
                        $sql = "SELECT * FROM kategori WHERE id_kategori    = '$sub_id'";
                        $result = query($sql);
                        confirm($result);
                        $row = fetch_array($result);
                        echo ucwords($row['namakategori']);
                        ?>
                    </div>
                </div>
            </div>
        </h1>
    </div>
    <div class="col-md-8 col-md-offset-2">
        <?php
        $sql = "SELECT * FROM kategori
    JOIN postingan
    ON kategori.id_kategori = postingan.idkategori WHERE kategori.id_kategori = '$sub_id' order by idpostingan desc";
        $result = (query($sql));
        if (row_count($result) <= 0) {
        ?>
            <div class="panel panel-primary">
                <div class="panel-body text-center">
                    <div class='alert alert-danger text-center'><strong>Postingan Tidak Ada</strong> <br></div>
                </div>
            </div>

            <?php
        } else {
            $i = 1;
            while ($row = fetch_array($result)) {
                $kategori = $row["namakategori"];
                $ques  = htmlspecialchars_decode($row["deskripsi"]);
                $email = $row["emailpengupload"];
                $dateTime = $row["waktu"];
                $newDate = date('j-F-Y \a\t g:i a', strtotime($dateTime));
                $userID = $row["idpengupload"];
                $q_id = $row["idpostingan"];
            ?>
                <div class="panel panel-primary">
                    <div class="panel-body ">
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
                      <br>
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
                        <hr>
                    </div>
                </div>
    <?php
                $i++;
            }
        }
    }
    ?>
    </div>
    <?php include("includes/footer.php") ?>