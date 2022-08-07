<?php
	if(isset($_SESSION['user'])) {
		?>
		<script type="text/javascript">
			$(document).ready(function () {
				let val = '<?php echo $_SESSION['user']['nome_de_usuario']; ?>';
				let logout = document.getElementById('login');
				let userSymbol = document.getElementById('cad-user');

				userSymbol.innerHTML = val;
				logout.innerHTML = 'Fazer logout';

				logout.href = 'php/logout.php';
				userSymbol.href = 'perfil/'+val;
			});
		</script>
	<?php
	}else {
		unset($_SESSION['user']);
	}
?>
<style type="text/css">
	.redes {
		position: absolute;
		right: 17px;
		top: 8px;
	}

	.redes a {
		color: #222;
		text-decoration: underline;
	}
</style>
<section class="outros">
	<table>
		<td><a href="">Politica de Privacidade</a></td>
		<td><a href="">Quem Somos</a></td>
		<td><a href="">Contato</a></td>
	</table>
	<div class="redes">
		<a href="cadastro/" id="cad-user">Cadastre-se</a>
		ou faça
		<a href="login/" id="login">Login</a>
	</div>
</section>
<header>
	<div class="hamburger">
		<div class="bar"></div>
		<div class="bar1"></div>
		<div class="bar2"></div>
	</div>
	<nav class="menu">
		<div class="mobile-menu">
			<hr class="close-line" />
			<ul>
				<a href="" id="location"><li style="width: 120px;"><span>Home</span></li></a>
				<a href=""><li><span>Temporadas</span></li></a>
				<a href=""><li><span>Camisetas</span></li></a>
				<a href=""><li><span>Contato</span></li></a>
				<a href=""><li><span>Usuários</span></li></a>
			</ul>
		</div>
		<div class="ps-icon"></div>
		<div id="content-ps" class="">
		<form id="pesquisa" method="POST">
			<input type="text" name="inp-ps" id="inp-ps" placeholder="Digíte aqui..." />
		</form>
	</div>
	</nav>
</header>