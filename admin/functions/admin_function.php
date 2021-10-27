<?php
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
    });
}, 5000);
</script>
DELIMITER;

	return $error_message;
}
function adminRequest_emailada($admin_email)
{
	$sql = "SELECT admin_id FROM admin_request WHERE admin_email = '$admin_email'";
	$result = query($sql);
	if (row_count($result) == 1) {
		return true;
	} else {
		return false;
	}
}
function admin_emailada($admin_email)
{
	$sql1 = "SELECT admin_id FROM admin WHERE admin_email = '$admin_email'";
	$result1 = query($sql1);
	if (row_count($result1) == 1) {
		return true;
	} else {
		return false;
	}
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
function validasi_admin_login()
{
	$errors = [];
	$min = 3;
	$max = 20;
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$admin_email	 = clean($_POST['admin_email']);
		$password  		 = clean($_POST['password']);
		$remember 		 = isset($_POST['remember']);
		if (empty($admin_email)) {
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
			if (login_admin($admin_email, $password, $remember)) {
				set_message("<div class='alert alert-success'>
    <strong>Berhasil</strong> Login </div>
	<script type='text/javascript'>
    window.setTimeout(function() {
    $('.alert').fadeTo(500, 0).slideUp(500, function(){
        $(this).remove();
    });
	}, 5000);
	</script>
    ");
				redirect("index.php");
			} else {
				echo validation_errors("Salah");
			}
		}
	}
} 
function login_admin($admin_email, $password, $remember)
{
	$sql = "SELECT password, admin_id FROM admin WHERE admin_email = '" . escape($admin_email) . "'";
	$result = query($sql);
	if (row_count($result) == 1) {
		$row = fetch_array($result);
		$db_password = $row['password'];
		if (md5($password) === $db_password) {
			if ($remember == "on") {
				setcookie('admin_email', $admin_email, time() + 86400);
			}
			$_SESSION['admin_email'] = $admin_email;
			return true;
		} else {
			return false;
		}
		return true;
	} else {
		return false;
	}
}
function admin_logged_in()
{
	if (isset($_SESSION['admin_email']) || isset($_COOKIE['admin_email'])) {
		return true;
	} else {
		return false;
	}
}			
function validasi_admintambahkategori()
{
	$errors = [];
	$min = 2;
	$max = 20;
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$kategori_name	     = clean($_POST['kategori_name']);
		if (!empty($errors)) {
			foreach ($errors as $error) {
				echo validation_errors($error);
			}
		} else {
			if (insert_kategori($kategori_name)) {
				set_message("<div class='alert alert-success'>
    			<strong>Berhasil</strong> Tambah Kategori  </div>
				<script type='text/javascript'>
    			window.setTimeout(function() {
    			$('.alert').fadeTo(500, 0).slideUp(500, function(){
       	 		$(this).remove();
    		});
			}, 5000);
			</script>
    		");
				redirect("admintambahkategori.php");
			} else {
				set_message("<div class='alert alert-danger'>
    		<strong>Gagal</strong>
  			</div>
    		<script type='text/javascript'>
    			window.setTimeout(function() {
    			$('.alert').fadeTo(500, 0).slideUp(500, function(){
        		$(this).remove();
    		});
    		}, 5000);
    		</script>
    		");
				redirect("admintambahkategori.php");
			}
		}
	}
}  

function validasi_admintambahposting()
{
	$errors = [];
	$min = 10;
	$max = 140;
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$id_kategori 	= clean($_POST['id_kategori']);
		$deskripsi_des	 = clean($_POST['deskripsi_des']);
		if (!empty($errors)) {
			foreach ($errors as $error) {
				echo validation_errors($error);
			}
		} else {
			if (insert_adminPostingan($id_kategori, $deskripsi_des)) {
				set_message("<div class='alert alert-success text-center'><strong>Berhasil</strong></div>");
				redirect("admin_add_deskripsi.php");
			} else {
				set_message("<p class='bg-danger text-center'> Gagal </p>");
				redirect("admin_add_deskripsi.php");
			}
		}
	}
}
function insert_adminPostingan($id_kategori, $deskripsi_des)
{
	$id_kategori   = escape($id_kategori);
	$deskripsi_des = escape($deskripsi_des);
	date_default_timezone_set('Asia/Kolkata');
	$date = date('Y-m-d H:i:s');
	$qry = "SELECT admin_id FROM admin WHERE admin_email='$_SESSION[admin_email]'";
	$result = query($qry);
	confirm($result);
	$row = fetch_array($result);
	$id = $row['admin_id'];
	$admin = 'ODF';
	$sql = "INSERT INTO postingan(id_kategori,deskripsi,waktu,emailpengupload,user_id)";
	$sql .= "VALUES($id_kategori,'$deskripsi_des','$date','ODF','$id')";
	$result = query($sql);
	confirm($result);
	return true;
}
function insert_kategori($kategori_name)
{
	$kategori_name = escape($kategori_name);
	date_default_timezone_set('Asia/Kolkata');
	$date = date('Y-m-d H:i:s');
	$sql = "SELECT sub_code, namakategori FROM kategoris WHERE namakategori = '$kategori_name'";
	$result = query($sql);
	if (row_count($result) == 0) {
		$qry = "SELECT admin_id FROM admin WHERE admin_email='$_SESSION[admin_email]'";
		$result = query($qry);
		confirm($result);
		$row = fetch_array($result);
		$id = $row['admin_id'];
		$sql = "INSERT INTO kategori(namakategori,s_admin_id)";
		$sql .= "VALUES('$kategori_name','1')";
		$result = query($sql);
		confirm($result);
		return true;
	} else {
		return false;
	}
}