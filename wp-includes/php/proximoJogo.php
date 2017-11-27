<?php
setlocale(LC_ALL,'');

try
{
	require_once('C:\wamp64\www\wp-includes\mysql\credentials.php');
	//Recupera IDs dos times que participarão do próximo jogo
	$conn = new PDO('mysql:host=localhost;dbname='.$dbname, $dbuser, $dbpass);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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

	//Recupera dados do time de fora
	$idTime = $idTimeVisitante;
	$sql = include 'wp-includes/mysql/queries/recuperaDadosTime.sql';
	$resultado = $conn->prepare($sql);
	$resultado->execute();
	$dadosTimeVisitante = $resultado->fetch(PDO::FETCH_ASSOC);

	echo '<h2 style="text-align: center;">Próximo Jogo:</h2>
	<h2 id="nextGameContent"> <span id="team1Scores"> <img class="wp-image-75 alignnone" style="color: #3c4858; font-size: 16px; width:88px; margin: auto 1em;" src="'.$dadosTimeCasa['escudo'].'", alt="" width="100" height="100" /> <span id="nextGameTeam1">'.$dadosTimeCasa['nomeTime'].'</span></span> <em><strong style="color:red;"><br class="line-break"> X <br class="line-break"></strong></em> <span id="team2Scores"><span id="nextGameTeam2">'.$dadosTimeVisitante['nomeTime'].'</span><img class="wp-image-76 alignnone" style="width:88px; margin: auto 1em;" src="'.$dadosTimeVisitante['escudo'].'", alt="" width="101" height="121"; /></span></h2>
	<p style="text-align: center;"><strong><em>'.$mysqldate.' </em></strong></p>';
}
catch(PDOException $ex)
{
    echo 'ERROR: ' . $ex->getMessage();
}

?>