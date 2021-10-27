<?php include("includes/header.php") ?>
<?php

if (logged_in()) {
} else {

    redirect("login.php");
}

?>
<?php include("includes/nav.php") ?>
<div class="container-fluid">
    <div class="col-md-8 col-md-offset-2">
        <?php display_message(); ?>
        <?php validasi_tambahposting(); ?>
    </div>

    <?php
    $sql = "SELECT * FROM kategori ORDER by namakategori ASC";
    $result = (query($sql));
    $i = 1;
    ?>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <h1>Tambah Postingan</h1>
            <div class="panel panel-white post panel-shadow">
                <div class="post-description">
                    <form method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="kategori">Kategori Upload</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-list"></span>
                                        </span>
                                        <select id="kategori" name="id_kategori" class="form-control">
                                            <option value="0" selected="">Pilih Kategori</option>


                                            <?php
                                            while ($row = mysqli_fetch_array($result)) {
                                                $id_kategori = $row["id_kategori"];
                                            ?>

                                                <li>
                                                    <option value=" <?php echo $row["id_kategori"] ?>"> <?php echo $row["namakategori"]; ?></option>
                                                </li>
                                            <?php
                                                $i++;
                                            }
                                            echo "</table>";
                                            mysqli_close($con);
                                            ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name">Cerita</label>
                                    <textarea name="deskripsi" class="form-control" rows="9" cols="25" placeholder="Tulis Cerita Anda Di Sini" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="foto">Foto</label>
                                    <input type="file" name="foto" class="form-control" accept="image/png, image/gif, image/jpeg">
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="submit" id="submit" class="btn btn-success pull-right" value="Simpan">
                                        Simpan</button>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include("includes/footer.php") ?>