<?php
require_once("c://xampp/htdocs/sistemacompras/index.php");

// Llamar controlador cotizacion
require_once("c://xampp/htdocs/sistemacompras/controllers/controladorPedido.php");
$obj = new controladorPedido(); 
$rows = $obj->index(); // Se llama al método index de la instancia de la clase controladorOrdenCompra para obtener una lista de órdenes de compra.
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<div id="cabecera-pagina">
    <h3>Pedidos Recibidos</h3>
          <!--<a type="button" class="btn btn-success" href="crear.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-plus" viewBox="0 0 16 16">
              <path d="M8 6.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 .5-.5z"/>
              <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/>
            </svg>
            Registrar Cotización Proveedor
          </a>
        </div>-->

        <hr class="divider">
        
        <div id="tabla-pagina">
            <!-- Comienzo de la tabla -->
            <table class="table table-striped">

            <!-- Cabecera de la tabla -->
            <thead class="table-secondary">
                <tr>
                    <th scope="col">Num. Ped.</th>
                    <th scope="col">Realizado Por:</th>
                    <th scope="col">Reakizado en:</th>
                    <th scope="col">OPCIONES</th>
                </tr>
            </thead>

            <!-- Cuerpo de la tabla -->
            <tbody>
                <?php if($rows): ?> <
                <?php foreach($rows as $row){ ?>
                    <tr>
                        <th class="col-1" scope="row"><?php echo $row['id']?></th> 
                        <td><?php echo $row['jb_nombre'] . ' ' . $row['jb_apellido']?></td>
                        <td><?php echo date('Y-m-d', strtotime($row['fechaHora'])) ?></td>
                        <td>
                            <a type="button" class="btn btn-success" href="/sistemacompras/views/documentos/cotizacion/generar.php?pedido_id=<?=$row["id"]?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-plus-fill" viewBox="0 0 16 16">
                                    <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM8.5 7v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 1 0z"/>
                                </svg>
                                Generar Cotización
                            </a>
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
