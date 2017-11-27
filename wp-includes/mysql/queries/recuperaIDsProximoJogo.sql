SELECT data AS dataJogo, fk_idTime AS idTimeCasa, fk_idVisitante AS idTimeVisitante
FROM jogo INNER JOIN jogo_tem_times 
ON jogo.idJogo = jogo_tem_times.fk_idJogo 
AND (jogo.data = (SELECT MAX(data) FROM jogo))