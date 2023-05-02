<?php
    require_once("c://xampp/htdocs/sistemacompras/controllers/controladorCotizacion.php");
    $obj = new controladorCotizacion(); 
    $idproveedor = $_POST['idproveedor'];
    $idPedido = $_POST['idPedido'];
    $garantia = $_POST['garantia'];
    $valor = $_POST['valor'];
    $estado = $_POST['estado'];
    $descripcion = $_POST['descripcion'];
    $cotizacion_id = $_POST['cotizacion_id'];/*
    if (isset($_POST['producto_id']) && isset($_POST['cotizacion_producto_cantidad'])) {
        // Accede a los valores de $_POST['producto_id'] y $_POST['cotizacion_producto_cantidad'] y realiza la actualización en la base de datos
    } else {
        // Muestra un mensaje de error indicando que no se recibió el producto_id
        echo "El campo producto_id es obligatorio. Por favor, seleccione un producto.";
    }*/
    
    $obj->updateCotizacion($cotizacion_id, $idproveedor, $idPedido, $garantia, $valor, $estado, $descripcion);