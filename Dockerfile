FROM ubuntu:22.04
ENV DEBIAN_FRONTEND="noninteractive"

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

RUN mkdir -p /home/siscap
RUN useradd siscap -m && echo "siscap:12345678" | chpasswd
RUN echo "root:12345678" | chpasswd

RUN echo "export LC_ALL=es_PE.UTF-8" >> /home/siscap/.bashrc
RUN echo "export LANG=es_PE.UTF-8" >> /home/siscap/.bashrc
RUN echo "export LANGUAGE=es_PE.UTF-8" >> /home/siscap/.bashrc

RUN echo "export LC_ALL=es_PE.UTF-8" >> /root/.bashrc
RUN echo "export LANG=es_PE.UTF-8" >> /root/.bashrc
RUN echo "export LANGUAGE=es_PE.UTF-8" >> /root/.bashrc

RUN apt-get install -y vim

WORKDIR /webapps/siscap
COPY /* /webapps/siscap

RUN chown -R www-data:siscap /webapps/siscap

RUN apt-get clean
RUN rm -rf /var/lib/apt/lists/*

RUN systemctl enable mariadb

EXPOSE 3306
EXPOSE 80

#CMD ["apachectl", "-D", "FOREGROUND"]
CMD ["bash", "-c", "service mariadb start && apachectl -D FOREGROUND"]
