<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css">
    <link rel="stylesheet" type="text/css" href="/sistemacompras/components/css/stylenav.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!--este es el script para desplegar la sidebar y cerrarla lo copie y lo pege de un video xD-->
  </head>
<body>
    <div class="sidebar retract">
      <div class="logo-details">
          <i class='bx bxs-school bx-md bx bx-menu'></i>
          <span class="logo_name">Sistema</span>
      </div>  
      <hr class="sidebar-divider my-0">
      <ul class="nav-links">
          <li>
          <a href="#">
              <i class='bx bx-home'></i>
              <span class="link_name">Inicio</span>
          </a>
          <ul class="sub-menu blank">
              <li><a class="link_name" href="#">Inicio</a></li>
          </ul>
          </li>
          <hr class="sidebar-divider">
          <li>
            <div class="iocn-link">
              <a href="#">
                <i class='bx bxs-group'></i>
                <span class="link_name">Personas</span>
              </a>
              <i class='bx bxs-chevron-down arrow' ></i>
            </div>
            <ul class="sub-menu">
              <li><a class="link_name" href="#">Personas</a></li>
              <li><a href="#">Bodega</a></li>
              <li><a href="#">Compras</a></li>
              <li><a href="#">Proveedores</a></li>
            </ul>
          </li>
          <hr class="sidebar-divider">
          <li>
            <div class="iocn-link">
              <a href="#">
                <i class='bx bx-file-blank'></i>
                <span class="link_name">Documentos</span>
              </a>
              <i class='bx bxs-chevron-down arrow' ></i>
            </div>
            <ul class="sub-menu">
              <li><a class="link_name" href="#">Documentos</a></li>
              <li><a href="/sistemacompras/views/documentos/pedidos/index.php">Pedidos</a></li>
              <li><a href="/sistemacompras/views/documentos/cotizacion/index.php">Cotizaciones</a></li>
              <li><a href="/sistemacompras/views/documentos/ordencompra/index.php">Ordenes de Compras</a></li>
            </ul>
          </li>
          <hr class="sidebar-divider">
          <li>
            <a href="#">
                <i class='bx bx-basket'></i>
                <span class="link_name">Productos</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="#">Productos</a></li>
            </ul>
          </li>
          <hr class="sidebar-divider">
      </ul>
    </div>
    <script>
        let arrow = document.querySelectorAll(".arrow");
        for (var i = 0; i < arrow.length; i++) {
            arrow[i].addEventListener("click", (e)=>{
            let arrowParent = e.target.parentElement.parentElement;//selecting main parent of arrow
            arrowParent.classList.toggle("showMenu");
            });
        }
        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".bx-menu");
        console.log(sidebarBtn);
        sidebarBtn.addEventListener("click", ()=>{
            sidebar.classList.toggle("retract");
            document.querySelector(".contenido").classList.toggle("retract"); // agregar la clase .retract al elemento .contenido cuando el menú está cerrado
        });
    </script>
    <!--Esta parte es la seccion en blanco  donde queria poner las tablas pero no me salió xD -->
    <section class="home-section">
      <div>