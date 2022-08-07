<?php 

	require_once('connection.php');

	session_start();

	$nome_de_usuario = $_SESSION['user']['nome_de_usuario'];
	$id = $_SESSION['user']['id'];

	$json_arr = array(
		"error" => '',
		"success" => '',
		"altUser" => array(false,'')
	);

	switch($_POST['op']) {
		case 1:
			$banner = $_FILES['banner'];
			$extensao = strtolower(substr($banner['name'], -4));
			$diretorio = '../perfil_images/';
			$diretorio .= 'banner/';
			$novoNome = md5(time()).$extensao;
			move_uploaded_file($banner['tmp_name'], $diretorio.$novoNome);

			if(update($id, $novoNome, $con, 'perfil', 'banner')): 
				header('location: /breakingbad/perfil/'.$nome_de_usuario);
			endif;

			break;
		case 2:
			$perfil_foto = $_FILES['perfil_foto'];
			$extensao = strtolower(substr($perfil_foto['name'], -4));
			$diretorio = '../perfil_images/';
			$diretorio .= 'foto/';
			$novoNome = md5(time()).$extensao;
			move_uploaded_file($perfil_foto['tmp_name'], $diretorio.$novoNome);
			
			if(update($id, $novoNome, $con, 'perfil', 'foto')): 
				header('location: /breakingbad/perfil/'.$nome_de_usuario);
			endif;
			
			break;
		case 3:
			$arr_data = array(
				"nome" => $_POST['nome'],
				"sobreNome" => $_POST['sobreNome'],
				"nome_de_usuario" => $_POST['nomeUsuario'],
				"email" => $_POST['email'],
				"descricao" => $_POST['descricao']
			);

			foreach ($arr_data as $key => $value) {
				$table = ($key == 'descricao')?'perfil':'usuario';
				$pass = update($id, $value, $con, $table, $key);
				if(is_array($pass)) {
					$json_arr['altUser'][0] = $pass[0];
					$json_arr['altUser'][1] = $pass[1];
				}
			}

			if($pass) {
				$json_arr['success'] = 'Dados alterados com sucesso!';
			}else {
				$json_arr['error'] = 'Erro ao efetuar alteração.';
			}

			break;
	}

	function update($user, $value, $con, $table, $attr) {
		$value = strip_tags(trim($value));

		if($attr == "banner" || $attr == 'foto') {
			$query = $con->query("SELECT $attr FROM $table WHERE usuario_id = $user AND $attr != ''");
			$exist = $query->rowCount();

			if($exist > 0) {
				$row = $query->fetch();
				$image = "../perfil_images/".$attr."/".$row[0];

				if(file_exists($image)) {
					unlink($image);
				}
			}
		}

		if($table == 'usuario'){
			if($attr == 'nome_de_usuario' && $value != $_SESSION['user']['nome_de_usuario']) {

				$query = $con->query("SELECT nome_de_usuario FROM usuario WHERE nome_de_usuario = '$value'");
				$count = $query->rowCount();

				if($count == 0) {
					$query = $con->query("UPDATE $table SET $attr = '$value' WHERE id = $user");

					$_SESSION['user']['nome_de_usuario'] = $value;

				}

				return array(true, $value);
			}else {
				$query = $con->query("UPDATE $table SET $attr = '$value' WHERE id = $user");
			}
		}else{
			$query = $con->query("UPDATE $table SET $attr = '$value' WHERE usuario_id = $user");
		}

		return $query;
	}

	echo json_encode($json_arr);

?>