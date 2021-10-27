<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function clean($string)
{
	return htmlentities($string);
}
function redirect($location)
{
	return header("Location:{$location}");
}
function set_message($message)
{
	if (!empty($message)) {
		$_SESSION['message'] = $message;
	} else {
		$message = "";
	}
}
function display_message()
{
	if (isset($_SESSION['message'])) {
		echo $_SESSION['message'];
		unset($_SESSION['message']);
	}
}
function token_generator()
{
	$token = $_SESSION['token'] = md5(uniqid(mt_rand(), true));
	return $token;
}
function validation_errors($error_message)
{
	$error_message = <<<DELIMITER
	<div class="alert alert-danger alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<strong>Warning!</strong> $error_message;
	</div>
	<script type='text/javascript'>
    window.setTimeout(function() {
    $('.alert').fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    }); }, 5000);
	</script>
DELIMITER;
	return $error_message;
}
function emailada($email)
{
	$sql = "SELECT user_id FROM users WHERE email = '$email'";
	$result = query($sql);
	if (row_count($result) == 1) {
		return true;
	} else {
		return false;
	}
}
function details_ada($email)
{
	$sql = "SELECT user_id FROM users WHERE email = '$email' AND active = 0";
	$result = query($sql);
	if (row_count($result) == 1) {
		return true;
	} else {
		return false;
	}
}
function ceksetuju($email)
{
	$sql = "SELECT user_id FROM users WHERE email = '$email'";
	$result = query($sql);
	if (row_count($result) == 1) {
		return true;
	} else {
		return false;
	}
}
function logindetailada($email)
{
	$sql = "SELECT user_id FROM users WHERE email = '$email' AND active = 1";
	$result = query($sql);
	if (row_count($result) == 1) {
		return true;
	} else {
		return false;
	}
}
function usernameada($username)
{
	$sql = "SELECT user_id FROM users WHERE username = '$username'";
	$result = query($sql);
	if (row_count($result) == 1) {
		return true;
	} else {
		return false;
	}
}
function send_email($email, $subject, $msg, $headers)
{
	return mail($email, $subject, $msg, $headers);
}
function validEmail($email)
{
	if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email)) {
		return false;
	}
	$email_array = explode("@", $email);
	$local_array = explode(".", $email_array[0]);
	for ($i = 0; $i < sizeof($local_array); $i++) {
		if (!preg_match("/^(([A-Za-z0-9!#$%&'*+\/=?^_`{|}~-][A-Za-z0-9!#$%&'*+\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[$i])) {
			return false;
		}
	}
	if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1])) {
		$domain_array = explode(".", $email_array[1]);
		if (sizeof($domain_array) < 2) {
			return false;
		}
		for ($i = 0; $i < sizeof($domain_array); $i++) {
			if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i])) {
				return false;
			}
		}
	}
	return true;
}
function validasi_userdaftar()
{
	$errors = [];
	$min = 3;
	$max = 20;
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$namaawal	     = clean($_POST['namaawal']);
		$namaakhir	     = clean($_POST['namaakhir']);
		$username		 = clean($_POST['username']);
		$email	  		 = clean($_POST['email']);
		$password  		 = clean($_POST['password']);
		$confirm_password = clean($_POST['confirm_password']);
		if (emailada($email)) {
			$errors[] = "Email Telah Terdaftar";
		}
		if (usernameada($username)) {
			$errors[] = "Username Telah Terdaftar";
		}
		if (strlen($email) < $min) {

			$errors[] = "Email Salah";
		}
		if ($password !== $confirm_password) {

			$errors[] = "Password Tidak Sama";
		}
		if (empty($password)) {
			$errors[] = "Masukkan Password";
		}
		if (empty($confirm_password)) {
			$errors[] = "Masukkan Konfirmasi Password";
		}
		if (!empty($errors)) {
			foreach ($errors as $error) {
				echo validation_errors($error);
			}
		} else {
			if (register_user($namaawal, $namaakhir, $username, $email, $password)) {
				set_message("<div class='alert alert-success'>
    			<strong>Selamat Anda Berhasil Mendaftar </strong>Silahkan Cek Email Anda, dan Jika Tidak Ada cek di Spam</div> 
				<script type='text/javascript'>
    				window.setTimeout(function() {
    				$('.alert').fadeTo(500, 0).slideUp(500, function(){
        			$(this).remove(); 
    				});
					}, 2000);
				</script>
    			");
				redirect("register.php");
			} else {
				set_message("<div class='bg-danger text-center'>Gagal</div>
				<script type='text/javascript'>
    				window.setTimeout(function() {
    					$('.alert').fadeTo(500, 0).slideUp(500, function(){
        				$(this).remove(); 
    				});
					}, 2000);
				</script>	
			");
				redirect("index.php");
			}
		}
	}
}
function register_user($namaawal, $namaakhir, $username, $email, $password)
{
	$namaawal = escape($namaawal);
	$namaakhir = escape($namaakhir);
	$username = escape($username);
	$email = escape($email);
	$password = escape($password);
	date_default_timezone_set('Asia/Kolkata');
	$date = date('Y-m-d H:i:s');

	if (emailada($email)) {
		return false;
	} else if (usernameada($username)) {
		return false;
	} else {
		$password = md5($password);
		$kodevalidasi = md5($username);

		$sql = "INSERT INTO users(namaawal,namaakhir,username,email,password,waktubuat,kodevalidasi,foto)";
		$sql .= "VALUES('$namaawal','$namaakhir','$username','$email','$password','$date','$kodevalidasi','user.png')";
		$result = query($sql);
		confirm($result);
		include('phpmailer/Exception.php');
		include('phpmailer/PHPMailer.php');
		include('phpmailer/SMTP.php');

		$mail = new PHPMailer(true);
		$mail->SMTPDebug = 0;
		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPAuth = true;
		$mail->Username = 'atmaspheresocial@gmail.com';
		$mail->Password = 'tezchroutqyvmpge';
		$mail->SMTPSecure = 'tls';
		$mail->Port = 587;
		$mail->setFrom('atmaspheresocial@gmail.com', 'Atmasphere Social Media');
		$mail->addAddress($email);
		$mail->addReplyTo('no-reply@gmail.com', 'Np-reply');
		$mail->isHTML(true);
		$mail->Subject = 'Aktivasi Akun';
		$mail->Body    = "Selamat Datang Di Atmasphere Social Media, Silahkan Klik <a href='http://atmasphere.xyz/activate.php?email=$email&code=$kodevalidasi'> 
		Link Ini</a> Untuk Mengaktivasi Akun Anda";
		$mail->AltBody = '';
		if (!$mail->send()) {
			echo 'Gagal';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
			echo 'Gagal';
		}
		return true;
	}
}

function activate_user()
{
	if ($_SERVER['REQUEST_METHOD'] == "GET") {

		if (isset($_GET['email'])) {

			$email = clean($_GET['email']);
			$kodevalidasi = clean($_GET['code']);
			$sql = "SELECT * FROM users WHERE email = '" . escape($_GET['email']) . "' AND kodevalidasi = '" . escape($_GET['code']) . "' AND active = 0";
			$result = query($sql);
			confirm($result);
			if (row_count($result) == 1) {
				$sql2 = "UPDATE users SET active = 1, kodevalidasi = 0 WHERE email = '" . escape($email) . "' AND kodevalidasi = '" . escape($kodevalidasi) . "' ";
				$result2 = query($sql2);
				confirm($result2);
				set_message("<div class='alert alert-success'>Akun Anda Berhasil Di Aktivasi Silahkan
     		<strong>Login</strong></div> 
			<script type='text/javascript'>
   			window.setTimeout(function() {
    		$('.alert').fadeTo(500, 0).slideUp(500, function(){
        	$(this).remove(); 
    		});}, 2500);
			</script>");
				redirect("login.php");
			} else {
				set_message("<div class='alert alert-danger'>
    	<strong>Maaf,</strong> Akun Gagal Di Aktivasi</div> 
		<script type='text/javascript'>
    	window.setTimeout(function() {
    	$('.alert').fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    	});}, 2500);
		</script>
    	");

				redirect("login.php");
			}
		}
	}
}
function active_ac()
{
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		if (isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
			$email = clean($_POST['email']);
			if (emailada($email)) {
				if (details_exits($email)) {
					$kodevalidasi = md5($email . microtime());
					setcookie('temp_access_code', $kodevalidasi, time() + 60);
					$sql = "UPDATE users SET kodevalidasi ='" . escape($kodevalidasi) . "'WHERE email ='" . escape($email) . "' ";
					$result = query($sql);
					confirm($result);
					require 'phpmailer/PHPMailerAutoload.php';
					$mail = new PHPMailer;
					$mail->isSMTP();
					$mail->Host = 'smtp.gmail.com';
					$mail->SMTPAuth = true;
					$mail->Username = 'atmaspheresocial@gmail.com';
					$mail->Password = 'tezchroutqyvmpge';
					$mail->SMTPSecure = 'tls';
					$mail->Port = 587;
					$mail->setFrom('atmaspheresocial@gmail.com', 'Online Discussion Forum');
					$mail->addAddress($email);
					$mail->addReplyTo('no-reply@gmail.com', 'Np-reply');

					$mail->isHTML(true);

					$mail->Subject = 'Activate Account';
					$mail->Body    = "Please click <a href='http://atmasphere.xyz/ODF/activate.php?email=$email&code=$kodevalidasi'>
					this link </a>to activate your Account";
					$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

					if (!$mail->send()) {
						echo 'Message could not be sent.';
						echo 'Mailer Error: ' . $mail->ErrorInfo;
					} else {
						echo 'Message has been sent';
					}




					set_message("<div class='alert alert-success'>
     Welcome  Please check your <strong>email</strong> or <strong>spam folder</strong> for a password reset code </div> 
	<script type='text/javascript'>
    window.setTimeout(function() {
    $('.alert').fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
	}, 2500);
	</script>
    ");


					redirect("index.php");
				} else {
					echo validation_errors("This email is already active");
				}
			} else {

				echo validation_errors("This emails does not exits");
			}
		} else {

			redirect("index.php");
		}
		if (isset($_POST['cancel_submit'])) {

			redirect("login.php");
		}
	}
}

function validasi_user_login()
{

	$errors = [];
	$min = 3;
	$max = 20;

	if ($_SERVER['REQUEST_METHOD'] == "POST") {


		$email	  		 = clean($_POST['email']);
		$password  		 = clean($_POST['password']);
		$remember 		 = isset($_POST['remember']);

		if (empty($email)) {

			$errors[] = "Email Kosong";
		}

		if (empty($password)) {

			$errors[] = "Password Kosong";
		}



		if (!empty($errors)) {

			foreach ($errors as $error) {

				echo validation_errors($error);
			}
		} else {


			if (emailada($email)) {
				if (logindetailada($email)) {
					if (ceksetuju($email)) {

						if (login_user($email, $password, $remember)) {

							set_message("<div class='alert alert-success'>
     Selamat Datang <strong>$_SESSION[email]</strong> Anda Berhasil Login</div> 
	<script type='text/javascript'>
    window.setTimeout(function() {
    $('.alert').fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
	}, 2000);
	</script>
    ");

							redirect("index.php");
						} else {

							echo validation_errors("Password Tidak Sama");
						}
					} else {

						echo validation_errors("Mohon Tunggu");
					}
				} else {

					echo validation_errors("Silahkan Aktivasi Dulu Akun Anda");
				}
			} else {

				echo validation_errors("Email Anda Tidak Di Kenali");
			}
		}
	}
}


function login_user($email, $password, $remember)
{
	$sql = "SELECT password, user_id FROM users WHERE email = '" . escape($email) . "'";
	$result = query($sql);
	$query = "UPDATE users SET online = 1 WHERE email = '" . escape($email) . "'";
	$resultQuery = query($query);
	confirm($resultQuery);

	if (row_count($result) == 1) {

		$row = fetch_array($result);
		$db_password = $row['password'];

		if (md5($password) === $db_password) {

			if ($remember == "on") {
				setcookie('email', $email, time() + 86400);
			}

			$_SESSION['email'] = $email;

			return true;
		} else {
			return false;
		}
		return true;
	} else {
		return false;
	}
}
function logged_in()
{
	if (isset($_SESSION['email']) || isset($_COOKIE['email'])) {

		return true;
	} else {

		return false;
	}
}
function randomCode()
{
	$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
	$pass = array();
	$alphaLength = strlen($alphabet) - 1;
	for ($i = 0; $i < 8; $i++) {
		$n = rand(0, $alphaLength);
		$pass[] = $alphabet[$n];
	}
	return implode($pass);
}


function validasi_code()
{

	if (isset($_COOKIE['temp_access_code'])) {

		if (!isset($_GET['email']) && !isset($_GET['code'])) {

			redirect("index.php");
		} else if (empty($_GET['email']) || empty($_GET['code'])) {

			redirect("index.php");
		} else {
			if (isset($_POST['code'])) {
				$email = clean($_GET['email']);
				$kodevalidasi = clean($_POST['code']);
				$sql = "SELECT user_id FROM users WHERE kodevalidasi = '" . escape($kodevalidasi) . "' AND email = '" . escape($email) . "'";

				$result = query($sql);


				if (row_count($result) == 1) {

					setcookie('temp_access_code', $kodevalidasi, time() + 300);

					redirect("reset.php?email=$email&code=$kodevalidasi");
				} else {

					echo validation_errors("Sorry worng validation code");
				}
			}
		}
	} else {

		set_message("<div class='alert alert-danger'>
    <strong>Warning!</strong> Sorry your validation cookie was expired </div> 
	<script type='text/javascript'>
    window.setTimeout(function() {
    $('.alert').fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
	}, 2500);
	</script>
    ");
		redirect("recover.php");
	}
}


function validasi_tambahposting()
{

	$errors = [];
	$min = 10;
	$max = 1440;

	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$namanamafoto = $_FILES['foto']['name'];
		$lokasilokasifoto = $_FILES['foto']['tmp_name'];
		move_uploaded_file($lokasilokasifoto, "postingan/" . $namanamafoto);
		$id_kategori	     = clean($_POST['id_kategori']);
		$deskripsi	     = clean($_POST['deskripsi']);

		if (isset($_REQUEST['id_kategori']) && $_REQUEST['id_kategori'] == '0') {
			$errors[] = "Kategori Kosong";
		}

		if (!empty($errors)) {

			foreach ($errors as $error) {

				echo validation_errors($error);
			}
		} else {
			if (insertpostingan($id_kategori, $deskripsi, $namanamafoto)) {

				set_message("<div class='alert alert-success'>
    <strong>Berhasil</strong> Tambah Posting </div> 
	<script type='text/javascript'>
    window.setTimeout(function() {
    $('.alert').fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
	}, 2500);
	</script>
    ");

				redirect("index.php");
			} else {

				set_message("<div class='alert alert-danger'>
    <strong>Maaf</strong> Gagal </div> 
	<script type='text/javascript'>
    window.setTimeout(function() {
    $('.alert').fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
	}, 2500);
	</script>
    ");

				redirect("tambahposting.php");
			}
		}
	}
}

function insertpostingan($id_kategori, $deskripsi, $namanamafoto)
{

	$id_kategori = escape($id_kategori);
	$deskripsi = escape($deskripsi);
	$foto = escape($namanamafoto);
	date_default_timezone_set('Asia/Kolkata');
	$date = date('Y-m-d H:i:s');

	$qry = "SELECT user_id FROM users WHERE email='$_SESSION[email]'";
	$result = query($qry);
	confirm($result);
	$row = fetch_array($result);
	$id = $row['user_id'];

	$sql = "INSERT INTO postingan(idkategori,deskripsi,waktu,emailpengupload,idpengupload, foto)";

	$sql .= "VALUES($id_kategori,'$deskripsi','$date','{$_SESSION['email']}',$id,'$foto')";

	$result = query($sql);
	confirm($result);

	return true;
}


function validasi_editakun()
{

	$errors = [];
	$min = 1;
	$max = 20;

	$uploadOk = 1;
	$image_dir = "fotoprofil/";

	if ($_SERVER['REQUEST_METHOD'] == "POST") {

		$add   	        = clean($_POST['add']);
		$password 		= clean($_POST['password']);


		$image = $_FILES['user_pic'];
		$filename = $_FILES["user_pic"]["name"];
		$tempname = $_FILES["user_pic"]["tmp_name"];
		$folder = "fotoprofil/" . $filename;


		if (!empty($_FILES['user_pic']['tmp_name']) && ($_FILES['user_pic']['name'])) {

			$image_file = $image_dir . basename($_FILES["user_pic"]["name"]);
			$imageFileType = strtolower(pathinfo($image_file, PATHINFO_EXTENSION));


			$check =  getimagesize($tempname);
			if ($check !== false) {
				$uploadOk = 1;
			} else {
				$errors[] = "File Bukan Foto";
				$uploadOk = 0;
			}

			if ($_FILES["user_pic"]["size"] > 500000) {
				$errors[] = "Terlalu Besar";
				$uploadOk = 0;
			}


			if ($uploadOk == 0) {
				$errors[] = "Gagal Upload Foto";
			} else {
				if (move_uploaded_file($tempname, $folder)) {

					set_message("<div class='alert alert-success'>
    	<strong>Berhasil</strong> Berhasil</div> 
	<script type='text/javascript'>
    window.setTimeout(function() {
    $('.alert').fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
	}, 5000);
	</script>
    ");
				} else {

					set_message("<p class='bg-danger text-center'> Gagal </p>");
				}
			}
		} else {
		}

		if (!empty($errors)) {

			foreach ($errors as $error) {

				echo validation_errors($error);
			}
		} else {
			if (insert_detailakun($add, $filename, $password)) {


				set_message("<div class='alert alert-success'>
    <strong>Berhasil</strong> Profil Berhasil Diganti</div> 
	<script type='text/javascript'>
    window.setTimeout(function() {
    $('.alert').fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
	}, 5000);
	</script>
    ");


				redirect("editakun.php");
			} else {

				set_message("<div class='alert alert-danger'>
    <strong>Gagal</strong> Gagal
  	</div>

    <script type='text/javascript'>
    window.setTimeout(function() {
    $('.alert').fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
    }, 2000);
    </script>
    ");

				redirect("editakun.php");
			}
		}
	}
}

function insert_detailakun($add, $filename, $password)
{

	$add        = escape($add);

	date_default_timezone_set('Asia/Kolkata');
	$date = date('Y-m-d H:i:s');


	$sqluser = "SELECT password, user_id FROM users WHERE email = '$_SESSION[email]' ";
	$resultuser = query($sqluser);
	if (row_count($resultuser) == 1) {

		$rowuser = fetch_array($resultuser);
		$db_password = $rowuser['password'];
		$id = $rowuser['user_id'];

		if (md5($password) === $db_password) {


			$sql = "UPDATE users SET 
    alamat     = '$add', foto = '$filename'
    WHERE user_id = '$id'";

			$result = query($sql);
			confirm($result);


			return true;
		} else {
			return false;
		}
		return true;
	} else {
		return false;
	}
}
