$acao = $_POST['acao'];
//acao 1 - cadastrar, 2 - alterar, 

$id = $_POST['id'];
$nome = $_POST['nome'];
$status = $_POST['status'];
$preco = $_POST['preco'];
$descricao = $_POST['descricao'];
$categoria = $_POST['id_categoria'];

functionCadastraProduto(){
  #sql = "Insert into PRODUTOS(nome, status, preco, descricao, categoria)values('$nome', '$status', '$preco', '$descricao', '$categoria');
}
functionAlteraProduto(){
  $sql = "Update PRODUTOS set nome = '$nome', status = '$status', preco = '$preco', descricao = '$descricao', categoria = '$categoria' where id like '$id';
}
functionExcluiProduto(){
  $sql = "Delete from PRODUTOS where id like '$id';
}
