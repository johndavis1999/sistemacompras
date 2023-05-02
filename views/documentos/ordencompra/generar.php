<?php

require_once("c://xampp/htdocs/sistemacompras/controllers/controladorProductos.php");
$obj = new controladorProducto(); 
$productos = $obj->index();

require_once("c://xampp/htdocs/sistemacompras/controllers/controladorCotizacion.php");
$obj = new controladorCotizacion(); 
$cotizacionValues = $obj->getCotizacion($_GET['cotizacion_id']);
$cotizacionItems = $obj->getCotizacionItems($_GET['cotizacion_id']);

require_once("c://xampp/htdocs/sistemacompras/index.php");
?>

<link href="css/style.css" rel="stylesheet">

<div class="container content-orden">
    <h5>Registrar Orden de compra</h5>
	<form action='addorden.php' id="orden-form" method="post" class="orden-form" role="form">
		<div class="load-animate animated fadeInUp">
			<input id="currency" type="hidden" value="$">
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 pull-right">
                    <div class="form-group">
                        <!-- Aquí se muestra el nombre del usuario que crea la orden -->
                        <h6 for="">Creado por: John Davis</h6>
                        <!-- Este campo está oculto y contiene el ID del usuario que crea la orden -->
                        <input type="hidden" class="form-control" name="idjefecompra" id="idjefebodega" value="1" placeholder="Nombre Cliente" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <!-- Aquí se muestra la fecha y hora actual de creación de la orden -->
                        <h6 for="">Fecha y hora de creación:</h6>
                        <!-- Este campo está deshabilitado y muestra la fecha y hora actual -->
                        <input class="form-control" type="datetime-local" value="<?php echo date('Y-m-d\TH:i'); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <!-- Este campo permite seleccionar el estado de la orden -->
                        <h6 for="">Estado</h6>
                        <select class="form-select" name="estado" id="estado" aria-label="Disabled select example" required>
                            <!-- Aquí se muestran las opciones de estado disponibles -->
                            <option value="1" selected>Activo</option>
                            <option value="2">Inactivo</option>
                            <option value="3">Finalizado</option>
                            <option value="4">Cancelado</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <!-- Este campo permite seleccionar la cotización relacionada con la orden -->
                        <h6 for="">Cotización relacionada</h6>
                        <input class="form-control" name="cotizacion_id" type="text" value="<?=$cotizacionValues['cotizacion_id']?>" readonly>
                    </div>
                </div>
            </div>
			<div class="">
                <div class="card mb-4 rounded-3 shadow-sm">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <?php
                        // Creamos una variable para almacenar el HTML de las opciones de productos
                        $optionsHtml = '';
                        // Iteramos a través de la lista de productos y creamos una opción para cada uno
                        foreach ($productos as $producto) {
                            $optionsHtml .= '<option value="' . $producto['id'] . '">' . $producto['nombre'] . '</option>';
                        }
                        ?>
                        <div class="card-header py-3 mb3">
                            <h3 class="my-0 fw-normal">Detalles Cotización</h3>
                        </div>
                        <div class="my-0 fw-normal">
                            <!-- Creamos una tabla para los detalles de la cotización -->
                            <table class="table table-bordered table-hover" id="cotizacionItem">
                                <tr>
                                    <th><input id="checkAll" class="formcontrol" type="checkbox"></th>
                                    <th>Producto</th>    
                                    <th>Cantidad</th>
                                </tr>
                                <?php
                                // Iteramos a través de la lista de elementos de la cotización
                                
                                $count = 0;
                                foreach ($cotizacionItems as $cotizacionItem) {
                                    $count++;
                                    $producto_id = $cotizacionItem["producto_id"];
                                    $cotizacion_producto_cantidad = $cotizacionItem["cotizacion_producto_cantidad"];
                                ?>
                                <tr>
                                    <td><input class="itemRow" type="checkbox"></td>
                                    <td>
                                        <!-- Creamos un menú desplegable para seleccionar el producto -->
                                        <select class="form-select" name="item_id[]" id="item_id_<?php echo $count; ?>" aria-label="Disabled select example" required>
                                            <option value="" selected>Seleccionar producto</option>
                                            <!-- Iteramos a través de la lista de productos y creamos una opción para cada uno -->
                                            <?php foreach ($productos as $producto): ?>
                                            <option value="<?php echo $producto['id']; ?>" <?php if ($producto_id == $producto['id']) { echo 'selected'; } ?>><?php echo $producto['nombre']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <!-- Creamos un campo de entrada para la cantidad de producto -->
                                    <td><input type="number" value="<?php echo $cotizacion_producto_cantidad;?>" name="orden_item_cantidad[]" id="orden_item_cantidad_<?php echo $count; ?>" class="form-control cotizacion_producto_cantidad" autocomplete="off" pattern="[0-9]" min="1" required></td>
                                </tr>
                                <?php } ?>
                            </table>
                    </div>
                </div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
					<h4>Descripcion adicional: </h4>
					<div class="form-group">
						<textarea class="form-control txt" rows="5" name="descripcion" id="descripcion" placeholder="Observaciones"></textarea>
					</div>
					<br>
					<div class="form-group">
						<input data-loading-text="Guardando orden..." type="submit" name="orden_btn" value="Guardar Orden" class="btn btn-success submit_btn orden-save-btm">
                        <a class="btn btn-danger" type="button" href="index.php">Cancelar</a>
					</div>

				</div>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					<span class="form-inline">
					</span>
				</div>
			</div>
		</div>
	</form>
</div>
</div><!-- Este script se ejecuta cuando el documento está listo -->
