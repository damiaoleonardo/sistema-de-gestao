<?php
class MultiploUpload{

	public $diretorio        = "docs/";
	public $numeroAleatorio;
	public $data;

	function MultiploUpload($nomeArquivo , $tamanho , $tmp_nome , $tipo){		
		
		$contador 	=  count($nomeArquivo);
		$this->numeroAleatorio = rand(0,1000);
		$this->data = date('d-m-Y');
		for($i = 0 ; $i <= $contador ; $i++){
			move_uploaded_file($tmp_nome[$i] , $this->diretorio.$this->numeroAleatorio.'+'.$this->data.'+'.$nomeArquivo[$i]);
		}
	}
}
?>