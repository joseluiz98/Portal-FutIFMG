$(document).ready(function(){
	//Esconde todos os slides
	$(".carousel-content > div").hide();
	
	//Configura o estilo dos hovers (verde com o cursor em cima, verifica a cor quando estiver sem o cursor)
	$('.carousel-buttons').on('mouseenter', '.glyphicon-chevron-left', function () {
    	$(this).css("color", "green");
	}).on('mouseleave', '.glyphicon-chevron-left', function () {
    	atribuiCoresBotoes();
	});
	//Este é do botão direito
	$('.carousel-buttons').on('mouseenter', '.glyphicon-chevron-right', function () {
    	$(this).css("color", "green");
	}).on('mouseleave', '.glyphicon-chevron-right', function () {
    	atribuiCoresBotoes();
	});

	//Pega o slide inicial e o exibe
	var slideAtivo = $('[id*="active"]');
	atribuiCoresBotoes();
	slideAtivo.show();

	//Atribui tamanho ideal para as divs
	atribuiTamanhoDivs();
	$('.carousel-content').height($('.fourth-finals').height());

	//Função para responsividade do nome dos times
	if($(window).width() < 450){
		$('.nomeMandante').each(function() {
				$(this).html($(this).html().substring(0,3).toUpperCase());
			}
		);

		$('.nomeVisitante').each(function() {
				$(this).html($(this).html().substring(0,3).toUpperCase());
			}
		);
	}

	//Recupera e adicionar título inicial do slide
	var tituloAtivo = slideAtivo.children().find('h2').text();
	slideAtivo.children().find('h2').hide();
	$("#chave-titulo h3").html(tituloAtivo);

	var totalslides = $(".carousel-content > div").length;

	//User clicou para mudar de slide, trate
	$(".carousel-buttons > div > h2 > a").click(function(event){
		var indexAtual = slideAtivo.index();
		//User clicou em anterior
		if($(this).attr("id") == "prev"){
			var indexProximoSlide = slideAtivo.index() - 1;
			if (indexProximoSlide >= 0){
				var proximoSlide = $(".carousel-content > div").eq(indexProximoSlide); //Salva slide cujo index é o mesmo presente em .carousel-content
				tituloAtivo = proximoSlide.children().find('h2').text();
				proximoSlide.children().find('h2').hide();
				$("#chave-titulo h3").html(tituloAtivo);
				slideAtivo.hide();
				slideAtivo = proximoSlide;
				proximoSlide.show();
			}
		}
		//User clicou em próximo
		else {
			var indexProximoSlide = slideAtivo.index() + 1;
			if (indexProximoSlide < totalslides){
				var proximoSlide = $(".carousel-content > div").eq(indexProximoSlide); //Salva slide cujo index é o mesmo presente em .carousel-content
				tituloAtivo = proximoSlide.children().find('h2').text();
				proximoSlide.children().find('h2').hide();
				$("#chave-titulo h3").html(tituloAtivo);
				slideAtivo.hide();
				slideAtivo = proximoSlide;
				slideAtivo.show();
			}
		}
		atribuiCoresBotoes();
	 });

	///Esta função testa quais cores os botões devem receber
	///Black = existe um slide após o atual
	///Lightgrey = este é o´último slide nesta direção
	function atribuiCoresBotoes() {
		//Se é o primeiro slide à esquerda, colore lightgrey
		if(slideAtivo.index() == 0) {
			$(".glyphicon-chevron-left").css("color", "lightgrey");
			$(".glyphicon-chevron-right").css("color", "black");
		}
		//Se é o último slide à direita, colore lightgrey
		else if(slideAtivo.index() == totalslides-1){
			$(".glyphicon-chevron-left").css("color", "black");
			$(".glyphicon-chevron-right").css("color", "lightgrey");
		}
		//Senão, os dois recebem black
		else {
			$(".glyphicon-chevron-left").css("color", "black");
			$(".glyphicon-chevron-right").css("color", "black");
		}
	}

	//Função que atribui alturas visualmente agradáveis ao css das divs do slider
	function atribuiTamanhoDivs() {
		var maiorLargura = -1;

	   	$('.game-content').each(function() {
	 		maiorLargura = maiorLargura > $(this).width() ? maiorLargura : $(this).width();
	   	});

  		$('.game-content').each(function() {
	    	$(this).width(maiorLargura);
	   	});
	}
})