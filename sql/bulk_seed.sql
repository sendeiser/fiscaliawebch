-- Seed masivo de personas y expedientes
-- Base: fiscaliach
-- Asegura consistencia con FK personas1.dnidenunciante → expedientes.dnidenunciante

SET NAMES utf8;

-- 1) Completar personas1 para DNIs ya presentes en expedientes (si faltan)
INSERT INTO personas1 (dnidenunciante, nombre, apellido, genero, nombreabogado)
SELECT e.dnidenunciante,
       CASE MOD(e.dnidenunciante, 10)
         WHEN 0 THEN 'Juan' WHEN 1 THEN 'María' WHEN 2 THEN 'Carlos' WHEN 3 THEN 'Ana'
         WHEN 4 THEN 'Pedro' WHEN 5 THEN 'Lucía' WHEN 6 THEN 'Sofía' WHEN 7 THEN 'Miguel'
         WHEN 8 THEN 'Valeria' ELSE 'Jorge' END AS nombre,
       CASE MOD(e.dnidenunciante, 10)
         WHEN 0 THEN 'Pérez' WHEN 1 THEN 'Gómez' WHEN 2 THEN 'López' WHEN 3 THEN 'Rodríguez'
         WHEN 4 THEN 'Martínez' WHEN 5 THEN 'Fernández' WHEN 6 THEN 'Herrera' WHEN 7 THEN 'Torres'
         WHEN 8 THEN 'Díaz' ELSE 'Álvarez' END AS apellido,
       CASE MOD(e.dnidenunciante, 4)
         WHEN 0 THEN 'Femenino' WHEN 1 THEN 'Masculino' WHEN 2 THEN 'No binario' ELSE NULL END AS genero,
       CASE MOD(e.dnidenunciante, 5)
         WHEN 0 THEN 'Dr. Ricardo Tapia' WHEN 1 THEN 'Dra. Mónica Soria' WHEN 2 THEN 'Dr. Hugo Roldán'
         WHEN 3 THEN 'Dra. Natalia Bustamante' ELSE NULL END AS nombreabogado
FROM expedientes e
WHERE NOT EXISTS (
  SELECT 1 FROM personas1 p WHERE p.dnidenunciante = e.dnidenunciante
);
-- 2) Generar 500 nuevos expedientes con DNIs únicos (41000000..41000499)
WITH RECURSIVE seq(n) AS (
  SELECT 1
  UNION ALL
  SELECT n + 1 FROM seq WHERE n < 500
)
INSERT INTO expedientes (
  dnidenunciante, denunciado, causa, medida, fojas, librodeactas,
  codigocomisaria, numerodeexpediente, numexpinstru, fechadeentrada, fechadesalida
)
SELECT 
  41000000 + n - 1 AS dnidenunciante,
  CASE MOD(n, 10)
    WHEN 0 THEN 'Juan Pérez' WHEN 1 THEN 'María Gómez' WHEN 2 THEN 'Carlos López' WHEN 3 THEN 'Ana Rodríguez'
    WHEN 4 THEN 'Pedro Martínez' WHEN 5 THEN 'Lucía Fernández' WHEN 6 THEN 'Sofía Herrera' WHEN 7 THEN 'Miguel Torres'
    WHEN 8 THEN 'Valeria Díaz' ELSE 'Jorge Álvarez' END AS denunciado,
  CASE MOD(n, 6)
    WHEN 0 THEN 'Robo' WHEN 1 THEN 'Hurto' WHEN 2 THEN 'Estafa'
    WHEN 3 THEN 'Violencia' WHEN 4 THEN 'Lesiones' ELSE 'Amenazas' END AS causa,
  CASE MOD(n, 7)
    WHEN 0 THEN 'Prisión preventiva' WHEN 1 THEN 'Libertad condicional' WHEN 2 THEN 'Probation'
    WHEN 3 THEN 'Embargo preventivo' WHEN 4 THEN 'Botón antipánico' WHEN 5 THEN 'Multa' ELSE 'Trabajo comunitario' END AS medida,
  (MOD(n, 20) + 1) AS fojas,
  (MOD(n, 4) + 1) AS librodeactas,
  (MOD(n, 7) + 1) AS codigocomisaria,
  (200000 + n) AS numerodeexpediente,
  CASE WHEN MOD(n, 3) = 0 THEN (2300 + n) ELSE NULL END AS numexpinstru,
  DATE_FORMAT(DATE_ADD('2024-06-01', INTERVAL n DAY), '%Y-%m-%d') AS fechadeentrada,
  CASE WHEN MOD(n, 5) = 0 THEN DATE_FORMAT(DATE_ADD('2024-06-01', INTERVAL n + 30 DAY), '%Y-%m-%d') ELSE NULL END AS fechadesalida;
-- 3) Generar 500 personas1 correspondientes a los DNIs anteriores
WITH RECURSIVE seq(n) AS (
  SELECT 1
  UNION ALL
  SELECT n + 1 FROM seq WHERE n < 500
)
INSERT INTO personas1 (
  dnidenunciante, nombre, apellido, genero, nombreabogado
)
SELECT 
  41000000 + n - 1 AS dnidenunciante,
  CASE MOD(n, 12)
    WHEN 0 THEN 'Juan' WHEN 1 THEN 'María' WHEN 2 THEN 'Carlos' WHEN 3 THEN 'Ana'
    WHEN 4 THEN 'Pedro' WHEN 5 THEN 'Lucía' WHEN 6 THEN 'Sofía' WHEN 7 THEN 'Miguel'
    WHEN 8 THEN 'Valeria' WHEN 9 THEN 'Jorge' WHEN 10 THEN 'Daniela' ELSE 'Franco' END AS nombre,
  CASE MOD(n, 12)
    WHEN 0 THEN 'Pérez' WHEN 1 THEN 'Gómez' WHEN 2 THEN 'López' WHEN 3 THEN 'Rodríguez'
    WHEN 4 THEN 'Martínez' WHEN 5 THEN 'Fernández' WHEN 6 THEN 'Herrera' WHEN 7 THEN 'Torres'
    WHEN 8 THEN 'Díaz' WHEN 9 THEN 'Álvarez' WHEN 10 THEN 'Suárez' ELSE 'Molina' END AS apellido,
  CASE MOD(n, 4)
    WHEN 0 THEN 'Femenino' WHEN 1 THEN 'Masculino' WHEN 2 THEN 'No binario' ELSE NULL END AS genero,
  CASE MOD(n, 6)
    WHEN 0 THEN 'Dr. Ricardo Tapia' WHEN 1 THEN 'Dra. Mónica Soria' WHEN 2 THEN 'Dr. Hugo Roldán'
    WHEN 3 THEN 'Dra. Natalia Bustamante' WHEN 4 THEN 'Dr. Gabriel Moyano' ELSE NULL END AS nombreabogado;
