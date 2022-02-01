<?php
	session_start();
    $path = dirname(__FILE__);
        @$empresa = $_SESSION['empresa_id'];
        @$filial = $_SESSION['filial_id'];
        @$usuario = $_SESSION['usuario_id'];
    	$msg = '';
        $log_msg = '';
	function __autoload($classe) 
	{
        include_once "../classes/$classe.php";
	}


                                                $listagem = new Consulta();
                                                $listagem->Conecta();
                                                // $retorno = $listagem->ConsultaDados('cf_imagem', 'img_nome','ASC','(img_nome like "%'.$pesquisa.'%" or img_tags like "%'.$pesquisa.'%") and img_empresa='.$_SESSION['empresa_id']);

                                                $retorno = $listagem->ConsultaDados('cf_imagem', 'img_id','DESC','1');
                         
                                                $a = 1;
                                                if(count($retorno) > 0){
                         	                       	foreach ($retorno as $linha) {
                            								echo $linha->img_caminho;
                            								$a++;     
                            								if ($a > 1) {
                            									exit;
                            								}
                            								               			# code...
                            								               		              		
                                                	}
                                                }



?>



<?php //echo  'https://dboaditivos.cartazfacil.pro/vinhos/7896855901417.png';

?>
