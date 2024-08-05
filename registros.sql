-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-08-2024 a las 05:28:20
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
-- Base de datos: `registros`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `form`
--

CREATE TABLE `form` (
  `id_encuesta` int(2) NOT NULL,
  `nombre` varchar(75) NOT NULL,
  `url` text NOT NULL,
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
(4, 'Registro ', '', '2024-07-18', 1),
(5, 'PROVEEDORES', 'https://www.canva.com/design/DAFt16tPPyQ/HspJ1vkTuq4iPtPO80Xthw/view?utm_content=DAFt16tPPyQ&utm_campaign=designshare&utm_medium=link&utm_source=publishsharelink', '2024-07-05', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `id_encuesta` int(2) NOT NULL,
  `id_pregunta` int(11) NOT NULL,
  `pregunta` varchar(250) NOT NULL,
  `tipo_pregunta` varchar(255) NOT NULL,
  `conf` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`id_encuesta`, `id_pregunta`, `pregunta`, `tipo_pregunta`, `conf`) VALUES
(4, 1, 'Empresa', 'text', 'libre'),
(4, 24, 'Cual es tu nombre', 'text', 'libre'),
(4, 25, 'Area donde se realiza la actividad ', 'lista', 'area'),
(5, 26, '¿Ha tenido contacto directo o ha cuidado a alguna persona diagnosticada con COVID-19 en los últimos 7 días?', 'radio', 'sino'),
(5, 27, '¿Ha tenido síntomas de resfriado común o gripa en los últimos 14 días (incluyendo síntomas de fiebre, tos, dolor de garganta, dolor de articulaciones, escurrimiento nasal, conjuntivitis, dolor torácico, dificultad para respirar)?', 'radio', 'sino'),
(5, 28, 'Nombre del contacto POSCO', 'text', 'libre'),
(5, 29, 'Área', 'text', 'libre'),
(5, 30, 'Actividad a Realizar', 'text', 'libre'),
(5, 31, 'Documentación que presentas', 'checkbox', 'permisos'),
(5, 32, 'Permisos de Trabajo', 'checkbox', 'documentos'),
(5, 33, 'COMPROMISO DE SEGURIDAD', 'text', 'libre');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta_detalle`
--

CREATE TABLE `pregunta_detalle` (
  `id` int(11) NOT NULL,
  `grupo` varchar(50) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `valor` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `pregunta_detalle`
--

INSERT INTO `pregunta_detalle` (`id`, `grupo`, `nombre`, `valor`) VALUES
(1, 'area', 'Produccion', 'lista'),
(2, 'area', 'ventas', 'lista '),
(3, 'sino', 'si', 'si'),
(4, 'sino', 'no', 'no'),
(5, 'documentos', 'TBM', 'documentos'),
(6, 'documentos', 'Oxicorte y Soldadura', 'documentos'),
(7, 'documentos', 'Trabajos en Espacios Confinados', 'documentos'),
(8, 'documentos', '\r\nEscalas', 'documentos'),
(9, 'documentos', 'Andamios', 'documentos'),
(10, 'documentos', 'No Aplica', 'documentos'),
(11, 'permisos', 'Identificación Oficial', 'permisos'),
(12, 'permisos', 'SUA', 'permisos'),
(13, 'permisos', 'DC-3 Trabajo en Alturas', 'permisos'),
(14, 'permisos', 'DC-3 Soldadura', 'permisos'),
(15, 'permisos', 'DC-3 Espacios Confinados', 'permisos'),
(16, 'permisos', 'FDS o MSDS de Sustancias químicas\r\n', 'permisos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reg_visit`
--

CREATE TABLE `reg_visit` (
  `id_registro` int(11) NOT NULL,
  `empresa` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `departamento_area` varchar(255) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `reg_visit`
--

INSERT INTO `reg_visit` (`id_registro`, `empresa`, `nombre`, `departamento_area`, `fecha`) VALUES
(7005846, '', '', '', '2024-07-24 04:57:30'),
(7005847, '', '', '', '2024-07-24 05:09:03'),
(7005848, 'Baterias ', 'Julian', '', '2024-07-24 05:10:53'),
(7005849, 'flawers ', 'danycr', '', '2024-07-24 05:17:03'),
(7005850, 'posco ', 'sandyx', '', '2024-07-24 05:18:03'),
(7005851, 'posco ', 'julian ', '', '2024-07-24 05:18:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas`
--

CREATE TABLE `respuestas` (
  `id_registro` int(2) NOT NULL,
  `id_pregunta` int(11) NOT NULL,
  `respuesta` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `respuestas`
--

INSERT INTO `respuestas` (`id_registro`, `id_pregunta`, `respuesta`, `fecha`) VALUES
(0, 25, 'ventas', '2024-07-19 21:03:43'),
(0, 25, 'Produccion', '2024-07-19 21:07:05'),
(0, 25, 'ventas', '2024-07-19 21:09:47'),
(0, 25, 'ventas', '2024-07-19 21:42:08'),
(0, 25, 'Produccion', '2024-07-22 00:56:49'),
(0, 25, 'ventas', '2024-07-22 01:08:07'),
(0, 25, 'ventas', '2024-07-22 01:09:00'),
(0, 25, 'ventas', '2024-07-22 01:18:32'),
(0, 25, 'ventas', '2024-07-22 01:28:26'),
(0, 25, 'ventas', '2024-07-22 01:34:45'),
(0, 25, 'Produccion', '2024-07-22 01:38:37'),
(0, 25, 'ventas', '2024-07-22 01:39:26'),
(0, 25, 'ventas', '2024-07-22 01:51:06'),
(0, 25, 'ventas', '2024-07-22 01:51:30'),
(0, 25, 'ventas', '2024-07-22 01:55:08'),
(0, 25, 'ventas', '2024-07-22 02:05:00'),
(0, 25, 'ventas', '2024-07-22 02:13:39'),
(0, 25, 'ventas', '2024-07-22 02:19:19'),
(0, 25, 'ventas', '2024-07-22 02:28:31'),
(0, 25, 'ventas', '2024-07-22 02:29:42'),
(0, 25, 'ventas', '2024-07-22 02:37:03'),
(0, 25, 'ventas', '2024-07-23 04:08:42'),
(0, 25, 'ventas', '2024-07-23 04:42:26'),
(0, 1, 'Motores', '2024-07-23 04:52:30'),
(0, 24, 'danycr', '2024-07-23 04:52:30'),
(0, 25, 'ventas', '2024-07-23 04:52:30'),
(0, 1, 'MOTORS', '2024-07-23 05:09:08'),
(0, 24, 'Diego', '2024-07-23 05:09:08'),
(0, 25, 'ventas', '2024-07-23 05:09:08'),
(0, 1, 'Tacos', '2024-07-23 05:16:31'),
(0, 24, 'KEKO', '2024-07-23 05:16:31'),
(0, 25, 'ventas', '2024-07-23 05:16:31'),
(0, 1, '', '2024-07-24 04:44:09'),
(0, 24, '', '2024-07-24 04:44:09'),
(0, 25, 'Produccion', '2024-07-24 04:44:09'),
(0, 1, 'MX', '2024-07-24 04:55:22'),
(0, 24, 'bofo', '2024-07-24 04:55:22'),
(0, 25, 'ventas', '2024-07-24 04:55:22'),
(0, 1, 'CHACO', '2024-07-24 04:57:30'),
(0, 24, 'DANI', '2024-07-24 04:57:30'),
(0, 25, 'Produccion', '2024-07-24 04:57:30'),
(0, 1, 'Baterias', '2024-07-24 05:09:03'),
(0, 24, 'Tacos', '2024-07-24 05:09:03'),
(0, 25, 'ventas', '2024-07-24 05:09:03'),
(7005811, 1, 'Baterias ', '2024-07-24 05:10:53'),
(7005811, 24, 'Julian', '2024-07-24 05:10:53'),
(7005811, 25, 'Produccion', '2024-07-24 05:10:53'),
(0, 1, 'flawers ', '2024-07-24 05:17:03'),
(0, 24, 'danycr', '2024-07-24 05:17:03'),
(0, 25, 'ventas', '2024-07-24 05:17:03'),
(0, 1, 'posco ', '2024-07-24 05:18:03'),
(0, 24, 'sandyx', '2024-07-24 05:18:03'),
(0, 25, 'ventas', '2024-07-24 05:18:03'),
(0, 1, 'posco ', '2024-07-24 05:18:41'),
(0, 24, 'julian ', '2024-07-24 05:18:41'),
(0, 25, 'ventas', '2024-07-24 05:18:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
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
  MODIFY `id_encuesta` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id_pregunta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `pregunta_detalle`
--
ALTER TABLE `pregunta_detalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `reg_visit`
--
ALTER TABLE `reg_visit`
  MODIFY `id_registro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7005852;

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
  ADD CONSTRAINT `respuestas_ibfk_2` FOREIGN KEY (`id_pregunta`) REFERENCES `preguntas` (`id_pregunta`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
