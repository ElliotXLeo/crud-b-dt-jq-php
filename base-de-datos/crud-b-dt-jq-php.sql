-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-12-2021 a las 02:32:38
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `crud-b-dt-jq-php`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `descripcion`) VALUES
(1, 'admin'),
(2, 'data entry');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `celular` varchar(50) NOT NULL,
  `ubicacion` varchar(50) NOT NULL,
  `idRol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `usuario`, `clave`, `celular`, `ubicacion`, `idRol`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', '951123456', '@-12.0460077,-77.0305912,21z', 1),
(2, 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229', '985145753', '@-12.0460077,-77.0305912,21z', 2),
(3, 'ElliotXLeo', 'e10adc3949ba59abbe56e057f20f883e', '963640765', '@-12.0671257,-77.0358376,21z', 2),
(4, 'Chocolate', '202cb962ac59075b964b07152d234b70', '951753456', '@-12.0671257,-77.0358376,21z', 2),
(5, 'Doky', '202cb962ac59075b964b07152d234b70', '954613554', '@-12.0671257,-77.0358376,21z', 2),
(6, 'Amorosa', '202cb962ac59075b964b07152d234b70', '948546132', '@-12.0671257,-77.0358376,21z', 2),
(7, 'NN', '202cb962ac59075b964b07152d234b70', '954613213', '@-12.0671257,-77.0358376,21z', 2),
(8, 'Chispa', '202cb962ac59075b964b07152d234b70', '985461321', '@-12.0671257,-77.0358376,21z', 2),
(9, 'Patón', '202cb962ac59075b964b07152d234b70', '954613294', '@-12.0671257,-77.0358376,21z', 2),
(10, 'Arthas', '202cb962ac59075b964b07152d234b70', '999781325', '@-12.0671257,-77.0358376,21z', 2),
(11, 'Quilla', '202cb962ac59075b964b07152d234b70', '945613294', '@-12.0671257,-77.0358376,21z', 2),
(12, 'Inti', '202cb962ac59075b964b07152d234b70', '933545464', '@-12.0671257,-77.0358376,21z', 2),
(13, 'Gaaa', '202cb962ac59075b964b07152d234b70', '985461313', '@-12.0671257,-77.0358376,21z', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD UNIQUE KEY `celular` (`celular`),
  ADD KEY `idRol` (`idRol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`idRol`) REFERENCES `rol` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
