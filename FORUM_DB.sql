-- CREATE THE DATABASE 

CREATE DATABASE IF NOT EXISTS `FORUM` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `FORUM`;

-- STRUCTURE OF `USERS` TABLE

CREATE TABLE `users` (
    `id_user` int(11) NOT NULL AUTO_INCREMENT,
    `names` varchar(30) NOT NULL,
    `email` varchar(30) NOT NULL,
    `pw` varchar(128) NOT NULL,
    `genre` char(2) NOT NULL, 
    `rol` varchar(20) NOT NULL,
    PRIMARY KEY (`id_user`)
);

-- DATA DUMP FOR `USERS` TABLE

INSERT INTO `users` (`id_user`, `names`, `email`, `pw`, `genre`, `rol`)
VALUES
    (1, 'carlos99', 'carlos99@example.com', '$2y$10$aVJJtykFTBudvLa40xISPe2h5fKTA4sMw8ZkUC0gdNIipzwZ26uCy', 'M', 'editor'),
    (2, 'jose84', 'jose84@example.com', '$2y$10$aVJJtykFTBudvLa40xISPe2h5fKTA4sMw8ZkUC0gdNIipzwZ26uCy', 'M', 'editor'),
    (3, 'adrina96', 'adriana96@example.com', '$2y$10$aVJJtykFTBudvLa40xISPe2h5fKTA4sMw8ZkUC0gdNIipzwZ26uCy', 'F', 'editor'),
    (4, 'maria82', 'maria82@example.com', '$2y$10$NQNlGcM9EjhYB3WPWpUZoucoLZaQMrK8vZjj52bAEPG3QSI93VT8y', 'F', 'subscriber'),
    (5, 'felipe78', 'felipe78@example.com', '$2y$10$NQNlGcM9EjhYB3WPWpUZoucoLZaQMrK8vZjj52bAEPG3QSI93VT8y', 'M', 'subscriber'),
    (6, 'carmen90', 'carmen90@example.com', '$2y$10$NQNlGcM9EjhYB3WPWpUZoucoLZaQMrK8vZjj52bAEPG3QSI93VT8y', 'F', 'subscriber');

-- STRUCTURE OF `THREADS` TABLE

CREATE TABLE `threads` (
    `id_thread` int(11) NOT NULL AUTO_INCREMENT,
    `category` varchar(30),
    `title` varchar(100) NOT NULL,
    `body` text,
    `id_user` int,
    PRIMARY KEY (`id_thread`),
    FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`)
);

-- DATA DUMP FOR `THREADS` TABLE

INSERT INTO `threads` (`id_thread`, `category`, `title`, `body`, `id_user`)
VALUES 
    (1, 'Tecnología', 'Últimas tendencias tecnológicas', '¿Cuáles son las tendencias tecnológicas en este momento?', 1),
    (2, 'Cine y series', 'Recomendaciones de películas', 'Comparte tus películas favoritas', 2),
    (3, 'Turismo', 'Experiencias de viaje inolvidables', '¿Cuál ha sido tu viaje más memorable? Comparte tus historias.', 3);

-- STRUCTURE OF `COMMENTS` TABLE

CREATE TABLE `comments` (
    `id_comment` int(11) NOT NULL AUTO_INCREMENT,
    `comment` text,
    `id_user` int,
    `id_thread` int,
    PRIMARY KEY (`id_comment`),
    FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
    FOREIGN KEY (`id_thread`) REFERENCES `threads` (`id_thread`)
);

-- DATA DUMP FOR `COMMENTS` TABLE

INSERT INTO `comments` (`id_comment`, `comment`, `id_user`, `id_thread`)
VALUES
    (1, 'Me encanta estar al tanto de las últimas tendencias tecnológicas. ¿Alguien tiene alguna recomendación?', 4, 1),
    (2, 'Creo que la inteligencia artificial está dando forma al futuro de la tecnología. ¿Qué opinan?', 5, 1),
    (3, 'He visto muchas películas últimamente, pero "Inception" es definitivamente una obra maestra.', 6, 2),
    (4, '¿Algún fanático del cine por aquí? ¡Compartan sus recomendaciones!', 4, 2),
    (5, 'Mis experiencias de viaje favoritas siempre están relacionadas con la naturaleza. ¿Alguien más comparte esa pasión?', 5, 3),
    (6, 'París es definitivamente un destino increíble. ¿Alguien más ha tenido una experiencia inolvidable allí?', 6, 3);

