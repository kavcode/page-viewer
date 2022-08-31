FROM php:8.1.7-fpm-alpine3.16

# Install dependencies, which should be preserved
RUN apk update \
    && apk add --no-cache \
      freetype \
      libpng \
      libzip-dev \
      oniguruma-dev \
      libjpeg-turbo \
      libmcrypt \
      librsvg \
      imagemagick \
      git \
      openssl \
      mpdecimal-dev \
      php8-pecl-memcached \
      icu-dev \
      gettext-dev \
      postgresql-dev \
      libsodium-dev

# Install selected extensions and other stuff
RUN apk add --no-cache --virtual .build-deps \
      freetype-dev \
      libjpeg-turbo-dev \
      libpng-dev \
      libmcrypt-dev \
      libxml2-dev \
      curl-dev \
      imagemagick-dev \
      libmemcached-dev \
      zlib-dev \
      $PHPIZE_DEPS \
      libtool \
   && docker-php-ext-configure gd \
    --with-freetype=/usr/include/ \
    --with-jpeg=/usr/include/ \
   && docker-php-ext-configure zip \
   && docker-php-ext-install -j$(getconf _NPROCESSORS_ONLN) \
      gd \
      mysqli \
      pdo_mysql \
      pdo_pgsql \
      xml \
      curl \
      mbstring \
      exif \
      zip \
      opcache \
      bcmath \
      sockets \
      pcntl \
      intl \
      gettext \
      zip \
      soap \
      sodium \
      shmop \
      simplexml \
    && pecl install xdebug-3.1.3 \
    && pecl install decimal \
    && export CFLAGS="$PHP_CFLAGS" CPPFLAGS="$PHP_CPPFLAGS" LDFLAGS="$PHP_LDFLAGS" \
    && pecl install imagick \
    && pecl install redis-5.3.3 \
    && pecl install memcached-3.2.0 \
    && docker-php-ext-enable imagick \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-enable decimal \
    && docker-php-ext-enable redis \
    && docker-php-ext-enable memcached \
    && apk del .build-deps

ADD ./*ini $PHP_INI_DIR/conf.d/

ADD ./*sh /var/tools/
RUN chmod u+x /var/tools/*.sh && /var/tools/install-composer.sh

ARG APP_CONTAINER_VAR_DIR
ARG APP_CONTAINER_CACHE_DIR
RUN mkdir -p ${APP_CONTAINER_VAR_DIR} && mkdir -p ${APP_CONTAINER_CACHE_DIR}

# Add user and group for isolated run
ARG APP_CONTAINER_USER
ENV USER ${APP_CONTAINER_USER}
ARG APP_CONTAINER_UID
ENV UID ${APP_CONTAINER_UID}
ARG APP_CONTAINER_GID
ENV GID ${APP_CONTAINER_GID}

RUN addgroup -g ${GID} -S ${USER} && \
    adduser -u ${UID} -S ${USER} -G ${USER} && \
    chmod -R 0755 ${APP_CONTAINER_VAR_DIR} && \
    chown -R ${USER}:${USER} ${APP_CONTAINER_VAR_DIR}
USER ${USER}

CMD ["php-fpm"]





