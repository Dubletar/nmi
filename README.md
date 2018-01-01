NMI Tests - Adam Velma
===

Controller
==

src/AppBundle/Controller/AppController.php

Assets
==

src/AppBundle/Resources/public/assets

Installation
==

* Prerequisites: gulp, composer.
* Clone this repository.
* Run these commands:
```
#Install the project
$ composer install

#Update cache permissions (Linux)
$ HTTPDUSER=$(ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1)
$ sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX var
$ sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX var

#Install node libraries
$ npm install

#Run gulp
$ gulp

#Clear cache and dump assets
$ ./cacheclear.sh
```