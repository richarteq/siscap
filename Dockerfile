FROM ubuntu:22.04
ENV DEBIAN_FRONTEND="noninteractive"

# Variables de entorno
ENV MYSQL_ROOT_PASSWORD=12345678
ENV MYSQL_DATABASE=siscap
ENV MYSQL_USER=siscap
ENV MYSQL_PASSWORD=12345678

RUN apt-get update
RUN apt-get install -y apache2 mariadb-server
RUN apt install -y software-properties-common
RUN add-apt-repository -y ppa:ondrej/php
RUN apt-get update
RUN apt-get install -y php7.0
RUN apt-get install -y libapache2-mod-php7.0 php7.0-mysql php7.0-mbstring php7.0-xml php7.0-gd php7.0-curl php7.0-intl php7.0-json php7.0-mcrypt php7.0-opcache php7.0-zip  php7.0-sqlite3
RUN apt -y install systemctl

RUN apt-get install -y locales
RUN echo -e 'LANG=es_PE.UTF-8\nLC_ALL=es_PE.UTF-8' > /etc/default/locale
RUN sed -i 's/^# *\(es_PE.UTF-8\)/\1/' /etc/locale.gen
RUN /sbin/locale-gen es_PE.UTF-8

RUN mkdir -p /webapps/siscap
RUN mkdir -p /webapps/siscap/webapp
RUN mkdir -p /webapps/siscap/folder

RUN mkdir -p /home/siscap
RUN useradd siscap -m && echo "siscap:12345678" | chpasswd
RUN echo "root:12345678" | chpasswd

RUN echo "export LC_ALL=es_PE.UTF-8" >> /home/siscap/.bashrc
RUN echo "export LANG=es_PE.UTF-8" >> /home/siscap/.bashrc
RUN echo "export LANGUAGE=es_PE.UTF-8" >> /home/siscap/.bashrc

RUN echo "export LC_ALL=es_PE.UTF-8" >> /root/.bashrc
RUN echo "export LANG=es_PE.UTF-8" >> /root/.bashrc
RUN echo "export LANGUAGE=es_PE.UTF-8" >> /root/.bashrc

#RUN apt-get install -y vim

WORKDIR /webapps/siscap
COPY /webapp /webapps/siscap/webapp
COPY /folder /webapps/siscap/folder
COPY /siscap.sql /webapps/siscap/siscap.sql

RUN touch /etc/apache2/sites-available/siscap.conf

RUN echo 'alias /siscap /webapps/siscap/webapp/webroot' >> /etc/apache2/sites-available/siscap.conf && \
echo '<Directory /webapps/siscap/webapp/webroot>' >> /etc/apache2/sites-available/siscap.conf && \
echo '        Options -Indexes +FollowSymLinks +Multiviews' >> /etc/apache2/sites-available/siscap.conf && \
echo '        AllowOverride All' >> /etc/apache2/sites-available/siscap.conf && \
echo '        Require all granted' >> /etc/apache2/sites-available/siscap.conf && \
echo '</Directory>' >> /etc/apache2/sites-available/siscap.conf && \
echo '<VirtualHost *:80>' >> /etc/apache2/sites-available/siscap.conf && \
echo '        ServerAdmin siscap@webapps.com' >> /etc/apache2/sites-available/siscap.conf && \
echo '        ServerName siscap.webapps.com' >> /etc/apache2/sites-available/siscap.conf && \
echo '        ServerAlias www.siscap.webapps.com' >> /etc/apache2/sites-available/siscap.conf && \
echo '        DocumentRoot /webapps/siscap/webapp/webroot' >> /etc/apache2/sites-available/siscap.conf && \
echo '        ErrorLog ${APACHE_LOG_DIR}/siscap.error.log' >> /etc/apache2/sites-available/siscap.conf && \
echo '        CustomLog ${APACHE_LOG_DIR}/siscap.access.log combined' >> /etc/apache2/sites-available/siscap.conf && \
echo '</VirtualHost>' >> /etc/apache2/sites-available/siscap.conf

RUN a2enmod rewrite
RUN a2ensite siscap.conf

RUN service mariadb start && \
    mysql -e "CREATE DATABASE IF NOT EXISTS $MYSQL_DATABASE;" -u root && \
    mysql -e "CREATE USER IF NOT EXISTS '$MYSQL_USER'@'localhost' IDENTIFIED BY '$MYSQL_PASSWORD';" -u root && \
    mysql -e "GRANT ALL PRIVILEGES ON $MYSQL_DATABASE.* TO '$MYSQL_USER'@'localhost'; FLUSH PRIVILEGES;" -u root && \
    mysql -u root $MYSQL_DATABASE < /webapps/siscap/siscap.sql

RUN chmod -R 755 /webapps/siscap
RUN chown -R siscap:www-data /webapps/siscap

RUN chmod -R 755 /webapps/siscap/folder
RUN chown -R www-data:www-data /webapps/siscap/folder

RUN chmod 775 -R /webapps/siscap/webapp/logs/
RUN chmod 775 -R /webapps/siscap/webapp/tmp/

RUN chown www-data:siscap -R /webapps/siscap/webapp/tmp/
chown www-data:siscap -R /webapps/siscap/webapp/logs/

RUN apt-get clean
RUN rm -rf /var/lib/apt/lists/*

RUN systemctl enable mariadb

EXPOSE 3306
EXPOSE 80

#CMD ["apachectl", "-D", "FOREGROUND"]
CMD ["bash", "-c", "service mariadb start && apachectl -D FOREGROUND"]
