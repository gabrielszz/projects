$_

if(isset($_SESSION['carrinho'])){
  $n = sizeof($_SESSION['carrinho'];
  $_SESSION['carrinho'][$n] = $_POST['carrinho'];
}

