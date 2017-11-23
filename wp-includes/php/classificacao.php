<?php
set_include_path('C:/wamp64/www/wp-includes/');
require_once('mysql/credentials.php');

$conn = new PDO('mysql:host=localhost;dbname='.$dbname, $dbuser, $dbpass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
}1
?>