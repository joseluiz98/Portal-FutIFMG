<?php
require("C:/xampp/htdocs/FutIFMG/wp-includes/mysql/credentials.php");

$sql = "SELECT nomeTime, escudo from time";
$consulta = $conn->prepare($sql);
$consulta->execute();
$resultado = $consulta->fetchAll();

$contador = 1;
$qtdMaxTimesLinha = 2;

foreach($resultado AS $equipe)
{
	//print json_encode($equipe[0], JSON_HEX_TAG);
}
?>

<!DOCTYPE html>
<html>
<body>

<script id="script-widget-equipes" language="javascript" type="text/javascript">
	// Imprime com Javascript informações dos times recuperadas via PHP
    var equipes = <?php echo json_encode($resultado); ?>;
    var linhas = equipes.length;
    var colunas = 2;

	var html = '<div class="row">';
    for(var i = 0; i<equipes.length; i++)
    {
    	var nome 	= equipes[i][0];
    	var escudo = equipes[i][1];
        var link   = "http://futifmg.serveblog.net:8080/times?tmpString=";
        link       += nome;
		html += '<div class="col-xs-12 col-ms-6 col-sm-6"><div class="card card-profile card-plain"><div class="col-md-5"><div class="card-image"><a href="'+ link + '" ><img class="img" src=" ' + escudo + '" alt="" title="Clique para ver mais informações sobre a equipe"></a></div></div><div class="col-md-7"><div class="content"><h4 class="card-title"> ' + nome + '</h4><p class="card-description">Locavore pinterest chambray affogato art party, forage coloring book typewriter. Bitters cold selfies, retro celiac sartorial mustache.</p></div></div></div></div>';
    }
    html += '</div>';

    $(".hestia-team-content").html(html);
</script>
</body>
</html>