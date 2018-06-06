<?php
    require_once("C:\xampp\htdocs\FutIFMG\wp-includes\mysql\credentials.php");
 ?>

<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" carousel-content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="/wp-includes/js/pageJogos.js"></script>
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
				<span id="currentcarousel-contentTitle"><h2>Quartas de Final</h2></span>
            	<div class="fourth-finals">
	              <?php
	                $sqlCasa = "SELECT nomeTime, escudo, placarCasa, idJogo FROM time, jogo_tem_times, jogo WHERE fk_idJogo in (13,14,15,16) and idTime = fk_idTime and fk_idJogo = idJogo ORDER BY idJogo";
	                $sqlVisitante = "SELECT nomeTime, escudo, placarVisitante, idJogo FROM time, jogo_tem_times, jogo WHERE fk_idJogo in (13,14,15,16) and idTime = fk_idVisitante and fk_idJogo = idJogo ORDER BY idJogo";
	                
	                $resultCasa = $conn->prepare($sqlCasa);
	                $resultCasa->execute();

	                $resultVisitante = $conn->prepare($sqlVisitante);
	                $resultVisitante->execute();

	                while($rowMandante = $resultCasa->fetch() and $rowVisitante = $resultVisitante->fetch()){
                  		echo '<div class="game">';
                  		echo '<span class="game-content">';
	                  	echo '<img class="escudoTime escudoMandante" src='.$rowMandante["escudo"].'></img>';
	                  	echo '<span class="nomeMandante">'.$rowMandante["nomeTime"].'</span>';
                  		echo " " . $rowMandante["placarCasa"];
                	  	echo ' x ';
	                  	echo $rowVisitante["placarVisitante"]. " ";
	                  	echo '<span class="nomeVisitante">'.$rowVisitante["nomeTime"].'</span>';
	                  	echo '<img class="escudoTime escudoVisitante" src='.$rowVisitante["escudo"].'></img>';
	                  	echo '</span>';
	                  	echo '</div>';
	                }
	              ?>
				</div>
			</div>

			<div id="item" style="display: none;">
				<span id="currentcarousel-contentTitle"><h2>Semifinais</h2></span>
            	<div class="semiFinals">
	              <?php
	                $sql = "SELECT nomeTime, escudo, placarCasa, idJogo FROM time, jogo_tem_times, jogo WHERE fk_idJogo in (17,18) and idTime = fk_idTime and fk_idJogo = idJogo ORDER BY idJogo";
	                $sql2 = "SELECT nomeTime, escudo, placarVisitante, idJogo FROM time, jogo_tem_times, jogo WHERE fk_idJogo in (17,18) and idTime = fk_idVisitante and fk_idJogo = idJogo ORDER BY idJogo";
	                
	                $resultCasa = $conn->prepare($sql);
	                $resultCasa->execute();

	                $resultVisitante = $conn->prepare($sql2);
	                $resultVisitante->execute();

	                while($rowMandante = $resultCasa->fetch() and $rowVisitante = $resultVisitante->fetch()){
                  		echo '<div class="game">';
              			echo '<span class="game-content">';
                  		echo '<img class="escudoTime escudoMandante" src='.$rowMandante["escudo"].'></img>';
	                  	echo '<span class="nomeMandante">'.$rowMandante["nomeTime"].'</span>';
                  		echo " " . $rowMandante["placarCasa"];
                	  	echo ' x ';
	                  	echo $rowVisitante["placarVisitante"]. " ";
	                  	echo '<span class="nomeVisitante">'.$rowVisitante["nomeTime"].'</span>';
	                  	echo '<img class="escudoTime escudoVisitante" src='.$rowVisitante["escudo"].'></img>';
	                  	echo '</span>';
	                  	echo '</div>';
	                }
	              ?>
				</div>
			</div>

			<div id="item" style="display: none;">
				<span id="currentcarousel-contentTitle"><h2>Finais</h2></span>
            	<div class="finals">
	              <?php
	                $sql = "SELECT nomeTime, escudo, placarCasa, idJogo FROM time, jogo_tem_times, jogo WHERE fk_idJogo in (20) and idTime = fk_idTime and fk_idJogo = idJogo ORDER BY idJogo";
	                $sql2 = "SELECT nomeTime, escudo, placarVisitante, idJogo FROM time, jogo_tem_times, jogo WHERE fk_idJogo in (20) and idTime = fk_idVisitante and fk_idJogo = idJogo ORDER BY idJogo";
	                
	                $resultCasa = $conn->prepare($sql);
	                $resultCasa->execute();

	                $resultVisitante = $conn->prepare($sql2);
	                $resultVisitante->execute();

	                while($rowMandante = $resultCasa->fetch() and $rowVisitante = $resultVisitante->fetch()){
                  		echo '<div class="game">';
              			echo '<span class="game-content">';
                  		echo '<img class="escudoTime escudoMandante" src='.$rowMandante["escudo"].'></img>';
	                  	echo '<span class="nomeMandante">'.$rowMandante["nomeTime"].'</span>';
                  		echo " " . $rowMandante["placarCasa"];
                	  	echo ' x ';
	                  	echo $rowVisitante["placarVisitante"]. " ";
	                  	echo '<span class="nomeVisitante">'.$rowVisitante["nomeTime"].'</span>';
	                  	echo '<img class="escudoTime escudoVisitante" src='.$rowVisitante["escudo"].'></img>';
	                  	echo '</span>';
	                  	echo '</div>';
	                }
	              ?>
				</div>
			</div>

			<div id="item" style="display: none;">
				<span id="currentcarousel-contentTitle"><h2>Terceiro Lugar</h2></span>
            	<div class="thirdPlace">
	              <?php
	                $sql = "SELECT nomeTime, escudo, placarCasa, idJogo FROM time, jogo_tem_times, jogo WHERE fk_idJogo in (19) and idTime = fk_idTime and fk_idJogo = idJogo ORDER BY idJogo";
	                $sql2 = "SELECT nomeTime, escudo, placarVisitante, idJogo FROM time, jogo_tem_times, jogo WHERE fk_idJogo in (19) and idTime = fk_idVisitante and fk_idJogo = idJogo ORDER BY idJogo";
	                
	                $resultCasa = $conn->prepare($sql);
	                $resultCasa->execute();

	                $resultVisitante = $conn->prepare($sql2);
	                $resultVisitante->execute();

	                while($rowMandante = $resultCasa->fetch() and $rowVisitante = $resultVisitante->fetch()){
                  		echo '<div class="game">';
              			echo '<span class="game-content">';
                  		echo '<img class="escudoTime escudoMandante" src='.$rowMandante["escudo"].'></img>';
	                  	echo '<span class="nomeMandante">'.$rowMandante["nomeTime"].'</span>';
                  		echo " " . $rowMandante["placarCasa"];
                	  	echo ' x ';
	                  	echo $rowVisitante["placarVisitante"]. " ";
	                  	echo '<span class="nomeVisitante">'.$rowVisitante["nomeTime"].'</span>';
	                  	echo '<img class="escudoTime escudoVisitante" src='.$rowVisitante["escudo"].'></img>';
	                  	echo '</span>';
	                  	echo '</div>';
	                }
	              ?>
				</div>
			</div>
			</div>
		</div>
	</div>
</body>
</html>