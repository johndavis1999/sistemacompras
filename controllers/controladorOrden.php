<?php
    // Importamos el modelo de OrdenCompra
    require_once("c://xampp/htdocs/sistemacompras/models/OrdenCompra.php");

    class controladorOrdenCompra{
        // Creamos una variable privada para instanciar el modelo de OrdenCompra
        private $model;
        
        // Constructor que inicializa el modelo de OrdenCompra
        public function __construct()
        {
            $this->model = new OrdenCompra();
        }

        // Función que llama al modelo para obtener todas las órdenes de compra y las retorna
        public function index(){
            return ($this->model->index()) ? $this->model->index() : false;
        }

        // Función que llama al modelo para eliminar una orden de compra y redirige a la página principal
        public function deleteOrden($ordenId){
            return ($this->model->deleteOrden($ordenId)) ? header("Location:index.php") : header("Location:index.php") ;
        }
        // Función que llama al modelo para eliminar una orden de compra y redirige a la página principal
        public function deleteOrdenLogico($ordenId){
            return ($this->model->deleteOrdenLogico($ordenId)) ? header("Location:index.php") : header("Location:index.php") ;
        }
        
        // Función que recibe los datos de una orden de compra, los almacena en un arreglo y llama al modelo para guardarlos
        public function saveOrden($idjefecompra, $cotizacion_id, $estado, $descripcion){
            $POST = array(
                'idjefecompra' => $idjefecompra,
                'cotizacion_id' => $cotizacion_id,
                'estado' => $estado,
                'descripcion' => $descripcion,
                'item_id' => $_POST['item_id'],
                'orden_item_cantidad' => $_POST['orden_item_cantidad']
            );
            $id = $this->model->saveOrden($POST);
            return header("Location:index.php");
        }

        public function getOrdenCompra($orden_id){
            // Devuelve el resultado de la consulta
            return $this->model->getOrdenCompra($orden_id);
        }

        public function getOrdenCompraItems($orden_id){
            // Devuelve el resultado de la consulta
            return $this->model->getOrdenCompraItems($orden_id);
        }
        public function updateOrden($cotizacion_id, $orden_id, $estado, $descripcion){
            // Creando un array POST con los datos actualizados de la cotización y el producto
            $POST = array(
                'cotizacion_id' => $cotizacion_id,
                'orden_id' => $orden_id,
                'estado' => $estado,
                'descripcion' => $descripcion,
                'item_id' => $_POST['item_id'],
                'orden_item_cantidad' => $_POST['orden_item_cantidad']
            );
            // Actualizando la cotización
            $this->model->updateOrden($POST);
            // Redirigiendo al índice
            return header("Location:index.php");
            
        }
    }
?>
