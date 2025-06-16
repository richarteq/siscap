# SisCap - Sistema de Capacitación
SISCAP es una Aplicación Web(WebApp), para dar soporte a un sistema de Capacitación. Esta disponible a través del servicio de Internet y es gestionado y utilizado por administradores, profesores y estudiantes, que a su vez participan en una plataforma de trabajo de capacitaciones.

## Autor
- Richart Escobedo Quispe (richartescobedo@gmail.com).

## Colaboradores
- Yasiel Perez, Cristhian Quispe, David Mamani, Antonia Quispe, Zenon Quispe, María Figueroa, Victor Arapa, Nelida Quispe, Beto Puma.

## Requerimientos
- Ubuntu GNU/Linux 16.04 (Recomendado 20.04).
- Apache HTTP Server 2.x.
- PHP 7 (7.0 de preferencia).
- CakePHP (Ver requerimientos en Documentación oficial del framework o en el manual de instalación).
- Opcional: Docker (Se incluye un archivo Dockerfile para reconstruir servidor Backend.

## Docker

### Crear imagen
```
docker build -t richarteq/siscap .
```

### Crear contenedor con acceso sólo al servidor web
``` 
docker run -d -p 8192:80 --name siscap richarteq/siscap
```

## Acceder a la aplicación web SisCap desde el navegador Web
- http://127.0.0.1:8192/siscap

### Crear contenedor con acceso a los servidores web y de base de datos
```
docker run -d -p 8090:80 -p 3306:33060 --name siscap richarteq/siscap
```

### Acceder al contenedor desde terminal
```
docker exec -it siscap /bin/bash
```

### Iniciar contenedor
```
docker start siscap
```

### Detener contenedor
```
docker stop siscap
```

### Eliminar contenedor
```
docker rm siscap
```

### Eliminar imagen
```
docker rmi richarteq/siscap
```

#### Otros comandos desde terminal
``` 
php --version
PHP 7.0.33-79+ubuntu24.04.1+deb.sury.org+1 (cli) (built: Dec 24 2024 06:43:22) ( NTS )

/etc/init.d/apache2 status
apache2 is running.

apt-get update

apt-get install -y mariadb-server

/etc/init.d/mariadb restart

apt-cache search libapache2-mod-php

/etc/init.d/apache2 restart

chown -R siscap:www-data /webapps/siscap

ls /etc/apache2/sites-available

cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/siscap.conf

vim /etc/apache2/sites-available/siscap.conf
```

### siscap.conf (Virtual Host)
```
alias /siscap /webapps/siscap/webapp/webroot
<Directory /webapps/siscap/webapp/webroot>
       Options -Indexes +FollowSymLinks +Multiviews
       AllowOverride All
       Require all granted
</Directory>
<VirtualHost *:80>
        ServerAdmin siscap@webapps.com
        ServerName siscap.webapps.com
        ServerAlias www.siscap.webapps.com
        DocumentRoot /webapps/siscap/webapp/webroot
        ErrorLog ${APACHE_LOG_DIR}/siscap.error.log
        CustomLog ${APACHE_LOG_DIR}/siscap.access.log combined
</VirtualHost>
```

````
# a2ensite siscap.conf

# /etc/init.d/apache2 reload

# vim /webapps/siscap/webapp/config/app.php
```

### Credenciales de acceso a SisCap
```
admin@siscap.com	12345678
teacher@siscap.com	12345678
student@siscap.com	12345678
````

