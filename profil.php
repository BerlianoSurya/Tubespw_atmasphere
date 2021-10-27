<?php include("includes/header.php") ?>
<?php

if (logged_in()) {
} else {

  redirect("login.php");
}

?>
<?php include("includes/nav.php") ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12 ">
      <div class="panel panel-white post panel-shadow">
        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <div class="text-center">
              <h2 style="color:royalblue;">
                <?php
                if (isset($_SESSION['email']))
                  $sql = "SELECT * FROM users WHERE email ='$_SESSION[email]'";
                $result = query($sql);
                confirm($result);
                $row = fetch_array($result);
                echo ucwords($row['namaawal']);
                echo " ";
                echo ucwords($row['namaakhir']);
                ?>

              </h2>
            </div>

            <div class="panel panel-primary">
              <div class="panel-body ">
                <form action="#" method="post" class="form-horizontal">
                  <div class="form-group">
                    <center>
                      <div class="col-sm-12">
                        <div class="custom-input-file">
                          <label class="uploadPhoto">
                            <?php
                            if (!strlen($post_pic) < 1 || !empty($post_pic)) {
                            ?>
                              <?php echo "<a href='fotoprofil/$row[foto]' target='_blank'><img src='fotoprofil/" . $row["foto"] . "' alt=' ' class='img-circle' style=' width: 140px; height: 140px;'  /></a>"; ?>
                            <?php
                            } else {
                              echo "<img src='fotoprofil/user.png' alt='User' class='img-circle' style=' width: 140px; height: 140px; margin-top: 6px;'>";
                            }
                            ?>
                          </label>
                        </div>
                      </div>
                    </center>
                  </div>
                  <div class="form-group">
                    <label for="name" class="col-sm-2">Username</label>
                    <div class="col-sm-10">

                      <p style="color:#02225a;"> <?php echo $row['username']; ?> </p>

                    </div>
                  </div>

                  <div class="form-group">
                    <label for="nickName" class="col-sm-2">Name</label>
                    <div class="col-sm-10">
                      <p style="color:#02225a;">
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
                      <p style="color:#02225a;"> <?php echo $row['email']; ?> </p>
                    </div>
                  </div>


                  <div class="form-group">
                    <label for="newPassword" class="col-sm-2">Alamat</label>
                    <div class="col-sm-10">
                      <p style="color:#02225a;"><?php echo $row['alamat']; ?></p>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <a href="editakun.php" class="btn btn-primary btn-circle pull-right"> Edit </a>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <center>
              <h3>Riwayat Postingan</h3>
            </center>
            <?php display_message(); ?>
            <br>
            <div class="col-md-8 col-md-offset-2">
              <?php
              $a_id = $row['user_id'];
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
                    <br>
                    <div style="padding-right:10px" class="pull-right">
                      <a class="btn btn-primary" href="editposting.php?idpostingan=<?php echo $row['idpostingan']; ?>">Edit</a>
                      <a class="btn btn-danger" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus')" href="hapusposting.php?idpostingan=<?php echo $row['idpostingan']; ?>">Hapus</a>
                    </div>
                    <br>
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