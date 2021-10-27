<?php include("includes/header.php") ?>
<?php include("includes/nav.php") ?>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12 ">
      <div class="panel panel-white post panel-shadow" style="background-color: #B0E0E6;">
        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <div class="text-center">
              <h2 style="color:royalblue;">
              </h2>
            </div>
            <?php
            if (isset($_GET['user_id'])) {
              $a_id = $_GET['user_id'];

              $sql1 = "SELECT * FROM users WHERE user_id ='$a_id'";
              $result1 = query($sql1);
              confirm($result1);
              $row = fetch_array($result1);
            ?>
              <div class="panel panel-primary">
                <div class="panel-body ">
                  <form action="#" method="post" class="form-horizontal">
                    <div class="form-group">
                      <label for="avatar" class="col-sm-2">
                        <!--Username-->
                      </label>
                      <center>
                        <div class="col-sm-12">
                          <div class="custom-input-file">
                            <label class="uploadPhoto">
                              <?php echo "<a href='fotoprofil/$row[foto]' target='_blank'><img src='fotoprofil/" . $row["foto"] . "' alt=' ' class='img-circle' style=' width: 140px; height: 140px;'  /></a>"; ?>
                            </label>
                          </div>
                        </div>
                      </center>
                    </div>
                    <hr style="border-color: #4169E1">
                    <div class="form-group">
                      <label for="name" class="col-sm-2">Username</label>
                      <div class="col-sm-10">
                        <p style="color:#02225a;">: <?php echo $row['username']; ?> </p>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="nickName" class="col-sm-2">Nama</label>
                      <div class="col-sm-10">
                        <p style="color:#02225a;">:
                          <?php
                          echo ucwords($row['namaawal']);
                          echo " ";
                          echo ucwords($row['namaakhir']);
                          ?>
                        </p>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="email" class="col-sm-2">Email</label>
                      <div class="col-sm-10">
                        <p style="color:#02225a;">: <?php echo $row['email']; ?> </p>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="newPassword" class="col-sm-2">Alamat</label>
                      <div class="col-sm-10">
                        <p style="color:#02225a;">: <?php echo $row['alamat']; ?></p>
                      </div>
                    </div>
                    <hr style="border-color: #4169E1">
                  </form>
                </div>
              </div>
            <?php } ?>
            <center>
              <h3>Riwayat Postingan</h3>
            </center>
            <br>
            <div class="col-md-8 col-md-offset-2">
              <?php
              $sql = "SELECT * FROM kategori
            JOIN postingan
            ON kategori.id_kategori = postingan.idkategori where postingan.idpengupload = '$a_id' order by idpostingan desc";
              $result = (query($sql));
              $count = 1;
              while ($row = fetch_array($result)) {
                $ques  = htmlspecialchars_decode($row["deskripsi"]);
                $email = $row["emailpengupload"];
                $dateTime = $row["waktu"];
                $newDate = date('j-F-Y \a\t g:i a', strtotime($dateTime));
                $userID = $row["idpengupload"];
                $q_id = $row["idpostingan"];
              ?>
                <div class="col-sm-12">
                  <div class="panel panel-white post panel-shadow">
                    <div class="post-heading" style="margin-bottom:0px;">
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
                    </div>
                  </div>
                </div>
              <?php
                $count++;
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include("includes/footer.php") ?>