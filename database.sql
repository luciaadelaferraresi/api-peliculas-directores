-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 03-11-2025 a las 19:41:35
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cine`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `directores`
--

CREATE TABLE `directores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `nacionalidad` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `directores`
--

INSERT INTO `directores` (`id`, `nombre`, `nacionalidad`) VALUES
(1, 'Steven Spielberg', 'Estados Unidos'),
(2, 'Christopher Nolan', 'Reino Unido'),
(3, 'Quentin Tarantino', 'Estados Unidos'),
(4, 'Martin Scorsese', 'Estados Unidos'),
(5, 'James Cameron', 'Canadá');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peliculas`
--

CREATE TABLE `peliculas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `duracion` int(11) NOT NULL,
  `anio` int(11) NOT NULL,
  `portada` varchar(400) NOT NULL,
  `id_director` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `peliculas`
--

INSERT INTO `peliculas` (`id`, `titulo`, `duracion`, `anio`, `portada`, `id_director`) VALUES
(1, 'Jurassic Park', 127, 1993, 'https://m.media-amazon.com/images/I/61iF3RSsLsL.jpg', 1),
(2, 'Inception', 148, 2010, 'https://m.media-amazon.com/images/I/714Mwnmg2mL._UF894,1000_QL80_.jpg', 2),
(3, 'Pulp Fiction', 154, 1994, 'https://m.media-amazon.com/images/I/718LfFW+tIL.jpg', 3),
(4, 'E.T.', 115, 1982, 'https://m.media-amazon.com/images/I/814-9+LgNTL.jpg', 1),
(5, 'Interstellar', 169, 2014, 'https://m.media-amazon.com/images/I/81kz06oSUeL.jpg', 2),
(7, 'Django Unchained', 165, 2012, 'https://m.media-amazon.com/images/I/81IVfnsVtIL._AC_UF1000,1000_QL80_.jpg', 3),
(8, 'The Wolf of Wall Street', 180, 2013, 'https://m.media-amazon.com/images/I/71Wp80+pLhL._AC_UF1000,1000_QL80_.jpg', 4),
(9, 'Shutter Island', 138, 2010, 'https://m.media-amazon.com/images/I/81FNja+9-iL._AC_UF1000,1000_QL80_.jpg', 4),
(10, 'Titanic', 195, 1997, 'https://m.media-amazon.com/images/I/71i6L1vZjiL.jpg', 5),
(11, 'Avatar', 162, 32009, 'https://m.media-amazon.com/images/I/91N1lG+LBIS._AC_UF1000,1000_QL80_.jpg', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resenias_peliculas`
--

CREATE TABLE `resenias_peliculas` (
  `id` int(11) NOT NULL,
  `id_pelicula` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `comentario` text NOT NULL,
  `puntaje` int(2) NOT NULL CHECK (`puntaje` between 1 and 5),
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` char(60) NOT NULL,
  `rol` enum('admin','usuarios') DEFAULT 'usuarios'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `password`, `rol`) VALUES
(6, 'webadmin', '$2y$10$UZ6.iGGx5iKQ8OS7esar8u970cN7L.WN3z3rqje/O7ULqq2vg5omi', 'admin');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `directores`
--
ALTER TABLE `directores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_director` (`id_director`);

--
-- Indices de la tabla `resenias_peliculas`
--
ALTER TABLE `resenias_peliculas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pelicula` (`id_pelicula`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `directores`
--
ALTER TABLE `directores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `resenias_peliculas`
--
ALTER TABLE `resenias_peliculas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `peliculas`
--
ALTER TABLE `peliculas`
  ADD CONSTRAINT `fk_director` FOREIGN KEY (`id_director`) REFERENCES `directores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `resenias_peliculas`
--
ALTER TABLE `resenias_peliculas`
  ADD CONSTRAINT `resenias_peliculas_ibfk_1` FOREIGN KEY (`id_pelicula`) REFERENCES `peliculas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
