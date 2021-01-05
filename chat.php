<?php

$db = new mysqli("localhost", "root", "admin", "CHAT");

if ($db->connect_error){
    die("Conexion fallida " . $db->connect_error);
}

$result = array();
$mensaje = isset($_POST['message']) ? $_POST['message'] : null;
$from = isset($_POST['from']) ? $_POST['from'] : null;

if(!empty($mensaje) && !empty($from)){
    $sql="INSERT INTO chat (mensaje,autor) VALUES ('".$mensaje."','".$from."')";
    $result['enviar_datos'] = $db->query($sql);
}

//imprimir mensajes en el chat
$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
$items = $db->query("SELECT * FROM `chat` WHERE `id` > $start");

while($row = $items->fetch_assoc()){
    $result['items'][] = $row;
}

$db->close();

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

echo json_encode($result);
?>

