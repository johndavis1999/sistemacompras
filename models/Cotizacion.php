<?php
    class Cotizacion{
        private $PDO; // variable privada para almacenar la conexión a la base de datos
        //atributos cabecera doc
        private $idproveedor; // variable privada para almacenar el ID del proveedor
        private $idPedido; // variable privada para almacenar el ID del pedido
        private $garantia; // variable privada para almacenar la garantía de la cotización
        private $valor; // variable privada para almacenar el valor de la cotización
        private $estado; // variable privada para almacenar el estado de la cotización
        private $descripcion; // variable privada para almacenar la descripción de la cotización
        //atributos detalle doc
        private $cotizacion_id; // variable privada para almacenar el ID de la cotización
        private $producto_id; // variable privada para almacenar el ID del producto en detalle de cotización
        private $cotizacion_producto_cantidad; // variable privada para almacenar la cantidad del producto en detalle de cotización

        public function __construct()
        {
            require_once("c://xampp/htdocs/sistemacompras/config/db.php"); // incluir el archivo de configuración de la base de datos
            $con = new db(); // crear un objeto de conexión a la base de datos
            $PDO = $con->conexion();
            $this->PDO = $con->conexion(); // almacenar la conexión en la variable privada $PDO
            
        }

        public function cerrarConexion() {
            $this->PDO = null; // cerrar la conexión establecida
        }
        
        public function saveCotizacion($POST){
            // Asignar los valores de POST a las propiedades de la clase
            $this->idproveedor = $POST['idproveedor'];
            $this->idPedido = $POST['idPedido'];
            $this->garantia = $POST['garantia'];
            $this->valor = $POST['valor'];
            $this->estado = $POST['estado'];
            $this->descripcion = $POST['descripcion'];
            // Preparar la consulta SQL para insertar la cotización en la base de datos
            $stament = $this->PDO->prepare("INSERT INTO cotizacion (idproveedor, idPedido, garantia, valor, estado, descripcion) 
                        VALUES (:idproveedor, :idPedido, :garantia, :valor, :estado, :descripcion)");
            // Vincular los parámetros con los valores correspondientes
            $stament->bindParam(':idproveedor', $POST['idproveedor']);
            $stament->bindParam(':idPedido', $POST['idPedido']);
            $stament->bindParam(':garantia', $POST['garantia']);
            $stament->bindParam(':valor', $POST['valor']);
            $stament->bindParam(':estado', $POST['estado']);
            $stament->bindParam(':descripcion', $POST['descripcion']);
            // Ejecutar la consulta SQL
            $stament->execute();
            // Obtener el último ID insertado en la tabla cotizacion
            $lastInsertId = $this->PDO->lastInsertId();
            // Recorrer los productos seleccionados y sus cantidades
            for ($i = 0; $i < count($POST['producto_id']); $i++) {
                // Preparar la consulta SQL para insertar los detalles de la cotización en la tabla detalle_cotizacion_item
                $statement = $this->PDO->prepare("INSERT INTO detalle_cotizacion_item (cotizacion_id, producto_id, cotizacion_producto_cantidad) 
                                VALUES (:cotizacion_id, :producto_id, :cotizacion_producto_cantidad)");
                // Vincular los parámetros con los valores correspondientes
                $statement->bindParam(':cotizacion_id', $lastInsertId);
                $statement->bindParam(':producto_id', $POST['producto_id'][$i]);
                $statement->bindParam(':cotizacion_producto_cantidad', $POST['cotizacion_producto_cantidad'][$i]);
                // Ejecutar la consulta SQL
                $statement->execute();
            }
        
            // Cerrar la conexión a la base de datos después de ejecutar la función
            $this->cerrarConexion();
        
            // Devolver el último ID insertado en la tabla cotizacion
            return $lastInsertId;
        }

        public function index(){
            // Preparar la declaración SQL para obtener todas las cotizaciones y sus proveedores
            $statement = $this->PDO->prepare("SELECT c.*, p.Razon_Social as p_nombre  
                                   FROM cotizacion c 
                                   LEFT JOIN proveedor p ON c.idproveedor = p.id 
                                   WHERE c.estado != 111
                                   ORDER BY c.cotizacion_id  DESC");

            // Ejecutar la declaración SQL y devolver el resultado si la ejecución es exitosa
            return ($statement->execute()) ? $statement->fetchAll() : false;

            if ($statement->execute()) {
                $resultados = $statement->fetchAll(); // obtener todos los resultados y almacenarlos en la variable $resultados
                $con->cerrarConexion(); // Devolver los resultados obtenidos de la base de datos
                return $resultados; // Devolver los resultados obtenidos de la base de datos
            } else { // Si la ejecución de la declaración SQL no es exitosa, devolver falso
                $con->cerrarConexion(); // Cerrar la conexión después de ejecutar la función
                return false;
            }
        }

        public function deleteCotizacion($cotizacion_id){
            require_once("c://xampp/htdocs/sistemacompras/config/db.php"); // Se requiere el archivo de configuración de la base de datos
            $con = new db(); // Se crea un objeto de la clase db para establecer una conexión con la base de datos
            $PDO = $con->conexion(); // Se obtiene una instancia de PDO para realizar consultas en la base de datos
        
            $stament = $this->PDO->prepare("DELETE FROM cotizacion WHERE cotizacion_id = :cotizacion_id"); // Se prepara la consulta para eliminar la cotización con el id especificado
            $stament->bindParam(":cotizacion_id",$cotizacion_id); // Se enlaza el parámetro de la consulta con el valor del id de la cotización a eliminar
            if ($stament->execute()) { // Si se ejecuta la consulta exitosamente
                $this->deleteCotizacionItems($cotizacion_id, $PDO); // Se llama a la función deleteCotizacionItems() para eliminar los detalles de la cotización
                $con->cerrarConexion(); // Se cierra la conexión con la base de datos
                return true; // Se devuelve true para indicar que se eliminó la cotización y sus detalles exitosamente
            } else {
                $con->cerrarConexion(); // Se cierra la conexión con la base de datos
                return false; // Se devuelve false para indicar que no se pudo eliminar la cotización
            }
        }
        
        // Función auxiliar que elimina los detalles de una cotización en la tabla detalle_cotizacion_item
        public function deleteCotizacionItems($cotizacion_id, $PDO)
        {
            // Se prepara la consulta para eliminar los detalles de la cotización de la tabla detalle_cotizacion_item
            $stament = $PDO->prepare("DELETE FROM detalle_cotizacion_item WHERE cotizacion_id = :cotizacion_id");
            $stament->bindParam(":cotizacion_id",$cotizacion_id);
            $stament->execute();
        }

        
        public function deleteCotizacionLogico($cotizacion_id){
            require_once("c://xampp/htdocs/sistemacompras/config/db.php"); // Se requiere el archivo de configuración de la base de datos
            $con = new db(); // Se crea un objeto de la clase db para establecer una conexión con la base de datos
            $PDO = $con->conexion(); // Se obtiene una instancia de PDO para realizar consultas en la base de datos
        
            $stament = $PDO->prepare("UPDATE cotizacion SET estado = 111 WHERE cotizacion_id = :cotizacion_id"); // Se prepara la consulta para actualizar el estado de la cotización con el id especificado
            $stament->bindParam(":cotizacion_id", $cotizacion_id); // Se enlaza el parámetro de la consulta con el valor del id de la cotización a actualizar
            if ($stament->execute()) { // Si se ejecuta la consulta exitosamente
                $con->cerrarConexion(); // Se cierra la conexión con la base de datos
                return true; // Se devuelve true para indicar que se actualizó el estado de la cotización exitosamente
            } else {
                $con->cerrarConexion(); // Se cierra la conexión con la base de datos
                return false; // Se devuelve false para indicar que no se pudo actualizar el estado de la cotización
            }
        }
        

        public function updateCotizacion($POST){
            
            $con = new db(); // Se crea un objeto de la clase db para establecer una conexión con la base de datos
            $PDO = $con->conexion(); // Se obtiene una instancia de PDO para realizar consultas en la base de datos
            // Asignar los valores de POST a las propiedades de la clase
            $this->idproveedor = $POST['idproveedor'];
            $this->idPedido = $POST['idPedido'];
            $this->garantia = $POST['garantia'];
            $this->valor = $POST['valor'];
            $this->estado = $POST['estado'];
            $this->descripcion = $POST['descripcion'];
            $cotizacion_id = $POST['cotizacion_id'];
        
            // Preparar la consulta SQL para actualizar la cotización en la base de datos
            $stament = $this->PDO->prepare("UPDATE cotizacion SET 
                idproveedor = :idproveedor,
                idPedido = :idPedido,
                garantia = :garantia,
                valor = :valor,
                estado = :estado,
                descripcion = :descripcion
                WHERE cotizacion_id = :cotizacion_id");
        
            // Vincular los parámetros con los valores correspondientes
            $stament->bindParam(':idproveedor', $POST['idproveedor']);
            $stament->bindParam(':idPedido', $POST['idPedido']);
            $stament->bindParam(':garantia', $POST['garantia']);
            $stament->bindParam(':valor', $POST['valor']);
            $stament->bindParam(':estado', $POST['estado']);
            $stament->bindParam(':descripcion', $POST['descripcion']);
            $stament->bindParam(':cotizacion_id', $POST['cotizacion_id']);
            $this->deleteCotizacionItems($cotizacion_id, $PDO);
            // Ejecutar la consulta SQL
            $stament->execute();
            //seccion para manipular detalles
            for ($i = 0; $i < count($POST['producto_id']); $i++) {
                $stament = $this->PDO->prepare("INSERT INTO detalle_cotizacion_item (cotizacion_id, producto_id, cotizacion_producto_cantidad) 
                VALUES ('" . $POST['cotizacion_id'] . "', '" . $POST['producto_id'][$i] . "', '" . $POST['cotizacion_producto_cantidad'][$i] . "')");
                $stament->execute();
            }
        }
        
        public function getCotizacion($cotizacion_id){
            $statement = $this->PDO->prepare("SELECT cotizacion.*, proveedor.Razon_Social, proveedor.ruc 
                                                    FROM cotizacion 
                                                    LEFT JOIN proveedor ON cotizacion.idproveedor = proveedor.id 
                                                    WHERE cotizacion_id = :cotizacion_id");
            $statement->bindParam(":cotizacion_id",$cotizacion_id);
            $statement->execute();
            // Devuelve el resultado de la consulta como un array asociativo
            return $statement->fetch(PDO::FETCH_ASSOC);
        }

        public function getCotizacionItems($cotizacion_id){
            $statement = $this->PDO->prepare("SELECT detalle_cotizacion_item.*, producto.nombre as producto
                                                    FROM detalle_cotizacion_item 
                                                    LEFT JOIN producto ON detalle_cotizacion_item.producto_id = producto.id
                                                    WHERE cotizacion_id = :cotizacion_id");
            $statement->bindParam(":cotizacion_id", $cotizacion_id);
            $statement->execute();

            // Devuelve el resultado de la consulta como un array asociativo
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }

        
        

        
        

    }
?>