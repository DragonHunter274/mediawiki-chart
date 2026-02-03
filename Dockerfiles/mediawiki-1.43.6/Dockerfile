FROM mediawiki:1.43.6
RUN apt-get update
RUN apt-get install unzip zip
RUN tar -xzf PluggableAuth-REL1_43-fa46796.tar.gz -C /var/www/mediawiki/extensions
RUN tar -xzf OpenIDConnect-REL1_43-3ac5fa1.tar.gz -C /var/www/mediawiki/extensions
RUN git clone --depth 1 https://github.com/StarCitizenTools/mediawiki-skins-Citizen.git /var/www/html/skins/Citizen
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === 'c8b085408188070d5f52bcfe4ecfbee5f727afa458b2573b8eaaf77b3419b0bf2768dc67c86944da1544f06fa544fd47') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
COPY composer.json /var/www/html/composer.json
RUN php composer.phar update --no-dev
