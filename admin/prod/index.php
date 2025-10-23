<?php
include("../config.inc.php");
include("../session.php");
validaSessao();
include("../../header.php");
include("../menu.php");
?>

<h3>PRODUTOS</h3>

<a href="/sistema/admin/prod/add.php" style="color: black;">+ Adicionar</a>

<br><br>
<table border="1">
	<tr>
		<th>Nome</th>
		<th>Preço</th>
		<th>Descrição</th>
		<th>Ação</th>
	</tr>
	<?php
	$link = mysqli_connect("localhost", "root", "", "sistema");
	$sql = "SELECT id_product, name, sell_price, description FROM product ORDER BY name;";
	$result = mysqli_query($link, $sql);
	while ($row = mysqli_fetch_assoc($result)) {
		?>
		<tr>
			<td><?=$row["name"];?></td>
			<td><?=$row["sell_price"];?></td>
			<td><?=$row["description"];?></td>
			<td>
				<a href="/sistema/admin/prod/edit.php?id=<?=$row["id_product"];?>" style="color: black;">Editar</a> |
				<a href="/sistema/admin/prod/del.php?id=<?=$row["id_product"];?>" style="color: black;">Excluir</a>
			</td>
		</tr>
		<?php
	}
	?>
</table>
<br><br>

<a href="/sistema/admin/prod/add.php" style="color: black;">+ Adicionar</a>

<?php
include("../../footer.php");
?>