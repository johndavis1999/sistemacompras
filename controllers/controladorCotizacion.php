<?php
    // Incluyendo el modelo Cotizacion
    require_once("c://xampp/htdocs/sistemacompras/models/Cotizacion.php");
    
    // Definición de la clase controladorCotizacion
    class controladorCotizacion{
        // Variable privada para guardar el modelo Cotizacion
        private $model;
        
        // Constructor de la clase que instancia el modelo Cotizacion
        public function __construct(){
            $this->model = new Cotizacion();
        }
        
        // Método para obtener la lista de cotizaciones
        public function index(){
            // Si se puede obtener la lista de cotizaciones, se retorna la lista, de lo contrario se retorna falso
            return ($this->model->index()) ? $this->model->index() : false;
        }
        
        // Método para eliminar una cotización
        public function deleteCotizacion($cotizacion_id){
            // Si se puede eliminar la cotización, se redirige al índice, de lo contrario se redirige al índice
            return ($this->model->deleteCotizacion($cotizacion_id)) ? header("Location:index.php") : header("Location:index.php") ;
        }

        
        public function deleteCotizacionLogico($cotizacion_id){
            // Si se puede eliminar la cotización, se redirige al índice, de lo contrario se redirige al índice
            return ($this->model->deleteCotizacionLogico($cotizacion_id)) ? header("Location:index.php") : header("Location:index.php") ;
        }
        
        // Método para guardar una cotización
        public function saveCotizacion($idproveedor, $idPedido, $garantia, $valor, $estado, $descripcion){
            // Creando un array POST con los datos de la cotización y el producto
            $POST = array(
                'idproveedor' => $idproveedor,
                'idPedido' => $idPedido,
                'garantia' => $garantia,
                'valor' => $valor,
                'estado' => $estado,
                'descripcion' => $descripcion,
                'producto_id' => $_POST['producto_id'],
                'cotizacion_producto_cantidad' => $_POST['cotizacion_producto_cantidad']
            );
            // Guardando la cotización y obteniendo su id
            $id = $this->model->saveCotizacion($POST);
            // Redirigiendo al índice
            return header("Location:index.php");
        }

        public function getCotizacion($cotizacion_id){
            // Devuelve el resultado de la consulta
            return $this->model->getCotizacion($cotizacion_id);
        }

        public function getCotizacionItems($cotizacion_id){
            // Devuelve el resultado de la consulta
            return $this->model->getCotizacionItems($cotizacion_id);
        }

        // Método para actualizar una cotización
        public function updateCotizacion($cotizacion_id, $idproveedor, $idPedido, $garantia, $valor, $estado, $descripcion){
            // Creando un array POST con los datos actualizados de la cotización y el producto
            $POST = array(
                'cotizacion_id' => $cotizacion_id,
                'idproveedor' => $idproveedor,
                'idPedido' => $idPedido,
                'garantia' => $garantia,
                'valor' => $valor,
                'estado' => $estado,
                'descripcion' => $descripcion,
                'producto_id' => $_POST['producto_id'],
                'cotizacion_producto_cantidad' => $_POST['cotizacion_producto_cantidad']
            );
            if($_POST['producto_id']==null){
                header("Location: edit_cotizacion.php?cotizacion_id=$cotizacion_id");
            }else{
                // Actualizando la cotización
                $this->model->updateCotizacion($POST);
                // Redirigiendo al índice
                return header("Location:index.php"); 
            }
            
        }

        
    }
?> 
