FROM mediawiki:1.43.6
RUN apt-get update
RUN apt-get install unzip zip wget
RUN git clone --depth 1 -b REL1_43 https://gerrit.wikimedia.org/r/mediawiki/extensions/PluggableAuth.git /var/www/html/extensions/PluggableAuth
RUN git clone --depth 1 -b REL1_43 https://gerrit.wikimedia.org/r/mediawiki/extensions/OpenIDConnect.git /var/www/html/extensions/OpenIDConnect
RUN git clone --depth 1 -b REL1_43 https://gerrit.wikimedia.org/r/mediawiki/extensions/Widgets.git /var/www/html/extensions/Widgets
RUN git clone --depth 1 https://github.com/StarCitizenTools/mediawiki-skins-Citizen.git /var/www/html/skins/Citizen
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === 'c8b085408188070d5f52bcfe4ecfbee5f727afa458b2573b8eaaf77b3419b0bf2768dc67c86944da1544f06fa544fd47') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
COPY composer.json /var/www/html/composer.json
RUN php composer.phar update --no-dev
RUN sed -i 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf && \
    sed -i 's/<VirtualHost \*:80>/<VirtualHost *:8080>/' /etc/apache2/sites-available/000-default.conf
EXPOSE 8080
