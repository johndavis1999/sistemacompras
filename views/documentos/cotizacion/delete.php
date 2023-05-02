<?php
    // Se requiere el archivo que contiene la clase controladorCotizacion
    require_once("c://xampp/htdocs/sistemacompras/controllers/controladorCotizacion.php");

    // Se crea una nueva instancia de la clase controladorCotizacion
    $obj = new controladorCotizacion();

    // Se llama a la función deleteCotizacion() del objeto controladorCotizacion, pasándole el id de la cotización a eliminar
    //$obj->deleteCotizacion($_GET['cotizacion_id']);
    $obj->deleteCotizacionLogico($_GET['cotizacion_id']);
?> 