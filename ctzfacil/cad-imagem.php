<?php
	session_start();
    $path = dirname(__FILE__);
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

    /** ---- PAGINAÇÃO ---- **/
  
    // pega a pagna esclhida
    $paginaAtual = (isset($_POST['paginaEscolhida']))? $_POST['paginaEscolhida'] : 1;

    // Pega o texto da pesquisa digitado
    $textoDaPesquisa = (isset($_POST['pesquisa']))? $_POST['pesquisa'] : '';
    
    // ve se ele pesquisou anteriormente
    if (isset($_SESSION['textoDaPesquisaAnteriorImagem']) ) {
        // a pesquisa anterios é diferente da pesquisa atual?
        if ($_SESSION['textoDaPesquisaAnteriorImagem'] != $textoDaPesquisa) {
            // se for diferente a pagina autal recebe 1(para não quebrar a paginção)
            $paginaAtual = 1;
        }
    }
    // Guarda a pesquisa atual na session como pesquisa anterior
    $_SESSION['textoDaPesquisaAnteriorImagem'] = $textoDaPesquisa;
 
    /** ---- PAGINAÇÃO ---- **/




    $nome_final = round(microtime(true) * 1000);
	$imagem = new Imagem();
	if(isset($_POST['btnsalvar'])){
        try{
            $uploaddir = './imageUpload/';
            $file_parts = pathinfo($_FILES['ft_arquivo']['name']);
            $cool_extensions = Array('jpg','JPG','jpeg','JPEG','png','PNG','tiff','TIFF','gif','GIF','mp4','avi');
            $file_parts['extension'];

            if($file_parts['extension'] ==""){
                $uploadfile =  $_POST['img_caminho'];
                $dados = array('img_nome' => $_POST['img_nome'], 'img_tags' => $_POST['img_tags'],'img_inicio' => $_POST['img_inicio'],'img_fim' => $_POST['img_fim'],'img_caminho' =>$uploadfile,'img_descricao' => $_POST['img_descricao'],'img_empresa' =>$_SESSION['empresa_id'],'img_estabelecimento' => $_SESSION['filial_id']);
                $log = array ('log_empresa' => $empresa, 'log_filial' => $filial,'log_usuario' => $usuario, 'log_data' => date("d/m/Y - H:i:s"), 'log_mensagem' => 'Imagem: '.$_POST['img_nome'].' - Inserido com Sucesso !');
                $inserir = new Inserir();
                $inserir->Conecta();
                $msg = $inserir->SalvarRegistro('cf_imagem', $dados);
                $contextoMsgClass = 'success';
                $contextoMsgNome = 'Sucesso:';

                $log_msg = $inserir->SalvarRegistro('cf_logs', $log);
                $inserir->Desconecta();
            }else{
                if (in_array($file_parts['extension'], $cool_extensions)){
                    
                    $oArquivo = $_FILES['ft_arquivo']['name'];
                    
                    $uploadfile = $uploaddir.basename($_FILES['ft_arquivo']['name']);
                    move_uploaded_file($_FILES['ft_arquivo']['tmp_name'], $uploadfile);


                        if (strlen($_POST['img_caminho']) > 8) {
                            $novoNome = $_POST['img_caminho'];
                        } else {
                            // --- Muda o nome do arquivo para fazer o upload   
                            // $nome_final = mysql_insert_id($inserir);                    
                            $extencaoArquivo = pathinfo($oArquivo, PATHINFO_EXTENSION);
                            $nomeAntigo = $uploaddir.$oArquivo;
                            $novoNome = $uploaddir.$nome_final.".".$extencaoArquivo;
                            rename($nomeAntigo,$novoNome);
                            // --- Muda o nome do arquivo para fazer o upload
                        }


                    // $url_caminho_img = $uploaddir.

                    $dados = array('img_nome' => $_POST['img_nome'], 'img_tags' => $_POST['img_tags'],'img_inicio' => $_POST['img_inicio'],'img_fim' => $_POST['img_fim'],'img_caminho' =>$novoNome,'img_descricao' => $_POST['img_descricao'],'img_empresa' =>$_SESSION['empresa_id'],'img_estabelecimento' => $_SESSION['filial_id']);


                    $log = array ('log_empresa' => $empresa, 'log_filial' => $filial,'log_usuario' => $usuario, 'log_data' => date("d/m/Y - H:i:s"), 'log_mensagem' => 'Imagem: '.$_POST['img_nome'].' - Inserido com Sucesso !');
        			$inserir = new Inserir();
        			$inserir->Conecta();
        			$msg = $inserir->SalvarRegistro('cf_imagem', $dados);
                    $log_msg = $inserir->SalvarRegistro('cf_logs', $log);
        			$inserir->Desconecta();
                    $contextoMsgClass = 'success';
                    $contextoMsgNome = 'Sucesso:';

                } else{
                    $msg = "Tipo de Arquivo Invalido";
                    $contextoMsgClass = 'danger';
                    $contextoMsgNome = 'Erro:';
                }
            }
        }
        catch (Exception $erro)
        {
            $inserir->Desconecta();
			$msg = "{$erro->getMessage()}";
            $contextoMsgClass = 'danger';
            $contextoMsgNome = 'Erro:';
        }
    }


    if(isset($_POST['btnexcluir']))
    {
        try 
        {
            $listagem = new Consulta();
            $listagem->Conecta();
            $retorno = $listagem->ConsultaDados('cf_imgprod', 'pi_idimg', 'ASC','pi_idimg='.$_POST['referencia'].' and empresa_id='.$_SESSION['empresa_id']);

            if(count($retorno) > 0 ){
                $msg = "Utilizado em Imagem/Produto";
                $contextoMsgClass = 'danger';
                $contextoMsgNome = 'Erro:';
            }else{

                //Inserir LOG
                $log = array ('log_empresa' => $empresa, 'log_filial' => $filial,'log_usuario' => $usuario, 'log_data' => date("d/m/Y - H:i:s"), 'log_mensagem' => 'Imagem ID: '.$_POST['referencia'].' - Excluido com Sucesso !');
                $inserir = new Inserir();
                $inserir->Conecta();
                $log_msg = $inserir->SalvarRegistro('cf_logs', $log);
                $inserir->Desconecta();
                //-------------
                $deletar = new Deletar();
                $deletar->Conecta();
                $msg = $deletar->ExcluirRegistro('cf_imagem', 'img_id', $_POST['referencia']);
                $deletar->Desconecta();
                $contextoMsgClass = 'success';
                $contextoMsgNome = 'Sucesso:';
            }
        }
        catch (Exception $erro)
        {
            $deletar->Desconecta();
            $msg = "{$erro->getMessage()}";
            $contextoMsgClass = 'danger';
            $contextoMsgNome = 'Erro:';
        }
    }
    if(isset($_POST['btneditar']))
    {
        try 
        {
            $imagembd = new Consulta();
            $imagembd->Conecta();
            $dados = $imagembd->ConsultaDados('cf_imagem', 'img_id', 'ASC', "img_id = '".$_POST['referencia']."'");
            // Carrega Dados

            $imagem->CarregaDados($dados[0]);
        }
        catch (Exception $erro)
        {
            $deletar->Desconecta();
            $msg = "{$erro->getMessage()}";
            $contextoMsgClass = 'danger';
            $contextoMsgNome = 'Erro:';
        }
    }
    if(isset($_POST['btnalterar']))
    {
        try{
            $uploaddir = './imageUpload/';
            $file_parts = pathinfo($_FILES['ft_arquivo']['name']);
            $cool_extensions = Array('jpg','JPG','jpeg','JPEG','png','PNG','tiff','TIFF','gif','GIF','mp4','avi');
            $file_parts['extension'];

/*
              $imagembd = new Consulta();
                $imagembd->Conecta();
                $dados = $imagembd->ConsultaDados('cf_imagem', 'img_id', 'ASC', "img_id = '".$_POST['referencia']."'");
                
                if(count($dados) > 0){ 
                    foreach($dados as $linha){ 
                        $caminho =  $linha->img_caminho;
                    }   
                }
*/

                $uploadfile =  $_POST['img_caminho'];
                $dados = array('img_nome' => $_POST['img_nome'], 'img_tags' => $_POST['img_tags'],'img_inicio' => $_POST['img_inicio'],'img_fim' => $_POST['img_fim'],'img_caminho' =>$uploadfile,'img_descricao' => $_POST['img_descricao'],'img_empresa' =>$_SESSION['empresa_id'],'img_estabelecimento' => $_SESSION['filial_id']);

                $alterar = new Edicao();
                $alterar->Conecta();
                $msg = $alterar->EditarRegistro('cf_imagem', $dados, 'img_id', $_POST['referencia']);
               
                $log = array ('log_empresa' => $empresa, 'log_filial' => $filial,'log_usuario' => $usuario, 'log_data' => date("d/m/Y - H:i:s"), 'log_mensagem' => 'Imagem: '.$_POST['img_nome'].' - Inserido com Sucesso !');
                $inserir = new Inserir();
                $inserir->Conecta();
                $log_msg = $inserir->SalvarRegistro('cf_logs', $log);
                $inserir->Desconecta();


                $contextoMsgClass = 'success';
                $contextoMsgNome = 'Sucesso:';

                    ///exclusao da imagem antiga
              
                //try
                if(pathinfo($_FILES['ft_arquivo']['name']) != NULL){
                  unlink($caminho);
                }

                move_uploaded_file($_FILES['ft_arquivo']['tmp_name'], $uploadfile);



            
        }catch (Exception $erro){
            $inserir->Desconecta();
			$msg = "{$erro->getMessage()}";
            $contextoMsgClass = 'danger';
            $contextoMsgNome = 'Erro:';
        }
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title><?php include('./inc/title.php'); ?></title>
    <!--ESTILOS-->
    <link type="text/css" rel="stylesheet" href="cssnew/bootstrap/css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="./cssnew/menu.css" />
    <!-- <link type="text/css" rel="stylesheet" href="./css/master_reset.css" />
    <link type="text/css" rel="stylesheet" href="./css/estilo.css" />
    <link type="text/css" rel="stylesheet" href="./css/sidebar_menu.css" /> -->
    <!--MOTORES JS-->
    <script src="jsnew/jquery.js"></script>
    <script src="cssnew/bootstrap/js/bootstrap.min.js"></script>


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
<body>
    <div id="cabecalho">
        <?php include 'inc/cabecalhod.php'; ?>
    </div>
    
    <div id="container-fluid">
        <div>
            <div id="barra_topo"></div>
            <div id="corpo">
                <div id="central">

                    <?php
                            if ($msg) {
                                echo '
                                    <div class="alert alert-'.$contextoMsgClass.' mt-3 mx-4 alertAutoClose" role="alert" id="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <div class="text-center">
                                            <strong>'.$contextoMsgNome.'</strong> '.$msg.'
                                        </div>
                                    </div>
                                    ';
                            }
                        ?>
                    <div class="row mx-4 mt-4">
                        


                        <div class="col-md-12 p-4 bg-white rounded border-bottom">
                            <div class="col-md-4 col-sm-12 order-sm-1 my-2">
                                    <h4>Filtros</h4>
                                </div>
                            <div class="row bg-white">
                                <div class="col-md-12 p-4 bg-white rounded border-bottom">
                                <a class="btn <?php if(!isset($_GET['filtro'])){ echo "btn-success"; }else{?> btn-warning <?php } ?>" href="cad-imagem.php">Mostrar todos</a>
                                <a class="btn <?php if($_GET['filtro'] == 'produto'){ echo "btn-success"; }else{?> btn-warning <?php } ?>" href="cad-imagem.php?filtro=produto">Produto</a>
                                <a class="btn <?php if($_GET['filtro'] == 'tema'){ echo "btn-success"; }else{?> btn-warning <?php } ?>" href="cad-imagem.php?filtro=tema">Tema</a>
                                <a class="btn <?php if($_GET['filtro'] == 'imagem'){ ?> btn-success <?php }else{?> btn-warning <?php }?>" href="cad-imagem.php?filtro=imagem">Outras Imagens</a>
                                <a class="btn <?php if($_GET['filtro'] == 'videolocal'){ echo "btn-success"; }else{?> btn-warning <?php } ?>" href="cad-imagem.php?filtro=videolocal">Video Local</a>
                                <a class="btn <?php if($_GET['filtro'] == 'video'){ echo "btn-success"; }else{?> btn-warning <?php } ?>" href="cad-imagem.php?filtro=video">Youtube</a>
                                </div>
                            </div>




                            <div class="form-row">
                                <div class="col-md-4 col-sm-12 order-sm-3 text-right my-2">
                                    <a href="#" class="btn btn-success" title="Adicionar imagem" data-toggle="modal" data-target="#cadastrarImagem"> 
                                        <i class="fa fa-plus text-white"></i> Nova Imagem
                                    </a>
                                </div>
                                <div class="col-md-4 col-sm-12 order-sm-2 my-2 ">
                                    <form id="aditivo" name="pesq_form" method="post" action="cad-imagem.php<?php if(isset($_GET['filtro'])){echo '?filtro='.$_GET['filtro'];}?>" class="d-flex flex-row">
                                        <input type="text" maxlength="20" id="pesquisa" name="pesquisa" class="form-control">
                                        <!-- <input type="submit" class="btn btn_view_for_pesq btn-primary mx-2" value="go" name="btn_pesquisar"> -->
                                        <button type="submit" class="btn btn_view_for_pesq btn-primary mx-2" name="btn_pesquisar" title="Pesquisar">
                                            <i class="fa fa-search text-white"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="col-md-4 col-sm-12 order-sm-1 my-2">
                                    <h4>Imagens</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                        <!-- modal adicionaor imagem -->
                        <div class="modal fade bd-example-modal-lg" id="cadastrarImagem" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="dMModal<?php echo $linha->dm_id?>lLabel">
                                            Adicionar imagem
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="imagem" name="imagem" method="post" action="cad-imagem.php" class="form_cadastro_funcionario" enctype="multipart/form-data">
                                            <fieldset>
                                                    <div class="form-row my-2">
                                                        <div class="col-md-6">
                                                            <label>Nome</label><span class="campos_obrigatorios"> *</span>
                                                            <input required="required" maxlength="20" id="img_nome" name="img_nome" type="text" class="campo_1 form-control"/>
                                                        </div>
                                                    
                                                         <div class="col-md-6">
                                                             <label>Tags</label>
                                                             <select name="img_tags" class="campo_1 form-control">
                                                                <option value="produto">Produto</option>
                                                                <option value="tema">Tema</option>
                                                                <option value="imagem">Outras Imagens</option>
                                                                <option value="videolocal">Video Local</option>
                                                                <option value="video">Youtube</option> 
                                                             </select>
                                                            <!--  <input maxlength="200" id="img_tags" name="img_tags" type="text" /> -->
                                                        </div>
                                                    </div>

                                                    <div class="form-row my-2">

                                                        <div class="col-md-6">
                                                            <label>Data Incio</label>
                                                             <input id="img_inicio" name="img_inicio" type="date" class="campo_1 form-control" />
                                                        </div>
                                                        <div class="col-md-6">
                                                             <label>Data Fim</label>
                                                             <input id="img_fim" name="img_fim" type="date" class="campo_1 form-control"/>
                                                        </div>
                                                    </div>

                                                    <div class="form-row my-2">
                                                        <div class="col-md-12">
                                                            <label>Caminho - URL</label>
                                                            <input id="img_caminho" name="img_caminho" type="text" class="campo_1 form-control" style="text-transform: none"/>
                                                        </div>
                                                    </div>

                                                    <div class="form-row my-4">
                                                        <div class="col-md-12">
                                                            <p>Arquivo img</p>
                                                            <p>** Recomendamos a compressão da Imagem com TinyPng 
                                                                <a href="https://tinypng.com/" target="_blank"> Clique Aqui</a>
                                                            </p>

                                                            <input accept=".png, .jpg, .jpeg, .tiff" class="inserirft_arquivo" id="ft_arquivo" name="ft_arquivo" type="file" class="campo_1" style="border:none;"/>
                                                            
                                                            <p>Limite Máximo de arquivo> 2mb.</p>
                                                            <p class="bg-danger text-center text-white" id="msgUploadFileSize"></p>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-row my-2">
                                                        <div class="col-md-12">
                                                            <label>Descrição</label>
                                                            <textarea id="img_descricao" maxlength="100" name="img_descricao" class="campo_1 form-control" rows="4" style="resize:none;"></textarea>
                                                        </div>
                                                    </div>

                                      <div class="campos_esq_1">
                                                        <a href="importar_dados.php?cft=Imagem" target="_blank" class="my-3 btn btn-outline-info">
                                                            Importar dados .CSV <i class="fa fa-mail-forward text-white ml-1"></i> </a>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                        <input name="btnsalvar" type="submit" value="Salvar" class="btn_salvar btn btn-primary"/>
                                                        <input id="limparPagina" type="button" value="Limpar" class="btn_salvar btn btn-warning text-white"/>
                                                    </div>
                                            </fieldset>
                                        </form>
                                        <br>
                                        <div class="modal-header" id="loteImg" style="cursor:pointer;">
                                         <h5 class="modal-title">
                                          + Associar a Produto em lote
                                        </h5>
                                        </div>
                                        <div id="formImgLote" style="display:none;">
                                        <form enctype="multipart/form-data" method="POST" action="./inc/cadastraImagemLote.php">
                                            <input type="file"  accept=".png, .jpg, .jpeg, .tiff" name="arquivo[]" multiple="multiple" /><br><br>
                                            <input name="enviar" class="btn_salvar btn btn-primary" type="submit" value="Enviar">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        </form>
                                        </div>    
              
                                        <!-- form cadastro img -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- modal adicionaor imagem -->
                </div>
            </div>
        </div>
    </div>

   

                            <?php 
                                @$pesquisa = $_POST['pesquisa'];
                            ?>

                                        <?php
                                            if(isset($_POST['btn_pesquisar']) || isset($textoDaPesquisa)){
                                                ?>
                                         <div class="container-fluid">
                                            <div class="row rounded bg-white p-3 mx-2 mb-4">

                                                <?php
                                                try{

                                                    /** PAGINAÇÃO ---- **/

                                                    // pegar o numero total de linhas para fazer a paginação e depois arredonda pra cima
                                                    $contLinhas = new Consulta();
                                                    $contLinhas->Conecta();
                                                    

                                                    //echo 'filtro=' . $_POST['filtro'] . "ss";
                                                    if(isset($_POST['filtro'])){
                                                        if($_POST['filtro'] != ''){
                                                        $_GET['filtro'] = $_POST['filtro'];
                                                            }
                                                    }
                                                    //echo $_GET['filtro'];


                                                    if(!isset($_GET['filtro'])){

                                                    $qtdLinhass = $contLinhas->ConsultaCountRow('cf_imagem', 'img_nome','(img_nome like "%'.$pesquisa.'%" or img_tags like "%'.$pesquisa.'%" or img_id like "%'.$pesquisa.'%") and img_empresa='.$_SESSION['empresa_id']);
                                                    }else{
                                                        $qtdLinhass = $contLinhas->ConsultaCountRow('cf_imagem', 'img_nome','(img_nome like "%'.$pesquisa.'%" or img_tags like "%'.$pesquisa.'%" or img_id like "%'.$pesquisa.'%") and img_empresa='.$_SESSION['empresa_id'] . ' and img_tags = ' . '"'.$_GET['filtro'].'"' );
                                                    }


                                                    // Quandidade de itens mostrado por paginação
                                                    $quantidade_por_pagina = "12";

                                                    $totalLinhas = $qtdLinhass[0][0];
                                                    // arrendondando pra cima para fazer a numeração da paginação
                                                    $numPaginas = ceil($totalLinhas/$quantidade_por_pagina);

                                                    //echo "<h1 class='text-danger'>".$totalLinhas."</h1>";

                                                    //variavel para pehar o inicio da visualização com base na pagina que ele esta
                                                    $inicio = ($quantidade_por_pagina*$paginaAtual)-$quantidade_por_pagina;
                                                    /** PAGINAÇÃO ---- **/


                                                $listagem = new Consulta();
                                                $listagem->Conecta();
                                                // $retorno = $listagem->ConsultaDados('cf_imagem', 'img_nome','ASC','(img_nome like "%'.$pesquisa.'%" or img_tags like "%'.$pesquisa.'%") and img_empresa='.$_SESSION['empresa_id']);
                                                if(!isset($_GET['filtro'])){

                                                $retorno = $listagem->ConsultaDadospg('cf_imagem', 'img_nome','ASC','(img_nome like "%'.$pesquisa.'%" or img_tags like "%'.$pesquisa.'%" or img_id like "%'.$pesquisa.'%") and img_empresa='.$_SESSION['empresa_id'],$quantidade_por_pagina,$inicio);
                                                }else{

                                                    $retorno = $listagem->ConsultaDadospg('cf_imagem', 'img_nome','ASC','(img_nome like "%'.$pesquisa.'%" or img_tags like "%'.$pesquisa.'%" or img_id like "%'.$pesquisa.'%") and img_empresa='.$_SESSION['empresa_id']. ' and img_tags = ' . '"'.$_GET['filtro'].'"',$quantidade_por_pagina,$inicio);
                                                }

                                                    if(count($retorno) > 0){
                                                    ?>


                                                            <?php
                                        //$_GET['filtro'] = '';
                                                            if(!isset($_GET['filtro'])){
                                                                $filtro = '';
                                                            }else{
                                                                $filtro = '?filtro='.$_GET['filtro'];
                                                            }
                                                            ?>
                                    <!-- Paginação  Exibe a paginação-->
                                    <div class="col-md-12">
                                        
                                    <div class="mt-2" style="min-height: 50px">
                                        <?php if(isset($_POST['btn_pesquisar']) || isset($textoDaPesquisa)){ ?>
                                            <nav aria-label="Paginação de produtos" >
                                                <ul class="pagination flex-wrap justify-content-center pagination">
                                                    <li class="page-item m-1 <?php echo $paginaAtual == 1 ? "disabled" : ""; ?> ">
                                                        <form id="aditivo" name="pesq_form" method="post" action="cad-imagem.php<?=$filtro;?>" >
                                                            <input hidden type="text" name="pesquisa" class="input_pesq form-control" value="<?php echo $textoDaPesquisa; ?>">
                                                            <input hidden type="text" name="paginaEscolhida" class="input_pesq form-control" value="1">
                                                            <button type="submit" class="page-link" name="btn_pesquisar"><i class="fa fa-angle-double-left"></i></button>
                                                        </form>
                                                    </li>
                                                    <?php
                                                        $cont = 0;
                                                        for($i = 1; $i < $numPaginas + 1; $i++) {
                                                            // numero de paginas menor ou igual a 12, mostra todos
                                                            if ($numPaginas <= 12) {
                                                                if ($paginaAtual == $i) {
                                                                    echo '<li class=" page-item m-1 active ">
                                                                            <form id="aditivo" name="pesq_form" method="post" action="cad-imagem.php'.$filtro.'" >
                                                                                <input hidden type="text" id="pesquisa" name="pesquisa" class="input_pesq form-control" value="'.$textoDaPesquisa.'">
                                                                                <input hidden type="text" id="pesquisa" name="paginaEscolhida" class="input_pesq form-control" value="'.$i.'">
                                                                                <input id="pesquirCM" type="submit" class="page-link" value="'.$i.'" name="btn_pesquisar">
                                                                            </form>
                                                                          </li>';
                                                                }else{
                                                                    echo '<li class=" page-item m-1">
                                                                            <form id="aditivo" name="pesq_form" method="post" action="cad-imagem.php'.$filtro.'" >
                                                                                <input hidden type="text" id="pesquisa" name="pesquisa" class="input_pesq form-control" value="'.$textoDaPesquisa.'">
                                                                                <input hidden type="text" id="paginaEscolhida" name="paginaEscolhida" class="input_pesq form-control" value="'.$i.'">
                                                                                <input id="pesquirCM" type="submit" class="page-link" value="'.$i.'" name="btn_pesquisar">
                                                                            </form>
                                                                          </li>';
                                                                    }
                                                                }else{
                                                                    // se o numero de paginas for maior que 12
                                                                    // mostrar os 5 primeiro, a partir da pagina escohida
                                                                    if ($paginaAtual <= $i  && $cont < 5) {
                                                                        // coloca o active na pagina escolhida
                                                                        if ($paginaAtual == $i) {
                                                                            echo '<li class=" page-item m-1 active ">
                                                                                    <form id="aditivo" name="pesq_form" method="post" action="cad-imagem.php'.$filtro.'" >
                                                                                        <input hidden type="text" id="pesquisa" name="pesquisa" class="input_pesq form-control" value="'.$textoDaPesquisa.'">
                                                                                        <input hidden type="text" id="paginaEscolhida" name="paginaEscolhida" class="input_pesq form-control" value="'.$i.'"> 
                                                                                        <input id="pesquirCM" type="submit" class="page-link" value="'.$i.'" name="btn_pesquisar">
                                                                                    </form>
                                                                                  </li>';
                                                                        }else{
                                                                            echo '<li class=" page-item m-1">
                                                                                    <form id="aditivo" name="pesq_form" method="post" action="cad-imagem.php'.$filtro.'" >
                                                                                        <input hidden type="text" id="pesquisa" name="pesquisa" class="input_pesq form-control" value="'.$textoDaPesquisa.'">
                                                                                        <input hidden type="text" id="paginaEscolhida" name="paginaEscolhida" class="input_pesq form-control" value="'.$i.'">
                                                                                        <input id="pesquirCM" type="submit" class="page-link" value="'.$i.'" name="btn_pesquisar">
                                                                                    </form>
                                                                                  </li>';
                                                                        }
                                                                        // coloca os 3 pontos (...) na quinta posição
                                                                        $cont++;
                                                                        if ($cont == 5) {
                                                                            echo '<li class=" page-item mx-4">.....</li>';
                                                                        }
                                                                        // mostra as 3 ultimas opções
                                                                    }elseif ($numPaginas <= $i+3 ) {
                                                                        echo '<li class=" page-item m-1">
                                                                                <form id="aditivo" name="pesq_form" method="post" action="cad-imagem.php'.$filtro.'" >
                                                                                    <input hidden type="text" id="pesquisa" name="pesquisa" class="input_pesq form-control" value="'.$textoDaPesquisa.'">
                                                                                    <input hidden type="text" id="paginaEscolhida" name="paginaEscolhida" class="input_pesq form-control" value="'.$i.'">
                                                                                    <input id="pesquirCM" type="submit" class="page-link" value="'.$i.'" name="btn_pesquisar">
                                                                                </form>
                                                                              </li>';
                                                                    }
                                                                }
                                                            }
                                                                $cont = 0;
                                                         ?>
                                                        <li class="page-item m-1 <?php echo $paginaAtual == $numPaginas ? "disabled " : ""; ?> ">
                                                            <form id="aditivo" name="pesq_form" method="post" action="cad-imagem.php" >
                                                                <input hidden type="text" name="pesquisa" class="input_pesq form-control" value="<?php echo $textoDaPesquisa; ?>">
                                                                <input hidden type="text" name="paginaEscolhida" class="input_pesq form-control" value="<?php echo $numPaginas  ?>">
                                                                <button type="submit" class="page-link" name="btn_pesquisar"><i class="fa fa-angle-double-right"></i></button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </nav>
                                            <?php } ?>                   
                                        </div>
                                    </div>

                                    <!-- Paginação  Exibe a paginação-->

                                                    
                                                   <?php
                                                        foreach($retorno as $linha)
                                                        { 
                                                            $img_id = $linha ->img_id;
                                                            $img_nome = $linha ->img_nome;
                                                    ?>
                                                    
                                                  

                                                    <div class="col-md-3 my-2">
                                                        <div class="card " style="width: 18rem;">
                                                            <?php
                                                                if (file_exists($linha->img_caminho)) {
                                                                    $imagemCartarM = $linha->img_caminho;
                                                                } else {
                                                                    $comprador = 'imageUploas';
                                                                    // $resultado = strstr($linha->img_caminho, 'imageUpload');

                                                                    // echo $resultado."<br> +++ <br>";
                                                                    
                                                                    if( strstr($linha->img_caminho, 'imageUpload') === false) {
                                                                        // echo "nao tem Caminho";
                                                                        $imagemCartarM = $linha->img_caminho;
                                                                    }else{
                                                                        // echo "tem Caminho";   
                                                                        $imagemCartarM = '/imageUpload/imagemnaodisponivel.png';
                                                                    }

                                                                    /*
                                                                    if( strstr($linha->img_caminho, '.jpg') === false or strstr($linha->img_caminho, '.png') === false) {
                                                                        $imagemCartarM = 'https://www.youtube.com/watch?v='.$linha->img_caminho;
                                                                    }*/
                                                                }
                                                            ?>
                                                                

                                                            <img src="<?php echo $imagemCartarM; ?>" class="card-img-top" style="min-height: 210px; max-height: 210px; width: auto; object-fit: contain;" alt="...">
                                                            
                                                            <div class="card-body">
                                                                <h5 class="card-title mb-3"><?php echo substr($img_nome,0,15); ?></h5>
                                                                <p><?php //echo $linha->img_caminho; ?></p>
                                                                <div class="d-flex justify-content-end">

                                                                    <div>
                                                                        <span class="badge badge-secondary mr-4">
                                                                            ID :<?php echo $img_id ?>
                                                                        </span>
                                                                    </div>


                                                                    <a target='_blank' data-toggle="modal" data-target="#VisualizarImg<?php echo $linha->img_id; ?>" class="btn btn-info mx-1" title="visializar">
                                                                        <i class="fa fa-eye text-white"></i>
                                                                    </a>
                                                                    <button class="btn btn-info mx-1" title="Editar" data-toggle="modal" data-target="#EditImg<?php echo $img_id?>">
                                                                        <i class="fa fa-pencil text-white"></i>
                                                                    </button>
                                                                    <!-- excluir -->
                                                                    <button class="btn btn-danger mx-1" data-toggle="modal" data-target="#ExcluirImg<?php echo $linha->img_id; ?>" title="excluir"> 
                                                                            <i class="fa fa-trash text-white"></i>
                                                                    </button>
                                                                    <!-- excluir -->
                                                                </div>

                                                          </div>
                                                        </div>
                                                    </div>

                                                    <!-- Vizualizar imagem modal -->
                                                    <div class="modal fade bd-example-modal-lg" id="VisualizarImg<?php echo $linha->img_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                      <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Vizualização da imagem</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                                <img src="<?php echo $imagemCartarM; ?>" class="mx-auto img-fluid" alt="">
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <!-- Vizualizar imagem modal -->

                                                    <!-- excluir imagem modal -->
                                                    <div class="modal fade" id="ExcluirImg<?php echo $linha->img_id; ?>" tabindex="-1" role="dialog" aria-labelledby="ExcluirImg<?php echo $linha->img_id; ?>lLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="ExcluirImg<?php echo $linha->img_id; ?>lLabel">Excluir Imagem</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <h6>Tem certeza que deseja excluir a imagem:</h6>
                                                                    <p class="text-danger">
                                                                        <?php echo substr($img_nome,0,15); ?>
                                                                    </p>
                                                                    <img src="<?php echo $imagemCartarM; ?>" class="img-thumbnail" style="max-width: 130px;">

                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                                    <form action="cad-imagem.php" method="post" class="form_btn_excluir ">
                                                                        <button name="btnexcluir" class="btn btn-danger mx-1" type="submit" title="excluir">
                                                                            Excluir
                                                                        </button>
                                                                        <input name="referencia" type="hidden" value="<?php echo $img_id ?>" />
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- excluir imagem modal -->
                                                    
                                                    <!-- editar imagem modal -->
                                                       <div class="modal fade bd-example-modal-lg" id="EditImg<?php echo $img_id?>" tabindex="-1" role="dialog" aria-labelledby="EditImg<?php echo $img_id?>lLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="EditImg<?php echo $img_id?>lLabel">
                                                                            Editar imagem
                                                                        </h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form id="imagem" name="imagem" method="post" action="cad-imagem.php" class="form_cadastro_funcionario" enctype="multipart/form-data">
                                                                            <fieldset>
                                                                                    <div class="form-row my-2">
                                                                                        <div class="col-md-6">
                                                                                            <label>Nome</label>
                                                                                            <input required="required" maxlength="20" id="img_nome" name="img_nome" type="text" class="campo_1 form-control" value="<?php echo $linha->img_nome;?>"/>
                                                                                        </div>

                                                                                    
                                                                                        <div class="col-md-6">
                                                                                             <label>Tags</label>
                                                                                                  <select name="img_tags" class="campo_1 form-control">
                                                                                                       <option value="<?php echo $linha->img_tags ?>"><?php echo $linha->img_tags ?></option>'; ?>
                                                                                                        <option value="produto">Produto</option>
                                                                                                        <option value="tema">Tema</option>
                                                                                                        <option value="imagem">Outras Imagens</option>
                                                                                                        <option value="videolocal">Video Local</option>
                                                                                                        <option value="video">Youtube</option> 
                                                                                         </select>
                                                                                        
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-row my-2">

                                                                                        <div class="col-md-6">
                                                                                            <label>Data Incio</label>
                                                                                             <input id="img_inicio" name="img_inicio" type="date" class="campo_1 form-control" value="<?php echo $linha->img_inicio;?>"/>
                                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                             <label>Data Fim</label>
                                                                                             <input id="img_fim" name="img_fim" type="date" class="campo_1 form-control" value="<?php echo $linha->img_fim;?>"/>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="form-row my-2">
                                                                                        <div class="col-md-12">
                                                                                            <label>Caminho - URL</label>
                                                                                            <input id="img_caminho" name="img_caminho" type="text" class="campo_1 form-control" value="<?php echo $linha->img_caminho;?>"style="text-transform: none"/>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="form-row my-4">
                                                                                        <div class="col-md-12">
                                                                                            <label>Arquivo img</label>
                                                                                            <input accept=".png, .jpg, .jpeg, .tiff" id="ft_arquivo" name="ft_arquivo" type="file" class="campo_1" style="border:none;"/>
                                                                                        </div>
                                                                                    </div>

                                                                                    
                                                                                    <div class="form-row my-2">
                                                                                        <div class="col-md-12">
                                                                                            <label>Imagem</label>
                                                                                            <img src="<?php echo $imagemCartarM; ?>" class="img-thumbnail" style="max-width: 130px;">
                                                                                        </div>
                                                                                    </div>
                                                                                    
                                                                                    <div class="form-row my-2">
                                                                                        <div class="col-md-12">
                                                                                            <label>Descrição</label>
                                                                                            <textarea id="img_descricao" maxlength="100" name="img_descricao" class="campo_1 form-control" rows="4" style="resize:none;"><?php echo $linha->img_descricao;?></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="campos_esq_1">
                                                                                        <form action="cad-produto.php" method="post" class="form_btn_excluir">
                                                                                          <a href="importar_dados.php?cft=Imagem" target="_blank" class="my-3 btn btn-outline-info">
                                                                                            Importar dados .CSV <i class="fa fa-mail-forward text-white ml-1"></i> </a>
                                                                                       </form>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                                                        <input id="limparPagina" type="button" value="Limpar" class="btn_salvar btn btn-warning text-white"/>
                                                                                        <input name="btnalterar" type="submit" value="Alterar" class="btn_salvar btn btn-primary"/>
                                                                                        <input name="referencia" class="verificaref btn btn-primary" hidden value="<?php echo $img_id?>" />
                                                                                    </div>
                                                                            </fieldset>
                                                                        </form>
                                                                        <!-- form cadastro img -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <!-- editar imagem modal -->

                                                <?php
                                                       }
                                                    }
                                                }catch (Exception $erro){
                                                    $msg = "Erro ao pesquisar";
                                                    $contextoMsgClass = 'danger';
                                                    $contextoMsgNome = 'Erro:';
                                                }
                                                ?>
                                                <!-- Paginação  Exibe a paginação-->
                                    <div class="col-md-12">
                                    
                                        
                                    <div class="mt-2" style="min-height: 50px">
                                        <?php if(isset($_POST['btn_pesquisar']) || isset($textoDaPesquisa)){ ?>
                                            <nav aria-label="Paginação de produtos" >
                                                <ul class="pagination flex-wrap justify-content-center pagination">
                                                    <li class="page-item m-1 <?php echo $paginaAtual == 1 ? "disabled" : ""; ?> ">
                                                        <form id="aditivo" name="pesq_form" method="post" action="cad-imagem.php" >
                                                            <input hidden type="text" name="pesquisa" class="input_pesq form-control" value="<?php echo $textoDaPesquisa; ?>">
                                                            <input hidden type="text" name="paginaEscolhida" class="input_pesq form-control" value="1">

                                                            <button type="submit" class="page-link" name="btn_pesquisar"><i class="fa fa-angle-double-left"></i></button>
                                                        </form>
                                                    </li>
                                                    <?php
                                                        $cont = 0;
                                                        for($i = 1; $i < $numPaginas + 1; $i++) {
                                                            
                                                            // numero de paginas menor ou igual a 12, mostra todos
                                                            if ($numPaginas <= 12) {
                                                                if ($paginaAtual == $i) {
                                                                    echo '<li class=" page-item m-1 active ">
                                                                            <form id="aditivo" name="pesq_form" method="post" action="cad-imagem.php'.$filtro.';" >
                                                                                <input hidden type="text" id="pesquisa" name="pesquisa" class="input_pesq form-control" value="'.$textoDaPesquisa.'">
                                                                                <input hidden type="text" id="pesquisa" name="paginaEscolhida" class="input_pesq form-control" value="'.$i.'">
                                                                                <input id="pesquirCM" type="submit" class="page-link" value="'.$i.'" name="btn_pesquisar">
                                                                            </form>
                                                                          </li>';
                                                                }else{
                                                                    echo '<li class=" page-item m-1">
                                                                            <form id="aditivo" name="pesq_form" method="post" action="cad-imagem.php'.$filtro.'" >
                                                                                <input hidden type="text" id="pesquisa" name="pesquisa" class="input_pesq form-control" value="'.$textoDaPesquisa.'">
                                                                                <input hidden type="text" id="paginaEscolhida" name="paginaEscolhida" class="input_pesq form-control" value="'.$i.'">
                                                                                <input id="pesquirCM" type="submit" class="page-link" value="'.$i.'" name="btn_pesquisar">
                                                                            </form>
                                                                          </li>';
                                                                    }
                                                                }else{
                                                                    // se o numero de paginas for maior que 12
                                                                    // mostrar os 5 primeiro, a partir da pagina escohida
                                                                    if ($paginaAtual <= $i  && $cont < 5) {
                                                                        // coloca o active na pagina escolhida
                                                                        if ($paginaAtual == $i) {
                                                                            echo '<li class=" page-item m-1 active ">
                                                                                    <form id="aditivo" name="pesq_form" method="post" action="cad-imagem.php'.$filtro.'" >
                                                                                        <input hidden type="text" id="pesquisa" name="pesquisa" class="input_pesq form-control" value="'.$textoDaPesquisa.'">
                                                                                        <input hidden type="text" id="paginaEscolhida" name="paginaEscolhida" class="input_pesq form-control" value="'.$i.'"> 
                                                                                        <input id="pesquirCM" type="submit" class="page-link" value="'.$i.'" name="btn_pesquisar">
                                                                                    </form>
                                                                                  </li>';
                                                                        }else{
                                                                            echo '<li class=" page-item m-1">
                                                                                    <form id="aditivo" name="pesq_form" method="post" action="cad-imagem.php'.$filtro.'" >
                                                                                        <input hidden type="text" id="pesquisa" name="pesquisa" class="input_pesq form-control" value="'.$textoDaPesquisa.'">
                                                                                        <input hidden type="text" id="paginaEscolhida" name="paginaEscolhida" class="input_pesq form-control" value="'.$i.'">
                                                                                        <input id="pesquirCM" type="submit" class="page-link" value="'.$i.'" name="btn_pesquisar">
                                                                                    </form>
                                                                                  </li>';
                                                                        }
                                                                        // coloca os 3 pontos (...) na quinta posição
                                                                        $cont++;
                                                                        if ($cont == 5) {
                                                                            echo '<li class=" page-item mx-4">.....</li>';
                                                                        }
                                                                        // mostra as 3 ultimas opções
                                                                    }elseif ($numPaginas <= $i+3 ) {
                                                                        echo '<li class=" page-item m-1">
                                                                                <form id="aditivo" name="pesq_form" method="post" action="cad-imagem.php'.$filtro.'" >
                                                                                    <input hidden type="text" id="pesquisa" name="pesquisa" class="input_pesq form-control" value="'.$textoDaPesquisa.'">
                                                                                    <input hidden type="text" id="paginaEscolhida" name="paginaEscolhida" class="input_pesq form-control" value="'.$i.'">
                                                                                    <input id="pesquirCM" type="submit" class="page-link" value="'.$i.'" name="btn_pesquisar">
                                                                                </form>
                                                                              </li>';
                                                                    }
                                                                }
                                                            }
                                                                $cont = 0;
                                                         ?>
                                                        <li class="page-item m-1 <?php echo $paginaAtual == $numPaginas ? "disabled " : ""; ?> ">
                                                            <form id="aditivo" name="pesq_form" method="post" action="cad-imagem.php" >
                                                                <input hidden type="text" name="pesquisa" class="input_pesq form-control" value="<?php echo $textoDaPesquisa; ?>">
                                                                <input hidden type="text" name="paginaEscolhida" class="input_pesq form-control" value="<?php echo $numPaginas  ?>">
                                                                <button type="submit" class="page-link" name="btn_pesquisar"><i class="fa fa-angle-double-right"></i></button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </nav>
                                            <?php } ?>                   
                                        </div>
                                    </div>

                                    <!-- Paginação  Exibe a paginação-->
                                        </div>
                                    </div>

                                                <?php
                                            }
                                            ?>

   <script type="text/javascript">
    $(function(){
        $(".tabelaresult input").keyup(function(){        
            var index = $(this).parent().index();
            var nth = ".tabelaresult  td:nth-child("+(index+1).toString()+")";
            var valor = $(this).val().toUpperCase();
            $(".tabelaresult  tbody tr").show();
            $(nth).each(function(){
                if($(this).text().toUpperCase().indexOf(valor) < 0){
                    $(this).parent().hide();
                }
            });
        });
    });
    $("#loteImg").click(function(){  
        if( $("#formImgLote").css("display") == "none"){
            $("#formImgLote").css("display","block");
        }else{
            $("#formImgLote").css("display","none");
        }
        
    });

    function rename_label_file() {
          $(".input-file").before(
            function() {
              if ( ! $(this).prev().hasClass('input-ghost') ) {
                var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0'>");
                element.attr("name",$(this).attr("name"));
                element.change(function(){
                  element.next(element).find('input').val((element.val()).split('\\').pop());
                });
                $(this).find("button.btn-choose").click(function(){
                  element.click();
                });
                $(this).find('input').css("cursor","pointer");
                $(this).find('input').mousedown(function() {
                  $(this).parents('.input-file').prev().click();
                  return false;
                });
                return element;
              }
            }
          );
        }
      $(function() {
        rename_label_file();
      });

      // limitar o tamanho do upload da img

        var ArrfileUpS = document.getElementsByClassName("inserirft_arquivo");
        var uploadField = ArrfileUpS[0]; 

        uploadField.onchange = function() {
            if(this.files[0].size > 2000000){
               // alert("Arquivo muito grande! 2");
               $("#msgUploadFileSize").text("O arquivo é > que 2mb, selecione outra imagem");

               this.value = "";
            }else{
               $("#msgUploadFileSize").text("");

            };
        };
      // limitar o tamanho do upload da img


    </script>
       <script language="JavaScript" src="js/custom.js"></script>
</body>
</html>

<?php 

    unset($_POST['img_caminho']);

 ?>
