<?php

include("../config.inc.php");
include("../session.php");
validaSessao();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	extract($_POST);
	$error = "";
	if (!$nome) {
		$error .= " Nome obrigatório! ";
	}
	if (!$error) {
		$link = mysqli_connect("localhost", "root", "", "sistema");
		$sql = "";
		$sql .= " INSERT INTO category ";
		$sql .= " (name) ";
		$sql .= " VALUES ";
		$sql .= " ('".$nome."') ";
		$result = mysqli_query($link, $sql);
		header("Location: /sistema/admin/category");
		exit;
	}
}

include("../../header.php");
include("../menu.php");

?>

<h3>ADICIONAR CATEGORIA</h3>

<?php
if (isset($error)) {
	echo "<span style=\"color: red; font-style: italic;\">";
	echo $error;
	echo "</span>";
}
?>

<form method="POST">
	<table>
		<tr>
			<td style="text-align: right;">Nome:</td>
			<td>
				<input type="text" name="nome" value="<?=isset($nome)?$nome:"";?>">
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: center;">
				<input type="submit" name="submit" value="Cadastrar">
			</td>
		</tr>
	</table>
</form>

<?php
include("../../footer.php");
?>