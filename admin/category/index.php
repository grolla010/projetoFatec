<?php
include("../config.inc.php");
include("../session.php");
validaSessao();
include("../../header.php");
include("../menu.php");
?>

<h3>CATEGORIAS</h3>

<a href="/sistema/admin/category/add.php" style="color: black;">+ Adicionar</a>

<br><br>
<table border="1">
	<tr>
		<th>Nome</th>
		<th>Ação</th>
	</tr>
	<?php
	$link = mysqli_connect("localhost", "root", "", "sistema");
	$sql = "SELECT id_category, name FROM category ORDER BY name;";
	$result = mysqli_query($link, $sql);
	while ($row = mysqli_fetch_assoc($result)) {
		?>
		<tr>
			<td><?=$row["name"];?></td>
			<td>
				<a href="/sistema/admin/category/edit.php?id=<?=$row["id_category"];?>" style="color: black;">Editar</a> |
				<a href="/sistema/admin/category/del.php?id=<?=$row["id_category"];?>" style="color: black;">Excluir</a>
			</td>
		</tr>
		<?php
	}
	?>
</table>
<br><br>

<a href="/sistema/admin/category/add.php" style="color: black;">+ Adicionar</a>

<?php
include("../../footer.php");
?>