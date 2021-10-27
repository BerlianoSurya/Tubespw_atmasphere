<?php include "includes/admin_header.php" ?>
<?php
if (admin_logged_in()) {
} else {
	redirect("admin_login.php");
}
?>
<?php include "includes/admin_navigation.php" ?>
<?php
    if (isset($_GET['idkategori'])) {
        $sql = "SELECT * FROM kategori WHERE id_kategori='" . $_GET['idkategori'] . "'";
        $ress = mysqli_query($con, $sql);
        $data = mysqli_fetch_array($ress);
    }
    ?>
<div id="wrapper">
	<div class="container-fluid">
		<div id="page-wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-8 col-md-offset-2" style="padding-bottom: 100px;">
						<div class="text-center">
							<h1 class="page-header">
								Edit Kategori
							</h1>

							<?php display_message();  ?>
							<?php validasi_admintambahkategori(); ?>

						</div>
						<div class="well well-sm" style="background-color:white;">
							<form method="post" action="updatekategori.php">
								<div class="row">
									<div class="col-md-10 col-md-offset-1">
										<br>
										<div class="form-group">
											<label for="name">Nama Kategori</label>
                                            <input type="hidden" 
													class="form-control" 
													name="idkategori" 
													value="<?= $data['id_kategori'] ?>" required>
											<input type="text" 
													class="form-control" 
													id="kategori_name" 
													name="kategori_name" value="<?= $data['namakategori'] ?>" placeholder="Nama Kategori" required>
											<br>
											<button type="submit" 
													name="perbarui" 
													class="btn btn-success pull-right" 
													id="btnContactUs" 
													value="Go!">
													Simpan</button>
										</div>
									</div>
								</div>
								<br>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include "includes/admin_footer.php" ?>