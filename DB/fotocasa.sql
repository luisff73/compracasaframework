-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 04-06-2024 a las 07:26:36
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `fotocasa`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `ACTUALIZA_CARRITO` (IN `p_id_vivienda` INT, IN `p_username` VARCHAR(255))   BEGIN
    IF NOT EXISTS (SELECT 1 FROM purchase WHERE id_vivienda = p_id_vivienda AND username = p_username) THEN
        INSERT INTO `purchase`(`id_vivienda`, `vivienda_name`, `id_user`, `username`, `quantity`, `vivienda_price`, `operation_type`) 
        SELECT v.id_vivienda, v.vivienda_name, u.id_user, u.username, 1, v.vivienda_price, 'VP' 
        FROM viviendas v, users u 
        WHERE v.id_vivienda = p_id_vivienda AND u.username = p_username;
    ELSE
        UPDATE purchase
        SET quantity = quantity + 1
        WHERE id_vivienda = p_id_vivienda AND username = p_username;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ACTUALIZA_LIKES` (IN `id_vivienda_p` INT, IN `id_user_p` VARCHAR(50))   BEGIN
    DECLARE EXISTE INT;
    SET EXISTE=(SELECT COUNT(*) FROM LIKES WHERE ID_USERNAME=id_user_p AND ID_VIVIENDA=id_vivienda_p);
    IF EXISTE > 0 THEN
        DELETE FROM LIKES WHERE ID_USERNAME=id_user_p AND ID_VIVIENDA=id_vivienda_p;
    ELSE
        INSERT INTO LIKES (ID_USERNAME, ID_VIVIENDA) VALUES (id_user_p, id_vivienda_p);
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CIERRA_CARRITO` (IN `p_username` VARCHAR(255), IN `p_id_vivienda` INT, IN `p_cantidad` INT)   BEGIN

    -- Obtenemos el stock actual de la vivienda
    DECLARE v_stock INT;
    SELECT v.stock INTO v_stock
    FROM viviendas v
    WHERE v.id_vivienda = p_id_vivienda;

    -- Comprobamos si la cantidad del carrito es menor o igual al stock de la vivienda
    IF p_cantidad <= v_stock THEN
        -- Actualizamos el campo operation_type en la tabla purchase para pasarlo a factura
        UPDATE purchase p
        SET p.operation_type = 'VF', p.vivienda_price=p_cantidad*p.vivienda_price, p.quantity=p_cantidad
        WHERE p.username = p_username
        AND p.id_vivienda = p_id_vivienda
        AND p.operation_type = 'VP';

        -- Descontamos la cantidad del stock en la tabla viviendas
        UPDATE viviendas v
        SET v.stock = v.stock - p_cantidad
        WHERE v.id_vivienda = p_id_vivienda;
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adapted`
--

CREATE TABLE `adapted` (
  `id_adapted` int(11) NOT NULL,
  `adapted` varchar(50) NOT NULL DEFAULT 'Adaptada',
  `id_vivienda` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `adapted`
--

INSERT INTO `adapted` (`id_adapted`, `adapted`, `id_vivienda`) VALUES
(1, 'Adaptada', 4),
(2, 'Adaptada', 1111125),
(3, 'Adaptada', 26),
(4, 'Adaptada', 27),
(5, 'Adaptada', 28),
(6, 'Adaptada', 5),
(7, 'Adaptada', 24),
(8, 'Adaptada', 29),
(9, 'Adaptada', 30),
(10, 'Adaptada', 31),
(11, 'Adaptada', 32),
(12, 'Adaptada', 38),
(13, 'Adaptada', 39),
(14, 'Adaptada', 40),
(15, 'Adaptada', 41),
(16, 'Adaptada', 7),
(17, 'Adaptada', 19),
(18, 'Adaptada', 20),
(19, 'Adaptada', 21),
(20, 'Adaptada', 22),
(21, 'Adaptada', 23),
(22, 'Adaptada', 42);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category`
--

CREATE TABLE `category` (
  `id_category` int(50) NOT NULL,
  `category_name` varchar(250) NOT NULL,
  `image_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `category`
--

INSERT INTO `category` (`id_category`, `category_name`, `image_name`) VALUES
(1, 'Piso', 'view/img/piso_category.jpg'),
(2, 'Adosado', '	\nview/img/adosado_category.jpg'),
(3, 'Parcela', '	\nview/img/parcela_category.jpg'),
(4, 'Local', '	\nview/img/local_category.jpg'),
(6, 'Chalet', '	\nview/img/chalet_category.jpg'),
(7, 'Trastero', '	\nview/img/trastero_category.jpg'),
(8, 'Nave Industrial', 'view/img/nave_industrial_category.jpg'),
(9, 'Duplex', 'view/img/duplex_category.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `city`
--

CREATE TABLE `city` (
  `id_city` int(50) NOT NULL,
  `city_name` varchar(250) NOT NULL,
  `image_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `city`
--

INSERT INTO `city` (`id_city`, `city_name`, `image_name`) VALUES
(1, 'Albaida', 'view/img/albaida.jpg'),
(2, 'Fontanars', 'view/img/fontanars.jpg'),
(3, 'Ontinyent', 'view/img/ontinyent.jpg'),
(4, 'Bocairent', 'view/img/bocairent.jpg'),
(5, 'Agullent', 'view/img/agullent.jpg'),
(6, 'Paterna', 'view/img/paterna.jpg'),
(7, 'Valencia', 'view/img/valencia.jpg'),
(8, 'Xativa', 'view/img/xativa.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `images`
--

CREATE TABLE `images` (
  `id_image` int(50) NOT NULL,
  `id_vivienda` int(50) NOT NULL,
  `image_name` varchar(250) NOT NULL,
  `image_category` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `images`
--

INSERT INTO `images` (`id_image`, `id_vivienda`, `image_name`, `image_category`) VALUES
(1, 4, 'view/img/piso1.jpg', 'casa'),
(2, 4, 'view/img/piso2.jpg', 'casa'),
(3, 4, 'view/img/piso3.jpg', 'casa'),
(4, 4, 'view/img/piso4.jpg', 'casa'),
(5, 4, 'view/img/piso5.jpg', 'casa'),
(6, 5, 'view/img/adosado1.jpg', 'casa'),
(7, 5, 'view/img/adosado2.jpg', 'casa'),
(8, 5, 'view/img/adosado3.jpg', 'casa'),
(9, 5, 'view/img/adosado4.jpg', 'casa'),
(10, 5, 'view/img/adosado5.jpg', 'casa'),
(11, 6, 'view/img/duplex1.jpg', 'duplex'),
(12, 6, 'view/img/duplex2.jpg', 'duplex'),
(13, 6, 'view/img/duplex3.jpg', 'duplex'),
(14, 6, 'view/img/duplex4.jpg', 'duplex'),
(15, 6, 'view/img/duplex5.jpg', 'duplex'),
(16, 7, 'view/img/duplex6.jpg', 'duplex');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `likes`
--

CREATE TABLE `likes` (
  `id_vivienda` int(50) NOT NULL,
  `id_username` varchar(25) NOT NULL,
  `like` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `likes`
--

INSERT INTO `likes` (`id_vivienda`, `id_username`, `like`) VALUES
(4, 'luisito', 0),
(5, 'antonio', 0),
(5, 'josefina', 0),
(5, 'luisito', 0),
(5, 'paquito', 0),
(7, 'antonio', 0),
(7, 'fernandin', 0),
(8, 'antonio', 0),
(8, 'josefina', 0),
(8, 'luisito', 0),
(8, 'paquito', 0),
(9, 'josefina', 0),
(9, 'luisito', 0),
(10, 'antonio', 0),
(10, 'josefina', 0),
(10, 'luisito', 0),
(10, 'paquito', 0),
(11, 'fernandin', 0),
(11, 'paquito', 0),
(12, 'antonio', 0),
(12, 'fernandin', 0),
(12, 'josefina', 0),
(12, 'luisito', 0),
(13, 'antonio', 0),
(13, 'josefina', 0),
(13, 'luisito', 0),
(13, 'paquito', 0),
(14, 'fernandin', 0),
(15, 'antonio', 0),
(15, 'fernandin', 0),
(15, 'josefina', 0),
(15, 'luisito', 0),
(15, 'paquito', 0),
(16, 'josefina', 0),
(16, 'luisito', 0),
(16, 'paquito', 0),
(19, 'antonio', 0),
(19, 'fernandin', 0),
(19, 'josefina', 0),
(19, 'luisito', 0),
(19, 'paquito', 0),
(20, 'antonio', 0),
(20, 'fernandin', 0),
(20, 'josefina', 0),
(20, 'luisito', 0),
(20, 'paquito', 0),
(22, 'antonio', 0),
(22, 'fernandin', 0),
(22, 'josefina', 0),
(22, 'luisito', 0),
(22, 'paquito', 0),
(23, 'antonio', 0),
(23, 'fernandin', 0),
(23, 'josefina', 0),
(23, 'luisito', 0),
(23, 'paquito', 0),
(24, 'antonio', 0),
(24, 'fernandin', 0),
(24, 'luisito', 0),
(25, 'antonio', 0),
(25, 'paquito', 0),
(26, 'antonio', 0),
(26, 'fernandin', 0),
(26, 'josefina', 0),
(26, 'luisito', 0),
(26, 'paquito', 0),
(27, 'antonio', 0),
(27, 'fernandin', 0),
(27, 'josefina', 0),
(27, 'luisito', 0),
(27, 'paquito', 0),
(28, 'antonio', 0),
(28, 'fernandin', 0),
(28, 'paquito', 0),
(29, 'josefina', 0),
(29, 'luisito', 0),
(29, 'paquito', 0),
(30, 'antonio', 0),
(30, 'fernandin', 0),
(30, 'josefina', 0),
(30, 'luisito', 0),
(31, 'antonio', 0),
(31, 'fernandin', 0),
(31, 'paquito', 0),
(32, 'antonio', 0),
(32, 'paquito', 0),
(33, 'antonio', 0),
(33, 'fernandin', 0),
(33, 'josefina', 0),
(33, 'luisito', 0),
(33, 'paquito', 0),
(34, 'antonio', 0),
(34, 'fernandin', 0),
(34, 'josefina', 0),
(34, 'luisito', 0),
(35, 'antonio', 0),
(35, 'fernandin', 0),
(35, 'josefina', 0),
(36, 'fernandin', 0),
(36, 'josefina', 0),
(36, 'luisito', 0),
(36, 'paquito', 0),
(37, 'antonio', 0),
(37, 'fernandin', 0),
(37, 'paquito', 0),
(38, 'antonio', 0),
(38, 'fernandin', 0),
(39, 'antonio', 0),
(39, 'fernandin', 0),
(39, 'josefina', 0),
(39, 'luisito', 0),
(39, 'paquito', 0),
(40, 'antonio', 0),
(40, 'fernandin', 0),
(40, 'josefina', 0),
(40, 'luisito', 0),
(40, 'paquito', 0),
(42, 'antonio', 0),
(42, 'fernandin', 0),
(42, 'josefina', 0),
(42, 'luisito', 0),
(42, 'paquito', 0),
(43, 'antonio', 0),
(43, 'fernandin', 0),
(43, 'josefina', 0),
(43, 'luisito', 0),
(43, 'paquito', 0),
(44, 'josefina', 0),
(44, 'luisito', 0),
(45, 'fernandin', 0),
(45, 'josefina', 0),
(45, 'luisito', 0),
(45, 'paquito', 0),
(46, 'josefina', 0),
(46, 'luisito', 0),
(46, 'paquito', 0),
(47, 'antonio', 0),
(47, 'fernandin', 0),
(47, 'josefina', 0),
(47, 'luisito', 0),
(47, 'paquito', 0),
(48, 'antonio', 0),
(48, 'fernandin', 0),
(48, 'paquito', 0),
(59, 'fernandin', 0),
(59, 'luisito', 0),
(60, 'antonio', 0),
(60, 'fernandin', 0),
(60, 'josefina', 0),
(60, 'paquito', 0),
(61, 'josefina', 0),
(61, 'luisito', 0),
(62, 'antonio', 0),
(62, 'fernandin', 0),
(62, 'josefina', 0),
(62, 'luisito', 0),
(62, 'paquito', 0),
(63, 'antonio', 0),
(63, 'fernandin', 0),
(63, 'josefina', 0),
(63, 'paquito', 0),
(64, 'fernandin', 0),
(64, 'luisito', 0),
(65, 'antonio', 0),
(65, 'josefina', 0),
(65, 'luisito', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `most_visited`
--

CREATE TABLE `most_visited` (
  `id_vivienda` int(50) NOT NULL,
  `visitas` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `most_visited`
--

INSERT INTO `most_visited` (`id_vivienda`, `visitas`) VALUES
(4, 158),
(5, 47),
(4, 158),
(5, 47),
(6, 37),
(7, 28),
(8, 28),
(9, 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operation`
--

CREATE TABLE `operation` (
  `id_operation` int(50) NOT NULL,
  `operation_name` varchar(250) NOT NULL,
  `image_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `operation`
--

INSERT INTO `operation` (`id_operation`, `operation_name`, `image_name`) VALUES
(13, 'Compra', 'view/img/compra.jpg'),
(14, 'Venta', 'view/img/venta.jpg'),
(15, 'Alquiler', 'view/img/alquiler.jpg'),
(16, 'Alquiler opcion a Compra', 'view/img/alquiler_compra.jpg'),
(17, 'Alquier Habitaciones', 'view/img/alquiler_habitaciones.jpg'),
(18, 'Compra Naves ', 'view/img/compra_nave.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `purchase`
--

CREATE TABLE `purchase` (
  `id_vivienda` int(50) NOT NULL,
  `vivienda_name` varchar(250) NOT NULL,
  `id_user` int(30) NOT NULL,
  `username` varchar(250) NOT NULL,
  `quantity` int(50) NOT NULL,
  `vivienda_price` int(50) NOT NULL,
  `operation_type` varchar(10) NOT NULL,
  `contador` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `purchase`
--

INSERT INTO `purchase` (`id_vivienda`, `vivienda_name`, `id_user`, `username`, `quantity`, `vivienda_price`, `operation_type`, `contador`) VALUES
(19, 'Chalet en la montaña', 12, 'luisito', 1, 200000, 'VF', 20004),
(37, 'Parcela en Paterna', 12, 'luisito', 1, 14324, 'VF', 20001),
(39, 'Local en Ontinyent', 12, 'luisito', 1, 3435, 'VF', 20002),
(44, 'Duplex en Valencia', 12, 'luisito', 2, 211500, 'VF', 20003);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `type`
--

CREATE TABLE `type` (
  `id_type` int(50) NOT NULL,
  `type_name` varchar(250) NOT NULL,
  `image_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `type`
--

INSERT INTO `type` (`id_type`, `type_name`, `image_name`) VALUES
(7, 'A estrenar', 'view/img/a_estrenar.jpg'),
(8, 'Buen estado', 'view/img/buen_estado.jpg'),
(9, 'A reformar', 'view/img/a_reformar.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id_user` int(30) NOT NULL,
  `username` varchar(250) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `type_user` varchar(50) DEFAULT NULL,
  `avatar` varchar(250) DEFAULT NULL,
  `token_email` varchar(250) NOT NULL,
  `activate` int(10) NOT NULL DEFAULT 0,
  `attempts` int(10) NOT NULL DEFAULT 3,
  `tipo_login` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `email`, `type_user`, `avatar`, `token_email`, `activate`, `attempts`, `tipo_login`) VALUES
(12, 'luisito', '$2y$12$NpNteudxVguB8zBk/86xL.5eKCSiOyoeFNa5rWzJ3.jjAXuIZgzMa', '1jvrluis@hotmail.com', 'client', 'https://i.pravatar.cc/500?u=e180ce24ee0680d10937341695b92bbe', '', 1, 1, 'local'),
(13, 'fernandin', '$2y$12$olnGKNANkqSZMG6NLsDmduzKSV20nTlo4Etl2SfTdjCVzPJkLtglW', 'fernandin@hotrmail.com', 'client', 'https://i.pravatar.cc/500?u=88e4eb8edb044b44c30e8784014c9a05', '', 1, 3, 'local'),
(14, 'paquito', '$2y$12$PMhhFpZ3Q/C0PLFpDEHmo.Lbpsqi2fWrDeKTNxX8XuzVEvrnnLZC2', 'paquito@hotmail.com', 'client', 'https://i.pravatar.cc/500?u=8fd36194cbf128399e5b94634c6aaadd', '', 1, 3, 'local'),
(79, 'antonio', '$2y$10$/A/22x.sK8dlSoAHI2YEbuTygoZC9kzKdIpdm6vxfeHJAiPnXMyhG', 'jvrluis@hotmail.com', 'client', 'https://i.pravatar.cc/500?u=2b2bc99149c1eb1b555598291e1008d8', '', 1, 3, 'local'),
(100, 'antonios', '$2y$10$86hMTwlx1J2Tmy8ogryprup9KapztpPXNMxC0ua9wgnZjVOXxUhsK', 'jvrluis@hotmail.coms', 'client', 'https://i.pravatar.cc/500?u=2b2bc99149c1eb1b555598291e1008d8', 'cf27642bb19851dc4cbf', 0, 3, 'local'),
(101, 'jvrluis', ' ', 'jvrluis@gmail.com', 'client', 'https://lh3.googleusercontent.com/a/ACg8ocJ0cMP9yG5YJsLYrPXVcBdry4cKnzZSevc8R1pKpWb7U-KPWDU7=s96-c', '', 1, 3, 'gmail.com'),
(103, 'josele', '$2y$10$n0alHsxG1IN2ETADH5EtMO/RpgIixbQPLY6lllMfwZ5EKz0eiNA0K', 'josele@hotmail.com', 'client', 'https://i.pravatar.cc/500?u=83326004f6b544b7b36e515a2d08eb93', '2f31bf0cb9c241a74b3e', 0, 3, 'local');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `viviendas`
--

CREATE TABLE `viviendas` (
  `id_vivienda` int(50) NOT NULL,
  `vivienda_name` varchar(250) NOT NULL,
  `id_city` int(50) NOT NULL,
  `state` varchar(250) NOT NULL,
  `status` varchar(250) NOT NULL,
  `vivienda_price` int(50) NOT NULL,
  `description` varchar(250) NOT NULL,
  `image_name` varchar(250) NOT NULL,
  `m2` int(50) NOT NULL,
  `habitaciones` int(50) NOT NULL,
  `baños` int(10) NOT NULL,
  `long` float NOT NULL,
  `lat` float NOT NULL,
  `id_type` int(50) NOT NULL,
  `id_operation` int(50) NOT NULL,
  `id_category` int(50) NOT NULL,
  `id_image` int(50) NOT NULL,
  `stock` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `viviendas`
--

INSERT INTO `viviendas` (`id_vivienda`, `vivienda_name`, `id_city`, `state`, `status`, `vivienda_price`, `description`, `image_name`, `m2`, `habitaciones`, `baños`, `long`, `lat`, `id_type`, `id_operation`, `id_category`, `id_image`, `stock`) VALUES
(4, 'Piso en Albaida', 1, 'Valencia', 'Disponible', 138000, 'Encantador piso de 2 habitaciones con diseño moderno y luminoso. Cocina totalmente equipada, amplio salón con vistas panorámicas. Ubicación céntrica, cerca de servicios y transporte público. Ideal para aquellos que buscan comodidad y estilo en un hog', 'view/img/piso1.jpg', 90, 5, 2, -0.5791, 38.9098, 9, 13, 1, 1, 0),
(5, 'Adosado en Albaida', 1, 'Valencia', 'Disponible', 256000, 'Agradable adosado de 3 dormitorios con diseño contemporáneo. Cocina equipada, luminoso salón y patio privado. Ubicación conveniente cerca de servicios y transporte. Perfecto para aquellos que buscan confort y estilo en un hogar adosado moderno.', 'view/img/adosado1.jpg', 120, 2, 3, -0.5756, 38.9122, 8, 14, 2, 1, 3),
(6, 'Duplex en Bocairent', 4, 'Valencia', 'Disponible', 156000, 'Agradable duplex de 3 dormitorios con diseño contemporáneo. Cocina equipada, luminoso salón y patio privado. Ubicación conveniente cerca de servicios y transporte. Perfecto para aquellos que buscan confort y estilo en un hogar adosado moderno.', 'view/img/duplex1.jpg', 139, 4, 2, -0.572052, 38.774, 7, 14, 9, 1, 0),
(7, 'Chalet en Fontanars', 2, 'Valencia', 'Disponible', 132500, 'Agradable Chalet de 8 dormitorios con diseño moderno. Cocina equipada, luminoso salón y patio privado. Ubicación conveniente cerca de servicios y transporte. Perfecto para aquellos que buscan confort y estilo en un hogar adosado moderno.', 'view/img/chalet1.jpg', 380, 6, 3, -0.696433, 38.8054, 9, 14, 6, 1, 3),
(8, 'Trastero \n economico', 2, 'Valencia', 'Disponible', 20000, 'Trastero espacioso en venta.', 'view/img/trastero1.jpg', 10, 1, 0, -0.711086, 38.8191, 9, 14, 7, 1, 3),
(9, 'Trastero a reformar', 1, 'Valencia', 'Disponible', 20000, 'Trastero espacioso en venta.', 'view/img/trastero2.jpg', 10, 1, 0, -5.66861, 37.4057, 9, 14, 7, 1, 3),
(10, 'Trastero comunitario', 2, 'Valencia', 'Disponible', 18000, 'Trastero espacioso en venta.', 'view/img/trastero3.jpg', 120, 1, 0, -0.712631, 38.8091, 9, 15, 7, 1, 3),
(11, 'Trastero con posiblidades', 3, 'Valencia', 'Disponible', 8000, 'Trastero espacioso en venta.', 'view/img/trastero4.jpg', 13, 1, 0, -0.604614, 38.8536, 9, 16, 7, 1, 3),
(12, 'Amplio trastero', 4, 'Valencia', 'Disponible', 2500, 'Trastero espacioso en venta.', 'view/img/trastero5.jpg', 20, 1, 0, -0.559496, 38.7621, 9, 14, 7, 1, 3),
(13, 'Trastero en venta', 5, 'Valencia', 'Disponible', 12000, 'Trastero espacioso en venta.', 'view/img/trastero6.jpg', 12, 1, 0, -0.547625, 38.8004, 9, 15, 7, 1, 3),
(14, 'Nave Industrial totalmente reformada.', 1, 'Valencia', 'Disponible', 200000, 'Venta: Nave Industrial 1000m², zona industrial prime.', 'view/img/nave1.jpg', 1000, 1, 0, -5.68336, 37.4113, 9, 18, 8, 1, 3),
(15, 'Nave Industrial en poligono Alcocer', 2, 'Valencia', 'Disponible', 180000, 'Venta: Nave Industrial 1000m², zona industrial prime.', 'view/img/nave2.jpg', 1200, 1, 0, -0.700119, 38.8141, 9, 18, 8, 1, 3),
(16, 'Nave Industrial a reformar', 3, 'Valencia', 'Disponible', 80000, 'Venta: Nave Industrial 1000m², zona industrial prime.', 'view/img/nave3.jpg', 1300, 1, 0, -0.603982, 38.8344, 9, 18, 8, 1, 2),
(17, 'Nave Industrial con estanterias', 4, 'Valencia', 'Disponible', 75000, 'Venta: Nave Industrial 1000m², zona industrial prime.', 'view/img/nave4.jpg', 2000, 1, 0, -0.58356, 38.7708, 9, 18, 8, 1, 3),
(18, 'Nave Industrial adaptada.', 5, 'Valencia', 'Disponible', 120000, 'Venta: Nave Industrial 1000m², zona industrial prime.', 'view/img/nave5.jpg', 1200, 1, 0, -0.538627, 38.7997, 9, 18, 8, 1, 3),
(19, 'Chalet en la montaña', 1, 'Valencia', 'Disponible', 200000, 'Venta: Chalet 300m², jardín amplio.', 'view/img/chalet7.jpg', 100, 4, 3, -5.68396, 37.4038, 9, 14, 6, 1, 2),
(20, 'Chalet en la playa', 2, 'Valencia', 'Disponible', 180000, 'Venta: Chalet 300m², jardín amplio.', 'view/img/chalet2.jpg', 120, 3, 2, -0.718478, 38.8207, 9, 15, 6, 1, 3),
(21, 'Chalet con muchas posiblilidades', 3, 'Valencia', 'Disponible', 80000, 'Venta: Chalet 4 hab., piscina', 'view/img/chalet3.jpg', 130, 8, 0, -0.580634, 38.8544, 9, 14, 6, 1, 3),
(22, 'Chalet con piscina', 4, 'Valencia', 'Disponible', 75000, 'Venta: Chalet 4 hab., piscina', 'view/img/chalet6.jpg', 200, 4, 4, -0.58378, 38.7743, 9, 14, 6, 1, 3),
(23, 'Chalet de ensueño', 5, 'Valencia', 'Disponible', 120000, 'Venta: Chalet exclusivo, vistas panorámicas.', 'view/img/chalet5.jpg', 2500, 5, 3, -0.549881, 38.8068, 9, 15, 6, 1, 3),
(24, 'Adosado en Albaida', 1, 'Valencia', 'Preventa', 248000, 'Agradable adosado de 5 dormitorios con diseño contemporáneo. Cocina equipada, luminoso salón y patio privado. Ubicación conveniente cerca de servicios y transporte. Perfecto para aquellos que buscan confort y estilo en un hogar adosado moderno.', 'view/img/adosado2.jpg', 234, 5, 2, -0.5533, 38.9167, 7, 14, 2, 1, 3),
(25, 'Piso en Agullent', 5, 'Valencia', 'Disponible', 134000, 'Encantador piso de 5 habitaciones con diseño moderno y luminoso. Cocina totalmente equipada, amplio salón con vistas panorámicas. Ubicación céntrica, cerca de servicios y transporte público. Ideal para aquellos que buscan comodidad.', 'view/img/piso2.jpg', 88, 3, 1, -0.544702, 38.8091, 7, 14, 1, 1, 3),
(26, 'Piso en Bocairent', 4, 'Valencia', 'Disponible', 98000, 'Piso de 2 habitaciones con diseño moderno y luminoso. Cocina totalmente equipada, amplio salón con vistas panorámicas. Ubicación céntrica, cerca de servicios y transporte público. Ideal para aquellos que buscan comodidad y estilo.', 'view/img/piso3.jpg', 88, 3, 2, -0.581386, 38.7626, 9, 14, 1, 1, 0),
(27, 'Piso en Bocairent', 4, 'Valencia', 'Disponible', 72000, 'Encantador piso de 3 habitaciones con diseño moderno y luminoso. Cocina totalmente equipada, amplio salón con vistas panorámicas. Ubicación céntrica, cerca de servicios y transporte público. Ideal para aquellos que buscan comodidad.', 'view/img/piso4.jpg', 65, 2, 1, -0.563904, 38.7796, 8, 14, 1, 1, 3),
(28, 'Piso unifamiliar', 2, 'Valencia', 'Disponible', 56000, 'Pequeño piso de 2 habitaciones con diseño moderno y luminoso. Cocina totalmente equipada, amplio salón con vistas panorámicas. Ubicación céntrica, cerca de servicios y transporte público. Ideal para aquellos que buscan comodidad.', 'view/img/piso5.jpg', 65, 2, 1, -0.699907, 38.8198, 9, 14, 1, 1, 3),
(29, 'Adosado con Jaquzzi', 3, 'Valencia', 'Preventa', 248000, 'Agradable adosado de 5 dormitorios con piscina, Cocina equipada, luminoso salón y patio privado. Ubicación conveniente cerca de servicios y transporte. Perfecto para aquellos que buscan confort y estilo en un hogar adosado moderno.', 'view/img/adosado3.jpg', 159, 3, 2, -0.592714, 38.8477, 7, 14, 2, 1, 3),
(30, 'Adosado con piscina.', 8, 'Valencia', 'Preventa', 135000, 'Estupendo adosado de 5 dormitorios con piscina, Cocina equipada, luminoso salón y patio privado. Ubicación conveniente cerca de servicios y transporte. Perfecto para aquellos que buscan confort y estilo en un hogar adosado moderno.', 'view/img/adosado4.jpg', 125, 3, 2, -0.505588, 39.0196, 7, 15, 2, 1, 3),
(31, 'Adosado en Paterna', 6, 'Valencia', 'Preventa', 98000, 'Estupendo adosado de 5 dormitorios con piscina, Cocina equipada, luminoso salón y patio privado. Ubicación conveniente cerca de servicios y transporte. Perfecto para aquellos que buscan confort y estilo en un hogar adosado moderno.', 'view/img/adosado5.jpg', 132, 4, 2, -0.411096, 39.5289, 7, 15, 2, 1, 3),
(32, 'Local en Albaida', 1, 'Valencia', 'Disponible', 25000, 'Local de 200 metros con diseño moderno y luminoso. ', 'view/img/local1.jpg', 30, 1, 0, -5.67501, 37.407, 9, 13, 4, 1, 3),
(33, 'Parcela en Albaida', 1, 'Valencia', 'Disponible', 25000, 'Parcela de 2000 metros con arboles', 'view/img/parcela1.jpg', 2000, 0, 0, -5.6778, 37.3892, 9, 14, 3, 1, 3),
(34, 'Parcela en Fontanars', 2, 'Valencia', 'Disponible', 78000, 'Parcela de 1820 metros con arboles', 'view/img/parcela2.jpg', 1820, 0, 0, -0.691834, 38.8243, 9, 14, 3, 1, 3),
(35, 'Parcela en Xativa', 8, 'Valencia', 'Disponible', 56800, 'Parcela de 2000 metros urbanizable', 'view/img/parcela3.jpg', 2000, 0, 0, -0.500858, 39.0078, 9, 14, 3, 1, 3),
(36, 'Parcela en Valencia', 7, 'Valencia', 'Disponible', 135800, 'Parcela de 2000 metros urbanizable en el extraradio de Valencia', 'view/img/parcela4.jpg', 2000, 0, 0, -0.3633, 39.527, 9, 14, 3, 1, 3),
(37, 'Parcela en Paterna', 6, 'Valencia', 'Disponible', 12500, 'Parcela de 500 metros urbanizable en con muchas posibilidades', 'view/img/parcela5.jpg', 2000, 0, 0, -0.425729, 39.5213, 9, 14, 3, 1, 1),
(38, 'Local en Paterna', 6, 'Valencia', 'Disponible', 32000, 'Local de 200 metros en zona comercial.', 'view/img/local2.jpg', 200, 1, 0, -0.411585, 39.5244, 9, 13, 4, 1, 3),
(39, 'Local en Ontinyent', 3, 'Valencia', 'Disponible', 56000, 'Local de 200 en centro comercial', 'view/img/local3.jpg', 200, 1, 0, -0.582358, 38.8596, 9, 13, 4, 1, 1),
(40, 'Local en Valencia', 7, 'Valencia', 'Disponible', 56000, 'Local de 200m2 en centro comercial', 'view/img/local4.jpg', 200, 1, 0, -0.351837, 39.5274, 9, 15, 4, 1, 3),
(41, 'Local comercial', 7, 'Valencia', 'Disponible', 118000, 'Local de 200m2 en el centro de Valencia, apto para talleres de motos', 'view/img/local5.jpg', 90, 1, 0, -0.348506, 39.5091, 9, 15, 4, 1, 3),
(42, 'Chalet con muchas posiblilidades', 3, 'Valencia', 'Disponible', 80000, 'Venta: Chalet 4 hab., piscina', 'view/img/chalet4.jpg', 130, 8, 0, -0.576871, 38.8254, 9, 14, 6, 1, 3),
(43, 'Duplex a estrenar', 3, 'Valencia', 'Disponible', 320000, 'Agradable duplex de 3 dormitorios con diseño contemporáneo. Cocina equipada, luminoso salón y patio privado. Ubicación conveniente cerca de servicios y transporte. Perfecto para aquellos que buscan confort y estilo en un hogar adosado moderno.', 'view/img/duplex2.jpg', 157, 3, 2, -0.56583, 38.8298, 7, 14, 9, 1, 1),
(44, 'Duplex en Valencia', 7, 'Valencia', 'Disponible', 211500, 'Espectacular duplex de 3 dormitorios con diseño contemporáneo. Cocina equipada, luminoso salón y patio privado. Ubicación conveniente cerca de servicios y transporte. Perfecto para aquellos que buscan confort y estilo en un hogar adosado moderno.', 'view/img/duplex3.jpg', 132, 3, 2, -0.308383, 39.5166, 7, 16, 9, 1, 2),
(45, 'Espectacular Duplex', 7, 'Valencia', 'Disponible', 211500, 'Magnifico duplex de 3 dormitorios con diseño contemporáneo. Cocina equipada, luminoso salón y patio privado. Ubicación conveniente cerca de servicios y transporte. Perfecto para aquellos que buscan confort y estilo en un hogar adosado moderno.', 'view/img/duplex4.jpg', 132, 3, 2, -0.376023, 39.5245, 8, 15, 9, 1, 3),
(46, 'Duplex en Fontanars', 2, 'Valencia', 'Disponible', 211500, 'Duplex con cocina equipada, luminoso salón y patio privado. Ubicación conveniente cerca de servicios y transporte. Perfecto para aquellos que buscan confort y estilo en un hogar adosado moderno.', 'view/img/duplex5.jpg', 132, 3, 2, -0.705587, 38.8177, 8, 14, 9, 1, 3),
(47, 'Duplex en Xativa', 8, 'Valencia', 'Disponible', 218000, 'Duplex con cocina equipada, luminoso salón y patio privado. Ubicación conveniente cerca de servicios y transporte. Perfecto para aquellos que buscan confort y estilo en un hogar adosado moderno.', 'view/img/duplex6.jpg', 156, 4, 3, -0.519411, 39.0169, 7, 14, 9, 1, 3),
(48, 'Adosado unifamiliar.', 7, 'Valencia', 'Preventa', 13200, 'Estupendo adosado de 5 dormitorios con piscina, Cocina equipada, luminoso salón y patio privado. Ubicación conveniente cerca de servicios y transporte. Perfecto para aquellos que buscan confort y estilo en un hogar adosado moderno.', 'view/img/adosado3.jpg', 150, 3, 2, -0.505568, 39.0196, 9, 14, 2, 1, 3),
(59, 'Piso amueblado.', 7, 'Valencia', 'En Venta', 95000, 'Acogedor piso en el centro de la ciudad. Totalmente amueblado y con buenas conexiones de transporte público.', 'view/img/piso1.jpg', 80, 2, 1, -0.375177, 39.4699, 7, 14, 1, 1, 3),
(60, 'Chalet con jardin.', 7, 'Valencia', 'En Venta', 300000, 'Amplio chalet con jardín y piscina privada. Zona tranquila y bien comunicada.', 'view/img/chalet1.jpg', 200, 4, 3, -0.398358, 39.4659, 7, 14, 6, 1, 3),
(61, 'Adosado con garaje.', 7, 'Valencia', 'En Venta', 180000, 'Acogedor adosado con terraza y garaje. Cerca de colegios y supermercados.', 'view/img/adosado1.jpg', 120, 3, 2, -0.365857, 39.4592, 7, 15, 2, 1, 3),
(62, 'Piso en el extraradio', 7, 'Valencia', 'En Venta', 105000, 'Piso luminoso con balcón en zona residencial. Cercano a parques y servicios.', 'view/img/piso2.jpg', 90, 3, 2, -0.373182, 39.4754, 7, 15, 1, 1, 3),
(63, 'Chalet rustico.', 7, 'Valencia', 'En Venta', 320000, 'Chalet moderno con amplios espacios interiores y vistas panorámicas. Ideal para familias.', 'view/img/chalet2.jpg', 220, 5, 4, -0.412836, 39.4718, 7, 14, 6, 1, 3),
(64, 'Adosado con barbacoa.', 7, 'Valencia', 'En Venta', 195000, 'Adosado luminoso con patio y zona de barbacoa. Bien comunicado y cerca de comercios.', 'view/img/adosado2.jpg', 130, 4, 3, -0.361936, 39.4567, 8, 17, 2, 1, 3),
(65, 'Piso en el centro', 7, 'Valencia', 'En Venta', 98000, 'Piso reformado con cocina equipada. Cerca de transporte público y zonas de ocio.', 'view/img/piso3.jpg', 85, 2, 1, -0.389225, 39.4782, 9, 17, 1, 1, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `adapted`
--
ALTER TABLE `adapted`
  ADD PRIMARY KEY (`id_adapted`);

--
-- Indices de la tabla `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`);

--
-- Indices de la tabla `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id_city`);

--
-- Indices de la tabla `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id_image`),
  ADD KEY `id_vivienda` (`id_vivienda`),
  ADD KEY `id_vivienda_2` (`id_vivienda`),
  ADD KEY `id_vivienda_3` (`id_vivienda`);

--
-- Indices de la tabla `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id_vivienda`,`id_username`);

--
-- Indices de la tabla `operation`
--
ALTER TABLE `operation`
  ADD PRIMARY KEY (`id_operation`);

--
-- Indices de la tabla `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id_vivienda`,`id_user`);

--
-- Indices de la tabla `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id_type`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`) USING BTREE;

--
-- Indices de la tabla `viviendas`
--
ALTER TABLE `viviendas`
  ADD PRIMARY KEY (`id_vivienda`),
  ADD KEY `id_city` (`id_city`),
  ADD KEY `id_category` (`id_category`),
  ADD KEY `id_type` (`id_type`) USING BTREE,
  ADD KEY `id_operation` (`id_operation`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `adapted`
--
ALTER TABLE `adapted`
  MODIFY `id_adapted` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `city`
--
ALTER TABLE `city`
  MODIFY `id_city` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `images`
--
ALTER TABLE `images`
  MODIFY `id_image` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `operation`
--
ALTER TABLE `operation`
  MODIFY `id_operation` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `type`
--
ALTER TABLE `type`
  MODIFY `id_type` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT de la tabla `viviendas`
--
ALTER TABLE `viviendas`
  MODIFY `id_vivienda` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`id_vivienda`) REFERENCES `viviendas` (`id_vivienda`);

--
-- Filtros para la tabla `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`id_vivienda`) REFERENCES `viviendas` (`id_vivienda`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `viviendas`
--
ALTER TABLE `viviendas`
  ADD CONSTRAINT `viviendas_category` FOREIGN KEY (`id_category`) REFERENCES `category` (`id_category`) ON DELETE NO ACTION,
  ADD CONSTRAINT `viviendas_city` FOREIGN KEY (`id_city`) REFERENCES `city` (`id_city`) ON DELETE NO ACTION,
  ADD CONSTRAINT `viviendas_operation` FOREIGN KEY (`id_operation`) REFERENCES `operation` (`id_operation`) ON DELETE NO ACTION,
  ADD CONSTRAINT `viviendas_type` FOREIGN KEY (`id_type`) REFERENCES `type` (`id_type`) ON DELETE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
