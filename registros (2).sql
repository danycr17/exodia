-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-07-2024 a las 00:45:43
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
(4, 'Registro ', '', '2024-07-18', 1),
(5, 'PROVEEDORES', 'https://www.canva.com/design/DAFt16tPPyQ/HspJ1vkTuq4iPtPO80Xthw/view?utm_content=DAFt16tPPyQ&utm_campaign=designshare&utm_medium=link&utm_source=publishsharelink', '2024-07-05', 1);

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
(4, 24, 'Cual es tu nombre', 'text', 'libre'),
(4, 25, 'Area donde se realiza la actividad ', 'lista', 'area');

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

--
-- Volcado de datos para la tabla `pregunta_detalle`
--

INSERT INTO `pregunta_detalle` (`id`, `grupo`, `nombre`, `valor`) VALUES
(1, 'area', 'Produccion', 'lista'),
(2, 'area', 'ventas', 'lista ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reg_visit`
--

CREATE TABLE `reg_visit` (
  `id_registro` int(11) NOT NULL,
  `empresa` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `departamento_area` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `reg_visit`
--

INSERT INTO `reg_visit` (`id_registro`, `empresa`, `nombre`, `departamento_area`, `fecha`) VALUES
(666, '', '', '', '2024-07-19 19:39:00'),
(669, '', '', '', '2024-07-19 20:06:08'),
(670, '', '', '', '2024-07-19 20:17:42'),
(671, '', '', '', '2024-07-19 20:17:55'),
(672, '', '', '', '2024-07-19 20:18:49'),
(673, '', '', '', '2024-07-19 20:19:56'),
(674, '', '', '', '2024-07-19 20:22:20'),
(675, '', '', '', '2024-07-19 20:22:40'),
(676, '', '', '', '2024-07-19 20:22:57'),
(677, '', '', '', '2024-07-19 20:32:58'),
(678, '', '', '', '2024-07-19 20:33:04'),
(679, '', '', '', '2024-07-19 20:38:47'),
(680, '', '', '', '2024-07-19 20:39:06'),
(681, '', '', '', '2024-07-19 20:39:07'),
(682, '', '', '', '2024-07-19 20:39:09'),
(683, '', '', '', '2024-07-19 20:39:10'),
(684, '', '', '', '2024-07-19 20:39:11'),
(685, '', '', '', '2024-07-19 20:39:12'),
(686, '', '', '', '2024-07-19 21:08:24'),
(687, '', '', '', '2024-07-19 21:08:51'),
(688, '', '', '', '2024-07-19 21:14:30'),
(689, '', '', '', '2024-07-19 21:14:31'),
(690, '', '', '', '2024-07-19 21:14:50'),
(691, '', '', '', '2024-07-19 21:15:07'),
(692, '', '', '', '2024-07-19 21:15:12'),
(693, '', '', '', '2024-07-19 21:17:38'),
(694, '', '', '', '2024-07-19 21:18:08'),
(695, '', '', '', '2024-07-19 21:18:36'),
(696, '', '', '', '2024-07-19 21:19:11'),
(697, '', '', '', '2024-07-19 21:19:38'),
(698, '', '', '', '2024-07-19 21:19:53'),
(699, '', '', '', '2024-07-19 21:20:06'),
(700, '', '', '', '2024-07-19 21:20:21'),
(701, '', '', '', '2024-07-19 21:22:08'),
(702, '', '', '', '2024-07-19 21:22:28'),
(703, '', '', '', '2024-07-19 21:22:33'),
(704, '', '', '', '2024-07-19 21:24:02'),
(705, '', '', '', '2024-07-19 21:24:15'),
(706, '', '', '', '2024-07-19 21:24:23'),
(707, '', '', '', '2024-07-19 21:24:30'),
(708, '', '', '', '2024-07-19 21:24:33'),
(709, '', '', '', '2024-07-19 21:30:14'),
(710, '', '', '', '2024-07-19 21:30:22'),
(711, '', '', '', '2024-07-19 21:30:27'),
(712, '', '', '', '2024-07-19 21:38:27'),
(713, '', '', '', '2024-07-19 21:38:31'),
(714, '', '', '', '2024-07-19 21:38:54'),
(715, '', '', '', '2024-07-19 21:39:25'),
(716, '', '', '', '2024-07-19 21:39:31'),
(717, '', '', '', '2024-07-19 21:39:49'),
(718, '', '', '', '2024-07-19 21:39:53'),
(719, '', '', '', '2024-07-19 21:39:56'),
(720, '', '', '', '2024-07-19 21:40:01'),
(721, '', '', '', '2024-07-19 21:41:35'),
(722, '', '', '', '2024-07-19 21:41:41'),
(723, '', '', '', '2024-07-19 21:41:43'),
(724, '', '', '', '2024-07-19 21:42:20'),
(725, '', '', '', '2024-07-19 21:42:21'),
(726, '', '', '', '2024-07-19 21:53:00'),
(727, '', '', '', '2024-07-19 21:53:00'),
(728, '', '', '', '2024-07-19 21:53:11'),
(729, '', '', '', '2024-07-19 21:53:11'),
(730, '', '', '', '2024-07-19 21:53:27'),
(731, '', '', '', '2024-07-19 21:53:27'),
(732, '', '', '', '2024-07-19 21:55:13'),
(733, '', '', '', '2024-07-19 21:55:13'),
(734, '', '', '', '2024-07-19 21:55:17'),
(735, '', '', '', '2024-07-19 21:55:17'),
(736, '', '', '', '2024-07-19 21:55:19'),
(737, '', '', '', '2024-07-19 21:55:19'),
(738, '', '', '', '2024-07-19 21:57:41'),
(739, '', '', '', '2024-07-19 21:57:41'),
(740, '', '', '', '2024-07-19 21:58:17'),
(741, '', '', '', '2024-07-19 21:58:17'),
(742, '', '', '', '2024-07-19 21:58:37'),
(743, '', '', '', '2024-07-19 21:58:40'),
(744, '', '', '', '2024-07-19 21:59:01'),
(745, '', '', '', '2024-07-19 22:00:42'),
(746, '', '', '', '2024-07-19 22:00:46'),
(747, '', '', '', '2024-07-19 22:01:26'),
(748, '', '', '', '2024-07-19 22:01:28'),
(749, '', '', '', '2024-07-19 22:01:32'),
(750, '', '', '', '2024-07-19 22:03:12'),
(751, '', '', '', '2024-07-19 22:03:56'),
(752, '', '', '', '2024-07-19 22:03:57'),
(753, '', '', '', '2024-07-19 22:03:57'),
(754, '', '', '', '2024-07-19 22:03:57'),
(755, '', '', '', '2024-07-19 22:03:57'),
(756, '', '', '', '2024-07-19 22:03:58'),
(757, '', '', '', '2024-07-19 22:03:58'),
(758, '', '', '', '2024-07-19 22:04:01'),
(759, '', '', '', '2024-07-19 22:04:03'),
(760, '', '', '', '2024-07-19 22:04:11'),
(761, '', '', '', '2024-07-19 22:05:31'),
(762, '', '', '', '2024-07-19 22:05:47'),
(55301, '', '', '', '2024-07-19 22:16:05'),
(55302, '', '', '', '2024-07-19 22:22:26'),
(55303, '', '', '', '2024-07-19 22:22:41'),
(55304, '', '', '', '2024-07-19 22:22:45'),
(55305, '', '', '', '2024-07-19 22:22:50'),
(55306, '', '', '', '2024-07-19 22:22:52'),
(55307, '', '', '', '2024-07-19 22:22:54'),
(55308, '', '', '', '2024-07-19 22:43:49'),
(55309, '', '', '', '2024-07-19 22:43:52');

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

--
-- Volcado de datos para la tabla `respuestas`
--

INSERT INTO `respuestas` (`id_registro`, `id_pregunta`, `respuesta`, `fecha`) VALUES
(0, 25, 'ventas', '2024-07-19 21:03:43'),
(0, 25, 'Produccion', '2024-07-19 21:07:05'),
(0, 25, 'ventas', '2024-07-19 21:09:47'),
(0, 25, 'ventas', '2024-07-19 21:42:08');

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
  MODIFY `id_encuesta` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id_pregunta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `pregunta_detalle`
--
ALTER TABLE `pregunta_detalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `reg_visit`
--
ALTER TABLE `reg_visit`
  MODIFY `id_registro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55310;

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
