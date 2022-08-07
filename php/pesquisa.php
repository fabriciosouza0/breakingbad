<?php 

	require_once('connection.php');

	$value = $_POST['value'];

	$result = array(
		"dados" => null,
		"find" => 0
	);

	$query = $con->query("SELECT post.image_post, post.descricao, post.slug, post.data_postagem, usuario.nome_de_usuario, perfil.foto FROM post
	INNER JOIN usuario ON usuario.id = post.usuario_id
	INNER JOIN perfil ON perfil.usuario_id = usuario.id WHERE post.descricao LIKE '%$value%' ORDER BY data_postagem DESC");
	$rowCount = $query->rowCount();

	while($row = $query->fetch()) {
		$arr[] = $row;
	}
	if($rowCount > 0) {
		$result["dados"] = $arr;
		$result["find"] = 1;
	}else {
		$result["find"] = 0;
	}

	$json = json_encode($result);

	echo $json;

?>