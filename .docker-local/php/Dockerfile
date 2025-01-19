# Usar la última versión estable de PHP FPM sobre Alpine
FROM php:8.3-fpm-alpine3.18

# Instalar dependencias del sistema necesarias
RUN apk --update --no-cache add \
    linux-headers \
    autoconf \
    g++ \
    make \
    git \
    openssh-client

# Instalar y configurar Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Copiar configuración personalizada de Xdebug
COPY ./xdebug.ini "${PHP_INI_DIR}/conf.d/xdebug.ini"

# Instalar y habilitar la extensión MongoDB
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

# Instalar Composer desde la última imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Crear directorio de trabajo y asignar permisos
RUN mkdir -p /var/www/html/reserbadass
WORKDIR /var/www/html/reserbadass
RUN adduser -S 1000 -u 1000  && chown -R 1000:1000 /home/1000

# Actualizar configuración de OpenSSL para evitar problemas con renegociaciones inseguras
RUN sed -i 's/providers = provider_sect/providers = provider_sect\n\
ssl_conf = ssl_sect\n\
\n\
[ssl_sect]\n\
system_default = system_default_sect\n\
\n\
[system_default_sect]\n\
Options = UnsafeLegacyRenegotiation/' /etc/ssl/openssl.cnf
