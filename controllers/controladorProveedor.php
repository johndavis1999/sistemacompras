<?php
    class controladorProveedor{
        private $model;

        // El constructor se ejecuta automáticamente al crear un objeto de la clase
        public function __construct()
        {
            // Se requiere el archivo que contiene la definición de la clase Proveedor
            require_once("c://xampp/htdocs/sistemacompras/models/Proveedor.php");

            // Se crea un objeto de la clase Proveedor
            $this->model = new Proveedor();
        }

        // Este método devuelve la lista de proveedores (si hay)
        public function index(){
            // Se verifica si el método index() de la clase Proveedor devuelve una lista válida
            // Si es así, se devuelve la lista; de lo contrario, se devuelve false
            return ($this->model->index()) ? $this->model->index() : false;
        }
    }
?>
