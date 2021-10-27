<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-3">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse-3">
            <ul class="nav navbar-nav">
            <a class="navbar-brand" href="admin/admin_login.php"><b style="font-size:19px;color:white">Atmasphere Social Media</b></a>
                <li><a href="index.php"><img src="https://img.icons8.com/dusk/30/000000/home.png"/></a></li>
                <?php if (logged_in()) : ?>
                    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Kategori <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <?php
                            $sql = "SELECT * FROM kategori ORDER by namakategori ASC";
                            $result = (query($sql));
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <li><a href="kategori.php?sub_id=<?php echo $row["id_kategori"] ?>">
                                        <option value=" <?php echo $row["namakategori"] ?> "> <?php echo $row["namakategori"]; ?></option>
                                    </a></li>
                            <?php
                            }
                            ?>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
            <?php
            if (isset($_COOKIE['email'])) {
                $_SESSION['email'] = $_COOKIE['email'];
                $sql = "SELECT * FROM users WHERE email ='$_COOKIE[email]'";
                $result = query($sql);
                confirm($result);
                $row = fetch_array($result);
                $post_pic = $row['foto'];
                $post_user_id = $row['user_id'];
            } else if (isset($_SESSION['email'])) {
                $sql = "SELECT * FROM users WHERE email ='$_SESSION[email]'";
                $result = query($sql);
                confirm($result);
                $row = fetch_array($result);
                $post_pic = $row['foto'];
                $post_user_id = $row['user_id'];
            }
            ?>
            <ul class="nav navbar-nav navbar-right">
                <!--Visible Before Login-->
                <?php if (!logged_in()) : ?>
                    <li><a href="login.php"><span class=""><img src="https://img.icons8.com/dusk/30/000000/login-rounded-right.png"/></span> Login</a></li>
                    <li><a href="register.php"><span class=""><img src="https://img.icons8.com/office/30/000000/user.png"/></span> Register</a></li>    
                <?php endif; ?>

                <!--Visible After Login-->
                <?php if (logged_in()) : ?>

                    <li><a href="tambahposting.php"><span class=""><img src="https://img.icons8.com/bubbles/30/000000/upload.png"/></span> Buat Postingan</a></li>
                    <li>
                        <span class="chat-img1 pull-right">
                            <?php
                            if (!strlen($post_pic) < 1 || !empty($post_pic)) {
                            ?>
                                <?php echo "<a href='fotoprofil/$row[foto]' target='_blank'><img src='fotoprofil/" . $row["foto"] . "' alt=' ' id='userpic' class='img-circle' style=' width: 40px; height: 40px; margin-top: 6px;'  /></a>"; ?>
                            <?php
                            } else {
                                echo "<img src='fotoprofil/user.png' alt='User' class='img-circle' style=' width: 40px; height: 40px; margin-top: 6px;'>";
                            }

                            ?>
                        </span>
                    </li>
                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">

                            <?php echo $row['username']; ?>

                            <b class="caret"></b></a>

                        <ul class="dropdown-menu">
                            <li><a href="profil.php"><i class="fa fa-fw fa-user-circle-o"></i>
                                    <?php
                                    echo ucwords($row['namaawal']);
                                    echo " ";
                                    echo ucwords($row['namaakhir']);
                                    ?>

                                </a></li>
                            <li><a href="editakun.php"><i class="fa fa-fw fa-gear"></i> Profil</a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="logout.php"><span class="fa fa-fw fa-power-off"></span> Log Out</a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <!--Cari-->
                <?php if (logged_in()) : ?>
                <li>
                    <a class="btn btn-default btn-outline btn-circle" data-toggle="collapse" href="#nav-collapse3" aria-expanded="false" aria-controls="nav-collapse3">Cari</a>
                </li>
                <?php endif; ?>
            </ul>
            <div class="collapse nav navbar-nav nav-collapse" id="nav-collapse3">
                <form class="navbar-form navbar-right" role="search" method="post" action="cari.php">
                    <div class="form-group">
                        <input name="search" type="text" class="form-control" placeholder="Cari" />
                    </div>
                    <button name="submit" type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                </form>
            </div>
        </div>
    </div>
</nav>
<?php if (logged_in()) : ?>
    <?php
    $sqlblock = "SELECT * FROM users WHERE user_id = '$post_user_id'";
    $resultblock = query($sqlblock);
    confirm($resultblock);
    $rowblock = fetch_array($resultblock);


    ?>
<?php endif; ?>


<script type="text/javascript">
    var x = '<?php echo $post_pic; ?>';
    var v = document.getElementById("userpic");
    if (x.length > 0) {
        v.style.visibility = "visible";
    } else {
        v.style.visibility = "hidden";
    }
</script>