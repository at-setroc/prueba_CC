#!/usr/bin/env bash

# Limpiamos la cache
php /var/www/prueba_cc/bin/console cache:clear

service apache2 start

# Hacemos una acción infinita para que el POD no muera
touch test
tail -0f test