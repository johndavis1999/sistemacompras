<?php
    class db {
        private $host = "localhost"; // Nombre del host donde se encuentra la base de datos
        private $dbname = "db_dsn08"; // Nombre de la base de datos
        private $user = "root"; // Nombre del usuario de la base de datos
        private $password = ""; // Contraseña del usuario de la base de datos
        private $PDO; // Variable para almacenar la conexión PDO
    
        public function __construct() {
            try {
                // Se realiza la conexión con la base de datos utilizando los datos proporcionados
                $this->PDO = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname,$this->user,$this->password);
            } catch(PDOException $e) {
                // Si ocurre un error en la conexión, se muestra un mensaje de error
                echo "Error al conectarse a la base de datos: " . $e->getMessage();
            }
        }
    
        // Método para obtener la conexión a la base de datos
        public function conexion() {
            return $this->PDO;
        }
    
        // Método para cerrar la conexión a la base de datos
        public function cerrarConexion() {
            $this->PDO = null;
        }

    }
?>
