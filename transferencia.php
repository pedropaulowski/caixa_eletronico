<?php
session_start();
require 'config.php';

if(isset($_POST['id']) && !empty($_POST['id']) && !empty($_POST['valor'])){
	$id = addslashes($_POST['id']);
	$valor = addslashes($_POST['valor']);

	$sql = $pdo->prepare("SELECT * FROM contas WHERE id = :id");
	$sql->bindValue(":id", $id);
	$sql->execute();
	if($sql->rowCount() == 0 ){
		echo "Não pode transferir para essa conta pois ela não existe";
	} else {
	$sql = $pdo->prepare("UPDATE contas SET saldo = saldo + :valor WHERE id = :id");
	$sql->bindValue(":valor", $valor);
	$sql->bindValue(":id", $id);
	$sql->execute();

	$sql = $pdo->prepare("UPDATE contas SET saldo = saldo - :valor WHERE id = :id");
	$sql->bindValue(":valor", $valor);
	$sql->bindValue(":id", $_SESSION['banco']);
	$sql->execute();
	
	header("Location: index.php");
	exit;
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Caixa Eletrônico</title>
</head>
<body>
	<form method="POST">
		ID de quem vai receber:<br/>
		<input type="number" name="id" /><br/><br/>
		
		Valor a ser transferido:<br/>
		<input type="text" name="valor" pattern="[0-9.,]{1,}" /><br/><br/>

		<input type="submit" value="Fazer transferência" />

	</form>
</body>
</html>