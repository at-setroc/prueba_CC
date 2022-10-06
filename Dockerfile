FROM php:8.1-apache

# Instalamos paquetes necesitarios
RUN apt-get update && apt-get install -y libxml2-dev libzip-dev

# Instalamos módulos PHP necesarios
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install xml
RUN docker-php-ext-install zip

# Creamos las carpetas donde irá el proyecto
RUN mkdir /var/www/prueba_cc

# Ponemos que cuando abramos el pod vaya a esa carpeta
WORKDIR /var/www/prueba_cc

# Copiamos la configuración de apache
COPY ./docker/default.conf /etc/apache2/sites-available/000-default.conf
COPY ./docker/extra-conf.ini /usr/local/etc/php/conf.d/extra-conf.ini
RUN ln -s /usr/local/bin/php /usr/bin/php
RUN rm /etc/apache2/sites-enabled/*
RUN a2ensite 000-default.conf
RUN a2enmod ssl

# Copiamos y damos permisos al SCRIPT de inicialización del docker
COPY ./docker/startup.sh /etc/startup.sh
RUN chmod 777 /etc/startup.sh

# Copiamos en el PATH de la máquina el siguiente texto para ejecutar el bin que existe en los vendors
RUN PATH=$PATH:/usr/src/apps/vendor/bin:bin

# Instalamos composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer

# Ponemos correctamente la hora del servidor
ENV TZ=Europe/Madrid
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Copiamos el código
COPY ./ /var/www/prueba_cc

# Copiamos los archivos parameters
COPY ./.env /var/www/prueba_cc/web/.env.local

# Instalamos composer
RUN composer install

ENTRYPOINT ["/etc/startup.sh"]