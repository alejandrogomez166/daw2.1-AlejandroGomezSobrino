
SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de datos: `alimentos`
--
CREATE DATABASE IF NOT EXISTS `tienda` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tienda`;

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `tipo`

DROP TABLE IF EXISTS `tipo`;
CREATE TABLE IF NOT EXISTS `tipo` (
                                           `id` int(5) NOT NULL AUTO_INCREMENT,
                                           `Nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
                                           PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo`
--

INSERT INTO `tipo` (`id`, `Nombre`) VALUES
(1, 'Carne'),
(100, 'Pescado'),
(45, 'Fruta'),
(2, 'Verdura'),
(5888, 'Otro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tienda`
--

DROP TABLE IF EXISTS `tienda`;
CREATE TABLE IF NOT EXISTS `tienda` (
                                         `id` int(5) NOT NULL AUTO_INCREMENT,
                                         `Nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
                                         `Cantidad` int(5) DEFAULT NULL,                                      
                                         `Carrito` tinyint(1) NOT NULL DEFAULT 0,
                                         `tipoId` int(5) NOT NULL,
                                         PRIMARY KEY (`id`),
                                         KEY `fk_tipoIdIdx` (`tipoId`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tienda`
--

INSERT INTO `tienda` (`id`, `Nombre`, `Cantidad`, `Carrito`, `tipoId`) VALUES
(1, 'Tarator',50,1,5888),
(2, 'Naranjas',15,1,45 ),
(3, 'Alcachofas',12, 1,2),
(4, 'Jamón Serrano', 32, 1, 1),
(5, 'Judias Verdes',20,1, 2),
(6, 'Pepino',4,1, 2),
(7, 'Bacalao', 8, 1, 100),
(8, 'Sardinas',20, 1, 100),
(9, 'Pizza', 8, 1, 5888),
(10, 'Filete de Ternera', 23, 1, 1);



--
-- Filtros para la tabla `tienda`
--
ALTER TABLE `tienda`
    ADD CONSTRAINT `fk_tipoId` FOREIGN KEY (`tipoId`) REFERENCES `tipo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;