FROM dunglas/frankenphp

RUN install-php-extensions \
    pdo_sqlsrv \
    gd \
    intl \
    zip \
    opcache \
    sqlsrv \
    bcmath \
    pdo

# Hanya saat development:
ENV SERVER_NAME=":80"

# untuk mode worker:
ENV FRANKENPHP_CONFIG="worker /app/public/frankenphp-worker.php"
