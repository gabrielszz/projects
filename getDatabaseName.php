<?php   
//////pegando nome de uma conexão PDO e transformando ela em xml para ser lida como texto, retorno TEXTO


/////utilizando uma conexão PDO

public function getDatabase(){
			$resultado = $this->conexao->query("SELECT database();");
						//echo $resultado;

			$dados = $resultado->fetchAll(PDO::FETCH_OBJ);

            if(count($dados) > 0){
               foreach($dados as $linha){
                    $dados2 = $linha;
                    //echo "<option selected value='$linhaApi->email'>$linha->et_nome</option>";
               }
            } 
            ///
            
            //$dados3 = var_dump($dados);
           // $dados4 = $dados["database()"];
          //  return $dados3;

            $xml = json_decode(json_encode($dados),true);
            $xml2 = $xml[0]["database()"];

            return $xml2;          
  }
  
  
 ?> 
