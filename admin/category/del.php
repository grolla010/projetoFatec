<?php

include("../config.inc.php");
include("../session.php");
validaSessao();

$link = mysqli_connect("localhost", "root", "", "sistema");
if (!$link) {
    die("Erro de conexão: " . mysqli_connect_error());
}

if (!isset($_GET['id']) || empty($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: /sistema/admin/category/");
    exit;
}

$id = mysqli_real_escape_string($link, $_GET['id']);

if (isset($_GET['del']) && $_GET['del'] === "yes") {

    $sql = "DELETE FROM category WHERE id_category = '$id'";

    try {
        if (mysqli_query($link, $sql)) {
            header("Location: /sistema/admin/category/");
            exit;
        } else {
            echo "Erro ao apagar a categoria: " . mysqli_error($link);
        }
    } catch (\Throwable $th) {
        echo "<script>alert('Erro ao apagar a categoria. Não é possível apagar uma categoria que está associada a produtos.');</script>";
        echo "<script>window.location.href='/sistema/admin/category/';</script>";
        exit;
    }
}

$sql = "SELECT id_category, name FROM category WHERE id_category = '$id'";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) === 0) {
    header("Location: /sistema/admin/category/");
    exit;
}

$row = mysqli_fetch_assoc($result);

include("../../header.php");
include("../menu.php");
?>

<h3>APAGAR CATEGORIA</h3>

<table style="margin: 0 auto;">
    <tr>
        <td colspan="2" style="text-align: center;">
            Tem certeza que realmente quer apagar a categoria "<?= htmlspecialchars($row["name"]); ?>"?
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">Nome:</td>
        <td><?= htmlspecialchars($row["name"]); ?></td>
    </tr>
    <tr>
        <td style="text-align: center;">
            <a href="/sistema/admin/category/del.php?id=<?= $row['id_category']; ?>&del=yes"><input type="button" value="SIM"></a>
        </td>
        <td style="text-align: center;">
            <a href="/sistema/admin/category/"><input type="button" value="NÃO"></a>
        </td>
    </tr>
</table>

<?php
mysqli_close($link);
include("../../footer.php");
?>