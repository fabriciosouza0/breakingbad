<?php 
	
	require_once('connection.php');

	$json_arr = array(
		"erro" => '',
		"sucesso" => '',
		"userName" => ''
	);

	if(isset($_POST['nomeUsuario']) && isset($_POST['nome']) && isset($_POST['sobreNome']) && isset($_POST['email']) && isset($_POST['senha'])) {
		
		$nome_de_usuario = $_POST['nomeUsuario'];
		$nome = $_POST['nome'];
		$sobreNome = $_POST['sobreNome'];
		$email = $_POST['email'];
		$senha = $_POST['senha'];
		$acesso = 2;

		$values = array(
			$nome_de_usuario,
			$nome,
			$sobreNome,
			$email,
			$senha
		);

		$verifyUserName = $con->query("SELECT nome_de_usuario FROM usuario WHERE nome_de_usuario = '$nome_de_usuario'");
		$sameUsers = $verifyUserName->rowCount();

		$verifyEmail = $con->query("SELECT email FROM usuario WHERE email = '$email'");
		$sameEmails = $verifyEmail->rowCount();

		if($sameUsers == 0) {
			if($sameEmails == 0) {
				
				$query = $con->prepare("INSERT INTO usuario (nome_de_usuario, nome, sobreNome, email, senha, acesso_id) VALUES (?,?,?,?,?,?)");

				foreach ($values as $key => $value) {
					$query->bindValue($key+1, $value, PDO::PARAM_STR);
				}

				$query->bindValue(6, $acesso, PDO::PARAM_INT);
				$query->execute();
				$userId = $con->lastInsertId();

			}else {
				$json_arr["erro"] = 'Este e-mail já foi registrado.';
			}
		}else {
			$json_arr["erro"] = 'Este nome de usuário já foi registrado.';
		}

		if(isset($query) && $query) {

			$query = $con->query("SELECT id, nome_de_usuario, acesso_id, email FROM usuario WHERE id = $userId");
			$row = $query->fetch();
			
			session_start();

			if($row["acesso_id"] == 1) {
				$_SESSION["adm"] = array(
					"nome_de_usuario" => $row["nome_de_usuario"],
					"email" => $row["email"],
					"id" => $row["id"]
				);
			}else {
				$_SESSION["user"] = array(
					"nome_de_usuario" => $row["nome_de_usuario"],
					"email" => $row["email"],
					"id" => $row["id"]
				);
			}

			$query  = $con->query("INSERT INTO perfil (usuario_id) VALUES ($userId)");

			$json_arr["sucesso"] = 'Seu registro foi efetuado com sucesso! Você será redirecionado em ';
			$json_arr["userName"] = $_SESSION['user']['nome_de_usuario'];
		}

	}

	echo json_encode($json_arr);

?>