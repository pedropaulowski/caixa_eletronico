<?php
session_start();
require 'config.php';


if(isset($_SESSION['banco']) && !empty($_SESSION['banco'])){
	$id = $_SESSION['banco'];

	$sql = $pdo->prepare("SELECT * FROM contas WHERE id = :id");
	$sql->bindValue(":id", $id);
	$sql->execute();

	if($sql->rowCount() > 0){
		$info = $sql->fetch();
	} else {
		header("Location: login.php");
		exit;
	}

} else{
	header("Location: login.php");
	exit;
}
?>

<html>
<head>
	<title>Caixa Eletrônico</title>
</head>
<body>
	<center>
		<h1>Banco GOI</h1>
		Titular: <?php echo $info['titular'];?><br/>
		ID: <?php echo $_SESSION['banco'];?><br/>
		Agência: <?php echo $info['agencia'];?><br/>
		Conta: <?php echo $info['conta'];?><br/>
		Saldo: U$ <?php echo $info['saldo'];?><br/>

		<a href="sair.php">Sair</a>
		<hr>

		<h3>Movimentação/Extrato</h3>

		<a href="add-transacao.php">Fazer transação</a> ou <a href="transferencia.php">Fazer transferência</a><br/><br/><br/><br/>


		<table border="1" width="400">
			<tr>
				<th>Data</th>
				<th>Valor</th>
			</tr>
			<?php
			$sql = $pdo->prepare("SELECT * FROM historico WHERE id_conta = :id_conta ORDER BY data_operacao DESC ");
			$sql->bindValue(":id_conta", $id);
			$sql->execute();

			if($sql->rowCount() > 0) {
				foreach($sql->fetchAll() as $item) {
					?>
					<tr>
						<td><?php echo date('d/m/Y H:i:s', strtotime($item['data_operacao'])); ?></td>
						<td>
							<?php if($item['tipo'] == '0'): ?>
							<font color="green">U$ <?php echo $item['valor'] ?></font>
							<?php else: ?>
							<font color="red">- U$ <?php echo $item['valor'] ?></font>
							<?php endif; ?>
						</td>
					</tr>
					<?php
				}
			}
			?>
		</table>
	</center>
</body>
</html>