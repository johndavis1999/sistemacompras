<?php
    /**
     * La clase Proveedor representa la entidad proveedor en la base de datos
     * y provee métodos para interactuar con ella.
     */
    class Proveedor{
        private $PDO;

        /**
         * El constructor de la clase se encarga de establecer la conexión
         * con la base de datos a través de la clase db.
         */
        public function __construct()
        {
            require_once("c://xampp/htdocs/sistemacompras/config/db.php");
            $con = new db();
            $this->PDO = $con->conexion();
        }

        /**
         * El método index() retorna todos los registros de proveedores
         * almacenados en la base de datos.
         *
         *Un arreglo con todos los registros de proveedores o false si la consulta falla.
         */
        public function index(){
            $statement = $this->PDO->prepare("SELECT * FROM proveedor");
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
    }
?>