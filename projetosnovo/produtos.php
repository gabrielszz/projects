

$sql = "Select * from PRODUTOS where CATEGORIA like '$categoria' and status like '1';
$rs = mysqli_query($sql, $conexaoSelect);
while ($produtos = mysqli_fetch_array(MYSQLI_ASSOC, $sql)){
    $nome = $produtos['nome'];
    $descricao = $produtos['descricao'];
    $quantidade = $produtos['quantidade'];
    $preco = $produtos['preco'];
}
