    /*    <label for="usuario" class="text-white">usuário :</label>
            <input type="text" class="form-control form-control-2 mb-2" id="usuario" name="usuario" value="" autofocus>
            <label for="senha" class="text-white">senha :</label>
            <input type="password" class="form-control form-control-2 mb-2" id="senha" name="senha" value=""><i class="fa fa-eye" id="mostrarSenha" style="color: #fff; cursor: pointer; transition: 1s;"> mostrar/ocultar senha</i>
OCULTAR E DESOCULTAR SENHAR - FUNÇÃO OLHO
*/
$("#mostrarSenha").on("click", function(){
  if(document.getElementById("senha").type == "text"){
    document.getElementById("senha").type = "password";
    document.getElementById("mostrarSenha").innerHTML = " mostrar senha";
    document.getElementById("mostrarSenha").classList.remove("fa-eye-slash");
            document.getElementById("mostrarSenha").classList.add("fa-eye");
  }else{
        document.getElementById("senha").type = "text";
        document.getElementById("mostrarSenha").innerHTML = " ocultar senha";
        document.getElementById("mostrarSenha").classList.add("fa-eye-slash");
        document.getElementById("mostrarSenha").classList.remove("fa-eye");

  }
  
    
  /*
                    <div class="modal-body" id="divTemplates">
                        <input type="hidden" id="#cartazSendoAlterado">
                        <button type="button" class="btn btn-success" onclick="carregaTemplates(2)">Carregar Templates</button>
                    </div>
                    
                    FUNÇÃO CARREGAR INCLUDE DENTRO DE UMA DIV
  
  */
  
    function carregaTemplates(IdCartaz) {

                var cartazSendoAlterado = document.getElementById('#cartazSendoAlterado');

                //cartazSendoAlterado
                $("#divTemplates").load("components/modal_alt_assoc_template.php?lp_id="+document.getElementById('#cartazSendoAlterado').value);


                var idCartazAnt = IdCartaz;
                var idCartazProx = dupNun+idCartazAnt;
                //var cartazDuplicado = cartazHtml.replace("apagarCartaz(\'"+IdCartaz+"\')", "apagarCartaz(\'"+idCartazProx+"\')");

                //$('#inputsCartazes').append('<div id="'+idCartazProx+'">'+cartazDuplicado+'</div>');
                //quantidadeDeCartazesGerados++;

                //var contCTZDepois = document.getElementById('contCTZDepoisModal');
                //contCTZDepois.innerText--;
                //contCTZDepois.innerHTML = contCTZDepois.innerText;
                console.log(IdCartaz);           


            }
  
