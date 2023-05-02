<?php
// Se requiere el controlador de productos y se crea una instancia del mismo
require_once("c://xampp/htdocs/sistemacompras/controllers/controladorProductos.php");
$obj = new controladorProducto(); 
// Se obtiene un array con todos los productos del controlador de productos
$productos = $obj->index();
// Se requiere el controlador de proveedores y se crea una instancia del mismo
require_once("c://xampp/htdocs/sistemacompras/controllers/controladorProveedor.php");
$obj = new controladorProveedor(); 
// Se obtiene un array con todos los proveedores del controlador de proveedores
$proveedores = $obj->index();
// Se requiere el controlador de pedidos y se crea una instancia del mismo
require_once("c://xampp/htdocs/sistemacompras/controllers/controladorPedido.php");
$obj = new controladorPedido(); 
// Se obtiene un array con todos los pedidos del controlador de pedidos
$pedidos = $obj->index();
// Se requiere el archivo de inicio del sistema de compras
require_once("c://xampp/htdocs/sistemacompras/index.php");
?>
<div class="container content-cotizacion">
    <h5>Registrar Cotización</h5> <!-- Título del formulario -->
    <!-- Inicio del formulario -->
	<form action='addcotizacion.php' id="cotizacion-form" method="post" class="cotizacion-form" role="form">
		<!-- Animación de carga, que se muestra mientras se procesa el formulario -->
		<div class="load-animate animated fadeInUp">
			<!-- Fila para ubicar los campos de selección y entrada -->
			<div class="row">
				<!-- Columna que contiene los campos de selección y entrada -->
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 pull-right">
					<!-- Selector de proveedores -->
					<div class="form-group">
                        <h6 for="">Proveedor</h6>
                        <select class="form-select" name="idproveedor" id="idproveedor" aria-label="Disabled select example" required>
                            <option value="" selected>Seleccionar Proveedor</option>
                            <!-- Recorre array de proveedores -->
                            <?php foreach ($proveedores as $proveedor): ?>
                                <!-- Por cada proveedor en la array se agrega una nueva opcion asignando el id correspondiente -->
                                <option value="<?php echo $proveedor['id']; ?>"><?php echo $proveedor['Razon_Social']; ?></option>
                            <?php endforeach; ?>
                        </select>
					</div>
					<!-- Campo para la fecha y hora de creación -->
					<div class="form-group">
                        <h6 for="">Fecha y hora de creación:</h6>
                        <input class="form-control" type="datetime-local" value="<?php echo date('Y-m-d\TH:i'); ?>" readonly>
					</div>
					<!-- Selector de estado de la cotización -->
					<div class="form-group">
                        <h6 for="">Estado</h6>
                        <select class="form-select" name="estado" id="estado" aria-label="Disabled select example" required>
                            <option value="1" selected>Activa</option>
                            <option value="2">Inactiva</option>
                            <option value="3">Aprobada</option>
                            <option value="4">Rechazada</option>
                        </select>
					</div>
					<!-- Selector de garantía -->
					<div class="form-group">
                        <h6 for="">Garantía:</h6>
                        <select class="form-select" name="garantia" id="garantia" aria-label="Disabled select example" required>
                            <option value="">------</option>
                            <option value="1">Si</option>
                            <option value="0">No</option>
                        </select>
					</div>
					<!-- Selector de pedido relacionado -->
					<div class="form-group">
                        <h6 for="">Pedido relacionado</h6>
                        <select class="form-select" name="idPedido" id="idPedido" aria-label="Disabled select example" required>
                            <option value="" selected>Seleccionar pedido</option>
                            <!-- Recorre array de pedidos -->
                            <?php foreach ($pedidos as $pedido): ?>
                                <!-- Por cada pedido en la array se agrega una nueva opcion asignando el id correspondiente -->
                                <option value="<?php echo $pedido['id']; ?>"> Pedido #<?php echo $pedido['id']; ?></option>
                            <?php endforeach; ?>
                        </select>
					</div>
					<!-- Campo para el valor de la cotización -->
					<div class="form-group">
                        <h6 for="">Valor cotización:</h6>
						<input type="number" class="form-control" name="valor" id="valor" placeholder="$" autocomplete="off" pattern="[1-9]\d*(\.\d+)?" step="0.01" min="1" required>

					</div>
				</div>
			</div>
            <p><? echo "xd"; ?></p>
			<div class="">
                <div class="card mb-4 rounded-3 shadow-sm">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <?php
                            //Se recorre el arreglo de productos para construir las opciones del select
                            $optionsHtml = '';
                            foreach ($productos as $producto) {
                                $optionsHtml .= '<option value="' . $producto['id'] . '">' . $producto['nombre'] . '</option>';
                            }
                        ?>
                        <div class="card-header py-3">
                            <h3 class="my-0 fw-normal">Detalles Cotización</h3>
                        </div>
                        <div class="my-0 fw-normal">
                            <table class="table table-bordered table-hover" id="cotizacionItem">
                                <div class="row">
                                    <div class="">
                                        <!--Botones para agregar y eliminar filas de la tabla-->
                                        <button class="btn btn-danger delete" id="removeRows" type="button">- Eliminar Seleccionados</button>
                                        <button class="btn btn-success" id="addRows" type="button">+ Agregar Item</button>
                                    </div>
                                </div>
                                <tr>
                                    <!--Checkbox para seleccionar todas las filas de la tabla-->
                                    <th><input id="checkAll" class="formcontrol" type="checkbox"></th>
                                    <th>Producto</th>    
                                    <th>Cantidad</th>
                                </tr>
                                <small id="mensaje-error" style="color:red;">Importante; debe seleccionar al menos un producto para generar la cotización</small>
                                <!--Primera fila de la tabla con los campos del primer producto-->
                                <tr >
                                    <td><input class="itemRow" type="checkbox"></td>
                                    <td>
                                        <!--Select para seleccionar el producto recorriendo array de productos-->
                                        <select class="form-select" name="producto_id[]" id="producto_id_1" aria-label="Disabled select example" required>
                                            <option value="" selected>Seleccionar producto</option>
                                            <?php foreach ($productos as $producto): ?>
                                                <!-- Agrega una opcion por cada elemento devuelto -->
                                                <option value="<?php echo $producto['id']; ?>"><?php echo $producto['nombre']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <!--Input para ingresar la cantidad del producto-->
                                        <input type="number" name="cotizacion_producto_cantidad[]" id="cotizacion_producto_cantidad_1" class="form-control cotizacion_producto_cantidad" autocomplete="off" pattern="[0-9]" min="1" required>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

			<div class="row">
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <!-- Agrega descripcion al documento -->
					<h4>Descripcion adicional: </h4>
					<div class="form-group">
						<textarea class="form-control txt" rows="5" name="descripcion" id="descripcion" placeholder="Observaciones" required></textarea>
					</div>
					<div class="form-group">
                        <!-- Botonera para guardar documento o cancelar accion -->
						<input data-loading-text="Guardando factura..." type="submit" name="cotizacion_btn" value="Guardar Cotización" class="btn btn-success submit_btn cotizacion-save-btm">
                        <a class="btn btn-danger" type="button" href="index.php">Cancelar</a>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</form>
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



















        // función para actualizar el botón de guardar
/*function updateSaveButton() {
    var count = $(".itemRow").length;
    if(count == 0) {
        // si no hay filas, se cambia el color del botón y se cambia el texto
        $('.cotizacion-save-btm').removeClass('btn-success').addClass('btn-danger').val('No se puede guardar');
    } else {
        // si hay filas, se restaura el color y el texto original del botón
        $('.cotizacion-save-btm').removeClass('btn-danger').addClass('btn-success').val('Guardar Cotizacion');
    }
}

// evento al hacer click en el botón "addRows"
$(document).on('click', '#addRows', function() { 
    var count = $(".itemRow").length;
    // ...
    // se agrega el HTML al final de la tabla con id "cotizacionItem"
    $('#cotizacionItem').append(htmlRows);
    // se actualiza el botón de guardar
    updateSaveButton();
});

// evento al hacer click en el botón "removeRows"
$(document).on('click', '#removeRows', function() {
    $(".itemRow:checked").each(function() {
        $(this).closest('tr').remove();
    });
    // se actualiza el botón de guardar
    updateSaveButton();
});

// evento para actualizar el botón de guardar cada vez que se carga la página
$(document).ready(function() {
    updateSaveButton();
});*/

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
