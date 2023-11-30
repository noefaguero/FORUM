-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 13-11-2023 a las 17:36:08
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `FORUM`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments`
--

CREATE TABLE `comments` (
  `id_comment` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_thread` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `comments`
--

INSERT INTO `comments` (`id_comment`, `comment`, `id_user`, `id_thread`) VALUES
(1, 'Me encanta estar al tanto de las últimas tendencias tecnológicas. ¿Alguien tiene alguna recomendación?', 4, 1),
(2, 'Creo que la inteligencia artificial está dando forma al futuro de la tecnología. ¿Qué opinan?', 5, 1),
(3, 'He visto muchas películas últimamente, pero \"Inception\" es definitivamente una obra maestra.', 6, 2),
(4, '¿Algún fanático del cine por aquí? ¡Compartan sus recomendaciones!', 4, 2),
(5, 'Mis experiencias de viaje favoritas siempre están relacionadas con la naturaleza. ¿Alguien más comparte esa pasión?', 5, 3),
(6, 'París es definitivamente un destino increíble. ¿Alguien más ha tenido una experiencia inolvidable allí?', 6, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `threads`
--

CREATE TABLE `threads` (
  `id_thread` int(11) NOT NULL,
  `category` varchar(30) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `body` text DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `threads`
--

INSERT INTO `threads` (`id_thread`, `category`, `title`, `body`, `id_user`) VALUES
(1, 'Tecnología', 'Últimas tendencias tecnológicas', '¿Cuáles son las tendencias tecnológicas en este momento?', 1),
(2, 'Cine y series', 'Recomendaciones de películas', 'Comparte tus películas favoritas', 2),
(3, 'Turismo', 'Experiencias de viaje inolvidables', '¿Cuál ha sido tu viaje más memorable? Comparte tus historias.', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `names` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `pw` varchar(128) NOT NULL,
  `gender` char(1) NOT NULL,
  `rol` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `names`, `email`, `pw`, `gender`, `rol`) VALUES
(1, 'carlos99', 'carlos99@example.com', '$2y$10$aVJJtykFTBudvLa40xISPe2h5fKTA4sMw8ZkUC0gdNIipzwZ26uCy', 'M', 'editor'),
(2, 'jose84', 'jose84@example.com', '$2y$10$aVJJtykFTBudvLa40xISPe2h5fKTA4sMw8ZkUC0gdNIipzwZ26uCy', 'M', 'editor'),
(3, 'adrina96', 'adriana96@example.com', '$2y$10$aVJJtykFTBudvLa40xISPe2h5fKTA4sMw8ZkUC0gdNIipzwZ26uCy', 'F', 'editor'),
(4, 'maria82', 'maria82@example.com', '$2y$10$NQNlGcM9EjhYB3WPWpUZoucoLZaQMrK8vZjj52bAEPG3QSI93VT8y', 'F', 'subscriber'),
(5, 'felipe78', 'felipe78@example.com', '$2y$10$NQNlGcM9EjhYB3WPWpUZoucoLZaQMrK8vZjj52bAEPG3QSI93VT8y', 'M', 'subscriber'),
(6, 'carmen90', 'carmen90@example.com', '$2y$10$NQNlGcM9EjhYB3WPWpUZoucoLZaQMrK8vZjj52bAEPG3QSI93VT8y', 'F', 'subscriber');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id_comment`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_thread` (`id_thread`);

--
-- Indices de la tabla `threads`
--
ALTER TABLE `threads`
  ADD PRIMARY KEY (`id_thread`),
  ADD KEY `id_user` (`id_user`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comments`
--
ALTER TABLE `comments`
  MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `threads`
--
ALTER TABLE `threads`
  MODIFY `id_thread` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`id_thread`) REFERENCES `threads` (`id_thread`);

--
-- Filtros para la tabla `threads`
--
ALTER TABLE `threads`
  ADD CONSTRAINT `threads_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
