<?php
// Definimos la clase OrdenCompra
class OrdenCompra{
        private $PDO; // Conexión a la base de datos
        //atributos cabecera doc
        private $orden_id;
        private $cotizacion_id;
        private $idjefecompra;
        private $estado;
        private $descripcion;
        //atributos detalle doc
        private $item_id;
        private $orden_item_cantidad;
        // Constructor de la clase
        public function __construct()
        {
            // Incluimos el archivo de configuración de la base de datos
            require_once("c://xampp/htdocs/sistemacompras/config/db.php");
            $con = new db(); // Creamos una instancia de la clase db (que contiene la conexión a la base de datos)
            $PDO = $con->conexion();
            $this->PDO = $con->conexion(); // Asignamos la conexión a la variable $PDO
        }
        
        // Función para cerrar la conexión a la base de datos
        public function cerrarConexion() {
            $this->PDO = null;
        }
        
        // Función para obtener todas las órdenes de compra de la base de datos
        public function index(){
            // Preparamos la consulta SQL para obtener las órdenes de compra, uniendo la tabla 'orden_compra' con la tabla 'jefecompras' para obtener el nombre y apellido del jefe de compras responsable de cada orden, y ordenando los resultados por ID de orden descendente
            $statement = $this->PDO->prepare("SELECT o.*, jc.Nombre as jc_nombre , jc.Apellido as jc_apellido 
                                   FROM orden_compra o 
                                   LEFT JOIN jefecompras jc ON o.idjefecompra = jc.id 
                                   WHERE o.estado != 111
                                   ORDER BY o.orden_id DESC");

            // Ejecutamos la consulta y devolvemos los resultados si la ejecución fue exitosa, o 'false' en caso contrario
            return ($statement->execute()) ? $statement->fetchAll() : false;
            // Nota: El código que sigue después del return nunca se ejecuta, ya que el return termina la función
        }
        
        // Función para eliminar una orden de compra de la base de datos
        public function deleteOrden($orden_id){
            // Incluimos el archivo de configuración de la base de datos
            require_once("c://xampp/htdocs/sistemacompras/config/db.php");
            $con = new db(); // Creamos una instancia de la clase db (que contiene la conexión a la base de datos)
            $PDO = $con->conexion(); // Creamos una nueva conexión a la base de datos
            
            // Preparamos la consulta SQL para eliminar la orden de compra con el ID especificado
            $stament = $this->PDO->prepare("DELETE FROM orden_compra WHERE orden_id = :orden_id");
            $stament->bindParam(":orden_id",$orden_id); // Asignamos el valor del ID a eliminar a la variable :orden_id
            if ($stament->execute()) {
                // Si la ejecución de la consulta fue exitosa, llamamos a la función deleteOrdenItems para eliminar los items asociados a esta orden
                $this->deleteOrdenItems($orden_id, $PDO);
                $con->cerrarConexion(); // Cerramos la conexión a la base de datos
                return true; // Devolvemos 'true' indicando que la orden se eliminó correctamente
            } else {
                $con->cerrarConexion(); // Cerramos la conexión a la base de datos
                return false; // Devolvemos 'false' indicando que la eliminación de la orden falló
            }
        }
        
        // Función para eliminar una orden de compra de la base de datos
        public function deleteOrdenLogico($orden_id){
            // Incluimos el archivo de configuración de la base de datos
            require_once("c://xampp/htdocs/sistemacompras/config/db.php");
            $con = new db(); // Creamos una instancia de la clase db (que contiene la conexión a la base de datos)
            $PDO = $con->conexion(); // Creamos una nueva conexión a la base de datos
            
            // Preparamos la consulta SQL para eliminar la orden de compra con el ID especificado
            $stament = $PDO->prepare("UPDATE orden_compra SET estado = 111 WHERE orden_id = :orden_id");
            $stament->bindParam(":orden_id",$orden_id); // Asignamos el valor del ID a eliminar a la variable :orden_id
            if ($stament->execute()) {
                $con->cerrarConexion(); // Cerramos la conexión a la base de datos
                return true; // Devolvemos 'true' indicando que la orden se eliminó correctamente
            } else {
                $con->cerrarConexion(); // Cerramos la conexión a la base de datos
                return false; // Devolvemos 'false' indicando que la eliminación de la orden falló
            }
        }
        
        // Función para eliminar los items asociados a una orden de compra de la base de

        public function deleteOrdenItems($orden_id, $PDO){
            // Se prepara una consulta SQL para eliminar registros de la tabla detalle_orden_item 
            // que tengan el orden_id igual al valor que se pasa como parámetro a la función.
            $stament = $this->PDO->prepare("
                DELETE FROM detalle_orden_item
                WHERE orden_id = :orden_id");
            
            // Se vincula el valor del parámetro $orden_id con el marcador de posición de la consulta.
            $stament->bindParam(":orden_id",$orden_id);
            
            // Se ejecuta la consulta preparada.
            $stament->execute();
        }

        public function saveOrden($POST){
            $this->orden_id = $POST['orden_id'];
            $this->idjefecompra = $POST['idjefecompra'];
            $this->cotizacion_id = $POST['cotizacion_id'];
            $this->estado = $POST['estado'];
            $this->descripcion = $POST['descripcion'];
            // Se prepara una consulta SQL para insertar un registro en la tabla orden_compra
            // con los valores que se pasan como parámetro en el array $POST.
            $stament = $this->PDO->prepare("INSERT INTO orden_compra (idjefecompra, cotizacion_id, estado, descripcion) 
                        VALUES (:idjefecompra, :cotizacion_id, :estado, :descripcion)");
            
            // Se vinculan los valores de los campos de la tabla con los valores del array $POST.
            $stament->bindParam(':idjefecompra', $POST['idjefecompra']);
            $stament->bindParam(':cotizacion_id', $POST['cotizacion_id']);
            $stament->bindParam(':estado', $POST['estado']);
            $stament->bindParam(':descripcion', $POST['descripcion']);
            
            // Se ejecuta la consulta preparada.
            $stament->execute();
            
            // Se obtiene el ID del registro recién insertado en la tabla orden_compra.
            $lastInsertId = $this->PDO->lastInsertId();
            
            // Se recorre un ciclo for para insertar cada item de la orden de compra en la tabla detalle_orden_item.
            for ($i = 0; $i < count($POST['item_id']); $i++) {
                // Se prepara una consulta SQL para insertar un registro en la tabla detalle_orden_item
                // con los valores correspondientes de la orden de compra y el item actual del ciclo.
                $statement = $this->PDO->prepare("INSERT INTO detalle_orden_item (orden_id, item_id, orden_item_cantidad) 
                                VALUES (:orden_id, :item_id, :orden_item_cantidad)");
                
                // Se vinculan los valores de los campos de la tabla con los valores de la orden de compra y el item actual del ciclo.
                $statement->bindParam(':orden_id', $lastInsertId);
                $statement->bindParam(':item_id', $POST['item_id'][$i]);
                $statement->bindParam(':orden_item_cantidad', $POST['orden_item_cantidad'][$i]);
                
                // Se ejecuta la consulta preparada.
                $statement->execute();
            }
            // Se cierra la conexión con la base de datos.
            $this->cerrarConexion(); 
            // Se devuelve el ID de la orden de compra recién creada.
            return $lastInsertId;
        }
        
        public function getOrdenCompra($orden_id){
            $statement = $this->PDO->prepare("SELECT oc.*, p.Razon_Social, p.ruc 
                                                FROM orden_compra oc 
                                                LEFT JOIN cotizacion c ON oc.cotizacion_id = c.cotizacion_id 
                                                LEFT JOIN proveedor p ON c.idproveedor = p.id 
                                                WHERE oc.orden_id =:orden_id;");
            $statement->bindParam(":orden_id",$orden_id);
            $statement->execute();
            // Devuelve el resultado de la consulta como un array asociativo
            return $statement->fetch(PDO::FETCH_ASSOC);
        }

        public function getOrdenCompraItems($orden_id){
            $statement = $this->PDO->prepare("SELECT detalle_orden_item.*, producto.nombre as producto
                                                    FROM detalle_orden_item 
                                                    LEFT JOIN producto ON detalle_orden_item.item_id = producto.id
                                                    WHERE orden_id = :orden_id");
            $statement->bindParam(":orden_id", $orden_id);
            $statement->execute();
            // Devuelve el resultado de la consulta como un array asociativo
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        
        public function updateOrden($POST){
            
            $con = new db(); // Se crea un objeto de la clase db para establecer una conexión con la base de datos
            $PDO = $con->conexion(); // Se obtiene una instancia de PDO para realizar consultas en la base de datos
            // Asignar los valores de POST a las propiedades de la clase
            $this->cotizacion_id = $POST['cotizacion_id'];
            $this->estado = $POST['estado'];
            $this->descripcion = $POST['descripcion'];
            $orden_id = $POST['orden_id'];
        
            // Preparar la consulta SQL para actualizar la cotización en la base de datos
            $stament = $this->PDO->prepare("UPDATE orden_compra SET 
                cotizacion_id = :cotizacion_id,
                estado = :estado,
                descripcion = :descripcion
                WHERE orden_id = :orden_id");
        
            // Vincular los parámetros con los valores correspondientes
            $stament->bindParam(':cotizacion_id', $POST['cotizacion_id']);
            $stament->bindParam(':estado', $POST['estado']);
            $stament->bindParam(':descripcion', $POST['descripcion']);
            $stament->bindParam(':orden_id', $POST['orden_id']);
            $this->deleteOrdenItems($orden_id, $PDO);
            // Ejecutar la consulta SQL
            $stament->execute();    
            //seccion para manipular detalles
            for ($i = 0; $i < count($POST['item_id']); $i++) {
                $stament = $this->PDO->prepare("INSERT INTO detalle_orden_item (orden_id, item_id, orden_item_cantidad) 
                VALUES ('" . $POST['orden_id'] . "', '" . $POST['item_id'][$i] . "', '" . $POST['orden_item_cantidad'][$i] . "')");
                $stament->execute();
            }
        }

            


        
    }

?>