-- Datos ficticios de expedientes (60 registros)
-- Base: fiscaliach | Tabla: expedientes
-- Columnas: dnidenunciante, denunciado, causa, medida, fojas, librodeactas, codigocomisaria, numerodeexpediente, numexpinstru, fechadeentrada, fechadesalida

SET NAMES utf8;

INSERT INTO `expedientes` (
  `dnidenunciante`, `denunciado`, `causa`, `medida`, `fojas`, `librodeactas`, `codigocomisaria`, `numerodeexpediente`, `numexpinstru`, `fechadeentrada`, `fechadesalida`
) VALUES
(35658780, 'Juan Pérez', 'Robo', 'Prisión preventiva', 12, 1, 1, 100001, 2301, '2024-01-10', NULL),
(37945123, 'María Gómez', 'Lesiones', 'Prohibición de acercamiento', 8, 1, 2, 100002, NULL, '2024-01-12', '2024-02-05'),
(31245879, 'Carlos López', 'Violencia', 'Restricción perimetral', 10, 2, 3, 100003, 2302, '2024-01-15', NULL),
(29587412, 'Ana Rodríguez', 'Amenazas', 'Advertencia', 6, 2, 4, 100004, NULL, '2024-01-18', '2024-03-01'),
(40123568, 'Pedro Martínez', 'Hurto', 'Libertad condicional', 9, 3, 5, 100005, 2303, '2024-01-20', NULL),
(37894561, 'Lucía Fernández', 'Estafa', 'Embargo preventivo', 15, 1, 6, 100006, NULL, '2024-01-22', NULL),
(33456789, 'Sofía Herrera', 'Agresión', 'Trabajo comunitario', 7, 2, 7, 100007, 2304, '2024-01-25', '2024-02-20'),
(31897654, 'Miguel Torres', 'Daños', 'Reparación económica', 5, 3, 1, 100008, NULL, '2024-01-27', NULL),
(36258941, 'Valeria Díaz', 'Violencia', 'Perpetua (simulada)', 20, 4, 2, 100009, 2305, '2024-01-30', NULL),
(39214578, 'Jorge Álvarez', 'Robos reiterados', 'Prisión efectiva', 18, 2, 3, 100010, NULL, '2024-02-02', '2024-05-10'),
(35678412, 'Carla Romero', 'Lesiones leves', 'Probation', 4, 1, 4, 100011, NULL, '2024-02-05', NULL),
(37546981, 'Diego Sosa', 'Amenazas', 'Prohibición de contacto', 6, 3, 5, 100012, 2306, '2024-02-07', NULL),
(30124567, 'Gisela Ríos', 'Hurto simple', 'Multa', 3, 3, 6, 100013, NULL, '2024-02-10', '2024-03-15'),
(29654123, 'Ramiro Vega', 'Estafa', 'Embargo de bienes', 14, 4, 7, 100014, 2307, '2024-02-12', NULL),
(34561278, 'Laura Navarro', 'Violencia de género', 'Botón antipánico', 9, 2, 1, 100015, NULL, '2024-02-15', NULL),
(37896542, 'Franco Nieva', 'Robo calificado', 'Prisión preventiva', 13, 1, 2, 100016, 2308, '2024-02-18', NULL),
(32547891, 'Daniela Suárez', 'Amenazas', 'Restricción de acercamiento', 5, 3, 3, 100017, NULL, '2024-02-20', '2024-04-02'),
(36987412, 'Andrés Molina', 'Daños', 'Reparación plena', 6, 2, 4, 100018, NULL, '2024-02-22', NULL),
(31456987, 'Julieta Castro', 'Lesiones graves', 'Detención domiciliaria', 11, 3, 5, 100019, 2309, '2024-02-25', NULL),
(39785123, 'Tomás Rivas', 'Hurto', 'Libertad vigilada', 8, 1, 6, 100020, NULL, '2024-02-28', '2024-03-28'),
(35612478, 'Paula Ibáñez', 'Violencia', 'Prohibición de acercamiento', 7, 2, 7, 100021, 2310, '2024-03-02', NULL),
(37254816, 'Nicolás Bustos', 'Agresión', 'Trabajo comunitario', 9, 3, 1, 100022, NULL, '2024-03-05', NULL),
(30987415, 'Romina Silva', 'Estafa', 'Embargo preventivo', 16, 4, 2, 100023, NULL, '2024-03-07', '2024-04-12'),
(29874561, 'Gustavo Ordoñez', 'Robo', 'Prisión efectiva', 17, 2, 3, 100024, 2311, '2024-03-10', NULL),
(36124879, 'Florencia Paredes', 'Amenazas', 'Advertencia', 3, 1, 4, 100025, NULL, '2024-03-12', NULL),
(39587412, 'Hernán Fuentes', 'Lesiones', 'Probation', 5, 3, 5, 100026, NULL, '2024-03-15', NULL),
(31245678, 'Alicia Godoy', 'Hurto', 'Multa', 4, 1, 6, 100027, 2312, '2024-03-18', NULL),
(32789451, 'Marcelo Luna', 'Daños', 'Reparación económica', 6, 2, 7, 100028, NULL, '2024-03-20', '2024-05-01'),
(38451269, 'Silvina Ávila', 'Violencia', 'Botón antipánico', 9, 3, 1, 100029, NULL, '2024-03-23', NULL),
(34321876, 'Agustín Cabrera', 'Agresión', 'Trabajo comunitario', 7, 2, 2, 100030, 2313, '2024-03-25', NULL);

INSERT INTO `expedientes` (
  `dnidenunciante`, `denunciado`, `causa`, `medida`, `fojas`, `librodeactas`, `codigocomisaria`, `numerodeexpediente`, `numexpinstru`, `fechadeentrada`, `fechadesalida`
) VALUES
(31548792, 'Marina Quiroga', 'Estafa', 'Embargo preventivo', 12, 1, 3, 100031, NULL, '2024-03-28', NULL),
(39654127, 'Pablo Arce', 'Hurto', 'Libertad condicional', 8, 2, 4, 100032, 2314, '2024-03-30', '2024-04-30'),
(35897461, 'Cintia Viera', 'Violencia', 'Prohibición de acercamiento', 10, 3, 5, 100033, NULL, '2024-04-02', NULL),
(37214586, 'Emiliano Funes', 'Lesiones', 'Probation', 6, 1, 6, 100034, NULL, '2024-04-04', NULL),
(30198745, 'Patricia Becerra', 'Robo', 'Prisión efectiva', 19, 2, 7, 100035, 2315, '2024-04-06', NULL),
(29451687, 'Hugo Roldán', 'Amenazas', 'Restricción de acercamiento', 5, 3, 1, 100036, NULL, '2024-04-08', NULL),
(33321589, 'Mónica Soria', 'Agresión', 'Trabajo comunitario', 7, 4, 2, 100037, NULL, '2024-04-10', '2024-05-12'),
(38975412, 'Ricardo Tapia', 'Daños', 'Reparación económica', 6, 2, 3, 100038, 2316, '2024-04-12', NULL),
(31875469, 'Verónica Tello', 'Estafa', 'Embargo preventivo', 14, 1, 4, 100039, NULL, '2024-04-15', NULL),
(36789415, 'Gabriel Moyano', 'Hurto', 'Libertad vigilada', 8, 3, 5, 100040, NULL, '2024-04-18', '2024-05-18'),
(30457896, 'Natalia Bustamante', 'Violencia', 'Botón antipánico', 11, 2, 6, 100041, 2317, '2024-04-20', NULL),
(39254718, 'Fabián Carrizo', 'Lesiones graves', 'Detención domiciliaria', 13, 4, 7, 100042, NULL, '2024-04-22', NULL),
(35621479, 'Cecilia Duarte', 'Amenazas', 'Advertencia', 3, 1, 1, 100043, NULL, '2024-04-25', NULL),
(37985124, 'Mauricio Tejeda', 'Robo', 'Prisión preventiva', 16, 2, 2, 100044, 2318, '2024-04-27', NULL),
(31254786, 'Eliana Cardozo', 'Agresión', 'Trabajo comunitario', 5, 3, 3, 100045, NULL, '2024-04-30', '2024-06-02'),
(29876541, 'Sebastián Ponce', 'Daños', 'Reparación plena', 6, 4, 4, 100046, NULL, '2024-05-02', NULL),
(36125478, 'Lorena Escobar', 'Estafa', 'Embargo de bienes', 15, 2, 5, 100047, 2319, '2024-05-04', NULL),
(39561247, 'Hernán Cabrera', 'Hurto simple', 'Multa', 4, 1, 6, 100048, NULL, '2024-05-06', NULL),
(31246985, 'Ariel Vázquez', 'Violencia', 'Prohibición de acercamiento', 9, 3, 7, 100049, NULL, '2024-05-08', NULL),
(32784561, 'Estefanía Ruiz', 'Lesiones', 'Probation', 7, 2, 1, 100050, 2320, '2024-05-10', NULL),
(38451629, 'Agustina Leiva', 'Amenazas', 'Restricción de acercamiento', 6, 2, 2, 100051, NULL, '2024-05-12', NULL),
(34327618, 'Santiago Rivero', 'Robo calificado', 'Prisión preventiva', 18, 3, 3, 100052, NULL, '2024-05-14', '2024-07-01'),
(31548972, 'Mariela Gómez', 'Daños', 'Reparación económica', 5, 1, 4, 100053, NULL, '2024-05-16', NULL),
(39654821, 'Pablo Duarte', 'Estafa', 'Embargo preventivo', 12, 3, 5, 100054, 2321, '2024-05-18', NULL),
(35897146, 'Cintia Brizuela', 'Hurto', 'Libertad condicional', 8, 2, 6, 100055, NULL, '2024-05-20', NULL),
(37214568, 'Emiliano Godoy', 'Violencia de género', 'Botón antipánico', 10, 1, 7, 100056, NULL, '2024-05-22', NULL),
(30198754, 'Patricia Argañaraz', 'Lesiones', 'Probation', 6, 2, 1, 100057, 2322, '2024-05-24', NULL),
(29451867, 'Hugo Ledesma', 'Amenazas', 'Advertencia', 4, 3, 2, 100058, NULL, '2024-05-26', '2024-06-15'),
(33321598, 'Mónica Páez', 'Agresión', 'Trabajo comunitario', 7, 4, 3, 100059, NULL, '2024-05-28', NULL),
(38975421, 'Ricardo Ríos', 'Daños', 'Reparación plena', 6, 1, 4, 100060, NULL, '2024-05-30', NULL);
