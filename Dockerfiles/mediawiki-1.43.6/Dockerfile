FROM registry.access.redhat.com/ubi9/ubi:9.4
RUN dnf -y install httpd php php-mysqlnd php-zip php-gd php-mbstring php-curl \
    php-xml php-pear php-bcmath php-intl php-opcache wget \
    && dnf clean all
RUN sed -i 's/Listen 80/Listen 8080/' /etc/httpd/conf/httpd.conf \
    && mkdir -p /run/php-fpm \
    && chgrp -R 0 /var/log/httpd /var/run/httpd /run/php-fpm \
    && chmod -R g=u /var/log/httpd /var/run/httpd /run/php-fpm
RUN wget https://releases.wikimedia.org/mediawiki/1.43/mediawiki-1.43.6.tar.gz \
    && tar -zxpvf mediawiki-1.43.6.tar.gz --strip-components=1 -C /var/www/html/ \
    && rm mediawiki-1.43.6.tar.gz
RUN chgrp -R 0 /var/www/html/ /var/lib/php/ && chmod -R g=u /var/www/html/ /var/lib/php/
EXPOSE 8080
USER 1001
CMD php-fpm & httpd -D FOREGROUND
