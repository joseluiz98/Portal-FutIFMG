SELECT J.data AS dataJogo, JT.fk_idTime AS idTimeCasa, JT.idVisitante AS idTimeVisitante
FROM jogo J INNER JOIN jogo_tem_times JT
ON J.idJogo = JT.fk_idJogo 
AND (J.data = (SELECT MAX(data) FROM jogo));