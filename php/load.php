<?php 

	require_once('connection.php');

	$init = $_POST['init'];
	$end = $_POST['max'];

	$result = array(
		"total" => 0,
		"dados" => null
	);

	$queryTotal = $con->query("SELECT * FROM post");
	$result["total"] = $queryTotal->rowCount();

	$queryDados = $con->query("SELECT post.image_post, post.descricao, post.slug, post.data_postagem, usuario.nome_de_usuario, perfil.foto FROM post
	INNER JOIN usuario ON usuario.id = post.usuario_id
	INNER JOIN perfil ON perfil.usuario_id = usuario.id ORDER BY data_postagem DESC LIMIT $init,$end");

	if($result['total'] > 0){
		while($res = $queryDados->fetch()) {
			$arr[] = $res;
		}
		$result["dados"] = $arr;
	}

	$json = json_encode($result);

	echo $json;

?>