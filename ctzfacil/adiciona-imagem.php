     <script type="text/javascript">
     
        function salvaeadicionaimagem(){


         //var url_completa;
        //var x = $("#img_caminho").val():


/*
var data = new FormData(); 
data.append('ft_arquivo', document.getElementById('ft_arquivo').files[0]); 
$.ajax({    
url : 'cad-imagem.php', 
type : 'POST',
data : data,
processData: false, 
contentType: false, 
success : function(data) { 
console.log(data);


alert(data); }
});
*/
//////////////////////////////////////////
var formData = new FormData(document.getElementById("form1"));          
            $.ajax({
                type: 'POST',
                url: 'cad-imagem.php',
                data: formData,
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                        $('#btnSend').attr("disabled","disabled");
                        //$('#form1').css("opacity",".5");
                },
                success: function(msg){ 
                        $.ajax({
                type : 'POST',
                url: "inc/selecionaImagem.php",
                success: function(ultimaImagem){
                    console.log(ultimaImagem);
                    const url_completa = ultimaImagem;
                    //carregaDCartaz()// chama o ultimo box
                    console.log('url ' + url_completa);
                    adiciona(url_completa);
                },
                error:function(){
                    console.log('erro idsCartazesValores');
                }
            });

                }

                }); 


           
//console.log('completo ;x' + ex);





}


function adiciona(iurl){
        console.log('ola' + iurl);
        //var url_completa= "https://dboaditivos.cartazfacil.pro/vinhos/7896855901417.png";
        var id = 'aleatoria';
        var aleatoria = 'aletoria';
        $("<div class='img-papel mover' style='z-index:"+"999"+";width:200px;height:200px;position:absolute;background: url("+iurl+") no-repeat center center ;background-size:100% 100%;' id='iadd"+id+"-"+aleatoria+"''></div>").prependTo("#papel");
        //$('#papel').css('background-color', '#0ff');
            Draggable.create("#iadd"+id+"-"+aleatoria, {zIndexBoost:false});
       // document.getElementById("imagem").submit();
        console.log('começou');
        }



//}

/*

        $.ajax({
                                        type : 'post',
                                        url: "inc/oPprintList.php",
                                        data: 'operacao=add&IDproduto='+id_produto+'&IDvalor='+id_valor+'&Dmotivo='+dMotivo+'&Dcartaz='+dCartaz+'&motivo='+motivo+'&num_parcelas='+num_parcelas+'&id_taxa='+id_taxa/*+'&valida_tv='+valida_tv,
                                        dataType: 'html',
                                        success: function(data){
                                            carregaLista();
                                        },
                                        error:function(){
                                            console.log('erro');
                                        }
                                    });


        }

        // Evento Submit do formulário
    $('#formulario').submit(function() {
 
        // Captura os dados do formulário
        var formulario = document.getElementById('formulario');
 
        // Instância o FormData passando como parâmetro o formulário
        var formData = new FormData(formulario);
 
        // Envia O FormData através da requisição AJAX
        $.ajax({
           url: "cad-imagem.php",
           type: "POST",
           data: formData,
           dataType: 'json',
           processData: false,  
           contentType: false,
           success: function(retorno){
                if (retorno.status == '1'){
                    $('.mensagem').html(retorno.mensagem);
                }else{
                    $('.mensagem').html(retorno.mensagem)
                }
                $('.card-panel').removeClass('hide');
           }
        });
 
        return false;
    });
 
 
    $("input[type=file]").on("change", function(){
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return;
 
        if (/^image/.test( files[0].type)){
            var reader = new FileReader();
            reader.readAsDataURL(files[0]);
 
            reader.onload = function(){
                $("#imagem").attr('src', this.result);
            }
        }
    });
    */
</script>



<script>
   /*form Submit
   $("formulario").submit(function(evt){   
      evt.preventDefault();
      var formData = new FormData($(this)[0]);
   $.ajax({
       url: 'fileUpload',
       type: 'POST',
       data: formData,
       async: false,
       cache: false,
       contentType: false,
       enctype: 'multipart/form-data',
       processData: false,
       success: function (response) {
         alert(response);
       }
   });
   return false;
 });

 */
</script>

   <form id="form1" name="imagem" method="post" action="../cad-imagem.php" class="form_cadastro_funcionario" enctype="multipart/form-data">
                                            <fieldset>
                                            <?php
                                                $novonome = rand(10000, 20000);
                                            ?>

                                                        <div class="col-md-10">
                                                            <BR>
                                                            <label for="ft_arquivo"><center>Clique ou solte o arquivo aqui</label>
                                                            <input accept=".png, .jpg, .jpeg, .tiff" class="inserirft_arquivo" id="ft_arquivo" name="ft_arquivo" type="file" class="campo_1" style="border: 1px #0071bc solid; border-radius: 10px; background-color: #fff; padding: 30px; display: block; width: 100%; font-size: 10px;" onchange="salvaeadicionaimagem()" />
                                                            
                                                            <input type="hidden" name="img_inicio" value="">
                                                             <input type="hidden" name="img_tags" value="sem tag">
                                                               <input type="hidden" name="img_fim" value="">
                                                                <input type="hidden" name="img_descricao" value="Descrição">
                                                                 <input type="hidden" name="img_nome" value="nome2-<?=$novonome;?>">
                                                             <!--  <input type="hidden" name="img_caminho" id="img_caminho" value="./imageUpload/<?=$novonome;?>.png">-->

                                                            <input type="hidden" name="btnsalvar" value="nome">


                                                              <!--   <input type="submit" name="enviar" value="enviar">-->
                                                        </div>
                                                   
                                                    <!--
                                                    <div class="form-row my-2">
                                                        <div class="col-md-12">
                                                            <label>Descrição</label>
                                                            <textarea id="img_descricao" maxlength="100" name="img_descricao" class="campo_1 form-control" rows="4" style="resize:none;"></textarea>
                                                        </div>
                                                    </div>-->
<!--
                                      <div class="campos_esq_1">
                                                        <a href="importar_dados.php?cft=Imagem" target="_blank" class="my-3 btn btn-outline-info">
                                                            Importar dados .CSV <i class="fa fa-mail-forward text-white ml-1"></i> </a>
                                                    </div>
                                                -->
                                                <!--
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                        <input name="btnsalvar" type="submit" value="Salvar" class="btn_salvar btn btn-primary"/>
                                                        <input id="limparPagina" type="button" value="Limpar" class="btn_salvar btn btn-warning text-white"/>
                                                    </div>
                                                -->

                                            </fieldset>
                                        </form>
