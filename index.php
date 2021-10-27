<!-- Index of users -->
<?php include("includes/header.php") ?>
<?php include("includes/nav.php") ?>
<div class="container">
    <?php if (logged_in()) { ?>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="col-sm-12">
                    <div class="panel panel-white post panel-shadow">

                        <?php display_message();  ?>

                        <div class="post-heading">

                            <?php
                            if (isset($_SESSION['email'])) {
                                $sql = "SELECT * FROM users WHERE email='$_SESSION[email]'";
                                $result = query($sql);
                                confirm($result);
                                $row = fetch_array($result);
                                $post_pic = $row['foto'];
                            ?>

                                <span class="chat-img1 pull-left">
                                    <?php
                                    if (!strlen($post_pic) < 1 || !empty($post_pic)) {
                                    ?>
                                        <?php echo "<a href='fotoprofil/$row[foto]' target='_blank'><img src='fotoprofil/" . $row["foto"] . "' alt=' ' id='userpic' class='img-circle' style=' width: 40px; height: 40px; margin: 6px;'  /></a>"; ?>
                                    <?php
                                    } else {
                                        echo "<img src='fotoprofil/user.png' alt='User' class='img-circle' style=' width: 40px; height: 40px; margin-top: 6px;'>";
                                    }

                                    ?>


                                </span>
                                &nbsp;&nbsp;
                            <?php
                                echo ucwords($row['namaawal']);
                                echo " ";
                                echo ucwords($row['namaakhir']);
                            }
                            ?>
                            <div style="">
                                <p><a href="tambahposting.php" style="text-decoration: none; font-size:20px;"> &nbsp; Posting Cerita Anda <script language="javascript">
                                            DisplayVisits();
                                        </script> </a></p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-8 col-md-offset-2">
                <?php
                $sql = "SELECT * FROM kategori
            JOIN postingan
            ON kategori.id_kategori = postingan.idkategori order by idpostingan desc";
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
    <?php } else { ?>
        <div class="row">
            <div class="col-md-12">
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                        <div class="item">
                            <img class="third-slide" style="height:650px;width:100%;" src="https://corefreelancers.id/wp-content/uploads/2020/02/panel-sosmed-1024x683.png" height="250px" alt="Third slide">
                            <div class="container">
                                <div class="carousel-caption">
                                    <p><a class="btn btn-lg btn-primary" href="login.php" role="button">Atmasphere Social Media</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                        <!-- <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span> -->
                    </a>
                    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                        <!-- <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span> -->
                    </a>
                </div>
            </div>
        </div>
        <br><br>
        <div class="row">
            <div class="col-md-4">
                <img src="img/1.jpg" width="95%">
            </div>
            <div class="col-md-4">
                <img src="https://www.iamsinc.com/wp-content/uploads/social-media-P8LWDNR-720x360.jpg" width="100%">
            </div>
            <div class="col-md-4">
                <img src="img/2.jpg" width="100%">
            </div>
        </div>
        <br><br>
        <div class="row">
            <div class="col-md-12">
            <h2 class="text-center">Lokasi Admin Atmasphere Social Media</h2>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.0885094721193!2d110.41192221477816!3d-7.7804398943928765!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a59efe143b3d9%3A0x48def21d296c3765!2sUniversitas%20Atma%20Jaya%20Yogyakarta!5e0!3m2!1sid!2sid!4v1634745766828!5m2!1sid!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
        <br><br>
    <?php } ?>
</div>



<script language="javascript">
    function DisplayVisits() {
        // How many visits so far? 
        var numVisits = GetCookie("numVisits");
        if (numVisits) numVisits = parseInt(numVisits) + 1;
        else numVisits = 1; // the value for the new cookie 

        // Show the number of visits 
        if (numVisits == 1) document.write("This is your first visit.");
        else document.write("You have visited this page " + numVisits + " times.");

        // Set the cookie to expire 365 days from now 
        var today = new Date();
        today.setTime(today.getTime() + 365 /*days*/ * 24 /*hours*/ * 60 /*minutes*/ * 60 /*seconds*/ * 1000 /*milliseconds*/ );
        SetCookie("numVisits", numVisits, today);
    }
</script>

<?php include("includes/footer.php") ?>
