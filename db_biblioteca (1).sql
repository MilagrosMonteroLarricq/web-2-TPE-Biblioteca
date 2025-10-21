-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-10-2025 a las 02:58:50
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
-- Base de datos: `db_biblioteca`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autores`
--

CREATE TABLE `autores` (
  `id_autor` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `nacionalidad` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `autores`
--

INSERT INTO `autores` (`id_autor`, `nombre`, `apellido`, `nacionalidad`) VALUES
(1, 'Gabriel ', 'García Márquez', 'Colombiano'),
(2, 'Joanne Kathleen', 'Rowling', 'Británica'),
(3, 'Haruki', 'Murakami', 'Japonés'),
(4, 'Isabel', 'Allende', 'Chilena'),
(5, 'María Elena ', 'Walsh', 'Argentina'),
(6, 'Miguel ', 'de Cervantes ', 'Español');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `id_libro` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `genero` varchar(50) DEFAULT NULL,
  `anio_publicacion` int(11) DEFAULT NULL,
  `editorial` varchar(100) DEFAULT NULL,
  `id_autor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`id_libro`, `titulo`, `genero`, `anio_publicacion`, `editorial`, `id_autor`) VALUES
(1, 'Paula', 'Novela- autobiografía', 1994, 'Plaza & Janés', 4),
(2, 'La casa de los espíritus ', 'Novela- realismo mágico', 1982, 'Editorial Sudamericana', 4),
(3, 'Tokio Blues', 'Novela- ficción', 1987, 'Tusquets Editores', 3),
(4, 'Primera persona del singular ', 'Ficción', 2021, 'Tusquets Editores', 3),
(5, 'Harry Potter y el Prisionero de Azkaban', 'Novela fantastica', 1999, 'Bloomsbury', 2),
(6, 'Harry Potter y el cáliz de fuego ', 'Novela fantastica', 2000, 'Bloomsbury', 2),
(7, 'Don Quijote de la Mancha', 'Novela de aventuras', 1605, 'Juan de la Cuesta', 6),
(8, 'La Galatea', 'Novela romantica', 1585, 'Cátedra', 6),
(9, 'Cien años de soledad ', 'Realismo mágico', 1967, 'Editorial Sudamericana', 1),
(10, 'El amor en los tiempos del cólera', 'Novela romantica', 1985, 'La oveja negra', 1),
(11, 'Dailan Kifki', 'Ficción', 1966, 'Fariña Editores', 5),
(12, 'Manuelita, ¿dónde vas?', 'Literatura infantil ', 1997, 'Alfaguara Infantil Juvenil', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `email`, `password`, `rol`) VALUES
(1, 'webadmin', '$2y$10$J/uQtxpAuzEY2MA76zEYKexhtIi.70.Ai4PxDOaVEnm1UKfYlJ5dW', 'admin');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `autores`
--
ALTER TABLE `autores`
  ADD PRIMARY KEY (`id_autor`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`id_libro`),
  ADD KEY `id_autor` (`id_autor`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `autores`
--
ALTER TABLE `autores`
  MODIFY `id_autor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `id_libro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `libros`
--
ALTER TABLE `libros`
  ADD CONSTRAINT `libros_ibfk_1` FOREIGN KEY (`id_autor`) REFERENCES `autores` (`id_autor`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
