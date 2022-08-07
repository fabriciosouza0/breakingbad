function getStyle(classe, prop){
	if(!classe){
		try{
			if(typeof classe != 'string') throw 'O primeiro parametro deve ser uma string';
		}catch(ex){
			console.log(ex);
		}
		return;
	}

	var A_style = new Array();
	var style;
	var css = document.querySelector(classe);
	var rules = window.getComputedStyle(css, null);

	if(prop){
		try{
			if(typeof prop != 'string') throw 'O segundo parametro dessa fn deve ser uma string';
			style = rules.getPropertyValue(prop);
		}catch(ex){
			console.log(ex);
		}
		return style;
	}

	var tam = rules.length;

	for(var i = 0; i < tam; i++){
		if(rules.getPropertyValue(rules[i]) != null){
			style = rules[i];
		}
		strRules = rules[i]+" -> "+rules.getPropertyValue(style);
		A_style.push(strRules);
	}
	
	if(A_style.lenth >  0)
		return A_style;
}
//Funcao acionada ao fim do carregamento do documento.
$(document).ready(function(){
	//Variaveis 
	var topo = $('.top'),menu = $('.menu'),hamburger = $('.hamburger'),interval = setInterval(documentFocus, 200),count = 0,modal = document.querySelector('.modal-container'),hamburger = document.querySelector('.hamburger'),
	mobile_menu = document.querySelector('.mobile-menu'),pesquisa = $('.ps-icon'),pesquisaInp = $('#content-ps'),pesquisaInpS = document.querySelector('#content-ps');

	$(window).scroll(function(){
		let top = this.scrollY;
		let width = this.innerWidth;
		let aside = $('.aside');
		let mainHeigth =+ getStyle('main', 'height').replace('px', '');
		let contentWidth =+ getStyle('.content', 'width').replace('px', '');
		let mainWidth =+ getStyle('main', 'width').replace('px', '');
		let sizeOfAside = (width-mainWidth)/2;
		let leftOfAside = (sizeOfAside+contentWidth)-8;

		top > 420 && width > 980?(topo.fadeIn('fast'),menu.addClass('fix')):(topo.fadeOut('fast'),menu.removeClass('fix'));

		if(top > 430 && width > 980 && mainHeigth > 500) {
			console.log('entrou');
			if((mainHeigth+25) > top) {
				aside.css({"position": "absolute", "top": (top-aside.width()-65)+"px", "left": getStyle('.content', 'width')});
			}else {
				aside.css({"position": "absolute", "top": "auto", "bottom": "20px", "left": getStyle('.content', 'width')});
			}
		}else {
			aside.css({"position": "relative", "top": "0px", "left": "auto"});
		}
	});

	topo.click(function(){
		$('html, body').animate({scrollTop: 0}, 'slow');
	});

	$('.hamburger').click(function(){
		hamburger.classList.toggle('animate');
		mobile_menu.classList.toggle('show-menu');
		hamburger.classList.contains('animate')?$('html,body').css({overflow: "hidden"}):$('html,body').css({overflow: "auto"});
	});

	pesquisa.click(function(e){
		e.stopPropagation();
		fadeToggle('#content-ps', 0.00001);
	});

	pesquisaInp.click(function(e){
		e.stopPropagation();
	});

	$('body').click(function(e){
		var clickTarget = e.target.id;
		if(clickTarget != pesquisaInp)
			fadeOut('#content-ps', 0.00001);
	});

	function documentFocus(){
		if(document.hasFocus()){
			if(window.localStorage.getItem('first') != 'false'){
				count++;
				if(count == 50){
					_cadastro();
					window.localStorage.setItem('first', 'false');
					clearInterval(interval);
				}
			}else{
				clearInterval(interval);
			}
		}
	}

	function _cadastro(){
		modal.classList.add('show');
		modal.addEventListener('click', function(e){
			e.stopPropagation();
			if(e.target == modal){
				close(modal);
			}
		});
		document.querySelector('.close').addEventListener('click', close);
	}

	function close(){
		modal.classList.remove('show');
	}
});

function fadeToggle(elemento, tempo){
	if(getStyle(elemento, 'opacity') == 0){
		fadeIn(elemento, tempo);
	}else{
		fadeOut(elemento, tempo);
	}
}

function fadeIn(elemento, tempo){
	fade(elemento, tempo, 0, 100, 50);
}

function fadeOut(elemento, tempo){
	fade(elemento, tempo, 100, 0, 50);
}

function fade(elemento, tempo, inicio, fim, translate){
	var alvo = document.querySelector(elemento);
	var style = alvo.style;
	let move = translate;

	var elementTop = {
		top: function(){
			var marginTop = getStyle(elemento, 'margin-top');
			var top = marginTop.replace('px', '');
			return top;
		}
	}

	var contador;
	var contador_transfrom;
	var opacidade = inicio;
	var objetivo = elementTop.top();
	style.marginTop = "0px";

	if(inicio == 0){
		contador = 4;
		alvo.style.display = "block";
	}else{
		contador = -4;
	}

	if(translate != 0){
		contador_transfrom = 3;
	}

	var time = (tempo / 1000) * 50;

	setOpacidade(alvo, opacidade);
	setTranslate(alvo, 0);

	var intervalo = setInterval(
		function(){
			if((contador > 0 && opacidade >= fim) || (contador < 0 && opacidade <= fim)){
				if(fim == 0){
					setTimeout(function(){ style.display = "none"; }, 200);
				}
				clearInterval(intervalo);
			}else{
				opacidade += contador;
				setOpacidade(alvo, opacidade);
				if(translate <= move){
					translate += contador_transfrom;
					setTranslate(alvo, translate);
				}
			}
		}
	, time);
}

function setOpacidade(elemento, opacidade){
	elemento.style.opacity = opacidade/100;
}

function setTranslate(elemento, pixel){
	elemento.style.marginTop = pixel+"px";
}