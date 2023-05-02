<?php
    // Se importa el controlador de orden de compra
    require_once("c://xampp/htdocs/sistemacompras/controllers/controladorOrden.php");
    // Se instancia el objeto del controlador
    $obj = new controladorOrdenCompra();
    // Se obtiene el id de la orden de compra a eliminar mediante el método GET
    $orden_id = $_GET['orden_id'];
    // Se llama al método para eliminar la orden de compra
    //$obj->deleteOrden($orden_id);
    $obj->deleteOrdenLogico($orden_id);
?> 