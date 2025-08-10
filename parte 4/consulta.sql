SELECT 
    clientes.id,
    clientes.nome,
    AVG(produtos.preco) AS preco_medio_12m
FROM clientes
JOIN produtos 
    ON produtos.cliente_id = clientes.id
WHERE 
    clientes.status = 'ativo'
    AND produtos.tipo = 'livre'
    AND produtos.data >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
GROUP BY clientes.id, clientes.nome
ORDER BY clientes.nome;