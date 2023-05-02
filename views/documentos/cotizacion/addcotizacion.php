<?php
    // Se incluye el archivo del controlador de Cotización
    require_once("c://xampp/htdocs/sistemacompras/controllers/controladorCotizacion.php");
    // Se crea una instancia del controlador de Cotización
    $obj = new controladorCotizacion();
    // Se obtienen los datos de la cotización del formulario de envío
    $idproveedor = $_POST['idproveedor'];
    $idPedido = $_POST['idPedido'];
    $garantia = $_POST['garantia'];
    $valor = $_POST['valor'];
    $estado = $_POST['estado'];
    $descripcion = $_POST['descripcion'];
    // Se llama al método "saveCotizacion" del controlador para guardar la cotización en la base de datos
    $obj->saveCotizacion($idproveedor, $idPedido, $garantia, $valor, $estado, $descripcion);
?>
