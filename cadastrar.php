<?php
require 'config.php';
if(isset($_POST['titular']) && empty($_POST['titular']) == false && isset($_POST['senha']) && empty($_POST['senha']) == false){
	$titular = addslashes($_POST['titular']);
	$agencia = addslashes($_POST['agencia']);
	$conta = addslashes($_POST['conta']);
	$senha = md5(addslashes($_POST['senha']));

	$sql = $pdo->prepare("SELECT * FROM contas WHERE agencia = :agencia AND conta = :conta");
	$sql->bindValue(":agencia",$agencia);
	$sql->bindValue(":conta",$conta);
	$sql->execute();
	if ($sql->rowCount() > 0) {
		echo "Essa conta já existe";
	} else {
	$sql = $pdo->prepare("INSERT INTO contas SET titular = :titular, agencia = :agencia, conta = :conta, senha = :senha");
	$sql->bindValue(":titular",$titular);
	$sql->bindValue(":agencia",$agencia);
	$sql->bindValue(":conta",$conta);
	$sql->bindValue(":senha",$senha);
	$sql->execute();

	header("Location: index.php");
	}
}
?>
<html>
<head>
	<title>Criar conta</title>
</head>
<body>
	<form method="POST">
		Nome:<br/>
		<input type="text" name="titular" /><br/><br/>

		Agência:<br/>
		<input type="text" name="agencia" maxlength="4" /><br/><br/>
                                                        
		Conta:<br/>
		<input type="text" name="conta" maxlength="4" /><br/><br/>

		Senha:<br/>
		<input type="password" name="senha" /><br/><br/>

		<input type="submit" value="Criar conta" /><br/><br/>
	</form>
</body>
</html>