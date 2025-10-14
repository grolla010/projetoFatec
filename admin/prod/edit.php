<?php
include("../config.inc.php");
include("../session.php");
validaSessao();
 
$link = mysqli_connect("localhost", "root", "", "sistema");
if (!$link) {
    die("Erro de conexão: " . mysqli_connect_error());
}
 
$id = "";
$error = "";
 
if (isset($_GET["id"]) && !empty($_GET["id"]) && is_numeric($_GET["id"])) {
    $id = mysqli_real_escape_string($link, $_GET["id"]);
} elseif (isset($_POST["id"]) && !empty($_POST["id"]) && is_numeric($_POST["id"])) {
    $id = mysqli_real_escape_string($link, $_POST["id"]);
} else {
    header("Location: /sistema/admin/prod/");
    exit;
}
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    extract($_POST);
 
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
 
    if (empty($error)) {
        $nome_seguro = mysqli_real_escape_string($link, $nome);
        $preco_seguro = mysqli_real_escape_string($link, $preco);

        $sql = "UPDATE product SET 
            name = '$nome_seguro', 
            sell_price = '$preco_seguro', 
            buy_price = '" . mysqli_real_escape_string($link, $preco_compra) . "', 
            stock = '" . mysqli_real_escape_string($link, $estoque) . "', 
            active = '" . mysqli_real_escape_string($link, $ativo) . "', 
            id_account = '" . mysqli_real_escape_string($link, $id_conta) . "', 
            id_category = '" . mysqli_real_escape_string($link, $id_categoria) . "' 
            WHERE id_product = '$id'";
        if (mysqli_query($link, $sql)) {
            header("Location: /sistema/admin/prod/");
            exit;
        } else {
            $error = "Erro ao atualizar produto: " . mysqli_error($link);
        }
    }
}

$sql = "SELECT * FROM product WHERE id_product = '$id'";
$result = mysqli_query($link, $sql);
 
if (mysqli_num_rows($result) === 0) {
    header("Location: /sistema/admin/prod/");
    exit;
}
$row = mysqli_fetch_assoc($result);
extract($row);
//$nome = $row['name'];
//$preco = $row['sell_price'];
 
mysqli_close($link);
 
include("../../header.php");
include("../menu.php");
?>
 
<h3>EDITAR PRODUTO</h3>
 
<?php
if (!empty($error)) {
    echo "<span style='color: red; font-style: italic;'>" . $error . "</span>";
}
?>
 
<form method="POST">
    <input type="hidden" name="id" value="<?= htmlspecialchars($id); ?>">
    <table>
        <tr>
            <td style="text-align: right;">Nome:</td>
            <td>
            <input type="text" name="nome" value="<?= htmlspecialchars($name); ?>">
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">Preço de compra:</td>
            <td>
            <input type="text" name="preco_compra" value="<?= isset($buy_price) ? htmlspecialchars($buy_price) : ''; ?>">
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">Estoque:</td>
            <td>
            <input type="number" name="estoque" value="<?= isset($stock) ? htmlspecialchars($stock) : ''; ?>">
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">Ativo:</td>
            <td>
            <select name="ativo">
                <option value="1" <?= (isset($active) && $active == "1") ? "selected" : ""; ?>>Sim</option>
                <option value="0" <?= (isset($active) && $active == "0") ? "selected" : ""; ?>>Não</option>
            </select>
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">Conta:</td>
            <td>
            <input type="text" name="id_conta" value="<?= isset($id_account) ? htmlspecialchars($id_account) : ''; ?>">
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">Categoria:</td>
            <td>
            <input type="text" name="id_categoria" value="<?= isset($id_category) ? htmlspecialchars($id_category) : ''; ?>">
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">Preço:</td>
            <td>
                <input type="text" name="preco" value="<?= htmlspecialchars($sell_price); ?>">
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                <input type="submit" name="submit" value="Atualizar">
            </td>
        </tr>
    </table>
</form>
 
<?php
include("../../footer.php");
?>