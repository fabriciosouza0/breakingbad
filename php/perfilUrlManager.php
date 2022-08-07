<?php

	$getUrl = (isset($_GET['page']))?$_GET['page']:null;
	$setUrl = ($getUrl!=null)?$getUrl:'home';
	$uri = strip_tags(trim($setUrl));

	$url = explode('/', $uri);

	$whiteList = array(
		"perfil_home",
		"perfil_editar",
		"perfil_postar",
		"",
	);

	switch($url[0]) {
		case "home":
			$url[0] = "perfil_home";
			break;
		case "editar":
			$url[0] = "perfil_editar";
			break;
		case "postar":
			$url[0] = "perfil_postar";
			break;
	}

	$page = 'perfil/'.$url[0].'.php';

	if( isset( $url[1] ) ){
		if(is_int($url[1])){
			$id = $url[1];
		}
	}

	if( file_exists($page) && in_array($url[0], $whiteList) ) {
		include_once($page);
	}else {
		echo "Página inexistente!";
	}

?>