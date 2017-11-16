<?php 

return "SELECT grupo, nomeTime, (nVitorias*3)+nEmpates AS nPontos, nVitorias, nEmpates, nDerrotas, nGolsFeitos-nGolsSofridos AS saldoGols, nGolsFeitos, nGolsSofridos
FROM time, time_tem_campeonato, campeonato
WHERE idTime = fk_idTime
AND idCampeonato = fk_idCampeonato
AND grupo = '".$grupo."'
ORDER BY nPontos DESC, nVitorias DESC, saldoGols DESC, nGolsFeitos DESC;";
?>