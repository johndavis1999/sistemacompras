-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-04-2023 a las 05:15:27
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_dsn08`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizacion`
--

CREATE TABLE `cotizacion` (
  `cotizacion_id` int(11) NOT NULL,
  `idproveedor` int(11) NOT NULL,
  `idPedido` int(11) NOT NULL,
  `garantia` tinyint(1) NOT NULL,
  `valor` float NOT NULL,
  `fecha_hora` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` int(100) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cotizacion`
--

INSERT INTO `cotizacion` (`cotizacion_id`, `idproveedor`, `idPedido`, `garantia`, `valor`, `fecha_hora`, `estado`, `descripcion`) VALUES
(1, 11, 1, 1, 5000, '2023-04-09 02:56:05', 1, 'Promocion + envio incluidos en el precio'),
(9, 25, 1, 0, 2000, '2023-04-09 03:07:03', 1, 'proveedor no da garantia'),
(10, 28, 1, 1, 3000, '2023-04-09 03:07:39', 111, 'proveedor ofrece de enganche 5 monitores adicionales con descuento'),
(11, 3, 2, 1, 5000, '2023-04-09 03:12:18', 1, 'Proveedor ofrece garantia y entrega gratis despues de 1 semana'),
(12, 8, 2, 0, 4000, '2023-04-09 03:13:13', 1, 'proveedor no da garantia pero ofrece entrega inmediata, no tiene todos los productoss solicitados');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_cotizacion_item`
--

CREATE TABLE `detalle_cotizacion_item` (
  `cotizacion_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cotizacion_producto_cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_cotizacion_item`
--

INSERT INTO `detalle_cotizacion_item` (`cotizacion_id`, `producto_id`, `cotizacion_producto_cantidad`) VALUES
(1, 4, 200),
(5, 21, 22),
(8, 5, 20),
(8, 11, 3),
(8, 26, 1),
(8, 19, 4),
(8, 23, 2),
(9, 5, 20),
(9, 11, 3),
(9, 26, 1),
(9, 19, 4),
(9, 23, 2),
(10, 5, 25),
(10, 11, 3),
(10, 26, 1),
(10, 19, 4),
(10, 23, 2),
(12, 33, 5),
(12, 34, 20),
(12, 29, 8),
(11, 10, 4),
(11, 33, 5),
(11, 34, 40),
(11, 29, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_orden_item`
--

CREATE TABLE `detalle_orden_item` (
  `orden_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `orden_item_cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_orden_item`
--

INSERT INTO `detalle_orden_item` (`orden_id`, `item_id`, `orden_item_cantidad`) VALUES
(1, 4, 200),
(2, 10, 4),
(2, 33, 5),
(2, 34, 40),
(2, 29, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido_item`
--

CREATE TABLE `detalle_pedido_item` (
  `pedido_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `pedido_producto_cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_pedido_item`
--

INSERT INTO `detalle_pedido_item` (`pedido_id`, `producto_id`, `pedido_producto_cantidad`) VALUES
(1, 5, 20),
(1, 11, 3),
(1, 26, 1),
(1, 19, 4),
(1, 23, 2),
(2, 10, 4),
(2, 33, 5),
(2, 34, 40),
(2, 29, 8),
(3, 8, 9),
(3, 22, 5),
(3, 20, 10),
(4, 12, 15),
(4, 15, 3),
(4, 9, 10),
(4, 6, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jefebodega`
--

CREATE TABLE `jefebodega` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  `cedula` int(10) NOT NULL,
  `celular` varchar(14) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `jefebodega`
--

INSERT INTO `jefebodega` (`id`, `nombre`, `apellido`, `cedula`, `celular`, `correo`, `estado`) VALUES
(1, 'Angel', 'Cruz', 985637482, '0956897412', 'angelcruz@gmail.com', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jefecompras`
--

CREATE TABLE `jefecompras` (
  `id` int(11) NOT NULL,
  `Nombre` varchar(250) NOT NULL,
  `Apellido` varchar(250) NOT NULL,
  `Identificacion` int(11) NOT NULL,
  `Estado` int(11) NOT NULL,
  `Correo` varchar(155) DEFAULT NULL,
  `Telefono` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `jefecompras`
--

INSERT INTO `jefecompras` (`id`, `Nombre`, `Apellido`, `Identificacion`, `Estado`, `Correo`, `Telefono`) VALUES
(1, 'Marcos', 'Palacios', 923896591, 1, 'nohaybolo@gmail.com', 1234567890);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_compra`
--

CREATE TABLE `orden_compra` (
  `orden_id` int(11) NOT NULL,
  `idjefecompra` int(11) NOT NULL,
  `fecha_hora` timestamp NOT NULL DEFAULT current_timestamp(),
  `cotizacion_id` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `orden_compra`
--

INSERT INTO `orden_compra` (`orden_id`, `idjefecompra`, `fecha_hora`, `cotizacion_id`, `estado`, `descripcion`) VALUES
(1, 1, '2023-04-09 02:56:28', 1, 3, 'Se solicita los productos para el dia lunes pago contraentrega'),
(2, 1, '2023-04-09 03:14:36', 11, 3, 'Se solicita con entrega urgente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id` int(11) NOT NULL,
  `IdJefeBodega` int(11) NOT NULL,
  `fechaHora` datetime NOT NULL,
  `Estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`id`, `IdJefeBodega`, `fechaHora`, `Estado`) VALUES
(1, 1, '2023-04-09 04:46:06', 1),
(2, 1, '2023-04-09 04:46:21', 1),
(3, 1, '2023-04-09 04:46:21', 1),
(4, 1, '2023-04-09 05:11:24', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `precio` float NOT NULL,
  `stock` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `marca` varchar(45) DEFAULT NULL,
  `idTipo` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `nombre`, `precio`, `stock`, `estado`, `marca`, `idTipo`, `codigo`) VALUES
(1, 'Teclado', 20, 200, 1, NULL, 0, '78945'),
(2, 'Mouse', 10, 100, 1, NULL, 0, '34345'),
(3, 'Iphone', 1000, 6800, 1, 'apple', 15, 'iphone13'),
(4, 'Samsung Galaxy', 300, 385, 0, 'samsung', 16, 'galaxys20'),
(5, 'LG Monitor', 100, 0, 1, 'LG', 15, 'LG4K27'),
(6, 'HP Laptop', 480, 2, 0, 'HP', 16, 'HPEnvy13'),
(7, 'Bose Speaker', 50, 8, 1, 'Bose', 15, 'BoseSoundlink'),
(8, 'Cámara Sony', 180, 1, 0, 'Sony', 16, 'sonyalpha7'),
(9, 'Asus Laptop', 1200, 503, 1, 'Asus', 15, 'AsusZenbook'),
(10, 'Xbox Series X', 700, 2, 0, 'Microsoft', 16, 'xboxseriesx'),
(11, 'PS5', 900, 5099, 1, 'Sony', 15, 'ps5'),
(12, 'Smartwatch', 250, 4, 0, 'Samsung', 16, 'galaxywatch4'),
(14, 'Headphones', 80, 10, 0, 'JBL', 16, 'jbltune'),
(15, 'MacBook Pro', 800, 1, 1, 'Apple', 15, 'macbookpro'),
(17, 'GoPro Camera', 150, 6, 1, 'GoPro', 15, 'goprohero9'),
(18, 'Auriculares Sony', 70, 5, 0, 'Sony', 16, 'sonyheadphones'),
(19, 'Smart TV LG', 1000, 2, 1, 'LG', 15, 'lgsmarttv'),
(20, 'Audífonos Inalámbricos', 70, 3, 0, 'Samsung', 16, 'samsungbuds'),
(21, 'Laptop HP', 1300, 0, 1, 'HP', 15, 'hpnotebook'),
(22, 'Tablet Samsung', 150, 0, 0, 'Samsung', 16, 'samsungtablet'),
(23, 'Proyector Epson', 160, -2640, 1, 'Epson', 15, 'epsonprojector'),
(24, 'Impresora Canon', 100, 4, 0, 'Canon', 16, 'canonprinter'),
(25, 'Bose Speaker', 90, 3, 1, 'Bose', 15, 'boseaudio'),
(26, 'Reloj inteligente Garmin', 300, 5, 0, 'Garmin', 16, 'garminwatch'),
(27, 'Teléfono Samsung', 200, 0, 1, 'Samsung', 15, 'samsunggalaxy'),
(28, 'Plancha de vapor', 60, 6, 0, 'Philips', 16, 'philipsiron'),
(29, 'Silla de escritorio', 170, 120, 1, 'Ikea', 15, 'ikeachair'),
(30, 'Refrigerador LG1231312312', 500, 1, 1, 'LG', 2, 'lgfridge'),
(31, 'Tablet Amazon Fire', 350, 0, 1, 'Amazon', 12, 'amazonfiretablet'),
(32, 'Altavoz Harman Kardon123123', 50, 3, 1, 'Harman Kardon', 0, 'hkaudiospeaker'),
(33, 'Cafetera Nespresso2', 70, 4, 1, 'Nespresso', 0, 'nespressomachine'),
(34, 'Micrófono Rode1asasdassad', 30, 1, 1, 'Rode', 0, 'rodemic'),
(35, 'Smartwatch Fitbitasds', 90, 0, 1, 'Fitbit', 0, 'fitbitsmartwatch'),
(37, 'Consola de juegos retro1', 100, 1, 1, 'Retro Games', 0, 'retroconsole'),
(43, 'prueba tipo1', 12, 12, 1, 'asdas', 12, 'sdasd'),
(64, 'pc gamer', 800, 10, 0, 'Asus', 4, 'PCG-AS01'),
(66, 'kukfvhjfhj', 8, 5, 0, '', 0, '852');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id` int(11) NOT NULL,
  `Razon_Social` text NOT NULL,
  `RUC` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id`, `Razon_Social`, `RUC`) VALUES
(1, 'Computron S.A.', '0911127528001'),
(2, 'El Rosado S.A.', '0912345678001'),
(3, 'MegaMax S.A.', '0912345678001'),
(4, 'Tech Solutions S.A.', '0912345678001'),
(5, 'GreenFields S.A.', '0912345678001'),
(6, 'InnovaSoft S.A.', '0912345678001'),
(7, 'Blue Ocean S.A.', '0912345678001'),
(8, 'Express Cargo S.A.', '0912345678001'),
(9, 'Quality Foods S.A.', '0912345678001'),
(10, 'BeautyZone S.A.', '0912345678001'),
(11, 'SmartVision S.A.', '0912345678001'),
(12, 'GlobalTrade S.A.', '0912345678001'),
(13, 'Muebles Modernos S.A.', '0912345678001'),
(14, 'Tecnología y Servicios S.A.', '0912345678001'),
(15, 'Cultivos y Agroindustria S.A.', '0912345678001'),
(16, 'Ingeniería y Construcciones S.A.', '0912345678001'),
(17, 'Comercializadora de Productos S.A.', '0912345678001'),
(18, 'Distribuidora de Productos Médicos S.A.', '0912345678001'),
(19, 'Productos de Limpieza y Mantenimiento S.A.', '0912345678001'),
(20, 'Servicios de Consultoría S.A.', '0912345678001'),
(21, 'Industria Textil S.A.', '0912345678001'),
(22, 'Alimentos y Bebidas S.A.', '0912345678001'),
(23, 'Soluciones Empresariales S.A.', '0912345678001'),
(24, 'Productos de Belleza S.A.', '0912345678001'),
(25, 'Importadora de Maquinarias S.A.', '0912345678001'),
(26, 'Materiales de Construcción S.A.', '0912345678001'),
(27, 'Agencia de Viajes y Turismo S.A.', '0912345678001'),
(28, 'Servicios de Mantenimiento Industrial S.A.', '0912345678001'),
(29, 'Cultivos Orgánicos S.A.', '0912345678001'),
(30, 'Venta de Equipos Médicos S.A.', '0912345678001'),
(31, 'Comercializadora de Productos Agrícolas S.A.', '0912345678001'),
(32, 'Servicios de Publicidad y Marketing S.A.', '0912345678001');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
  ADD PRIMARY KEY (`cotizacion_id`);

--
-- Indices de la tabla `jefecompras`
--
ALTER TABLE `jefecompras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `orden_compra`
--
ALTER TABLE `orden_compra`
  ADD PRIMARY KEY (`orden_id`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
  MODIFY `cotizacion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `jefecompras`
--
ALTER TABLE `jefecompras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `orden_compra`
--
ALTER TABLE `orden_compra`
  MODIFY `orden_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
