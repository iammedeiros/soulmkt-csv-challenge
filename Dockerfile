# Usa imagem base do PHP com Apache
FROM php:8.2-apache

# Define o diretório de trabalho
WORKDIR /var/www/html

# Instala dependências e extensões do PHP
RUN apt-get update && \
    apt-get install -y \
    libzip-dev \
    zip \
    && docker-php-ext-install \
    zip \
    pdo_mysql

# Habilita o módulo rewrite do Apache
RUN a2enmod rewrite

# Copia os arquivos do projeto
COPY . /var/www/html/

# Configura o Apache para usar a pasta public como raiz
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Configura permissões
RUN chown -R www-data:www-data /var/www/html