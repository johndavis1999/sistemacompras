<?php
// Incluye los archivos necesarios
require_once("c://xampp/htdocs/sistemacompras/controllers/controladorProductos.php");
$obj = new controladorProducto(); 
$productos = $obj->index();

require_once("c://xampp/htdocs/sistemacompras/controllers/controladorProveedor.php");
$obj = new controladorProveedor(); 
$proveedores = $obj->index();

require_once("c://xampp/htdocs/sistemacompras/controllers/controladorPedido.php");
$obj = new controladorPedido(); 
$pedidos = $obj->index();

// Incluye la clase Cotizacion
require_once("c://xampp/htdocs/sistemacompras/controllers/controladorCotizacion.php");
$obj = new controladorCotizacion(); 
$cotizacionValues = $obj->getCotizacion($_GET['cotizacion_id']);
$cotizacionItems = $obj->getCotizacionItems($_GET['cotizacion_id']);



// Si se recibe una solicitud GET con un ID de actualización, obtiene los valores de la cotización y los detalles de los artículos
/*if (!empty($_GET['update_id']) && $_GET['update_id']) {
	$cotizacionValues = $cotizacion->getCotizacion($_GET['update_id']);
	$cotizacionItems = $cotizacion->getCotizacionItems($_GET['update_id']);
}*/

// Incluye el archivo index.php
require_once("c://xampp/htdocs/sistemacompras/index.php");
?>

<link href="css/style.css" rel="stylesheet">

<div class="container content-cotizacion">
    <h5>Editar Cotización #<?php echo $cotizacionValues['cotizacion_id'] ?></h5>
	<form action='edit.php' id="cotizacion-form" method="POST" class="cotizacion-form" role="form">
		<div class="load-animate animated fadeInUp">
			<input id="currency" type="hidden" value="$">
			<div class="row">
                <!-- Sección de formulario -->
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 pull-right">
                    <div class="form-group">
                        <!-- Selección de proveedor -->
                        <h6 for="">Proveedor</h6>
                        <select class="form-select" name="idproveedor" id="idproveedor" aria-label="Disabled select example" required>
                            <option value="" selected>Seleccionar Proveedor</option>
                            <!-- Ciclo para mostrar los proveedores -->
                            <?php foreach ($proveedores as $proveedor): 
                                // Si el proveedor seleccionado es igual al proveedor en el ciclo, se selecciona
                                if($proveedor['id'] == $cotizacionValues['idproveedor']){?>
                                    <option value="<?php echo $proveedor['id']; ?>" selected><?php echo $proveedor['Razon_Social']; ?></option>
                                <?php
                                } else{
                                // Si no, se muestra como opción normal
                                ?>
                                    <option value="<?php echo $proveedor['id']; ?>"><?php echo $proveedor['Razon_Social']; ?></option>
                                <?php
                                }
                                ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <!-- Campo de fecha y hora -->
                        <h6 for="">Fecha y hora de creación:</h6>
                        <input class="form-control" type="datetime-local" value="<?php echo date('Y-m-d\TH:i'); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <!-- Selección de estado -->
                        <h6 for="">Estado</h6>
                        <select class="form-select" name="estado" id="estado" aria-label="Disabled select example" required>
                            <option value="1" <?= $cotizacionValues['estado']=='1'? 'selected' : ''?>>Activo</option>
                            <option value="2" <?= $cotizacionValues['estado']=='2'? 'selected' : ''?>>Inactivo</option>
                            <option value="3" <?= $cotizacionValues['estado']=='3'? 'selected' : ''?>>Finalizado</option>
                            <option value="4" <?= $cotizacionValues['estado']=='4'? 'selected' : ''?>>Cancelado</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <!-- Selección de garantía -->
                        <h6 for="">Garantía:</h6>
                        <select class="form-select" name="garantia" id="garantia" aria-label="Disabled select example" required>
                            <option value="">------</option>
                            <option value="1" <?= $cotizacionValues['garantia']=='1'? 'selected' : ''?>>Si</option>
                            <option value="0" <?= $cotizacionValues['garantia']=='0'? 'selected' : ''?>>No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <!-- Selección de pedido relacionado -->
                        <h6 for="">Pedido relacionado</h6>
                        <select class="form-select" name="idPedido" id="idPedido" aria-label="Disabled select example" required>
                            <option value="" selected>Seleccionar pedido</option>
                            <!-- Ciclo para mostrar los pedidos -->
                            <?php foreach ($pedidos as $pedido): 
                                // Si el pedido seleccionado es igual al pedido en el ciclo, se selecciona automaticamente el pedido correspondiente
                                if($pedido['id'] == $cotizacionValues['idPedido']){?>
                                    <option value="<?php echo $pedido['id']; ?>" selected>Pedido #<?php echo $pedido['id']; ?></option>
                                <?php
                                } else{ //Si no hay un pedido seleccionado no se seleccionada nada
                                ?>
                                    <option value="<?php echo $pedido['id']; ?>">Pedido #<?php echo $pedido['id']; ?></option>
                                <?php
                                }
                                ?>
                            <?php endforeach; ?>
                        </select>
					</div>
					<div class="form-group">
                        <h6 for="">Valor cotización:</h6>
						<input type="text" class="form-control" name="valor" id="valor" placeholder="$" autocomplete="off" value="<?php echo $cotizacionValues['valor']; ?>" required>
					</div>
				</div>
			</div>
            <p><? echo "xd"; ?></p>
			<div class="">
                <div class="card mb-4 rounded-3 shadow-sm">
                    <!-- Inicio del bloque PHP -->
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <?php
                        // Creamos una variable para almacenar el HTML de las opciones de productos
                        $optionsHtml = '';
                        // Iteramos a través de la lista de productos y creamos una opción para cada uno
                        foreach ($productos as $producto) {
                            $optionsHtml .= '<option value="' . $producto['id'] . '">' . $producto['nombre'] . '</option>';
                        }
                        ?>
                        <div class="card-header py-3">
                            <h3 class="my-0 fw-normal">Detalles Cotización</h3>
                        </div>
                        <div class="my-0 fw-normal">
                            <!-- Creamos una tabla para los detalles de la cotización -->
                            <table class="table table-bordered table-hover" id="cotizacionItem">
                                <div class="row">
                                    <div class="">
                                        <!-- Creamos botones para agregar y eliminar filas -->
                                        <button class="btn btn-danger delete" id="removeRows" type="button">- Eliminar Seleccionados</button>
                                        <button class="btn btn-success" id="addRows" type="button">+ Agregar Item</button>
                                    </div>
                                </div>
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
                                        <select class="form-select" name="producto_id[]" id="producto_id_<?php echo $count; ?>" aria-label="Disabled select example" required>
                                            <option value="" selected>Seleccionar producto</option>
                                            <!-- Iteramos a través de la lista de productos y creamos una opción para cada uno -->
                                            <?php foreach ($productos as $producto): ?>
                                            <option value="<?php echo $producto['id']; ?>" <?php if ($producto_id == $producto['id']) { echo 'selected'; } ?>><?php echo $producto['nombre']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <!-- Creamos un campo de entrada para la cantidad de producto -->
                                    <td><input type="number" value="<?php echo $cotizacion_producto_cantidad;?>" name="cotizacion_producto_cantidad[]" id="cotizacion_producto_cantidad_<?php echo $count; ?>" class="form-control cotizacion_producto_cantidad" autocomplete="off" pattern="[0-9]" min="1" required></td>
                                </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                    <!-- Fin del bloque PHP -->
                </div>
            </div>
<script>
    $(document).on('click', '.cotizacion-save-btm', function() {
    // Validar que haya al menos una fila de productos en la tabla
    if ($('#cotizacionItem tr.itemRow').length === null) {
        alert('Debe agregar al menos un producto a la cotización.');
        return false; // Detener la ejecución de la función
    }
    // Si hay al menos una fila de productos, continuar con la ejecución de la función
    var btn = $(this);
    btn.button('loading');
    // Resto del código de la función...
});


</script>
			<div class="row">
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
					<h4>Descripción adicional: </h4>
					<div class="form-group">
						<textarea class="form-control txt" rows="5" name="descripcion" id="descripcion" placeholder="Observaciones" required><?php echo $cotizacionValues['descripcion']; ?></textarea>
					</div>
					<br>
					<div class="form-group">
						<input type="hidden" value="<?php echo $cotizacionValues['cotizacion_id']; ?>" class="form-control" name="cotizacion_id" id="cotizacion_id">
						<input data-loading-text="Guardando cambios..." type="submit" name="cotizacion_btn" value="Guardar cambios" class="btn btn-success submit_btn cotizacion-save-btm">
                        <a class="btn btn-danger" type="button" href="index.php">Cancelar</a>
                                    
					</div>

				</div>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					<span class="form-inline">
					</span>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</form>
</div>
</div>
<script>

$(document).ready(function(){
        // evento al hacer click en el botón "checkAll"
        $(document).on('click', '#checkAll', function() {          	
            $(".itemRow").prop("checked", this.checked);
        });	
        // evento al hacer click en cualquier casilla "itemRow"
        $(document).on('click', '.itemRow', function() {  	
            // si todas las casillas "itemRow" están seleccionadas, se marca la casilla "checkAll"
            if ($('.itemRow:checked').length == $('.itemRow').length) {
                $('#checkAll').prop('checked', true);
            } else {
                // de lo contrario, se desmarca la casilla "checkAll"
                $('#checkAll').prop('checked', false);
            }
        });  

        
        
        $(document).ready(function() {
  checkTableRows();
});

$(document).on('click', '.cotizacion-save-btm', function() {
  checkTableRows();
});

function checkTableRows() {
  var rowCount = $('#cotizacionItem .itemRow').length;

  if (rowCount === 0) {
    // Si no hay filas, cambiar el botón a rojo y quitar la propiedad "type"
    $('.cotizacion-save-btm')
      .removeClass('btn-success')
      .addClass('btn-danger')
      .removeAttr('type');
  } else {
    // Si hay filas, regresar el botón a su estado normal
    $('.cotizacion-save-btm')
      .removeClass('btn-danger')
      .addClass('btn-success')
      .attr('type', 'submit');
  }
}


$(document).on('click', '#addRows', function() {
  // Obtener la tabla y la cantidad de filas existentes
  var $table = $('#cotizacionItem');
  var rowCount = $table.find('.itemRow').length;

  // Obtener el HTML con las opciones de productos
  var optionsHtml = '<?php echo $optionsHtml; ?>';

  // Crear el HTML para la nueva fila
  var newRowHtml = '<tr>';
  newRowHtml += '<td><input class="itemRow" type="checkbox"></td>';
  newRowHtml += '<td><select class="form-select" name="producto_id[]" id="producto_id_' + rowCount + '" aria-label="Disabled select example" required>';
  newRowHtml += '<option value="" selected>Seleccionar producto</option>' + optionsHtml;
  newRowHtml += '</select></td>';
  newRowHtml += '<td><input type="number" name="cotizacion_producto_cantidad[]" id="cotizacion_producto_cantidad_' + rowCount + '" class="form-control cotizacion_producto_cantidad" pattern="[0-9]" min="1" required></td>';
  newRowHtml += '</tr>';

  // Agregar la nueva fila a la tabla
  $table.append(newRowHtml);

  // Verificar si la tabla ahora tiene filas o no
  checkTableRows();
});

        // evento al hacer click en el botón "removeRows"
        $(document).on('click', '#removeRows', function(){
            // se eliminan todas las filas con la clase "itemRow" seleccionadas
            $(".itemRow:checked").each(function() {
                $(this).closest('tr').remove();
            });
            // se desmarca la casilla "checkAll"
            $('#checkAll').prop('checked', false);
        });		
    });	
</script>