<style type="text/css">
	#divisor{
		top: 40px;
		background-image: linear-gradient(to right, transparent, #000,transparent);
	}
	
	.file-image {
		position: relative;
		margin: 0 auto;
		width: 80%;
		height: 80%;
		border: 2px solid #333;
		text-align: center;
	}

	#cad-field img#Image {
		max-width: 100%;
		max-height: 100%;
		border: 2px solid black;
	}

	#cad-field {
		width: 300px;
		height: 360px;
		margin: 3px auto;
		padding-top: 5px;
	}
</style>
<article class="perfil-apresentacao">
	<center>
		<h1 style="padding: 10px">Apresentação</h1>
	</center>
	<hr id="divisor" />
	<div class="content-data" style="padding: 12px;">
		<?php 
			echo $user['descricao'];
		?>
	</div>
</article>
<section class="content">
	
</section>