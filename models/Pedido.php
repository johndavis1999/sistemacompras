<?php
    // Definimos la clase Pedido
    class Pedido{
        // Definimos la propiedad PDO que se usará para conectarse a la base de datos
        private $PDO;
        
        // Constructor que se ejecuta automáticamente al crear un objeto de la clase Pedido
        public function __construct()
        {
            // Incluimos el archivo de configuración de la base de datos
            require_once("c://xampp/htdocs/sistemacompras/config/db.php");
            // Creamos una instancia de la clase db para obtener la conexión a la base de datos
            $con = new db();
            // Obtenemos la conexión y la asignamos a la propiedad PDO de la clase Pedido
            $this->PDO = $con->conexion();
        }

        // Función para obtener todos los pedidos de la base de datos
        public function index(){
            // Preparamos la consulta SQL para obtener todos los pedidos
            $statement = $this->PDO->prepare("SELECT p.*, jb.nombre as jb_nombre , jb.apellido as jb_apellido 
                                                FROM pedido p 
                                                LEFT JOIN jefebodega jb ON p.IdJefeBodega = jb.id ");
            // Ejecutamos la consulta y comprobamos si se ha ejecutado correctamente
            return ($statement->execute()) ? $statement->fetchAll() : false;
            
            if ($statement->execute()) {
                $resultados = $statement->fetchAll();
                $con->cerrarConexion();
                return $resultados;
            } else {
                $con->cerrarConexion();
                return false;
            }
        }
        
        public function getPedido($pedido_id){
            $statement = $this->PDO->prepare("SELECT *
                                                    FROM pedido 
                                                    WHERE id = :pedido_id");
            $statement->bindParam(":pedido_id",$pedido_id);
            $statement->execute();
            // Devuelve el resultado de la consulta como un array asociativo
            return $statement->fetch(PDO::FETCH_ASSOC);
        }

        public function getPedidoItems($pedido_id){
            $statement = $this->PDO->prepare("SELECT detalle_pedido_item.*, producto.nombre as producto
                                                    FROM detalle_pedido_item 
                                                    LEFT JOIN producto ON detalle_pedido_item.producto_id = producto.id
                                                    WHERE pedido_id = :pedido_id");
            $statement->bindParam(":pedido_id", $pedido_id);
            $statement->execute();

            // Devuelve el resultado de la consulta como un array asociativo
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>
