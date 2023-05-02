<?php
    /**
     * La clase Producto representa la entidad producto en el sistema.
     * 
     * Esta clase contiene métodos para obtener la lista de productos desde la base de datos.
     * 
     */
    class Producto{
        /**
         * La conexión a la base de datos.
         */
        private $PDO;
        
        /**
         * El constructor de la clase Producto.
         * 
         * Se encarga de establecer la conexión con la base de datos.
         * 
         */
        public function __construct()
        {
            require_once("c://xampp/htdocs/sistemacompras/config/db.php");
            $con = new db();
            $this->PDO = $con->conexion();
        }
        
        /**
         * Obtiene la lista de productos desde la base de datos.
         * 
         * etorna un array con los productos obtenidos desde la base de datos,
         *                      o false en caso de error.
         */
        public function index(){
            require_once("c://xampp/htdocs/sistemacompras/config/db.php");
            $con = new db();
            $PDO = $con->conexion();
        
            $statement = $PDO->prepare("SELECT * 
                                          FROM producto p
                                          ORDER BY p.id DESC");
        
            if ($statement->execute()) {
                $resultados = $statement->fetchAll();
                $con->cerrarConexion();
                return $resultados;
            } else {
                $con->cerrarConexion();
                return false;
            }
        }
        
    }
?>
