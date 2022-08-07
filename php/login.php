<?php 
	
	require_once('connection.php');

	$json_arr = array(
		"error" => '',
		"success" => '',
		"userName" => ''
	);

	if(isset($_POST['email']) && isset($_POST['senha'])) {
		$email = strip_tags(trim($_POST['email']));
		$senha = strip_tags(trim($_POST['senha']));

		$query = $con->prepare("SELECT id, nome_de_usuario, email, senha, acesso_id as acesso FROM usuario WHERE email = ? AND senha = ?");
		$query->bindValue(1, $email, PDO::PARAM_STR);
		$query->bindValue(2, $senha, PDO::PARAM_STR);
		$query->execute();
		$rowCount = $query->rowCount();

		if($rowCount > 0) {
			session_start();
			$row = $query->fetch();

			$nome_de_usuario = $row['nome_de_usuario'];
			$email = $row['email'];
			$id = $row['id'];

			if($row['acesso'] == 1) {
				$_SESSION['adm'] = array(
					"nome_de_usuario" => $nome_de_usuario,
					"email" => $email,
					"id" => $id
				);
			}else {
				$_SESSION['user'] = array(
					"nome_de_usuario" => $nome_de_usuario,
					"email" => $email,
					"id" => $id 
				);		
			}

			$json_arr["success"] = "Logado com sucesso!";
			$json_arr["userName"] = $_SESSION['user']['nome_de_usuario'];
		}else {
			$json_arr["error"] = "Usuário ou senha incorretos.";
		}
	}

	echo json_encode($json_arr);

?>