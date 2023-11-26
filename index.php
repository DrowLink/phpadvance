<?php

$host="localhost";
$usuario="root";
$password="";
$basededatos="phpadvance";

$conexion = new mysqli($host, $usuario, $password, $basededatos);


if ($conexion->connect_error){
    die ("Conexion no establecida". $conexion->connect_error);
}

header("Content-Type: application/json"); 
$metodo= $_SERVER['REQUEST_METHOD'];
print_r($metodo);

switch($metodo){
    case 'GET':
        echo "Consulta de registro - GET";
        consultaSelect($conexion);
        break;
    case 'POST':
        echo "Consulta de registro - POST";
        insertar($conexion);
        break;
    case 'PUT':
        echo "Consulta de registro - PUT";
        break;
}

function consultaSelect($conexion){
    $sql= "SELECT * FROM usuarios";
    $query= $conexion->query($sql);

    if ($query){
        $datos= array();
        while($fila= $resultado->fetch_assoc()){
            $datos[]= $fila;
        }
        echo json_encode($datos);
    }
}

function insertar($conexion){
    $datos= json_decode(file_get_contents('php://input'),true);
    $nombre= $datos=['nombre'];
    print_r($nombre);

    $sql= "INSERT INTO usuarios(nombre) VALUES ('$nombre')";
    $resultado = $conexion->query($sql);

    if($resultado){
        $datos['id'] = $conexion->insert_id;
        echo json_encode($datos);
    }else {
        echo json_encode(array('error'=>'Error al crear usuario'));
    }
}

?>