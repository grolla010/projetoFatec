<?php
include("./config.inc.php");
include("../header.php");

session_start();
if (empty($_SESSION["CONTA_ID"])) {
    echo '<a href="/sistema/user/login.php" style="color: black;">Login</a>';
} else {
    echo '<a href="/sistema/user/logout.php" style="color: black;">Logout</a>';
}
?>

<form>

    <br><br>
    Palavra Chave:
    <br>
    <input type="text" name="kw" value="<?= (isset($_GET['kw']) && $_GET['kw']) ? $_GET['kw'] : '' ?>">
    <button id="btn-buscar" type="submit">Buscar</button>
</form>

<?php
$link = mysqli_connect('localhost', 'root', '', 'sistema');
$sql = "select * from prod";
if (isset($_GET['kw']) && $_GET['kw']) {
    $sql .= " where nome like '%" . $_GET['kw'] . "%'";
}
$sql .= " order by nome";
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) > 0) {
?>
    <table border="1">
        <tr>
            <th>Nome</th>
            <th>Preço</th>
            <th>Carrinho</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
                <td><?= $row["nome"]; ?></td>
                <td><?= $row["preco"]; ?></td>
                <td>
                    <a href="/sistema/user/carrinho.php?a=<?= $row["id"]; ?>" style="color: black;">Adicionar +</a>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>
    <br>
    <br><a href="/sistema/user/carrinho.php">Carrinho</a>
<?php
} else {
    echo "Sem Produtos";
}
?>



<?php
include("../footer.php");
?>