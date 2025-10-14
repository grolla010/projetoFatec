<?php
function contaValida($username, $password) {
	$link = mysqli_connect("localhost", "root", "", "sistema");
	$sql = "SELECT active FROM account WHERE username = '".$username."' AND password = PASSWORD('$password')";
	$result = mysqli_query($link, $sql);
	if ($result) {
		if ($row = mysqli_fetch_assoc($result)) {
			if ($row["active"] != "Y") {
				return false;
			}
			return true;
		}
	}
	return false;
}

function registraConta($username) {
	session_start();
	session_unset();
	$link = mysqli_connect("localhost", "root", "", "sistema");
	$sql = "SELECT id_account FROM account WHERE username = '".$username."'";
	$result = mysqli_query($link, $sql);
	if ($result) {
		if ($row = mysqli_fetch_assoc($result)) {
			$_SESSION["CONTA_ID"] = $row["id_account"];
		}
	}
}

function logout() {
	session_start();
	session_unset();
	session_destroy();
	header("Location: /sistema/admin/login.php");
	exit;
}

function validaSessao() {
	session_start();
	if (empty($_SESSION["CONTA_ID"])) {
		header("Location: /sistema/admin/login.php");
		exit;
	}
}
?>
