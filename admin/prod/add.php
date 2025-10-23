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
		// map the posted ativo value ("1" / "0") to Y/N for the DB
		$active = ($ativo === "1") ? 'Y' : 'N';
		$link = mysqli_connect("localhost", "root", "", "sistema");
		$sql = "";
		$sql .= " INSERT INTO product ";
		$sql .= " (name, sell_price, buy_price, stock, image, description, active, id_account, id_category) ";
		$sql .= " VALUES ";
		$sql .= " ('" . $nome . "', '" . $preco . "', '" . $preco_compra . "', '" . $estoque . "', '" . $imagem . "', '" . $descricao . "', '" . $active . "', '" . $id_conta . "', '" . $id_categoria . "')";
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
				<input type="text" name="nome" value="<?= isset($nome) ? $nome : ""; ?>">
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">Preço:</td>
			<td>
				<input type="text" name="preco" value="<?= isset($preco) ? $preco : ""; ?>">
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">Preço de Compra:</td>
			<td>
				<input type="text" name="preco_compra" value="<?= isset($preco_compra) ? $preco_compra : ""; ?>">
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">Estoque:</td>
			<td>
				<input type="number" name="estoque" value="<?= isset($estoque) ? $estoque : ""; ?>">
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">Imagem:</td>
			<td>
				<input type="text" name="imagem" value="<?= isset($imagem) ? $imagem : ""; ?>">
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">Descrição:</td>
			<td>
				<textarea name="descricao"><?= isset($descricao) ? $descricao : ""; ?></textarea>
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">Ativo:</td>
			<td>
				<select name="ativo">
					<option value="1" <?= isset($ativo) && $ativo == "1" ? "selected" : ""; ?>>Sim</option>
					<option value="0" <?= isset($ativo) && $ativo == "0" ? "selected" : ""; ?>>Não</option>
				</select>
			</td>
		</tr>
		<?php
		$default_id = isset($id_conta)
			? $id_conta
			: (isset($_SESSION['id'])
				? $_SESSION['id']
				: (isset($_SESSION['CONTA_ID']) ? $_SESSION['CONTA_ID'] : ''));
		?>
		<tr>
			<td style="text-align: right;">Conta:</td>
			<td>
				<!-- mostra o id da conta mas disabled para não ser editável -->
				<input type="number" value="<?= htmlspecialchars($default_id); ?>" disabled="true">
				<!-- campo oculto para garantir que o id_conta seja submetido no POST -->
				<input type="hidden" name="id_conta" value="<?= htmlspecialchars($default_id); ?>">
			</td>
		</tr>
		</tr>
		<tr>
			<td style="text-align: right;">Categoria:</td>
			<td>
				<?php
				// buscar categorias (nome e id) e montar select
				$link = mysqli_connect("localhost", "root", "", "sistema");
				$categories = [];
				if ($link) {
					$res = mysqli_query($link, "SELECT id_category, name FROM category ORDER BY name");
					if ($res) {
						while ($row = mysqli_fetch_assoc($res)) {
							$categories[] = $row;
						}
						mysqli_free_result($res);
					}
				}

				// valor selecionado previamente (pode ser id)
				$selected_id = isset($id_categoria) ? $id_categoria : '';
				?>
				<select id="categoria_select" name="categoria_nome">
					<option value="">-- Escolha uma categoria --</option>
					<?php foreach ($categories as $c): ?>
						<option data-id="<?= htmlspecialchars($c['id_category']); ?>"
							<?= ($selected_id !== '' && $selected_id == $c['id_category']) ? 'selected' : ''; ?>>
							<?= htmlspecialchars($c['name']); ?>
						</option>
					<?php endforeach; ?>
				</select>

				<!-- campo oculto que será submetido com o id da categoria -->
				<input type="hidden" id="id_categoria" name="id_categoria" value="<?= htmlspecialchars($selected_id); ?>">
			</td>

			<script>
				// popula o campo oculto com o id correspondente ao nome escolhido
				(function() {
					var sel = document.getElementById('categoria_select');
					var hid = document.getElementById('id_categoria');

					function sync() {
						var opt = sel.options[sel.selectedIndex];
						hid.value = opt && opt.dataset ? (opt.dataset.id || '') : '';
					}
					if (sel) {
						sel.addEventListener('change', sync);
						// sincroniza inicialmente (caso já venha selecionado)
						sync();
					}
				})();
			</script>
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