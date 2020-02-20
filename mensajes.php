<?php
	function mensajes($mensaje){
		$mensaje=htmlspecialchars($mensaje);
		$mensaje=rawurlencode($mensaje);
		$mensaje=file_get_contents('https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q='.$mensaje.'&tl=es-ES');
		$reproducir="<div id='audio_oculto' ><audio controls='controls' autoplay><source src='data:audio/mpeg;base64,".base64_encode($mensaje)."'</audio></div>";
		echo $reproducir;
		//$_SESSION['mensaje']="";
		//style='display:none;'
	}

?>