FROM ubuntu:24.04

LABEL maintainer="Taylor Otwell"

ARG NODE_VERSION=24
ARG WWWGROUP=1000
ARG WWWUSER=1000

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=UTC
ENV SUPERVISOR_PHP_COMMAND="/usr/bin/php -d variables_order=EGPCS /var/www/html/artisan serve --host=0.0.0.0 --port=80"
ENV SUPERVISOR_PHP_USER="sail"

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN echo "Acquire::http::Pipeline-Depth 0;" > /etc/apt/apt.conf.d/99custom && \
    echo "Acquire::http::No-Cache true;" >> /etc/apt/apt.conf.d/99custom && \
    echo "Acquire::BrokenProxy    true;" >> /etc/apt/apt.conf.d/99custom

RUN apt-get update && apt-get upgrade -y \
    && mkdir -p /etc/apt/keyrings \
    && apt-get install -y gnupg gosu curl ca-certificates zip unzip git supervisor libcap2-bin libpng-dev python3 dnsutils nano \
    && curl -sS 'https://keyserver.ubuntu.com/pks/lookup?op=get&search=0xb8dc7e53946656efbce4c1dd71daeaab4ad4cab6' | gpg --dearmor | tee /etc/apt/keyrings/ppa_ondrej_php.gpg > /dev/null \
    && echo "deb [signed-by=/etc/apt/keyrings/ppa_ondrej_php.gpg] https://ppa.launchpadcontent.net/ondrej/php/ubuntu noble main" > /etc/apt/sources.list.d/ppa_ondrej_php.list \
    && apt-get update \
    && apt-get install -y libgd3 php8.2-cli php8.2-dev \
       php8.2-sqlite3 php8.2-gd \
       php8.2-curl \
       php8.2-mysql php8.2-mbstring \
       php8.2-xml php8.2-zip php8.2-bcmath \
       php8.2-intl php8.2-readline \
       php8.2-pcov php8.2-xdebug \
    && curl -sLS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer \
    && curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg \
    && echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_VERSION.x nodistro main" > /etc/apt/sources.list.d/nodesource.list \
    && apt-get update \
    && apt-get install -y nodejs \
    && npm install -g npm \
    && apt-get install -y mysql-client \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN setcap "cap_net_bind_service=+ep" /usr/bin/php8.2

RUN echo "WWWGROUP=$WWWGROUP"
RUN userdel -r ubuntu
RUN groupadd --force -g $WWWGROUP sail
RUN useradd -ms /bin/bash --no-user-group -g $WWWGROUP -u $WWWUSER sail

# Instalar dependências do Composer
ENV COMPOSER_PROCESS_TIMEOUT=2000
COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-scripts

# Instalar dependências do Node
COPY package.json package-lock.json ./
RUN npm install

# Copiar resto do código
COPY . .

# Build do Vite
RUN npm run build
# Backup dos arquivos compilados para restaurar caso o volume os oculte
RUN mkdir -p /opt/assets_backup && cp -r public/build /opt/assets_backup/

# Rodar scripts do composer que foram pulados (opcional, mas bom para gerar autoloader otimizado final e discover packages)
RUN php artisan package:discover --ansi || true

# Ajustar permissões
RUN chown -R sail:sail /var/www/html
RUN chmod -R 775 storage bootstrap/cache

# Arquivos de configuração do Docker
COPY docker/8.2/start-container /usr/local/bin/start-container
COPY docker/8.2/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/8.2/php.ini /etc/php/8.2/cli/conf.d/99-sail.ini

RUN chmod +x /usr/local/bin/start-container

EXPOSE 80/tcp

ENTRYPOINT ["start-container"]
