<?php
    class controladorPedido{
        private $model;
        public function __construct()
        {
            // Se requiere el archivo que contiene la clase Pedido
            require_once("c://xampp/htdocs/sistemacompras/models/Pedido.php");
            // Se crea una instancia del modelo Pedido
            $this->model = new Pedido();
        }
        public function index(){
            // Se llama al método index() del modelo Pedido
            // Si se recibe un resultado se retorna, de lo contrario se retorna falso
            return ($this->model->index()) ? $this->model->index() : false;
        }

        public function getPedido($pedido_id){
            // Devuelve el resultado de la consulta
            return $this->model->getPedido($pedido_id);
        }

        public function getPedidoItems($pedido_id){
            // Devuelve el resultado de la consulta
            return $this->model->getPedidoItems($pedido_id);
        }
    }
?>
