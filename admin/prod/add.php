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
	if (!$preco) {
		$error .= " Preço obrigatório! ";
	}
	if (!$preco_compra) {
		$error .= " Preço de compra obrigatório! ";
	}
	if (!$estoque && $estoque !== "0") {
		$error .= " Estoque obrigatório! ";
	}
	if (!isset($ativo) || $ativo === "") {
		$error .= " Ativo obrigatório! ";
	}
	if (!$id_conta) {
		$error .= " Conta obrigatória! ";
	}
	if (!$id_categoria) {
		$error .= " Categoria obrigatória! ";
	}
	if (!$error) {
		$link = mysqli_connect("localhost", "root", "", "sistema");
		$sql = "";
		$sql .= " INSERT INTO product ";
		$sql .= " (name, sell_price, buy_price, stock, image, description, active, id_account, id_category) ";
		$sql .= " VALUES ";
		$sql .= " ('".$nome."', '".$preco."', '".$preco_compra."', '".$estoque."', '".$imagem."', '".$descricao."', '".$ativo."', '".$id_conta."', '".$id_categoria."')";
		$result = mysqli_query($link, $sql);
		header("Location: /sistema/admin/prod");
		exit;
	}
}

include("../../header.php");
include("../menu.php");

?>

<h3>ADICIONAR PRODUTO</h3>

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
			<td style="text-align: right;">Preço:</td>
			<td>
				<input type="text" name="preco" value="<?=isset($preco)?$preco:"";?>">
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">Preço de Compra:</td>
			<td>
				<input type="text" name="preco_compra" value="<?=isset($preco_compra)?$preco_compra:"";?>">
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">Estoque:</td>
			<td>
				<input type="number" name="estoque" value="<?=isset($estoque)?$estoque:"";?>">
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">Imagem:</td>
			<td>
				<input type="text" name="imagem" value="<?=isset($imagem)?$imagem:"";?>">
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">Descrição:</td>
			<td>
				<textarea name="descricao"><?=isset($descricao)?$descricao:"";?></textarea>
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">Ativo:</td>
			<td>
				<select name="ativo">
					<option value="1" <?=isset($ativo)&&$ativo=="1"?"selected":"";?>>Sim</option>
					<option value="0" <?=isset($ativo)&&$ativo=="0"?"selected":"";?>>Não</option>
				</select>
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">Conta:</td>
			<td>
				<input type="number" name="id_conta" value="<?=isset($id_conta)?$id_conta:"";?>">
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">Categoria:</td>
			<td>
				<input type="number" name="id_categoria" value="<?=isset($id_categoria)?$id_categoria:"";?>">
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