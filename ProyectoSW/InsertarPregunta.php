<?php 

$local=1; //0 para la aplicación en 000WebHost
if ($local==1){
$server="localhost";
$user="root";
$pass="isomendar69";
$basededatos="Quiz";
}
else{
$server="localhost";
$user="id7157936_preguntas";
$pass="isomendar69";
$basededatos="id7157936_quiz";
}

$conn = new mysqli($server, $user, $pass, $basededatos);
$correo=$_GET['correo'];
$Pregunta=$_GET['Pregunta'];
$RC=$_GET['RC'];
$RI1=$_GET['RI1'];
$RI2=$_GET['RI2'];
$RI3=$_GET['RI3'];
$Complejidad=$_GET['complejidad'];
$tema=$_GET['tema'];

if($conn -> connect_error){
	//die("Conexion fallida" . $conn->connect_error);
	echo("error al conectarse");
	echo'<span><a href="layout.html?op=usuario">Volver</a></spam>';
}
if((preg_match("/^[a-z A-Z]+([0-9]{3})+@ikasle.ehu.eus$/",$correo))&&(preg_match("/^([0-5]{1})$/",$Complejidad))&&(!empty($Pregunta))&&(!empty($RC))&&(!empty($RI1))&&(!empty($RI2))&&(!empty($RI3))&&(!empty($tema))){
		$insertar="INSERT INTO Preguntas (Nombre, Enunciado, Respuesta_Correcta, Respuesta_Incorrecta1, Respuesta_Incorrecta2, Respuesta_Incorrecta3, Complejidad, Tema) VALUES ('$correo','$Pregunta', '$RC', '$RI1', '$RI2', '$RI3', '$Complejidad', '$tema')";

		$xml = simplexml_load_file('preguntas.xml');

		$pregun = $xml->addChild('assessmentItem');
		$pregun->addAttribute('subject', $tema);
		$pregun->addAttribute('author', $correo);
		$pregun->addChild('itembody',$Pregunta);

		$correctResponse = $pregun->addChild('correctResponse');
		$correctResponse->addChild('value', $RC);

		$incorrectResponse = $pregun->addChild('incorrectResponse');
		$incorrectResponse->addChild('value', $RI1);
		$incorrectResponse->addChild('value', $RI2);
		$incorrectResponse->addChild('value', $RI3);

		$xml->asXML();
		 if((($xml->asXML('preguntas.xml'))==FALSE)OR($conn->query($insertar)==FALSE)){
		 	echo("error al insertar los datos en xml o en la BD");
		 	echo'<span><a href="layout.html?op=usuario">Volver</a></spam>';
		 }
		 else{
			//echo("insertado con exito");
			//echo'<span><a href="VerPreguntasXML.php">Ver las preguntas en xml</a></spam>';	
		}
 }
else{
 	echo("error uno de los campos no se ha rellenado correctamente");
 	echo'<span><a href="layout.html?op=usuario">Volver</a></spam>';
 }
#if($conn->query($insertar)==true){
	#echo("Insertado con exito");
	#echo'<span><ahref="layout.html?op=usuario">Insertado con exito</a></spam>';
	//include("VerPreguntas.php");
#}
#else{
#	echo("error al insertarlo");
#	echo'<span><a href="layout.html?op=usuario">Volver</a></spam>';
#}
?>
