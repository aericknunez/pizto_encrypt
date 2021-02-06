CREATE TABLE `mesa_comentarios` (
  `id` int(6) NOT NULL,
  `mesa` int(6) NOT NULL,
  `tx` int(2) NOT NULL,
  `comentario` text NOT NULL,
  `fecha` varchar(20) NOT NULL,
  `hora` varchar(20) NOT NULL,
  `td` int(2) NOT NULL,
  `hash` varchar(12) NOT NULL,
  `time` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `mesa_comentarios`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `mesa_comentarios`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;
