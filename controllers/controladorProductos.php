<?php
    class controladorProducto {
        private $model;

        // El constructor se encarga de cargar el modelo de Producto
        public function __construct() {
            require_once("c://xampp/htdocs/sistemacompras/models/Producto.php");
            $this->model = new Producto();
        }

        // Método index que devuelve todos los productos de la base de datos
        public function index() {
            return ($this->model->index()) ? $this->model->index() : false;
        }
    }
?>
