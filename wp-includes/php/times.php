<?php

require_once("C:\wamp64\www\wp-includes\mysql\credentials.php");

if (isset($_GET['tmpString'])){
    $tmpString = $_GET['tmpString'];
  }else{
    $tmpString = null;
  }

try
{
    if ($tmpString != null){
    $sql = "SELECT * FROM time WHERE nomeTime = '$tmpString'";
    $result = $conn->prepare($sql);
    $result->execute();
    $row = $result->fetch();
    $id_Time = $row["idTime"];
    $sqlJogadores = "SELECT nome, numero FROM jogador WHERE fk_idTime = '$id_Time'";
    $result2 = $conn->prepare($sqlJogadores);
    $result2->execute();

    $imagem = $row["escudo"];

    $tabela = '<table border="1">';//abre table
    $tabela .='<thead>';//abre cabeçalho
    $tabela .= '<tr>';//abre uma linha
    $tabela .= '<th>Número</th>'; // colunas do cabeçalho
    $tabela .= '<th>Nome</th>';
    $tabela .= '</tr>';//fecha linha
    $tabela .='</thead>'; //fecha cabeçalho
    $tabela .='<tbody>';//abre corpo da tabela

    while ( $rowJogadores = $result2->fetch()) {
      $nomeJogador = $rowJogadores['nome'];
    utf8_encode($nomeJogador);
    $caminho = "http://futifmg.serveblog.net:8080/jogador?tmpString=";
    $caminho .= $nomeJogador;
    $tabela .= '<tr>'; // abre uma linha
    $tabela .= '<td>'.$rowJogadores['numero'].'</td>'; //coluna numero
    $tabela .= "<td> <a href='$caminho'>" .$nomeJogador."</a></td>"; // coluna nome
    $tabela .= '</tr>'; // fecha linha
    }

    $tabela .='</tbody>'; //fecha corpo
    $tabela .= '</table>';//fecha tabela

    echo '<div class = "infoTime" style = "position:relative; margin-top:15%">';
    echo '<div class = "imagemTime" style = "position:absolute;">';
    echo "<img src='$imagem' style = 'height:200px; width:200px; position:relative; margin-top:-21%'/>";
    echo '</div>';
    echo '<div class = "time" style = "margin-left:25%; margin-top:-15%;">';
    echo 'Nome: ' .$row['nomeTime'].'<br />';
    echo 'Técnico: '.$row['nomeTecnico'].'<br />';
    echo '</div></div>';
    echo '<div class = "jogadores" style = "margin-top:10%;">';
    echo '<h2 style="margin-left:40%;"> Elenco </h2>';
    echo $tabela;
    echo '</div>';

  } else {

  $sqlTimes = "SELECT nomeTime, escudo FROM time ";
    $resultTimes = $conn->prepare($sqlTimes);
    $resultTimes->execute();
    $tabela2 = '<table border="1" tbody style = "border-color: transparent;"';
    $tabela2 .='<tbody>'; //abre corpo da tabela

    while ( $rowTimes = $resultTimes->fetch()) {
    $imagem = $rowTimes['escudo'];
    $caminho = "http://futifmg.serveblog.net:8080/times?tmpString=";
    $caminho .= $rowTimes['nomeTime'];
    $tabela2 .= '<tr>'; // abre uma linha
    $tabela2 .= "<td> <img src='$imagem' style = 'height:200px; width:200px;'/> </td>";
    $tabela2 .= "<td> <a href='$caminho'>" .$rowTimes['nomeTime']."</a></td>";
    $tabela2 .= '</tr>'; // fecha linha
  }

    $tabela2 .='</tbody>'; //fecha corpo
    $tabela2 .= '</table>';//fecha tabela

    echo '<div class = "times" style = "position:relative;">';
    echo $tabela2;
    echo '</div>';

}
}
catch(PDOException $ex)
{
    echo 'ERRO:'.$ex->getMessage();
}
?>