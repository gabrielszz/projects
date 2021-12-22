	function verificaData($dataMenor, $dataMaior, $data){
  		//formato 
  		$aux = explode("-", $dataMenor);
  		$pecas = explode("/", $aux[0]);

  		$aux = explode("-", $data);
  		$pecas2 = explode("/", $aux[0]);

  		$aux = explode("-", $dataMaior);
  		$pecas3 = explode("/", $aux[0]);


  		if($pecas2[0] >= $pecas[0] and $pecas2[0] <= $pecas3[0]){
  			if($pecas2[1] >= $pecas[1] and $pecas2[1] <= $pecas3[1]){
  				if($pecas2[2] >= $pecas[2] and $pecas2[2] <= $pecas3[2]){
  					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
  		}else{
  			return false;
  		}
  	}
