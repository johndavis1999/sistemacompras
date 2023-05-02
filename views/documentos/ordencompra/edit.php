<?php
    require_once("c://xampp/htdocs/sistemacompras/controllers/controladorOrden.php");
    $obj = new controladorOrdenCompra(); 
    $orden_id = $_POST['orden_id'];
    $estado = $_POST['estado'];
    $descripcion = $_POST['descripcion'];
    $cotizacion_id = $_POST['cotizacion_id'];
    $obj->updateOrden($cotizacion_id, $orden_id, $estado, $descripcion);