-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-03-2019 a las 02:52:19
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `red_social`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `amigos`
--

CREATE TABLE `amigos` (
  `CodAm` int(11) NOT NULL,
  `usua_enviador` int(11) DEFAULT NULL,
  `usua_receptor` int(11) DEFAULT NULL,
  `status` bit(1) DEFAULT NULL,
  `solicitud` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `CodCom` int(11) NOT NULL,
  `comentario` text,
  `CodPost` int(11) DEFAULT NULL,
  `CodUsua` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `denuncia`
--

CREATE TABLE `denuncia` (
  `CodDen` int(11) NOT NULL,
  `CodUsua` int(11) DEFAULT NULL,
  `CodPost` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mg`
--

CREATE TABLE `mg` (
  `CodLike` int(11) NOT NULL,
  `CodPost` int(11) DEFAULT NULL,
  `CodUsua` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `CodNot` int(11) NOT NULL,
  `accion` bit(1) DEFAULT NULL,
  `visto` bit(1) DEFAULT NULL,
  `CodPost` int(11) DEFAULT NULL,
  `CodUsua` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post`
--

CREATE TABLE `post` (
  `CodPost` int(11) NOT NULL,
  `titulo` text,
  `autor` varchar(200) DEFAULT NULL,
  `fecha` varchar(200) DEFAULT NULL,
  `categoria` varchar(200) DEFAULT NULL,
  `contenido` text,
  `img` varchar(200) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `alt` varchar(200) NOT NULL,
  `CodUsua` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `CodUsua` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `pass` varchar(200) DEFAULT NULL,
  `pais` varchar(100) DEFAULT NULL,
  `profesion` varchar(50) DEFAULT NULL,
  `discapacidad` varchar(50) DEFAULT NULL,
  `foto_perfil` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `amigos`
--
ALTER TABLE `amigos`
  ADD PRIMARY KEY (`CodAm`),
  ADD KEY `usua_enviador` (`usua_enviador`),
  ADD KEY `usua_receptor` (`usua_receptor`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`CodCom`),
  ADD KEY `CodUsua` (`CodUsua`),
  ADD KEY `CodPost` (`CodPost`);

--
-- Indices de la tabla `denuncia`
--
ALTER TABLE `denuncia`
  ADD PRIMARY KEY (`CodDen`),
  ADD KEY `CodUsua` (`CodUsua`),
  ADD KEY `CodPost` (`CodPost`);

--
-- Indices de la tabla `mg`
--
ALTER TABLE `mg`
  ADD PRIMARY KEY (`CodLike`),
  ADD KEY `CodUsua` (`CodUsua`),
  ADD KEY `CodPost` (`CodPost`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`CodNot`),
  ADD KEY `CodUsua` (`CodUsua`),
  ADD KEY `fk_post` (`CodPost`);

--
-- Indices de la tabla `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`CodPost`),
  ADD KEY `CodUsua` (`CodUsua`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`CodUsua`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `amigos`
--
ALTER TABLE `amigos`
  MODIFY `CodAm` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `CodCom` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `denuncia`
--
ALTER TABLE `denuncia`
  MODIFY `CodDen` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mg`
--
ALTER TABLE `mg`
  MODIFY `CodLike` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `CodNot` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `post`
--
ALTER TABLE `post`
  MODIFY `CodPost` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `CodUsua` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `amigos`
--
ALTER TABLE `amigos`
  ADD CONSTRAINT `amigos_ibfk_1` FOREIGN KEY (`usua_enviador`) REFERENCES `usuarios` (`CodUsua`),
  ADD CONSTRAINT `amigos_ibfk_2` FOREIGN KEY (`usua_receptor`) REFERENCES `usuarios` (`CodUsua`);

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`CodUsua`) REFERENCES `usuarios` (`CodUsua`),
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`CodPost`) REFERENCES `post` (`CodPost`);

--
-- Filtros para la tabla `denuncia`
--
ALTER TABLE `denuncia`
  ADD CONSTRAINT `denuncia_ibfk_1` FOREIGN KEY (`CodUsua`) REFERENCES `usuarios` (`CodUsua`),
  ADD CONSTRAINT `denuncia_ibfk_2` FOREIGN KEY (`CodPost`) REFERENCES `post` (`CodPost`);

--
-- Filtros para la tabla `mg`
--
ALTER TABLE `mg`
  ADD CONSTRAINT `mg_ibfk_1` FOREIGN KEY (`CodUsua`) REFERENCES `usuarios` (`CodUsua`),
  ADD CONSTRAINT `mg_ibfk_2` FOREIGN KEY (`CodPost`) REFERENCES `post` (`CodPost`);

--
-- Filtros para la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `fk_post` FOREIGN KEY (`CodPost`) REFERENCES `post` (`CodPost`),
  ADD CONSTRAINT `notificaciones_ibfk_1` FOREIGN KEY (`CodUsua`) REFERENCES `usuarios` (`CodUsua`);

--
-- Filtros para la tabla `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`CodUsua`) REFERENCES `usuarios` (`CodUsua`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
