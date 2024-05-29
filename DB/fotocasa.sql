-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 29-05-2024 a las 18:32:27
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
(12, 'luisito', '$2y$12$NpNteudxVguB8zBk/86xL.5eKCSiOyoeFNa5rWzJ3.jjAXuIZgzMa', '1jvrluis@hotmail.com', 'client', 'https://i.pravatar.cc/500?u=e180ce24ee0680d10937341695b92bbe', '', 1, 3, 'local'),
(13, 'fernandin', '$2y$12$olnGKNANkqSZMG6NLsDmduzKSV20nTlo4Etl2SfTdjCVzPJkLtglW', 'fernandin@hotrmail.com', 'client', 'https://i.pravatar.cc/500?u=88e4eb8edb044b44c30e8784014c9a05', '', 1, 3, 'local'),
(14, 'paquito', '$2y$12$PMhhFpZ3Q/C0PLFpDEHmo.Lbpsqi2fWrDeKTNxX8XuzVEvrnnLZC2', 'paquito@hotmail.com', 'client', 'https://i.pravatar.cc/500?u=8fd36194cbf128399e5b94634c6aaadd', '', 1, 3, 'local'),
(79, 'antonio', '$2y$10$/A/22x.sK8dlSoAHI2YEbuTygoZC9kzKdIpdm6vxfeHJAiPnXMyhG', 'jvrluis@hotmail.com', 'client', 'https://i.pravatar.cc/500?u=2b2bc99149c1eb1b555598291e1008d8', '', 1, 3, 'local'),
(100, 'antonios', '$2y$10$86hMTwlx1J2Tmy8ogryprup9KapztpPXNMxC0ua9wgnZjVOXxUhsK', 'jvrluis@hotmail.coms', 'client', 'https://i.pravatar.cc/500?u=2b2bc99149c1eb1b555598291e1008d8', 'cf27642bb19851dc4cbf', 0, 3, 'local'),
(101, 'jvrluis', ' ', 'jvrluis@gmail.com', 'client', 'https://lh3.googleusercontent.com/a/ACg8ocJ0cMP9yG5YJsLYrPXVcBdry4cKnzZSevc8R1pKpWb7U-KPWDU7=s96-c', '', 1, 3, 'gmail.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
