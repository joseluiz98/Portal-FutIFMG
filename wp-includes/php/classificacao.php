<?php
set_include_path('C:/xampp/htdocs/FutIFMG/wp-includes/');
require_once('mysql/credentials.php');

try
{
	$gruposDoCampeonato = recuperaGruposDoCampeonato($conn);
	foreach($gruposDoCampeonato as $grupo)
	{
		preencheTabela($conn,$grupo["idGrupo"]);
	}
}
catch(PDOException $ex)
{
	echo $ex->getMessage();
}
catch(Exception $ex)
{
	echo $ex->getMessage();
}

function recuperaGruposDoCampeonato($conn)
{
	try
	{
		$sql = file_get_contents('wp-includes/mysql/queries/recuperaGruposDoCampeonato.sql');
		$consulta = $conn->prepare($sql);
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		return $resultado;
	}
	catch(PDOException $ex)
	{
		echo 'Erro: ' . $ex->getMessage();
	}
	catch(Exception $ex)
	{
		throw new PDOException("<b>Erro Fatal:</b> Há um erro na divisão de grupos do campeonato.");
	}
}

function preencheTabela($conn,$grupo)
{
	try
	{
		$sql = include 'wp-includes/mysql/queries/recuperaTabela.sql';
    	$consulta = $conn->query($sql);
	}
	catch(PDOException $ex)
	{
		throw new PDOException("<b>Erro Fatal:</b> Houve um erro ao recuperar os dados dos times.");
	}
	
	echo '<div class="table-responsive leagueTable">';
	    echo '<table>';
		echo '<tr id="tableHeader" style="font-family: Open Sans Condensed;">';
		echo '<td nowrap colspan="2" class="leagueTableColumn" id="teamNameColumn">Grupo '.$grupo.'</td>';
		echo '<td class="leagueTableColumn" id="col2">P</td>';
		echo '<td class="leagueTableColumn" id="col3">V</td>';
		echo '<td class="leagueTableColumn" id="col4">E</td>';
		echo '<td class="leagueTableColumn" id="col5">D</td>';
		echo '<td class="leagueTableColumn" id="col6">GF</td>';
		echo '<td class="leagueTableColumn" id="col7">GS</td>';
		echo '<td class="leagueTableColumn" id="col8">SG</td>';
		echo '</tr>';
	
	$i = 1;
    while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
		echo '<tr id="tableData">';
		echo '<td nowrap class="leagueTableColumn">'.$i;
		echo '<td nowrap class="leagueTableColumn">'.$linha['nomeTime'].'</td>';
		echo '<td nowrap class="leagueTableColumn">'.$linha['nPontos'].'</td>';
		echo '<td nowrap class="leagueTableColumn">'.$linha['nVitorias'].'</td>';
		echo '<td nowrap class="leagueTableColumn">'.$linha['nEmpates'].'</td>';
		echo '<td nowrap class="leagueTableColumn">'.$linha['nDerrotas'].'</td>';
		echo '<td nowrap class="leagueTableColumn">'.$linha['nGolsFeitos'].'</td>';
		echo '<td nowrap class="leagueTableColumn">'.$linha['nGolsSofridos'].'</td>';
		echo '<td nowrap class="leagueTableColumn">'.$linha['saldoGols'].'</td>';
		echo '</tr>';
		$i = $i+1;
	}
		echo '</table>';
	echo '</div>';
}

?>

<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" carousel-content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src='<?php echo site_url() ?>/wp-includes/js/pageJogos.js'></script>
</head>
<body>
	<div class="carousel-jogos">
		<nav class="carousel-buttons">
			<div class="col-sm-4" id="left-row"><h2><a class="glyphicon glyphicon-chevron-left" id="prev" style="color: black"></a></h2></div>
			<div class="col-sm-4" id="actual-title"><span id="chave-titulo"><h3></h3></span></div>
			<div class="col-sm-4" id="right-row"><h2><a class="glyphicon glyphicon-chevron-right" id="prox" style="color: black"></a></h2></div>
		</nav>

		<div class="carousel-content">
			<div id="item active" style="display: none;">
				<span id="currentcarousel-contentTitle"><h2>Grupo A</h2></span>
            	<div class="grupo-a">
	              <?php
	                $sqlCasa = "SELECT nomeTime, escudo, placarCasa, idJogo FROM time, jogo_tem_times, jogo WHERE fk_idJogo in (1,2,5,6,9,10) and idTime = fk_idTime and fk_idJogo = idJogo ORDER BY idJogo";
	                $sqlVisitante = "SELECT T.nomeTime, T.escudo, J.placarVisitante, J.idJogo FROM time T, jogo_tem_times JT, jogo J WHERE J.idJogo in (1,2,5,6,9,10) and T.idTime = JT.idVisitante and J.idJogo = JT.fk_idJogo ORDER BY J.idJogo";

	                $resultCasa = $conn->prepare($sqlCasa);
	                $resultCasa->execute();
	                $resultVisitante = $conn->prepare($sqlVisitante);
	                $resultVisitante->execute();
	                while($rowMandante = $resultCasa->fetch() and $rowVisitante = $resultVisitante->fetch()){
                  		echo '<div class="game">';
                  		echo '<span class="game-content">';
						  echo '<span class="nomeMandante">'.$rowMandante["nomeTime"].'</span>';
						  
                      	echo '<img class="escudoTime escudoMandante" src='.$rowMandante["escudo"].'></img>';
                  		echo " " . $rowMandante["placarCasa"];
                	  	echo ' x ';
	                  	echo $rowVisitante["placarVisitante"]. " ";
                      	echo '<img class="escudoTime escudoVisitante" src='.$rowVisitante["escudo"].'></img>';

	                  	echo '<span class="nomeVisitante">'.$rowVisitante["nomeTime"].'</span>';
	                  	echo '</span>';
	                  	echo '</div>';
	                }
	              ?>
				</div>
			</div>

			<div id="item" style="display: none;">
				<span id="currentcarousel-contentTitle"><h2>Grupo B</h2></span>
            	<div class="grupo-b">
	              <?php
	                $sql = "SELECT nomeTime, escudo, placarCasa, idJogo FROM time, jogo_tem_times, jogo WHERE fk_idJogo in (3,4,7,8,11,12) and idTime = fk_idTime and fk_idJogo = idJogo ORDER BY idJogo";
	                $sql2 = "SELECT T.nomeTime, T.escudo, J.placarVisitante, J.idJogo FROM time T, jogo_tem_times JT, jogo J WHERE J.idJogo in (3,4,7,8,11,12) and T.idTime = JT.idVisitante and JT.fk_idJogo = J.idJogo ORDER BY J.idJogo;";

	                $resultCasa = $conn->prepare($sql);
	                $resultCasa->execute();
	                $resultVisitante = $conn->prepare($sql2);
	                $resultVisitante->execute();
	                while($rowMandante = $resultCasa->fetch() and $rowVisitante = $resultVisitante->fetch()){
                    echo '<div class="game">';
                    echo '<span class="game-content">';
                    echo '<span class="nomeMandante">'.$rowMandante["nomeTime"].'</span>';
                    echo '<img class="escudoTime escudoMandante" src='.$rowMandante["escudo"].'></img>';
                    echo " " . $rowMandante["placarCasa"];
                    echo ' x ';
                    echo $rowVisitante["placarVisitante"]. " ";
                    echo '<img class="escudoTime escudoVisitante" src='.$rowVisitante["escudo"].'></img>';
                    echo '<span class="nomeVisitante">'.$rowVisitante["nomeTime"].'</span>';
                    echo '</span>';
                    echo '</div>';
	                }
	              ?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>