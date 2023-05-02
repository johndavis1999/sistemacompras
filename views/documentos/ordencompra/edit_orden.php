<?php
// Incluye los archivos necesarios
require_once("c://xampp/htdocs/sistemacompras/controllers/controladorProductos.php");
$obj = new controladorProducto(); 
$productos = $obj->index();

require_once("c://xampp/htdocs/sistemacompras/controllers/controladorProveedor.php");
$obj = new controladorProveedor(); 
$proveedores = $obj->index();

require_once("c://xampp/htdocs/sistemacompras/controllers/controladorCotizacion.php");
$obj = new controladorCotizacion(); 
$cotizaciones = $obj->index();

// Incluye la clase Cotizacion
require_once("c://xampp/htdocs/sistemacompras/controllers/controladorOrden.php");
$obj = new controladorOrdenCompra(); 
$ordenValues = $obj->getOrdenCompra($_GET['orden_id']);
$ordenItems = $obj->getOrdenCompraItems($_GET['orden_id']);

// Incluir el archivo index.php, que contiene el formulario de creación de órdenes y la tabla de órdenes existentes.
require_once("c://xampp/htdocs/sistemacompras/index.php");
?>

<link href="css/style.css" rel="stylesheet">

<!-- Contenedor principal del formulario -->
<div class="container content-orden">
    <!-- Título del formulario -->
    <h5>Editar Orden de compra # <?= $ordenValues['orden_id']?></h5>
    <!-- Formulario para editar la orden de compra -->
    <form action='edit.php' id="orden-form" method="post" class="orden-form" role="form">
        <!-- Contenedor para el efecto de carga animada -->
        <div class="load-animate animated fadeInUp">
            <!-- Campo oculto para la moneda -->
            <input id="currency" type="hidden" value="$">
            <!-- Fila principal del formulario -->
            <div class="row">
                <!-- Columna para los datos del jefe de compra -->
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 pull-right">
                    <!-- Campo para el nombre del jefe de compra -->
                    <div class="form-group">
                        <h6 for="">Creado por: John Davis</h6>
                        <input type="hidden" class="form-control" name="idjefecompra" id="idjefebodega" value="1" placeholder="Nombre Cliente" autocomplete="off">
                    </div>
                    <!-- Campo para la fecha y hora de creación de la orden -->
                    <div class="form-group">
                        <h6 for="">Fecha y hora de creación:</h6>
                        <input class="form-control" type="datetime-local" value="<?php echo date('Y-m-d\TH:i'); ?>" readonly>
                    </div>
                    <!-- Campo para el estado de la orden -->
                    <div class="form-group">
                        <h6 for="">Estado</h6>
                        <select class="form-select" name="estado" id="estado" aria-label="Disabled select example" required>
                            <option value="1" <?= $ordenValues['estado']=='1'? 'selected' : ''?>>Activo</option>
                            <option value="2" <?= $ordenValues['estado']=='2'? 'selected' : ''?>>Inactivo</option>
                            <option value="3" <?= $ordenValues['estado']=='3'? 'selected' : ''?>>Finalizado</option>
                            <option value="4" <?= $ordenValues['estado']=='4'? 'selected' : ''?>>Cancelado</option>
                        </select>
                    </div>
					<!-- Formulario para seleccionar la cotización relacionada con la orden de compra -->
                    <div class="form-group">
                        <h6 for="">Cotización relacionada</h6>
                        <select class="form-select" name="cotizacion_id" id="cotizacion_id" aria-label="Disabled select example" required>
                            <?php foreach ($cotizaciones as $cotizacion): 
                                // Comprobamos si la cotización actual es la misma que está relacionada con la orden de compra
                                if($cotizacion['cotizacion_id'] == $ordenValues['cotizacion_id']){?>
                                    <!-- Si es la misma, la seleccionamos por defecto -->
                                    <option value="<?php echo $cotizacion['cotizacion_id']; ?>" selected>Cotización #<?php echo $cotizacion['cotizacion_id']; ?></option>
                                <?php
                                } else{
                                ?>
                                    <!-- Si no es la misma, la mostramos en la lista -->
                                    <option value="<?php echo $cotizacion['cotizacion_id']; ?>">Cotización #<?php echo $cotizacion['cotizacion_id']; ?></option>
                                <?php
                                }
                                ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
				</div>
			</div>
            <p><? echo "xd"; ?></p>
			<div class="">
                <div class="card mb-4 rounded-3 shadow-sm">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <!-- Comienzo del código PHP -->
                        <?php
                            // Inicialización de la variable optionsHtml como una cadena vacía
                            $optionsHtml = '';
                            // Bucle foreach para recorrer el array $productos y construir las opciones del select
                            foreach ($productos as $producto) {
                                // Concatenación de la etiqueta option en la variable $optionsHtml
                                $optionsHtml .= '<option value="' . $producto['id'] . '">' . $producto['nombre'] . '</option>';
                            }
                        ?>
                        <!-- Fin del código PHP -->
                        <div class="card-header py-3">
                            <h3 class="my-0 fw-normal">Detalles Documento</h3>
                        </div>
                        <div class="my-0 fw-normal">
                            <table class="table table-bordered table-hover" id="cotizacionItem">
                                
                                <tr>
                                    <th><input id="checkAll" class="formcontrol" type="checkbox"></th>
                                    <th>Producto</th>    
                                    <th>Cantidad</th>
                                </tr>
                                <small id="mensaje-error" style="color:red;">Importante; debe seleccionar al menos un producto para generar la cotización</small>
                                <?php
                                // Iteramos a través de la lista de elementos de la orden
                                
                                $count = 0;
                                    foreach ($ordenItems as $ordenItem) {
                                        $count++;
                                        $item_id = $ordenItem["item_id"];
                                        $orden_item_cantidad = $ordenItem["orden_item_cantidad"];
                                ?>
                                <tr>
                                    
                                    <td><input class="itemRow" type="checkbox"></td>
                                    <td>
                                        <!-- Creamos un menú desplegable para seleccionar el producto -->
                                        <select class="form-select" name="item_id[]" id="item_id_<?php echo $count; ?>" aria-label="Disabled select example" required>
                                            <option value="" selected>Seleccionar producto</option>
                                            <!-- Iteramos a través de la lista de productos y creamos una opción para cada uno -->
                                            <?php foreach ($productos as $producto): ?>
                                            <option value="<?php echo $producto['id']; ?>" <?php if ($item_id == $producto['id']) { echo 'selected'; } ?>><?php echo $producto['nombre']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <!-- Creamos un campo de entrada para la cantidad de producto -->
                                    <td><input type="number" value="<?php echo $orden_item_cantidad;?>" name="orden_item_cantidad[]" id="orden_item_cantidad_<?php echo $count; ?>" class="form-control orden_item_cantidad" autocomplete="off" pattern="[0-9]" min="1" required></td>
                                </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
			</div>
            <!-- Sección de descripción adicional -->
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <h4>Descripción adicional: </h4>
                    <!-- Campo para agregar observaciones -->
                    <div class="form-group">
                        <textarea class="form-control txt" rows="5" name="descripcion" id="descripcion" placeholder="Observaciones"><?php echo $ordenValues['descripcion']?></textarea>
                    </div>
                    <br>
                    <!-- Botones para guardar y cancelar la orden -->
                    <div class="form-group">
                        <input type="hidden" value="<?php echo $ordenValues['orden_id']; ?>" class="form-control" name="orden_id" id="orden_id">
                        <input data-loading-text="Actualizar orden..." type="submit" name="orden_btn" value="Actualizar Orden" class="btn btn-success submit_btn orden-save-btm">
                        <a class="btn btn-danger" type="button" href="index.php">Cancelar</a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <!-- Sección vacía sin comentarios -->
                    <span class="form-inline"></span>
                </div>
            </div>
		</div>
	</form>
</div>