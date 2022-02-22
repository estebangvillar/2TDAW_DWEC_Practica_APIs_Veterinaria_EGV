-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-02-2022 a las 19:09:57
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
-- Base de datos: `veterinaria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `cliente` bigint(20) UNSIGNED NOT NULL,
  `servicio` bigint(20) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `edad` tinyint(3) UNSIGNED NOT NULL,
  `foto` varchar(255) NOT NULL,
  `dni_dueño` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dueño`
--

CREATE TABLE `dueño` (
  `dni` varchar(9) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `telefono` varchar(9) DEFAULT NULL,
  `nick` varchar(25) NOT NULL,
  `pass` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `dueño`
--

INSERT INTO `dueño` (`dni`, `nombre`, `telefono`, `nick`, `pass`) VALUES
('000000000', 'Administrador', '749274621', 'admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticia`
--

CREATE TABLE `noticia` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `contenido` varchar(5000) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `fecha_publicacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `noticia`
--

INSERT INTO `noticia` (`id`, `titulo`, `contenido`, `imagen`, `fecha_publicacion`) VALUES
(1, 'Grabado por primera vez un ejemplar macho de nutri', 'El grupo de investigación y divulgación de medio natural Natura Sterna ha obtenido imágenes por primera vez de un ejemplar macho de nutria en el parque urbano de los lagos de Castell-Platja d\'Aro.\r\n\r\nFotografía de los avistamientos de nutrias en el Besòs de esta semana\r\nEFECTOS DE LA PANDEMIA EN LA NATURALEZA\r\nLas nutrias vuelven a dejarse ver por el Besòs\r\nSegún informa este colectivo, el animal fue captado por cámaras de las que se conocen como de fototrampeo y la confirmación de su presencia se produce poco antes de la apertura de la ampliación de este espacio natural, prevista para Semana Santa.', 'https://estaticos-cdn.elperiodico.com/clip/5afc8a03-f7f0-4a1e-a865-9e1363aaf432_alta-libre-aspect-ratio_default_0.jpg', '2022-01-19'),
(2, 'El Gobierno amplía a dos años de cárcel la pena', 'El Consejo de Ministros ha aprobado este viernes una modificación del Código Penal para ampliar las penas por maltrato animal. En concreto, se aumentará de 18 meses hasta dos años de prisión el maltrato que acabe con la muerte del animal y de tres meses a 18 meses de cárcel las agresiones que impliquen atención veterinaria. Con este cambio \"empezamos a terminar con la inmunidad hacia el maltrato\", ha destacado la ministra Ione Belarra tras la reunión ministerial.\r\n\r\nLa modificación penal llega acompañada de la aprobación del anteproyecto de ley de protección animal, que lleva paralizado desde que en octubre el Ministerio de Derechos Sociales difundió un borrador. La promulgación de una ley estatal es una asignatura pendiente desde hace décadas, por lo que las entidades protectoras y expertos en derechos de los animales aplauden la normativa aunque avisan de que es \"insuficiente\" puesto que se centra en las mascotas y los animales del entorno urbano.\r\n\r\nConcretamente, las investigadoras incluidas en el ranking son Marisol Izquierdo López, del área de Zoología, con un Fhm de 1,31; Noemí Castro Navarro, del área de Producción Animal, con un Fhm de 0,86; María José Caballero Cansino, del área de Anatomía y Anatomía Patológica Comparadas, con un Fhm de 0,83; Lidia Esther Robaina Robaina, del área de Zoología, con un Fhm de 0,83; Teresa Carrillo Díaz, del área de Medicina, con un Fhm de 0,77.', 'https://estaticos-cdn.elperiodico.com/clip/f4cde552-6d93-4561-85d3-ebe246b69c6d_alta-libre-aspect-ratio_default_0.jpg', '2022-04-13'),
(3, 'Frank de la Jungla y los animalistas', 'Un inofensivo mapache se coló en un portal de Gijón este sábado y el Principado de Asturias ha tomado la decisión de sacrificarlo -dentro del plan vigente de erradicación de especies exóticas invasoras- tras denominarlo como una \"especie invasora y prolífica\".\r\n\r\nLa Consejería de Medio Rural y Cohesión Territorial del Principado de Asturias se hizo cargo este sábado del mapache sin identificación recogido por los bomberos en un portal de Gijón.', 'https://estaticos-cdn.elperiodico.com/clip/4179af7b-b19e-4fcc-a963-b5878189fd52_alta-libre-aspect-ratio_default_0.png', '2022-03-14'),
(4, '¿Cuánto vive un agaporni?', 'De cola corta y gran colorido, los agapornis son unos loros pequeños de origen africano, aunque muchos creen que son oriundos de Sudamérica. Pertenecientes a la familia de los Psittaculidae, son aves acostumbradas a entornos secos y áridos.\r\n\r\nConsulta las noticias publicadas en el Club de Animales y Plantas de El Periódico\r\nSI QUIERES SABER MÁS...\r\nConsulta las noticias publicadas en el Club de Animales y Plantas de El Periódico\r\nDebido a que son pájaros monógamos- se emparejan y siguen juntos para siempre-, se les conoce también como inseparables. De hecho, su propio nombre viene de la palabra griega \'agápi\', que significa amor o afecto, y \'ornis\', que significa ave\r\n\r\nA la vista de la denuncia, agentes de la Guardia Civil del Seprona (Servicio de Protección de la Naturaleza) abrieron una investigación para verificar los supuestos ilícitos, iniciando una serie de inspecciones sobre granjas ganaderas destinadas a la cría de caballos.', 'https://estaticos-cdn.elperiodico.com/clip/0ea5e67a-5860-4778-8210-27050daaf98b_alta-libre-aspect-ratio_default_0.jpg', '2022-01-13'),
(5, 'Descubierto un mono con ojeras blancas', 'Un mono con ojeras blancas, un tritón con cuernos de diablo y un bambú resistente a la escasez de agua son parte de las 224 nuevas especies de fauna y flora encontradas en la región del Gran Mekong, desveló este miércoles el Fondo Mundial para la Naturaleza (WWF).\r\n\r\nEn su informe anual, que suspendió el año pasado debido a la pandemia, el grupo ecologista resalta el hallazgo de un nuevo mamífero, 35 reptiles, 17 anfibios, 16 peces y 155 plantas y arboles en esta zona de gran biodiversidad que incluye a Birmania, Camboya, Laos, Tailandia y Vietnam.\r\n\r\n\"La región del Gran Mekong está todavía en primera línea para el descubrimiento (de especies), pero estos hallazgos resaltan que estamos perdiendo y destruyendo el hábitat natural, y un comercio insostenible de especies salvajes\", subraya WWF al apuntar que 3.000 nuevas especies han sido encontradas en la región desde 1997.\r\n\r\n\r\nAlgunas de estas especies ya se podrían encontrar amenazada su supervivencia, entre ellas la citada nueva especie de mono encontrada en la planicie central de Birmania, de la que podrían quedar entre 200-250 ejemplares repartidos en cuatro remotas localizaciones, apuntan los ecologistas.\r\n\r\n', 'https://estaticos-cdn.elperiodico.com/clip/7c3f1703-2205-49a0-a0f6-44697fe97975_alta-libre-aspect-ratio_default_0.jpg', '2022-01-04'),
(6, 'Muere la suricata Wilson del zoo de Barcelona', 'Muchos son los animales que han hecho historia en el Zoo de Barcelona, como Copito de Nieve o la orca Ulises, y aquellos que sean usuarios habituales de este zoo conocerán el nombre de Wilson. Esta suricata, famosa por ser el único macho que no vivía en comunidad después de que su grupo le expulsara hace siete años, murió el pasado 22 de noviembre de 2021, tras alcanzar una edad de 22 años y tres meses.\r\n\r\nWilson era la suricata más longeva de toda Europa (en Barcelona también falleció la chimpancé más anciana del continente), ya que lo común es que, en cautividad, vivan entre los 13 y 15 años, y en cambio en libertad, 8 años. Su fama empezó cuando en 2014, su grupo le expulsó a él y a otro más por su elevada edad.', 'https://estaticos-cdn.elperiodico.com/clip/5b318ddc-51a3-4fa6-a82e-5aa5907ce990_alta-libre-aspect-ratio_default_0.jpg', '2022-01-02'),
(7, 'Investigan en Hong Kong el contagio de covid', 'Las autoridades sanitarias de Hong Kong han encontrado indicios que apuntan a un contagio de covid-19 a partir de hámsters importados de los Países Bajos, informó hoy el diario South China Morning Post.\r\n\r\nEl contagio, que corresponde a la variante delta del SARS-CoV-2, se detectó el domingo en una empleada de una tienda de mascotas de Causeway Bay y sería el primer caso de transmisión de animal a humano (zoonosis) que se registra en la excolonia británica.', 'https://estaticos-cdn.elperiodico.com/clip/89bace66-4dcf-4655-b483-e3cb941e9f21_alta-libre-aspect-ratio_default_0.jpg', '2022-01-08'),
(8, 'Muere Magawa, la rata buscaminas más famosa', 'Magawa, una rata condecorada por detectar minas antipersona en Camboya, murió el pasado fin de semana a los 8 años, informó la oenegé belga Apopo.\r\n\r\n\"Magawa se encontraba en buena salud y empleaba la mayoría de su tiempo jugando con su habitual entusiasmo. A medida que se acercaba el fin de semana parecía más lenta y dormía más, al mostrar menos interés por la comida en sus últimos días\", apuntó este martes en un comunicado la oenegé encargada de su adiestramiento y cuidado.Magawa se jubiló el pasado junio tras cinco años de trabajo en los que su olfato le ha permitido encontrar más de 100 minas y bombas sin estallar en el segundo país más afectado por este tipo de armas después de Afganistán.', 'https://estaticos-cdn.elperiodico.com/clip/b7035878-a978-477c-8df2-77254eea3753_alta-libre-aspect-ratio_default_0.jpg', '2021-11-02'),
(9, 'La Biblioteca Pompeu Fabra de Mataro', 'La Biblioteca Pompeu Fabra de Mataró (Maresme) acoge hasta el viernes 31 de diciembre la exposición fotográfica Companys de viatge: essència dels animals i dels humans. Se trata de una muestra de fotografías de Isabel Navarra que muestran a los perros acogidos en el Centre d\'Atenció d\'Animals Domèstics de Companyia (CAAD) del Maresme.\r\n\r\nSe trata de un proyecto que quiere sensibilizar sobre la tenencia responsable de animales a partir de 31 imágenes, así como la labor que realizan los voluntarios de la asociación VOLCAAD Maresme', 'https://estaticos-cdn.elperiodico.com/clip/a8136f99-e022-45f3-8fd8-a97947fccbb2_alta-libre-aspect-ratio_default_0.jpg', '2021-12-15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `precio` decimal(5,2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `duracion` tinyint(3) UNSIGNED NOT NULL,
  `precio` decimal(5,2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `testimonio`
--

CREATE TABLE `testimonio` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contenido` varchar(500) NOT NULL,
  `fecha` date NOT NULL,
  `dni_autor` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`cliente`,`fecha`,`hora`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `dueño_cliente` (`dni_dueño`);

--
-- Indices de la tabla `dueño`
--
ALTER TABLE `dueño`
  ADD PRIMARY KEY (`dni`),
  ADD UNIQUE KEY `dni` (`dni`),
  ADD UNIQUE KEY `nick` (`nick`);

--
-- Indices de la tabla `noticia`
--
ALTER TABLE `noticia`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `testimonio`
--
ALTER TABLE `testimonio`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `dueño_testimonio` (`dni_autor`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `noticia`
--
ALTER TABLE `noticia`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `testimonio`
--
ALTER TABLE `testimonio`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `dueño_cliente` FOREIGN KEY (`dni_dueño`) REFERENCES `dueño` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `testimonio`
--
ALTER TABLE `testimonio`
  ADD CONSTRAINT `dueño_testimonio` FOREIGN KEY (`dni_autor`) REFERENCES `dueño` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
