$id = $_POST['id'];
$nome = $_POST['id'];
$cpf = $_POST['cpf'];


function cadastraCliente(){
	$sql = "insert into clientes (nome, cpf) values ('$nome', '$cpf')";
}
function alteraCliente(){
	$sql = "Update clientes set nome = '$nome', cpf = '$cpf' where id like '$id'";
}
function deletaCliente(){
  $sql = "Delete * from clientes where id like '$id';
}
