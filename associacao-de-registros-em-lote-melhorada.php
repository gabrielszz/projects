////Associação de registros em lote melhorara

<?php
session_start();

@$empresa = $_SESSION['empresa_id'];
@$filial = $_SESSION['filial_id'];
@$usuario = $_SESSION['usuario_id'];
include 'inc/valida-sessao.php';
$msg = '';
$log_msg = '';
function __autoload($classe) 
{
    include_once "classes/$classe.php";
}
 ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


  $range = 1000;
 
  if(isset($_GET['inicio'])){
          $iniciox = $_GET['inicio'];
        }else{
          $iniciox = 0;
        }
        $fimx = $iniciox + $range; 

  if(isset($_POST['limpar'])){
        $excluir = 1;
  }else{
    $excluir = 0;
  }

  if(isset($_GET['limpar'])){
    if($_GET['limpar'] == 1){
        $excluir = 1;
      }
  }

cadastrar($iniciox,$fimx, $excluir);

 function cadastrar($inicio, $fim, $excluir) {
        $range = 1000;

        //$grupo = $_POST['grupo'];
        $grupo = $_GET['array_produto'];
        $piece = explode(',', $grupo);
        $grupo = $piece[0];


        $dados = $_GET['array_motivo'];
        $piece = explode(',', $dados);
        $dados = $piece[0];

          $listagemGrupo = new Consulta();
          $listagemGrupo->Conecta();
          $retornoGrupo = $listagemGrupo->ConsultaDados('cf_mercadologica', 'cm_secao','ASC', 'cm_id ='.$grupo);
          $listagemGrupo->Desconecta();


         // if(isset($_GET['n'])){
       //     $n = $_GET['n']);
       //   }else{
        //    $n =0;
        //  }

          $dados2 = '';
          $ii = 1;
          if(count($retornoGrupo) > 0 ){
            foreach($retornoGrupo as $linhaGrupo){
              if($ii == 1){
                $listagemProds = new Consulta();
                $listagemProds->Conecta();
                $desc = $linhaGrupo->cm_secao;
                $retornoProds = $listagemProds->ConsultaDadosColunas('cf_produto', 'prod_id', null, null, 'prod_sessao ="'.$desc.'" limit '.$inicio.','.$range);
               // $retornoProds = $listagemProds->ConsultaDadosColunas('cf_produto', 'prod_id', null, null, 'prod_sessao ="'.$desc.'" limit '.$fim.' offset '.$inicio);
                //$retornoProds = $listagemProds->ConsultaDadosColunas('cf_produto', 'prod_id', null, null, 'prod_sessao ="'.$desc.'" limit');
                //$fx = $fim+200;
              //  $retornoProde = $listagemProds->ConsultaDadosColunas('cf_produto', 'prod_id', null, null, 'prod_sessao ="'.$desc.'"');

                $n = count($retornoProds) +$inicio;

                $listagemProds->Desconecta();

                if(count($retornoProds) > 0){
                    foreach($retornoProds as $linhaProds){
                    $dados2 .= ','.$linhaProds->prod_id;
                    }
                }//else{
                   // $acabou = 1;
                //}
                  $ii++;
                }
            }
          }

          //$dados2 = substr($dados2, 1);   
         // echo $dados2;
    try{
       // $dados2 = $_POST['array_produto'];
        
        //$col = 'pm_idmot';
        //$col2 = 'pm_idprod';
        
        if (empty($dados) || empty($dados2)){
           $msg = 'Erro ao Salvar';    
       }else{
         

          if($excluir == 1){
            $associar = new Deletar();
            $associar->Conecta();
                ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

            

          $piece = explode(',', $dados2);
          $tpie = count($piece);

          echo $tpie . 'ddddddddddd';


          for($a = 1; $a < $tpie; $a++){
                        $dados2 = $piece[$a];
          $msg = $associar->ExcluirRegistroReferentes('cf_prodmot', ' pm_idmot="' . $dados . '" and ' . ' pm_idprod="' .$dados2 . '"');
          echo "foi";

          }
          


          }else{
             $associar = new Controle();
             $associar->Conecta();
             $msg = $associar->associaRegistro('cf_prodmot',$dados,$dados2,'pm_idmot','pm_idprod');
          }


          $associar->Desconecta();

        $contextoMsgNome = 'Sucesso: ';
        //$contextoMsgClass = "success";
      }
    }
    catch (Exception $erro){
    $contextoMsgNome = "Erro: ";
    $contextoMsgClass = "danger";
    }

//header('Location: assoc-grupo-motivo.php?array_produto='. $_GET['array_produto'].'&array_motivo='.$_GET['array_motivo'].'&inicio='.$fim);
    if($fim <= $n){
             // sleep(10);

    //  cadastrar($fim, $fim+$range);

  $caminho =  'assoc-grupo-motivo.php?array_produto='. $_GET['array_produto'].'&array_motivo='.$_GET['array_motivo'].'&inicio='.$fim.'&limpar='.$excluir;

  echo 'Isto pode demorar um pouco';
  echo '<br>último pacote processado de '.$inicio . ' a ' . $fim . ' de ' . $n . ' registros <br>';

  echo  "<script> var timer = setTimeout(function() { window.location='".$caminho."'}, 10);    </script>";


   // header('Location: assoc-grupo-motivo.php?array_produto='. $_GET['array_produto'].'&array_motivo='.$_GET['array_motivo'].'&inicio='.$fim.'&limpar='.$excluir);
        ?>
        <!--<a href="<?php echo 'assoc-grupo-motivo.php?array_produto='. $_GET['array_produto'].'&array_motivo='.$_GET['array_motivo'].'&inicio='.$fim; ?> ">continuar</a>-->


        <?php
    }else{ ?>


      <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php include('./inc/title.php'); ?></title>
    <!--ESTILOS-->
    <link type="text/css" rel="stylesheet" href="cssnew/bootstrap/css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="./cssnew/menu.css" />
    <!-- js  -->
    <script src="cssnew/bootstrap/js/bootstrap.min.js"></script>
    <!--MOTORES JS-->
    <script type="text/javascript" src="./js/jquery-1.10.2.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
          $('.links li code').hide();  
          $('.links li p').click(function() {
            $(this).next().slideToggle('fast');
        });
      });
  </script>

</head>
<center>

<?php
  echo 'Isto pode demorar um pouco';
echo '<br>último pacote processado de '.$inicio . ' a ' . $fim . ' de ' . $n . ' registros <br>';
//secho $n; ;?>

Processo Finalizado
 <a href="<?php echo 'cad-grupo-motivo.php?array_produto='. $_GET['array_produto'].'&array_motivo='.$_GET['array_motivo'].'&inicio='.$fim; ?> " class="btn btn-primary">Voltar</a>
</center>
      <?php 

    }


}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
