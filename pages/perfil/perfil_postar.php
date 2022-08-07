<script type="text/javascript" src="<?=HOME?>/tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="<?=HOME?>/js/tinymce.init.js"></script>
<script type="text/javascript">
	$(function(){
		$('#cad-form').submit(function(e){
			e.preventDefault();
			let valueOfEditor = tinymce.get('editor').getContent();
			document.querySelector('#editor').innerHTML = valueOfEditor;
			let dados = new FormData(this);

			salva(dados);
		});

		function salva(dados){
			$.ajax({

				type: "POST",
				url: "/breakingbad/php/cad_postagem.php",
				data: dados,

				success: function(data){
					console.log(data.dados["slug"], data.success);
				},

				cache: false,
    			contentType: false,
    			processData: false,
    			dataType: 'JSON'

			});
		}
	});
</script>
<style type="text/css">
	main {
		margin-top: 30px;
		margin-bottom: 30px;
		background: #fff;
	}

	#cad-field table {
		width: 100%;
	}

	#cad-field table tr td {
		padding: 3px;
		margin: 0;
	}

	#cad-field input {
		width: 98.77777%;
		border: 1px solid #333;
	}

	#cad-field input[type="submit"] {
		width: 100.22222%;
	}

	@media screen and (max-width: 480px) {
		#cad-field input {
			width: 97.5555%;
		}

		#cad-field input[type="submit"] {
			width: 100.77777%;
		}
	}

	span#mceu_31{
		display: none;
	}

	.select {
		padding: 5px;
		font-size: 16px;
		line-height: 1;
		height: 34px;
	}

	.upload-image-preview {
		padding: 10px;
		max-width: 90%;
		max-height: 500px;
		border: solid 2px #000;
	}
</style>
<form id="cad-form" method="POST" enctype="multipart/form-data" style="margin-top: 35px; width: auto; padding: 10px">
	<fieldset id="cad-field" style="width: auto; height: auto;">
		<h3 class="title" style="color: #333; font-size: 1.3em;">
			Os campos com * são obrigatorios !
		</h3>
		<div class="alert hidden" id="alert"></div>
		<legend style="text-align: center; padding: 0px 10px;"><img src="<?=HOME?>/assets/cadeado.png" width="40px;" height="40px;" draggable="false"></legend>
		<table cellspacing="10px" style="position: relative; margin: 0 auto;">
			<tr>
				<tr>
					<td>Foto para o banner: </td>
				</tr>
				<td align="center">
					<label for="post-banner-image">
						<img src="<?=HOME?>/assets/upload.png" class="upload-image-preview" id="Image-banner" style="padding: 15px" />

					</label>
				</td>
				<input type="file" id="post-banner-image" onchange="validateImage(this, 1336, 720, 1920, 1080, 'Image-banner');" name="post-banner-image" accept="image/*" style="display: none;" />
				<tr>
					<td>Foto de amostra: *</td>
				</tr>
				<td align="center">
					<label for="post-image">
						<img src="<?=HOME?>/assets/upload.png" class="upload-image-preview" id="Image-post" style="padding: 15px" />
					</label>
				</td>
			</tr>
			<input type="file" id="post-image" onchange="validateImage(this, 133, 133, 610, 400, 'Image-post');" name="post-image" accept="image/*" style="display: none;" />
			<tr>
				<td>Titúlo: *</td>
			</tr>
			<tr>
				<td><input type="text" name="titulo" placeholder="Título da postagem" /></td>
			</tr>
			<tr>
				<td>Conteúdo da postagem: *</td>
			</tr>
			<tr>
				<td><textarea name="conteudo" id="editor"></textarea></td>
			</tr>
			<tr>
				<td>Categoria: *</td>
			</tr>
			<tr>
				<td align="left">
					<select class="select" name="categoria">
						<?php  

							$query = $con->query("SELECT * FROM categoria");

							while($row = $query->fetch()) {
								echo '<option value='.$row['id'].'>'.$row['nome'].'</option>';
							}

						?>
					</select>
				</td>
			</tr>
			<tr>
				<td align="Left"><input type="submit" name="" value="Postar" /></td>
			</tr>
		</table>
	</fieldset>
</form>