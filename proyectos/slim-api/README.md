## Pasos
Estructura de directorios:

```bash
.
└── slim-api
    ├── docker-compose.yml
    ├── README.md
    └── src
        ├── index.php
        └── slim
            ├── public
            │   └── index.php
            └── src
                └── Models
                    └── Db.php
```
* `slim-api/src` -> `/var/www/php` en contenedor nginx
* `slim-api/src/slim` -> raíz de la API

**Paso 1:** Instalación de composer y dependencias en `slim-api/src/slim

```bash
$ composer require slim/slim:"4.*"
$ composer require slim/psr7
$ composer require php-di/php-di -W
$ composer require phpunit/phpunit --dev
```

Contenido de `.gitignore`:

```
vendor/
.idea/
```
## Tutoriales
* [composer install ubuntu 20.04](https://www.digitalocean.com/community/tutorials/how-to-install-composer-on-ubuntu-20-04-quickstart)
* [nginx+php+mysql+phpmyadmin con docker](https://hackmd.io/8KkoPCLNSkaKt-xHhBI0IQ)