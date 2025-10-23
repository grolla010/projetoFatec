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
    header("Location: /sistema/admin/category/");
    exit;
}
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    extract($_POST);
 
    if (!$nome) {
		$error .= " Nome obrigatório! ";
	}
 
    if (empty($error)) {
        $nome_seguro = mysqli_real_escape_string($link, $nome);

        $sql = "UPDATE category SET 
            name = '$nome_seguro' 
            WHERE id_category = '$id'";
        if (mysqli_query($link, $sql)) {
            header("Location: /sistema/admin/category/");
            exit;
        } else {
            $error = "Erro ao atualizar categoria: " . mysqli_error($link);
        }
    }
}

$sql = "SELECT * FROM category WHERE id_category = '$id'";
$result = mysqli_query($link, $sql);
 
if (mysqli_num_rows($result) === 0) {
    header("Location: /sistema/admin/category/");
    exit;
}
$row = mysqli_fetch_assoc($result);
extract($row);
 
mysqli_close($link);
 
include("../../header.php");
include("../menu.php");
?>

<h3>EDITAR CATEGORIA</h3>

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
            <td colspan="2" style="text-align: center;">
                <input type="submit" name="submit" value="Atualizar">
            </td>
        </tr>
    </table>
</form>
 
<?php
include("../../footer.php");
?>