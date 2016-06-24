<?php
/*
	@utor hkanata@gmail.com
	http://harukanata.no-ip.org
*/
if($_POST['submit'] == "Upload"){
	include('config/UpLoadTree.php');
	$upload = new Upload($_FILES['arquivo']['name'] , $_FILES['arquivo']['size'] , $_FILES['arquivo']['tmp_name'] , $_FILES['arquivo']['type']);
}
if($_POST['submit'] == "Upload Todos"){
	include('config/MultiploUpLoadTree.php');
	$multiploUpload = new MultiploUpload($_FILES['arquivo']['name'] , $_FILES['arquivo']['size'] , $_FILES['arquivo']['tmp_name'] , $_FILES['arquivo']['type']);
	
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Upload</title>
<script type="text/javascript" src="js/jquery.js">             	</script>
<script type="text/javascript" src="js/interface/interface.js"> </script>
<script type="text/javascript" src="js/funcoes.js">           	</script>
<link href="css/estilo.css" type="text/css" rel="stylesheet" />

</head>

<body>
	<div>
    <form action="index.php" method="POST" enctype="multipart/form-data">
        <fieldset>
        	<legend>UPLOAD</legend>
        	<span>
				<input type="file"   name="arquivo"  />
        	</span>
            <span>
        		<input type="submit" name="submit" value="Upload" id="submit"/>    
            </span>
        </fieldset>
    </form>
    </div>
    
    <div id="MultiploUpload">
    	<a href="#" id="windowOpen">Vários Upload</a>
	</div>
    
    <!-- Início Janela Filé -->
    <div id="window">
        <div id="windowTop">
            <div id="windowTopContent">Vários Upload</div>
            <img src="images/window_min.jpg"   id="windowMin" />
            <img src="images/window_max.jpg"   id="windowMax" />
            <img src="images/window_close.jpg" id="windowClose" />
        </div>
        <div id="windowBottom">
            <div id="windowBottomContent">
                &nbsp;
            </div>
        </div>    
        <div id="windowContent">
            <form action="index.php" method="POST" enctype="multipart/form-data">
                <fieldset>
                    <span>
                        <input type="file"   name="arquivo[]"  />
                    </span>
                    <span id="result">
                    	<!-- Se for precionado o + aqui é adicionado os campos -->
                    </span>
                    <span>
                    	<a href="#" onClick="adicionaCampo();">+</a>
                    </span>
                    
                    <span>
                        <input type="submit" name="submit" value="Upload Todos" id="submit"/>    
                    </span>
                </fieldset>
            </form>
        </div>
        <img src="images/window_resize.gif" id="windowResize" />
	</div>
    <!-- Arquivo INI da Janela(window) -->
	<script src="js/fc.js"></script>
    <!-- Fim Janela Filé -->
</body>
</html>