<?php
setlocale(LC_ALL,'');

try
{
	require('C:\wamp64\www\wp-includes\mysql\credentials.php');
	//Recupera IDs dos times que participarão do próximo jogo
	$sql = file_get_contents('wp-includes/mysql/queries/recuperaIDsProximoJogo.sql');
	$resultado = $conn->prepare($sql);
	$resultado->execute();
	$dadosJogo = $resultado->fetch(PDO::FETCH_ASSOC);
	$phpdate = strtotime($dadosJogo["dataJogo"]);
	$mysqldate = strftime('%d de %B de %Y, às %R', $phpdate);
	$mysqldate{6} = strtoupper($mysqldate{6});;

	//Atribui IDs recuperados
	$idTimeCasa = $dadosJogo["idTimeCasa"];
	$idTimeVisitante = $dadosJogo["idTimeVisitante"];

	//Recupera dados do time da casa
	$idTime = $idTimeCasa;
	$sql = include 'wp-includes/mysql/queries/recuperaDadosTime.sql';
	$resultado = $conn->query($sql);
	$dadosTimeCasa = $resultado->fetch(PDO::FETCH_ASSOC);
	$linkTimeCasa = "http://futifmg.serveblog.net:8080/times?tmpString=";
	$linkTimeCasa .= $dadosTimeCasa["nomeTime"];

	//Recupera dados do time de fora
	$idTime = $idTimeVisitante;
	$sql = include 'wp-includes/mysql/queries/recuperaDadosTime.sql';
	$resultado = $conn->prepare($sql);
	$resultado->execute();
	$dadosTimeVisitante = $resultado->fetch(PDO::FETCH_ASSOC);
	$linkTimeVisitante= "http://futifmg.serveblog.net:8080/times?tmpString=";
	$linkTimeVisitante .= $dadosTimeCasa["nomeTime"];

	echo '<h2 style="text-align: center;">Próximo Jogo:</h2>
	<h2 class="proximo-jogo-conteudo"><a href="'.$linkTimeCasa.'"><img class="logo-time-proximo-jogo" src="'.$dadosTimeCasa['escudo'].'", alt="" width="100" height="100" /></a><span class="proximo-jogo-nome-time">'.$dadosTimeCasa['nomeTime'].'</span><em><strong style="color:red;"> X </strong></em><span class="proximo-jogo-nome-time">'.$dadosTimeVisitante['nomeTime'].'</span><a href="'.$linkTimeVisitante.'"><img class="logo-time-proximo-jogo" src="'.$dadosTimeVisitante['escudo'].'", alt="" width="101" height="121"; /></a></h2><p id="proximo-jogo-data" style="text-align: center;"><strong><em>'.$mysqldate.' </em></strong></p>';
}
catch(PDOException $ex)
{
    echo 'ERROR: ' . $ex->getMessage();
}
?>