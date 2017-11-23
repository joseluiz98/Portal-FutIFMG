<?php
try
{
require_once('C:\wamp64\www\wp-includes\mysql\credentials.php');

$sql = "SELECT * FROM time where idTime = 1";
$sql2="SELECT * FROM time where idTime = 2";

$conn = new PDO('mysql:host=localhost;dbname='.$dbname, $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$result = $conn->prepare($sql);
$result->execute();
$result2 = $conn->prepare($sql2);
$result2->execute();

$row = $result->fetch(PDO::FETCH_ASSOC);
$row2 = $result2->fetch(PDO::FETCH_ASSOC);

echo '<h2 style="text-align: center;">Próximo Jogo:</h2>
<h2 style="text-align: center;"> <img class="wp-image-75 alignnone" style="color: #3c4858; font-size: 16px; width:88px;" src="data: imagem/png;base64, '. base64_encode($row['escudo']). '" alt="" width="100" height="100" /> '.$row['nomeTime'].'  <em><strong style="color:red;"> VS </strong></em>   '.$row2['nomeTime'].'<img class="wp-image-76 alignnone" style="width:88px;" src="https://portalifmg.000webhostapp.com/wp-content/uploads/2017/09/331px-Melbourne_Victory.svg_-251x300.png" alt="" width="101" height="121" /></h2>
<p style="text-align: center;"><strong><em>26 de janeiro de 2017 </em></strong></p>';

}
catch(PDOException $ex)
{
    echo 'ERROR: ' . $ex->getMessage();
}

?>