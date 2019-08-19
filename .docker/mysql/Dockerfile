ARG MYSQL_VERSION=latest

FROM mysql:${MYSQL_VERSION}

LABEL maintainer="valeriu.anghel@cardstream.com"

RUN ln -snf /usr/share/zoneinfo/UTC /etc/localtime && \
    echo UTC > /etc/timezone && \
    chown -R mysql:root /var/lib/mysql/

COPY my.cnf /etc/mysql/conf.d/my.cnf

#COPY docker-entrypoint.sh /usr/local/bin/
#RUN ln -s usr/local/bin/docker-entrypoint.sh /docker-entrypoint.sh # backwards compat
#ENTRYPOINT ["docker-entrypoint.sh"]

CMD ["mysqld"]

EXPOSE 3306
