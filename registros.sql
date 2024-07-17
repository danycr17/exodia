-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-07-2024 a las 00:38:40
-- Versión del servidor: 10.1.30-MariaDB
-- Versión de PHP: 5.6.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `registros`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `form`
--

CREATE TABLE `form` (
  `id_encuesta` int(2) NOT NULL,
  `nombre` varchar(75) COLLATE utf8_spanish_ci NOT NULL,
  `url` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha_reg` date NOT NULL,
  `estatus` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `form`
--

INSERT INTO `form` (`id_encuesta`, `nombre`, `url`, `fecha_reg`, `estatus`) VALUES
(1, 'Compromiso del Sistema de Gestion Ambiental para Proveedores/ Visitantes ', '', '2024-06-17', 1),
(2, 'VIDEO SGA', 'https://www.canva.com/design/DAF0QaU6vyc/Lho66cnzHC335hJIt2Vfog/watch?utm_content=DAF0QaU6vyc&utm_campaign=designshare&utm_medium=link&utm_source=editor', '2024-06-18', 1),
(3, 'VISITANTES', 'https://www.canva.com/design/DAFt1kChIJ0/M6Ucb74bfANBJ_UYrGxpeA/view?utm_content=DAFt1kChIJ0&utm_campaign=designshare&utm_medium=link&utm_source=publishsharelink#6', '2024-07-05', 1),
(4, 'PROVEEDORES', 'https://www.canva.com/design/DAFt16tPPyQ/HspJ1vkTuq4iPtPO80Xthw/view?utm_content=DAFt16tPPyQ&utm_campaign=designshare&utm_medium=link&utm_source=publishsharelink', '2024-07-05', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `id_encuesta` int(2) NOT NULL,
  `id_pregunta` int(11) NOT NULL,
  `pregunta` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `tipo_pregunta` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `conf` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`id_encuesta`, `id_pregunta`, `pregunta`, `tipo_pregunta`, `conf`) VALUES
(4, 1, 'Empresa', 'text', 'libre'),
(4, 24, 'Cual es tu nombre', 'text', 'libre');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta_detalle`
--

CREATE TABLE `pregunta_detalle` (
  `id` int(11) NOT NULL,
  `grupo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `valor` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reg_visit`
--

CREATE TABLE `reg_visit` (
  `id_registro` int(2) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `empresa` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `departamento_area` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `reg_visit`
--

INSERT INTO `reg_visit` (`id_registro`, `nombre`, `empresa`, `departamento_area`, `fecha`) VALUES
(1, 'DANIEL', 'POSCO', 'SISTEMAS', '2024-07-16 06:00:00'),
(2, 'dani', 'Posco', '', '2024-07-16 22:34:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas`
--

CREATE TABLE `respuestas` (
  `id_registro` int(2) NOT NULL,
  `id_pregunta` int(11) NOT NULL,
  `respuesta` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`, `date`) VALUES
(1, 'dany', '0000', '2024-06-20');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `form`
--
ALTER TABLE `form`
  ADD PRIMARY KEY (`id_encuesta`);

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`id_pregunta`),
  ADD KEY `id_encuesta` (`id_encuesta`),
  ADD KEY `id_pregunta` (`id_pregunta`);

--
-- Indices de la tabla `pregunta_detalle`
--
ALTER TABLE `pregunta_detalle`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reg_visit`
--
ALTER TABLE `reg_visit`
  ADD PRIMARY KEY (`id_registro`);

--
-- Indices de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD KEY `id_pregunta` (`id_pregunta`),
  ADD KEY `id_registro` (`id_registro`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `form`
--
ALTER TABLE `form`
  MODIFY `id_encuesta` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id_pregunta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `pregunta_detalle`
--
ALTER TABLE `pregunta_detalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `reg_visit`
--
ALTER TABLE `reg_visit`
  MODIFY `id_registro` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD CONSTRAINT `preguntas_ibfk_1` FOREIGN KEY (`id_encuesta`) REFERENCES `form` (`id_encuesta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD CONSTRAINT `respuestas_ibfk_2` FOREIGN KEY (`id_pregunta`) REFERENCES `preguntas` (`id_pregunta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `respuestas_ibfk_3` FOREIGN KEY (`id_registro`) REFERENCES `reg_visit` (`id_registro`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
