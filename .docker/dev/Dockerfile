FROM phusion/baseimage:latest

LABEL maintainer="vlrnghl@gmail.com"

RUN DEBIAN_FRONTEND=noninteractive

RUN locale-gen en_US.UTF-8

ENV LANGUAGE=en_US.UTF-8
ENV LC_ALL=en_US.UTF-8
ENV LC_CTYPE=en_US.UTF-8
ENV LANG=en_US.UTF-8
ENV TERM xterm

###########################################################################

RUN ln -snf /usr/share/zoneinfo/UTC /etc/localtime && echo UTC > /etc/timezone

###########################################################################

ARG DOCKER_PHP_VERSION

RUN apt-get install -y software-properties-common && \
    add-apt-repository -y ppa:ondrej/php

RUN apt-get update && \
    apt-get install -y --allow-downgrades --allow-remove-essential \
        --allow-change-held-packages \
        php${DOCKER_PHP_VERSION}-cli \
        php${DOCKER_PHP_VERSION}-common \
        php${DOCKER_PHP_VERSION}-curl \
        php${DOCKER_PHP_VERSION}-intl \
        php${DOCKER_PHP_VERSION}-json \
        php${DOCKER_PHP_VERSION}-xml \
        php${DOCKER_PHP_VERSION}-mbstring \
        php${DOCKER_PHP_VERSION}-mysql \
        php${DOCKER_PHP_VERSION}-pgsql \
        php${DOCKER_PHP_VERSION}-zip \
        php${DOCKER_PHP_VERSION}-bcmath \
        php${DOCKER_PHP_VERSION}-memcached \
        php${DOCKER_PHP_VERSION}-gd \
        php${DOCKER_PHP_VERSION}-dev \
        pkg-config \
        libcurl4-openssl-dev \
        libedit-dev \
        libssl-dev \
        libxml2-dev \
        xz-utils \
        libsqlite3-dev \
        sqlite3 \
        git \
        curl \
        vim \
        nano \
        postgresql-client \
    && apt-get clean

###########################################################################

USER root

RUN apt-get update -yqq && \
    pecl channel-update pecl.php.net && \
    groupadd -g 1000 valeriu && \
    useradd -u 1000 -g valeriu -m valeriu -G docker_env && \
    usermod -p "*" valeriu

RUN apt-get install nano && \
    apt-get install htop;

###########################################################################

USER root

COPY ./aliases.sh /root/aliases.sh
COPY ./aliases.sh /home/valeriu/aliases.sh

RUN sed -i 's/\r//' /root/aliases.sh && \
    sed -i 's/\r//' /home/valeriu/aliases.sh && \
    chown valeriu:valeriu /home/valeriu/aliases.sh && \
    echo "" >> ~/.bashrc && \
    echo "# Load Custom Aliases" >> ~/.bashrc && \
    echo "source ~/aliases.sh" >> ~/.bashrc && \
	echo "" >> ~/.bashrc

USER valeriu

RUN echo "" >> ~/.bashrc && \
    echo "# Load Custom Aliases" >> ~/.bashrc && \
    echo "source ~/aliases.sh" >> ~/.bashrc && \
	echo "" >> ~/.bashrc

###########################################################################

USER root

RUN curl -s http://getcomposer.org/installer | php && \
    echo "export PATH=${PATH}:/var/www/vendor/bin" >> ~/.bashrc && \
    mv composer.phar /usr/local/bin/composer

COPY ./composer.json /home/valeriu/.composer/composer.json

RUN chown -R valeriu:valeriu /home/valeriu/.composer

USER valeriu

RUN composer global install;

RUN echo "" >> ~/.bashrc && \
    echo 'export PATH="~/.composer/vendor/bin:$PATH"' >> ~/.bashrc

###########################################################################

USER valeriu

RUN echo "" >> ~/.bashrc && \
    echo 'export PATH="/var/www/vendor/bin:$PATH"' >> ~/.bashrc

###########################################################################

USER root

ARG DOCKER_PHP_VERSION

RUN apt-get install -y php${DOCKER_PHP_VERSION}-xdebug && \
    sed -i 's/^;//g' /etc/php/${DOCKER_PHP_VERSION}/cli/conf.d/20-xdebug.ini && \
    echo "alias phpunit='php -dzend_extension=xdebug.so /var/www/vendor/bin/phpunit'" >> ~/.bashrc \
;

COPY ./xdebug.ini /etc/php/${DOCKER_PHP_VERSION}/cli/conf.d/xdebug.ini

RUN sed -i "s/xdebug.remote_autostart=0/xdebug.remote_autostart=1/" /etc/php/${DOCKER_PHP_VERSION}/cli/conf.d/xdebug.ini && \
    sed -i "s/xdebug.remote_enable=0/xdebug.remote_enable=1/" /etc/php/${DOCKER_PHP_VERSION}/cli/conf.d/xdebug.ini && \
    sed -i "s/xdebug.cli_color=0/xdebug.cli_color=1/" /etc/php/${DOCKER_PHP_VERSION}/cli/conf.d/xdebug.ini

###########################################################################

RUN pecl install mongodb
RUN echo "extension=mongodb.so" > /etc/php/${DOCKER_PHP_VERSION}/cli/conf.d/20-mongodb.ini && \
    echo "extension=mongodb.so" > /etc/php/${DOCKER_PHP_VERSION}/mods-available/mongodb.ini

###########################################################################

COPY insecure_id_rsa /tmp/id_rsa
COPY insecure_id_rsa.pub /tmp/id_rsa.pub

RUN rm -f /etc/service/sshd/down && \
    cat /tmp/id_rsa.pub >> /root/.ssh/authorized_keys \
        && cat /tmp/id_rsa.pub >> /root/.ssh/id_rsa.pub \
        && cat /tmp/id_rsa >> /root/.ssh/id_rsa \
        && rm -f /tmp/id_rsa* \
        && chmod 644 /root/.ssh/authorized_keys /root/.ssh/id_rsa.pub \
    && chmod 400 /root/.ssh/id_rsa \
    && cp -rf /root/.ssh /home/valeriu \
    && chown -R valeriu:valeriu /home/valeriu/.ssh \
;

USER valeriu

###########################################################################

ENV NODE_VERSION node
ENV NVM_DIR /home/valeriu/.nvm

RUN mkdir -p $NVM_DIR && \
    curl -o- https://raw.githubusercontent.com/creationix/nvm/v0.33.11/install.sh | bash \
        && . $NVM_DIR/nvm.sh \
        && nvm install ${NODE_VERSION} \
        && nvm use ${NODE_VERSION} \
        && nvm alias ${NODE_VERSION} \
        && ln -s `npm bin --global` /home/valeriu/.node-bin;

RUN echo "" >> ~/.bashrc && \
    echo 'export NVM_DIR="$HOME/.nvm"' >> ~/.bashrc && \
    echo '[ -s "$NVM_DIR/nvm.sh" ] && . "$NVM_DIR/nvm.sh"  # This loads nvm' >> ~/.bashrc;

USER root

RUN echo "" >> ~/.bashrc && \
    echo 'export NVM_DIR="/home/valeriu/.nvm"' >> ~/.bashrc && \
    echo '[ -s "$NVM_DIR/nvm.sh" ] && . "$NVM_DIR/nvm.sh"  # This loads nvm' >> ~/.bashrc;

ENV PATH $PATH:/home/valeriu/.node-bin

RUN find $NVM_DIR -type f -name node -exec ln -s {} /usr/local/bin/node \; && \
    NODE_MODS_DIR="$NVM_DIR/versions/node/$(node -v)/lib/node_modules" && \
    ln -s $NODE_MODS_DIR/npm/bin/npm-cli.js /usr/local/bin/npm && \
    ln -s $NODE_MODS_DIR/npm/bin/npx-cli.js /usr/local/bin/npx;

###########################################################################

USER root

ARG INSTALL_MYSQL_CLIENT=false

RUN apt-get update -yqq && \
    apt-get -y install mysql-client;

###########################################################################

RUN apt-get -y install python python-pip python-dev build-essential  \
  && python -m pip install --upgrade pip  \
  && python -m pip install --upgrade virtualenv;

###########################################################################

RUN php -v | head -n 1 | grep -q "PHP ${DOCKER_PHP_VERSION}."

###########################################################################

# Final upgrade
RUN apt-get update -yqq && \
    apt-get -y upgrade;

# Install Midnight commander file manager
RUN apt-get install mc -y;

###########################################################################

USER root

RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    rm /var/log/lastlog /var/log/faillog

###########################################################################

USER root

WORKDIR /var/www