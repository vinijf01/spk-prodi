FROM laravelsail/php81-composer:latest

# Install PHP extensions needed for Laravel + MySQL
RUN docker-php-ext-install pdo_mysql

# Tambah user sail yang dibutuhkan oleh script sail
RUN useradd -m -u 1000 sail || true
RUN echo "sail ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers
