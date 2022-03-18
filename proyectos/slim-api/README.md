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
* `slim-api/src/slim` -> `/var/www/php/slim`-> raíz de la API

**Paso 1:** Instalación de composer (ver tutorial) y dependencias en `slim-api/src/slim

```bash
$ sudo apt-get install php-curl
$ composer require slim/slim:3.12
```

Contenido de `.gitignore`:

```
vendor/
```

**Paso 2:** Creamos `slim-api/src/slim/index.php`

```php
    <?php
    require 'vendor/autoload.php';
    $app = new Slim\App();
```

**Paso 3:** Creamos base de datos de ejemplo. Le agregamos una tabla y le introducimos datos de ejemplo:

```sql
CREATE DATABASE library;

USE library;

CREATE TABLE IF NOT EXISTS `books` (

 `id` int(11) PRIMARY KEY AUTO_INCREMENT,

 `name` varchar(100) NOT NULL,

 `isbn` varchar(100),

 `category` varchar(100)

) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

INSERT INTO `books` (`id`, `name`, `isbn`, `category`) VALUES

(1, 'PHP', 'bk001', 'Server Side'),

(3, 'javascript', 'bk002', 'Client Side'),

(4, 'Python', 'bk003', 'Data Analysis'); 
```

**Paso 4:** Modificar Host virtual de nginx

```
server {
    server_name api.docker.local;
    index index.php;
    error_log /var/www/php/slim/log/error.log;
    access_log /var/www/php/slim/log/access.log;
    root /var/www/php/slim/public;

    location / {
        try_files $uri /index.php$is_args$args;
    }

    location ~* \.php$ {
        fastcgi_pass   php:9000;
        try_files $uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param SCRIPT_NAME $fastcgi_script_name;
        fastcgi_index index.php;
    }
}
```



## Tutoriales
* [composer install ubuntu 20.04](https://www.digitalocean.com/community/tutorials/how-to-install-composer-on-ubuntu-20-04-quickstart)
* [nginx+php+mysql+phpmyadmin con docker](https://hackmd.io/8KkoPCLNSkaKt-xHhBI0IQ)
* [Creating a Simple REST API With Slim Framework](https://www.cloudways.com/blog/simple-rest-api-with-slim-micro-framework/)