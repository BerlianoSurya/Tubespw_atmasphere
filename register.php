<?php include("includes/header.php") ?>
<?php include("includes/nav.php") ?>
 <?php

  	if(!logged_in()){

  	} else {

  		redirect("index.php");
  	}

?>
<div class="row">
	<div class="col-lg-6 col-lg-offset-3">
	
		<?php display_message(); ?>
		<?php validasi_userdaftar(); ?>

	</div>
</div> 
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-login">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-6">
						<a href="login.php">Login</a>
					</div>
					<div class="col-xs-6">
						<a href="register.php" class="active" id="">Daftar</a>
					</div>
				</div>
				<hr>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-12">
						<form id="register-form" method="post" role="form" >
							<div class="form-group">
								<input type="text" name="namaawal" id="namaawal" tabindex="1" class="form-control" placeholder="Nama Awal" value="" required >
							</div>
							<div class="form-group">
								<input type="text" name="namaakhir" id="namaakhir" tabindex="1" class="form-control" placeholder="Nama Akhir" value="" required >
							</div>
							<div class="form-group">
								<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="" required >
							</div>
							<div class="form-group">
								<input type="email" name="email" id="register_email" tabindex="1" class="form-control" placeholder="Email" value=""  required >
							</div>
							<div class="form-group">
								<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password" required>
							</div>
							<div class="form-group">
								<input type="password" name="confirm_password" id="confirm-password" tabindex="2" class="form-control" placeholder="Konfirmasi Password" required>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-sm-6 col-sm-offset-3">
										<input type="submit" name="register-submit" id="register-submit" onclick='Javascript:checkEmail();'  tabindex="4" class="form-control btn btn-register" value="Daftar Sekarang">
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include("includes/footer.php") ?>