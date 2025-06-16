--Crear una base de datos
--CREATE DATABASE siscap;

--Crear usuario en mysql
CREATE USER 'siscap'@'localhost' IDENTIFIED BY '12345678';
CREATE USER 'siscap2'@'%' IDENTIFIED BY '12345678';

--Otorgar permisos a un usuario para una BD
GRANT ALL PRIVILEGES ON siscap.* TO 'siscap'@'localhost';
GRANT ALL PRIVILEGES ON siscap.* TO 'siscap2'@'%';

--Refrescar permisos y credenciales
FLUSH PRIVILEGES;