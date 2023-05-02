<?php
    // Se requiere el archivo que contiene la definición de la clase controladorOrdenCompra
    require_once("c://xampp/htdocs/sistemacompras/controllers/controladorOrden.php");

    // Se crea un objeto de la clase controladorOrdenCompra
    $obj = new controladorOrdenCompra();

    // Se obtienen los datos enviados por POST desde un formulario
    $idjefecompra = $_POST['idjefecompra'];
    $cotizacion_id = $_POST['cotizacion_id'];
    $estado = $_POST['estado'];
    $descripcion = $_POST['descripcion'];

    // Se llama al método saveOrden del objeto controladorOrdenCompra y se le pasan los datos obtenidos
    $obj->saveOrden($idjefecompra, $cotizacion_id, $estado, $descripcion);
?>




