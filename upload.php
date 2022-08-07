<?php  

	require_once('php/connection.php');

	if(isset($_FILES['arq']) && isset($_POST['titulo']) && isset($_POST['conteudo']) && isset($_POST['categoria'])){

		$arquivo = $_FILES['arq'];
		$titulo = strip_tags(trim($_POST['titulo']));
		$slug = slug($titulo);
		$conteudo = htmlentities($_POST['conteudo'], ENT_QUOTES);
		$categoria = $_POST['categoria'];
		$data_post = date('Y-m-d H:i');

		$extensao = strtolower(substr($arquivo['name'], -4));
		$novo_nome = md5(time()).$extensao;
		$diretorio = HOME."images/".$novo_nome;

		move_uploaded_file($arquivo['tmp_name'], $diretorio);

		$query = $con->prepare("INSERT INTO post (image, descricao, conteudo, data_post) VALUES (:image,:descricao,:conteudo,:data_post)");
		$query->bindValue(":image", $diretorio);
		$query->bindValue(":descricao", $titulo);
		$query->bindValue(":conteudo", $conteudo);
		$query->bindValue(":data_post", $data_post);
		$query->execute();

		$codigo_noticia = $con->lastInsertId();

		$query = $con->prepare("INSERT INTO POST_NOTICIA (codigo_noticia) VALUES (:codigo_noticia)");
		$query->bindValue(":codigo_noticia", $codigo_noticia);
		$query->execute();

	}

?>