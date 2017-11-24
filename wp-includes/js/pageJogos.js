$(document).ready(function(){
	//Esconde todos os slides
	$(".content > div").hide();
	
	//Pega o elemento inicial e em seguida o exibe
	var elementoAtivo = $('[id*="active"]');
	elementoAtivo.show();
	
	//Recupera e adicionar título inicial do slide
	var tituloAtivo = elementoAtivo.children().find('h2').text();
	elementoAtivo.children().find('h2').hide();
	$("#chave-titulo h3").html(tituloAtivo);

	var totalElementos = $(".content > div").length;

	$(".carousel-buttons > div > h2 > a").click(function(event){
		var indexAtual = elementoAtivo.index();
		//User clicou em anterior
		if($(this).attr("id") == "prev"){
			var indexProximoElemento = elementoAtivo.index() - 1;
			if (indexProximoElemento >= 0){
				var proximoElemento = $(".content > div").eq(indexProximoElemento); //Salva elemento cujo index é o mesmo presente em .content
				tituloAtivo = proximoElemento.children().find('h2').text();
				proximoElemento.children().find('h2').hide();
				$("#chave-titulo h3").html(tituloAtivo);
				elementoAtivo.hide();
				elementoAtivo = proximoElemento;
				proximoElemento.show(400);
			}
		}
		//User clicou em próximo
		else {
			var indexProximoElemento = elementoAtivo.index() + 1;
			if (indexProximoElemento < totalElementos){
				var proximoElemento = $(".content > div").eq(indexProximoElemento); //Salva elemento cujo index é o mesmo presente em .content
				tituloAtivo = proximoElemento.children().find('h2').text();
				proximoElemento.children().find('h2').hide();
				$("#chave-titulo h3").html(tituloAtivo);
				elementoAtivo.hide();
				elementoAtivo = proximoElemento;
				elementoAtivo.show(400);
			}
		}
		
		/*if(elementoFilho.css("visibility") == "visible"){
			alert("caio!");
			elementoFilho.hide("slow");
		} else{
			alert("não caio!");
			alert(elementoFilho.attr("id"));
			elementoFilho.show("slow");
		}*/
	 });
})