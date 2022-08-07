<?php  

	require_once('connection.php');

	session_start();

	date_default_timezone_set('UTC');

	$json_arr = array(
		"success" => '',
		"dados" => null
	);
	
	$image_principal = $_FILES['post-banner-image'];
	$image_post = $_FILES['post-image'];
	$titulo = strip_tags(trim($_POST['titulo']));
	$descricao = $titulo;
	$slug = slug($titulo);
	$postagem = htmlentities($_POST['conteudo'], ENT_QUOTES);
	$data_postagem = date('Y-m-d H:i:s');
	$categoria = $_POST['categoria'];
	$usuario_id = $_SESSION['user']['id'];

	$info = array(
		"titulo" => $titulo,
		"slug" => $slug,
		"postagem" => $postagem,
		"data_postagem" => $data_postagem,
		"categoria" => $categoria,
		"usuario_id" => $usuario_id
	);

	$json_arr["dados"] = $info;

		$extensao = strtolower(substr($image_principal['name'], -4));
		$extensao1 = strtolower(substr($image_post['name'], -4));
		$novo_nome = md5(time()).$extensao;
		$novo_nome1 = md5(time()).$extensao1;
		$diretorio = "perfil_images/postagem/principal/".$novo_nome;
		$diretorio1 = "perfil_images/postagem/post/".$novo_nome1;

		$query = $con->prepare("INSERT INTO post (slug, titulo, descricao, postagem, image_principal, image_post, data_postagem, usuario_id) VALUES (?,?,?,?,?,?,?,?)");
		$values = array(
			$slug,
			$titulo,
			$descricao,
			$postagem,
			$diretorio,
			$diretorio1,
			$data_postagem,
			$usuario_id
		);
		$query->execute($values);
		$post_id = $con->lastInsertId();

		if($query) {
			$json_arr["success"] = 'Postagem efetuada com sucesso! Clique aqui para ve-la';
			move_uploaded_file($image_post['tmp_name'], '../'.$diretorio1);
			move_uploaded_file($image_principal['tmp_name'], '../'.$diretorio);
		}

		$query = $con->query("INSERT INTO post_has_categoria (post_id, categoria_id) VALUES ($post_id, $categoria)");

	function slug($title) {
		$title = preg_replace('~[^\pL\d]+~u', '-', $title);

		$title = iconv('utf-8', 'us-ascii//TRANSLIT', $title);

		$title = preg_replace('~[^-\w]+~', '', $title);

		$title = trim($title, '-');

		$title = preg_replace('~-+~', '-', $title);

		$title = strtolower($title);

		return $title;
	}

	echo json_encode($json_arr);

?>