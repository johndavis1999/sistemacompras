<?php
require_once("c://xampp/htdocs/sistemacompras/index.php");

// Llamar controlador cotizacion
require_once("c://xampp/htdocs/sistemacompras/controllers/controladorCotizacion.php");
$obj = new controladorCotizacion(); 
$rows = $obj->index(); // Se llama al método index de la instancia de la clase controladorOrdenCompra para obtener una lista de órdenes de compra.
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<div id="cabecera-pagina">
    <h3>Cotizaciones</h3>
    <!--
          <a type="button" class="btn btn-success" href="crear.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-plus" viewBox="0 0 16 16">
              <path d="M8 6.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 .5-.5z"/>
              <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/>
            </svg>
            Registrar Cotización Proveedor
          </a>-->
        </div>

        <hr class="divider">
        
        <div id="tabla-pagina">
            <!-- Comienzo de la tabla -->
            <table class="table table-striped">

            <!-- Cabecera de la tabla -->
            <thead class="table-secondary">
                <tr>
                    <th scope="col">Num. Cot.</th>
                    <th scope="col">PROVEEDOR</th>
                    <th scope="col">GARANTÍA</th>
                    <th scope="col">PEDIDO</th>
                    <th scope="col">VALOR</th>
                    <th scope="col">FECHA</th>
                    <th scope="col">ESTADO</th>
                    <th scope="col">OPCIONES</th>
                </tr>
            </thead>

            <!-- Cuerpo de la tabla -->
            <tbody>
                <?php if($rows): ?> <!-- Comprobar si hay filas en la base de datos -->
                <?php foreach($rows as $row){ ?> <!-- Ciclo para recorrer todas las filas -->
                    <tr>
                        <th class="col-1" scope="row"><?php echo $row['cotizacion_id']?></th> <!-- Mostrar ID de cotización -->
                        <td><?php echo $row['p_nombre']?></td> <!-- Mostrar nombre del proveedor -->
                        <td class="col-1"><?php echo $row['garantia']==1 ? 'SI': 'NO';?></td> <!-- Mostrar si hay garantía o no -->
                        <td><a href="#">Pedido #<?php echo $row['idPedido']?></a></td> <!-- Mostrar el número del pedido y proporcionar un enlace a la página de edición de pedidos -->
                        <th>$<?php echo $row['valor']?></th> <!-- Mostrar el valor de la cotización -->
                        <td><?php echo date('Y-m-d', strtotime($row['fecha_hora'])) ?></td> <!-- Mostrar la fecha de la cotización -->
                        <td>
                            <?php
                                // Mostrar el estado de la cotización
                                if($row['estado']==1) {
                                    echo "Activo";
                                } elseif($row['estado']==2) {
                                    echo "Inactivo";
                                } elseif($row['estado']==3) {
                                    echo "Aprobado";
                                } elseif($row['estado']==4) {
                                    echo "Rechazado";
                                }
                            ?>
                        </td>
                        <td class="col-">
                            <!-- Crea boton para editar con redirecionamiento a pantalla de edicion capturando informacion del documento en base al id -->
                            <a type="button" class="btn btn-secondary" href="edit_cotizacion.php?cotizacion_id=<?=$row["cotizacion_id"]?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                    <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"></path>
                                </svg>
                            </a>
                            <!-- Crea boton de eliminar que acciona modal pasando el id de la posicion del array seleccionado-->
                            <button type="button" class="btn btn-danger"  data-bs-toggle="modal" data-bs-target="#cotizacion_id<?=$row['cotizacion_id']?>" id="<?= $row["cotizacion_id"]?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"></path>
                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"></path>
                                </svg>
                            </button>
                            <a type="button" class="btn btn-primary" href="print_doc.php?cotizacion_id=<?=$row["cotizacion_id"]?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf" viewBox="0 0 16 16">
                                    <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                                    <path d="M4.603 14.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.697 19.697 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.712 5.712 0 0 1-.911-.95 11.651 11.651 0 0 0-1.997.406 11.307 11.307 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.266.266 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.71 12.71 0 0 1 1.01-.193 11.744 11.744 0 0 1-.51-.858 20.801 20.801 0 0 1-.5 1.05zm2.446.45c.15.163.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.876 3.876 0 0 0-.612-.053zM8.078 7.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z"/>
                                </svg>
                            </a>
                            
                            <a type="button" class="btn btn-success" href="/sistemacompras/views/documentos/ordencompra/generar.php?cotizacion_id=<?=$row["cotizacion_id"]?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-plus-fill" viewBox="0 0 16 16">
                                    <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM8.5 7v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 1 0z"/>
                                </svg>
                                Generar orden
                            </a>
                            <!-- Modal Eliminar -->
                            <div class="modal fade" id="cotizacion_id<?=$row['cotizacion_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">¿Desea eliminar la Cotización ID:<?php echo $row['cotizacion_id'];?>?</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Una vez eliminado no se podra recuperar el registro
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cerrar</button>
                                            <!-- Al hacer clic en eliminar se redirecciona a delete.php capturando el id del documento -->
                                            <a href="delete.php?cotizacion_id=<?= $row['cotizacion_id']?>" class="btn btn-danger">Eliminar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="12" class="text-center">No hay documentos ingresados</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- Modal acciones-->
  
