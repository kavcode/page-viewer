FROM php:7.3-fpm-alpine

# Install dependencies, which should be preserved
RUN apk add --no-cache \
      freetype \      
      libpng \
      libzip-dev \
      libjpeg-turbo \      
      libmcrypt \ 
      librsvg \
      imagemagick \
      git \
      openssl

# Install selected extensions and other stuff
RUN apk add --no-cache --virtual .build-deps \ 
      freetype-dev \
      libjpeg-turbo-dev \
      libpng-dev \
      libmcrypt-dev \
      libxml2-dev \
      curl-dev \ 
      imagemagick-dev \
      $PHPIZE_DEPS \
      libtool \
   && docker-php-ext-configure gd \
    --with-freetype-dir=/usr/include/ \
    --with-png-dir=/usr/include/ \
    --with-jpeg-dir=/usr/include/ \
   && docker-php-ext-install -j$(getconf _NPROCESSORS_ONLN) \
      gd \
      mysqli \
      pdo_mysql \
      xml \
      curl \
      mbstring \
      zip \
   && pecl install xdebug-2.7.2 \
   && export CFLAGS="$PHP_CFLAGS" CPPFLAGS="$PHP_CPPFLAGS" LDFLAGS="$PHP_LDFLAGS" \
   && pecl install imagick \
   && docker-php-ext-enable imagick \
   && docker-php-ext-enable xdebug \
   && apk del .build-deps

ADD ./*sh /var/tools/
RUN chmod u+x /var/tools/*.sh && /var/tools/install-composer.sh
   
WORKDIR "/home/app"

CMD ["php-fpm"]

