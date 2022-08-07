<?php

	require_once('../php/connection.php');

	$slug = isset($_GET['slug'])?$_GET['slug']:null;

	$query = $con->prepare("SELECT post.image_post, post.image_principal, post.titulo, post.postagem, usuario.nome_de_usuario, categoria.nome FROM post_has_categoria INNER JOIN post ON post.id = post_has_categoria.post_id INNER JOIN categoria ON categoria.id = post_has_categoria.categoria_id INNER JOIN usuario ON usuario.id = post.usuario_id where post.slug = ? LIMIT 1");
	$query->bindValue(1,$slug,PDO::PARAM_STR);
	$query->execute();

	if($query->rowCount() > 0) {
		$row = $query->fetch();
	}else {
		echo "Artigo inexistente ou excluido.";
	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, user-scalable=no" />
	<meta name="description" content="Site de notícias sobre Breaking Bad" />
	<meta name="keywords" content="Breaking Bad" />
	<meta name="robots" content="index, follow" />
	<meta name="author" content="Fabricio Souza" />
	<link rel="icon" href="<?=HOME?>/logo.ico" type="image/x-icon" />
	<title>Breaking Bad - <?php echo $row['titulo'] ?></title>
	<link rel="stylesheet" type="text/css" href="<?=STYLE?>" />
	<style type="text/css">
		main {
			padding-top: 20px;
			padding-bottom: 20px;
		}

		p {
			position: relative;
			margin-top: 25px;
		}

		iframe, object, embed {
	        max-width: 100%; 
	       	max-height: 300px;
		}

		@media screen and (min-width: 720px) {
			iframe, object, embed {
	        	max-width: 100%;
	        	max-height: 400px;
			}
		}

		@media screen and (max-width: 480px) {
			iframe, object, embed {
	        	max-width: 100%;
	        	max-height: 200px;
			}
		}

		h1 {
			margin-top: 25px;
		}

		img {
			max-width: 100%;
			height: auto;
		}

		.post {
			position: relative;
			margin: 10px;
		}

		#post-text {
			word-wrap: break-word;
			padding: 5px;
		}
	</style>
</head>
<body>
<section class="outros">
	<table>
		<td><a href="">Politica de Privacidade</a></td>
		<td><a href="">Quem Somos</a></td>
		<td><a href="">Contato</a></td>
	</table>
	<div class="redes">
	</div>
</section>
<header style="background: url(<?=HOME?>/<?php echo $row['image_principal']; ?>) no-repeat center; background-size:cover;">
	
</header>
<main>
	<section class="content" style="background: #fff; z-index: 102;">
		<div class="post">
			<center><span id="title-post"><?php echo $row['titulo'];  ?></span></center>
			<div id="post-text">
					<?php
						echo html_entity_decode($row['postagem']);
					?>
			</div>
		</div>
	</section>
	<section class="aside" style="background: #fff;">
		Sdsds
	</section>
</main>
<?php  

	include '../php/footer.php';

?>
</body>
</html>