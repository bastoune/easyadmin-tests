ARG PHP_VERSION=7.4.13

FROM php:${PHP_VERSION}-fpm-alpine

# persistent / runtime deps
RUN apk add --no-cache \
		acl \
		bash \
		fcgi \
		file \
		openssh-client \
		gettext \
		git \
		yarn \
        libmcrypt libmcrypt-dev \
        libxml2-dev libxslt-dev freetype-dev libpng-dev libjpeg-turbo-dev \
	;

ARG APCU_VERSION=5.1.19
ARG PECL_AMQP_VERSION=1.10.2
ARG PECL_XDEBUG_VERSION=3.0.2

RUN set -eux; \
	apk add --no-cache --virtual .build-deps \
		$PHPIZE_DEPS \
		icu-dev \
		libzip-dev \
		postgresql-client \
		postgresql-dev \
		rabbitmq-c-dev \
		zlib-dev \
	; \
	\
	docker-php-ext-configure zip; \
	docker-php-ext-install -j$(nproc) \
		intl \
		pgsql \
		pdo_pgsql \
		zip \
		xsl \
	; \
	pecl install \
		amqp-${PECL_AMQP_VERSION} \
		xdebug-${PECL_XDEBUG_VERSION} \
		apcu-${APCU_VERSION} \
	; \
	pecl clear-cache; \
	docker-php-ext-enable \
		apcu \
		amqp \
		opcache \
		xdebug \
	; \
	\
	runDeps="$( \
		scanelf --needed --nobanner --format '%n#p' --recursive /usr/local/lib/php/extensions \
			| tr ',' '\n' \
			| sort -u \
			| awk 'system("[ -e /usr/local/lib/" $1 " ]") == 0 { next } { print "so:" $1 }' \
	)"; \
	apk add --no-cache --virtual .api-phpexts-rundeps $runDeps; \
	\
	apk del .build-deps

# INSTALL BLACKFIRE
RUN version=$(php -r "echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;") \
    && curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/alpine/amd64/$version \
    && mkdir -p /tmp/blackfire \
    && tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp/blackfire \
    && mv /tmp/blackfire/blackfire-*.so $(php -r "echo ini_get ('extension_dir');")/blackfire.so \
    && printf "extension=blackfire.so\nblackfire.agent_socket=tcp://blackfire:8707\n" > $PHP_INI_DIR/conf.d/blackfire.ini \
    && rm -rf /tmp/blackfire /tmp/blackfire-probe.tar.gz

# XDEBUG CONFIGURATION
ARG XDEBUG_REMOTE_HOST
ARG XDEBUG_REMOTE_PORT
ARG XDEBUG_REMOTE_CONNECT_BACK
ARG XDEBUG_START_WITH_REQUEST=yes
ARG XDEBUG_INI=/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN touch /var/log/xdebug.log
RUN chmod -R 777 /var/log

RUN echo "\r\rEnabling XDEBUG ? ${XDEBUG_START_WITH_REQUEST}\r\r"

RUN echo -e "error_reporting=E_ALL\n" >> ${XDEBUG_INI} \
    "display_startup_errors=1\n" >> ${XDEBUG_INI} \
    "display_errors=1\n" >> ${XDEBUG_INI} \
    "xdebug.mode=coverage,debug,profile\n" >> ${XDEBUG_INI} \
    "xdebug.start_with_request=${XDEBUG_START_WITH_REQUEST}\n" >> ${XDEBUG_INI} \
    "xdebug.discover_client_host=${XDEBUG_REMOTE_CONNECT_BACK}\n" >> ${XDEBUG_INI} \
    "xdebug.idekey=\"PHPSTORM\"\n" >> ${XDEBUG_INI} \
    "xdebug.remote_handler=dbgp\n" >> ${XDEBUG_INI} \
    "xdebug.client_port=${XDEBUG_REMOTE_PORT}\n" >> ${XDEBUG_INI} \
    "xdebug.client_host=${XDEBUG_REMOTE_HOST}\n" >> ${XDEBUG_INI} \
    "xdebug.log_level=3\n" >> ${XDEBUG_INI} \
    "xdebug.log=/var/log/xdebug.log\n" >> ${XDEBUG_INI}

# COMPOSER INSTALLATION
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

EXPOSE ${XDEBUG_REMOTE_PORT}

# EXORT COMPOSER GLOBAL PATH
ENV PATH="$PATH:$HOME/.composer/vendor/bin"