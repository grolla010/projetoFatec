<?php
 
include("../config.inc.php");
include("../session.php");
validaSessao();
 
$link = mysqli_connect("localhost", "root", "", "sistema");
if (!$link) {
    die("Erro de conexão: " . mysqli_connect_error());
}
 
if (!isset($_GET['id']) || empty($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: /sistema/admin/prod/");
    exit;
}
 
$id = mysqli_real_escape_string($link, $_GET['id']);
 
if (isset($_GET['del']) && $_GET['del'] === "yes") {
 
    $sql = "DELETE FROM prod WHERE id = '$id'";
   
    if (mysqli_query($link, $sql)) {
        header("Location: /sistema/admin/prod/");
        exit;
    } else {
        echo "Erro ao apagar o produto: " . mysqli_error($link);
    }
}
 
$sql = "SELECT id, nome, preco FROM prod WHERE id = '$id'";
$result = mysqli_query($link, $sql);
 
if (mysqli_num_rows($result) === 0) {
    header("Location: /sistema/admin/prod/");
    exit;
}
 
$row = mysqli_fetch_assoc($result);
 
include("../../header.php");
include("../menu.php");
?>
 
<h3>APAGAR PRODUTO</h3>
 
<table style="margin: 0 auto;">
    <tr>
        <td colspan="2" style="text-align: center;">
            Tem certeza que realmente quer apagar o produto "<?= htmlspecialchars($row["nome"]); ?>"?
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">Nome:</td>
        <td><?= htmlspecialchars($row["nome"]); ?></td>
    </tr>
    <tr>
        <td style="text-align: right;">Preço:</td>
        <td><?= htmlspecialchars($row["preco"]); ?></td>
    </tr>
    <tr>
        <td style="text-align: center;">
            <a href="/sistema/admin/prod/del.php?id=<?= $row['id']; ?>&del=yes"><input type="button" value="SIM"></a>
        </td>
        <td style="text-align: center;">
            <a href="/sistema/admin/prod/"><input type="button" value="NÃO"></a>
        </td>
    </tr>
</table>
 
<?php
mysqli_close($link);
include("../../footer.php");
?>