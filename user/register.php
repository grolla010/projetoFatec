<?php

include("./config.inc.php");
include("./session.php");
include("../header.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$link = mysqli_connect("localhost", "root", "", "sistema");
	$sql = "INSERT INTO account (username, password, id_papel) 
		values ('" . $_POST["username"] . "', PASSWORD('" . $_POST["password"] . "'), 3)";//cod 3 para usuario
	try {
		$result = mysqli_query($link, $sql);
		if ($result) {
			if (contaValida($_POST["username"], $_POST["password"])) {
				registraConta($_POST["username"]);
				header("Location: /sistema/user/index.php");
				exit;
			}
		}
		$username = $_POST["username"];
		$mensagem = "Username ou Password incorreto!";
	} catch (Exception $e) {
		$mensagem = "Erro ao registrar conta! Tente outro username.";
		?>
		<div class="aviso" role="alert" aria-live="assertive">
    		Se o erro persistir, contate o administrador do sistema.
  		</div>
		<?php
	}
}

?>

<h3>REGISTRAR</h3>

<form name="formLogin" method="POST">
	<table>
		<tr>
			<td colspan="2" style="color: red;">
				<?=isset($mensagem)?$mensagem:"&nbsp;";?>
			</td>
		</tr>
		<tr>
			<td>Username:</td>
			<td>
				<input type="text" name="username" value="<?=isset($username)?$username:"";?>">
			</td>
		</tr>
		<tr>
			<td>Password:</td>
			<td>
				<input type="password" name="password" value="<?=isset($password)?$password:"";?>">
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" name="submit" value="Submit">
			</td>
		</tr>
	</table>
</form>
<script language="JavaScript" type="text/javascript">
	<!--
	if (document.formLogin.username.value) {
		document.formLogin.password.focus();
	} else {
		document.formLogin.username.focus();
	}
	//-->
</script>

<?php
include("../footer.php");
?>