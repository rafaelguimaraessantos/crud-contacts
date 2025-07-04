# Use uma imagem oficial do PHP com Apache
FROM php:8.2-apache

# Defina o DocumentRoot para /var/www/html/public
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Instale extensões necessárias do PHP e dependências do sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Habilite o mod_rewrite do Apache
RUN a2enmod rewrite

# Copie os arquivos do projeto para o diretório padrão do Apache
COPY . /var/www/html

# Defina o diretório de trabalho
WORKDIR /var/www/html

# Instale o Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Dê permissões para o storage e bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Exponha a porta 80
EXPOSE 80 