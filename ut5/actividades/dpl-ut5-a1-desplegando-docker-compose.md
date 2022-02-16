# DPL-UT5-A1. Desplegando con Docker Compose


## Creando un entorno de desarrollo LEMP con Docker

Antes de desplegar nuestra aplicación con Docker vamos a aprender como crear nuestro **entorno locale de desarrollo** con Docker.
### Instalación de Docker
Seguimos las instrucciones de la documentación oficial
* [Instalación de Docker en MAC/Windows/linux](https://docs.docker.com/get-docker/)
* [Guía oficial de instalación en Ubuntu](https://docs.docker.com/engine/install/ubuntu/)
* [Script para la instalación de Docker en entornos de desarrollo local](https://get.docker.com/)

### Identificando los contenedores necesarios

Docker recomienda ejecutar un único proceso por contenedor. Recordemos que una pila LEMP está compuesta de:

* **L** - Linux
* **E** - Nginx
* **M** - Mysql
* **P** - PHP

Linux es el sistema operativo que ejecuta Docker lo que nos deja con Nginx, Mysql y PHP. Añadiremos también phpMyAdmin  al mix con lo que necesitaremos los siguientes contenedores:

* Nginx
* PHP (PHP-FPM)
* MySQL
* phpMyAdmin

### Docker compose

La apliación de escritorio para desarrollo de Docker incluye una herramienta llamada [Docker Compose](https://docs.docker.com/compose/) que permite ejecutar aplicaciones Docker de más de un contenedor. 

Docker Compose no es imprescindible, pero su uso facilita mucho las cosas.

La configuración de los contenedores se describe en un fichero de configuración en formato YAML. A partir del mismo Docker Compose se encarga de construir las imágenes e iniciar los contenedores, así como de otras tareas como conectar las imágenes entre sí y a Internet

Las instrucciones generales para su instalación las tenemos en el [siguiente enlace](https://docs.docker.com/compose/install/). Seguimos las instrucciones para Linux

Una vez instalado debemos añadir nuestro usuario al grupo `docker` para que tenga permisos para su uso:

```bash
$ sudo usermod -aG docker $USER
```
Deberás cerrar sesión y volver a abrirla para que se apliquen los permisos

### Nginx

Empezamos creando una carpeta para nuestro proyecto y accediendo a la misma:

```bash
$ mkdir docker-dev
$ cd docker-dev
```

Creamos el fichero YAML de configuración `docker-compose.yml` con el siguiente contenido:

```yaml
version: '3.8'

# Services
services:

  # Nginx Service
  nginx:
    image: nginx:1.21
    ports:
      - 80:80
```

* `version` versión de docker compose **3.8** en este momento
* `services` permite especificar lista de aplicaciones que componen nuestro proyecto
* `nginx` de momento nuestra única aplicación. 
* `image` [imagen de nginx](https://hub.docker.com/_/nginx) que se va a usar. En el enlace tenemos más detalles sobre las imágenes disponibles. Docker provee un registro con las diferentes imágenes y versiones de las mismas disponibles. Docker mantiene en [Docker hub](https://hub.docker.com/search?type=image) una lista de imámenes oficiales que son las que deberíamos usar.
* `ports`: `80:80` indica que queremos mapear el puerto 80 de nuestra máquina local con el 80 del contenedor Nginx.

Una vez guardado el fichero solo queda ejecutar:

```bash
$ docker-compose up -d
```
* La opción `-d` le indica a docker-compose que queremos lanzar el contenedor en segundo plano y obtener el control del terminal

Después de unos segundos se descargará la imagen y se configurará.

Si abrimos el navegador en nuestro equipo deberá aparecer la web por defecto de nginx:

![](https://i.imgur.com/UtOvt3P.png)

Hemos creado nuestro primer contenedor docker

>**Nota**: en caso de que ya tuvieramos el puerto 80 en uso en nuestro equipo nos mostraría el servicio que actualmente lo usa. Si es apache o nginx debemos desinstalarlos del equipo. O si no queremos hacerlos tendremos que cambiar el puerto local en la configuración del contenedor, por ejemplo `8000:80` y volver a lanzar el contenedor `docker-compose -d`. La URL en el navegador ahora sería `http://localhost:8000`.

Podemos consultar que contenedores están actualmente en ejecución con el comando:

```bash
$ docker-compose ps

        Name                   Command           State            Ports         
--------------------------------------------------------------------------------
docker-local_nginx_1   /docker-entrypoint.sh     Up      0.0.0.0:80->80/tcp,:::8
                       ngin ...                          0->80/tcp
```

Detenemos el contenedor para continuar con la configuración:

```bash
$ docker-compose stop
```

### PHP
Nuestro servidor web lo vamos a utilizar en una aplicación PHP, por tanto necesitamos añadir soporte para el mismo de forma que cuando reciba una petición NGINX a una página que incluya PHP, este le pase dicha petición al módulo de PHP, en nuestro caso `PHP-FPM` para que este ejecute el script y devuelva la respuesta.

Añadimos al fichero `docker-compose.yml` el siguiente contenido

```yaml
version: '3.8'

# Services
services:

  # Nginx Service
  nginx:
    image: nginx:1.21
    ports:
      - 80:80
    volumes:
      - ./src:/var/www/php
      - ./.docker/nginx/conf.d:/etc/nginx/conf.d
    depends_on:
      - php

  # PHP Service
  php:
    image: php:8.0-fpm
    working_dir: /var/www/php
    volumes:
      - ./src:/var/www/php
```

Si observamos el servicio PHP vemos que:

Usamos como imagen `php:8.0-fpm` que es una imagen oficial del la versión `8.0` de `PHP-FPM`

El apartado `volumes` nos permite especificar que queremos montar del sistema de archivos local en el sistema de archivos de la imagen, en este caso montamos la carpeta local `src` en la carpeta del contenedor `/var/www/php`. La carpeta local todavía no existe, pero será donde ubiquemos el código de nuestra aplicación.

Dentro de la carpeta del proyecto `docker-dev` creamos la carpeta `src` y accedemos a la misma

```bash
$ mkdir src
$ cd src
```

Dentro de la misma añadimos el fichero `index.php` con el siguiente contendio de prueba:

```htmlembedded
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Hello there</title>
        <style>
            .center {
                display: block;
                margin-left: auto;
                margin-right: auto;
                width: 50%;
            }
        </style>
    </head>
    <body>
        <?php
                echo "<h1>Nginx + PHP</h1>";
        ?>
    </body>
</html>
```

Si nos fijamos ahora en la configuración de **nginx** vemos que hemos añadido la sección `volumes` que monta el directorio que contiene nuestro código de la misma forma que hicimos en el contenedor de **PHP**, de esta forma **nginx** obtiene también una copia del fichero `index.html`, de lo contrario obtendríamos un error **404 Not Found**  al intentar acceder al fichero.

También montamos en el contenedor de **nginx** la carpeta donde se almacenará la configuración del Host Virtual que creemos para nuestra aplicación:

```
- ./.docker/nginx/conf.d:/etc/nginx/conf.d
```

Creamos en la carpeta de inicio de nuestro proyecto la carpeta `.docker/nginx/conf.d` y accedemos a la misma:

```bash
$ cd ..
$ mkdir -p .docker/nginx/conf.d
```

> La carpeta `/etc/nginx/conf.d` es la que **nginx** consulta para ver que Hosts Virtuales debe procesar. **Nginx** lo hará con cualquier archivo que exista en dicha carpeta con la extensión `.conf`

Poner los ficheros relativos a **docker** de nuestro proyecto en una carpeta de nombre `.docker`  es una práctica común.

Creamos el archivo de configuración del Host Virtual `php.conf` 

```bash
$ nano .docker/nginx/conf.d/php.conf
```
E insertamos en el mismo el siguiente contenido:

```bash
server {
    listen 80 default_server;
    listen [::]:80 default_server;
    root   /var/www/php;
    index  index.php;

    location ~* \.php$ {
        fastcgi_pass   php:9000;
        include        fastcgi_params;
        fastcgi_param  SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param  SCRIPT_NAME     $fastcgi_script_name;
    }
}
```

La configuración que acabamos de añadir tiene lo mínimo necesario para un sitio con soporte `PHP-FPM`

El parámetro `root` nos permite configurar la carpeta raíz del sitio que coincide con la carpeta en la que se monta la carpeta local `src/` de nuestra aplicación.

La línea:

```bash
fastcgi_pass php:9000;
```

Se usa para indicar a **nginx**  que cada vez que reciba una petición para un recurso **php** reenvíe dicha petición al contenedor **PHP** al puerto `9000` que es el puerto por el que **PHP-FPM** escucha por defecto. Internamente, **DockerCompose** se encargará de resolver automáticamente el identificador **php** con la dirección IP privada que asignará automáticamente al contenedor **PHP**. Al iniciar los contenedores, automáticamente configurará una red interna en la que cualquier contenedor será localizable a partir del nombre del servicio asociado.

En el último apartado de la configuración de **nginx** se ha añadido:

```yaml
depends_on:
  - php
```

Esto es para indicar que el contenedor **nginx** depende del contenedor **php** y que por tanto, no debería iniciarse hasta que el contenedor **php** haya terminado de iniciarse. Ya que **nginx** debe poder reenviar peticiones al puerto 9000 de contenedor **php** si recibe peticiones que contienen código PHP.

La estructura de archivos y carpetas de nuestro proyecto debería ser actualmente la siguiete:

```bash
docker-tutorial/
├── .docker/
│   └── nginx/
│       └── conf.d/
│           └── php.conf
├── src/
│   └── index.php
└── docker-compose.yml
```

Ya podemos probar nuestra aplicación. En esta ocasión se descargará la imagen de PHP y se configurarán los elementos que hemos añadido. Ejecutamos en la carpeta de inicio de nuestro proyecto:

```bash
$ docker-compose -up -d
```

Si accedemos a `http://localhost` en el navegador veremos que se muestra la web que acabamos de crear.

Si ejecutamos:

```bash
docker-compose ps   
       Name                     Command               State                Ports              
----------------------------------------------------------------------------------------------
docker-local_nginx_1   /docker-entrypoint.sh ngin ...   Up      0.0.0.0:80->80/tcp,:::80->80/tcp
docker-local_php_1     docker-php-entrypoint php-fpm    Up      9000/tcp 
```

Ahora se muestran 2 contenedores en ejecución.

Si ejecutamos:

```bash
$ docker-compose exec php bash
```

Iniciamos sesión interactiva en el contenedor en su carpeta de inicio (`/var/www/php`) si ejecutamos `ls` en la misma se mostrará el contenido de la carpeta local del proyecto `src` qué es la que montamos en el apartado `volumes` de la configuración del contenedor.

```bash
root@378c17bacc24:/var/www/php# ls
index.php
```

Para salir del contenedor ejecutamos `exit`

Para ver el registro de actividad de nuestro proyecto ejecutamos:

```bash
docker-compose logs -f      
Attaching to docker-local_nginx_1, docker-local_php_1
nginx_1  | /docker-entrypoint.sh: /docker-entrypoint.d/ is not empty, will attempt to perform configuration
nginx_1  | /docker-entrypoint.sh: Looking for shell scripts in /docker-entrypoint.d/
nginx_1  | /docker-entrypoint.sh: Launching /docker-entrypoint.d/10-listen-on-ipv6-by-default.sh
nginx_1  | 10-listen-on-ipv6-by-default.sh: info: /etc/nginx/conf.d/default.conf is not a file or does not exist
nginx_1  | /docker-entrypoint.sh: Launching /docker-entrypoint.d/20-envsubst-on-templates.sh
nginx_1  | /docker-entrypoint.sh: Launching /docker-entrypoint.d/30-tune-worker-processes.sh
nginx_1  | /docker-entrypoint.sh: Configuration complete; ready for start up
nginx_1  | 2022/02/09 10:28:36 [notice] 1#1: using the "epoll" event method
nginx_1  | 2022/02/09 10:28:36 [notice] 1#1: nginx/1.21.6
nginx_1  | 2022/02/09 10:28:36 [notice] 1#1: built by gcc 10.2.1 20210110 (Debian 10.2.1-6) 
nginx_1  | 2022/02/09 10:28:36 [notice] 1#1: OS: Linux 5.13.0-28-generic
nginx_1  | 2022/02/09 10:28:36 [notice] 1#1: getrlimit(RLIMIT_NOFILE): 1048576:1048576
nginx_1  | 2022/02/09 10:28:36 [notice] 1#1: start worker processes
nginx_1  | 2022/02/09 10:28:36 [notice] 1#1: start worker process 22
nginx_1  | 2022/02/09 10:28:36 [notice] 1#1: start worker process 23
nginx_1  | 2022/02/09 10:28:36 [notice] 1#1: start worker process 24
nginx_1  | 2022/02/09 10:28:36 [notice] 1#1: start worker process 25
nginx_1  | 2022/02/09 10:28:36 [notice] 1#1: start worker process 26
nginx_1  | 2022/02/09 10:28:36 [notice] 1#1: start worker process 27
nginx_1  | 2022/02/09 10:28:36 [notice] 1#1: start worker process 28
nginx_1  | 2022/02/09 10:28:36 [notice] 1#1: start worker process 29
nginx_1  | 172.19.0.1 - - [09/Feb/2022:10:29:07 +0000] "GET / HTTP/1.1" 200 383 "-" "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:96.0) Gecko/20100101 Firefox/96.0" "-"
php_1    | [09-Feb-2022 10:27:15] NOTICE: fpm is running, pid 1
php_1    | [09-Feb-2022 10:27:15] NOTICE: ready to handle connections
php_1    | [09-Feb-2022 10:27:55] NOTICE: Finishing ...
php_1    | [09-Feb-2022 10:27:55] NOTICE: exiting, bye-bye!
php_1    | [09-Feb-2022 10:28:35] NOTICE: fpm is running, pid 1
php_1    | [09-Feb-2022 10:28:35] NOTICE: ready to handle connections
php_1    | 172.19.0.3 -  09/Feb/2022:10:29:07 +0000 "GET /index.php" 200
```

Nos muestra en vivo los logs de los contenedores. Esta opción de `docker-compose` es muy útil para el caso en que tengamos que depurar nuestra apliación.


Fíjate que como especificamos que el servicio **php** depende de **nginx** no hay ninguna actividad en **php** hasta que **nginx** no ha terminado de inciarse.

pulsa la combinación `ctrl+c` para volver al terminal. Y paramos `docker-compose` para seguir con la configuración:

```bash
$ docker-compose stop
```

### Mysql

El último componente de la pila LEMP es MySQL. Volvemos a modificar `docker-compose.yml`:

```yaml
version: '3.8'

# Services
services:

  # Nginx Service
  nginx:
    image: nginx:1.21
    ports:
      - 80:80
    volumes:
      - ./src:/var/www/php
      - ./.docker/nginx/conf.d:/etc/nginx/conf.d
    depends_on:
      - php

  # PHP Service
  php:
    build: ./.docker/php
    working_dir: /var/www/php
    volumes:
      - ./src:/var/www/php
    depends_on:
      mysql:
        condition: service_healthy

  # MySQL Service
  mysql:
    image: mysql/mysql-server:8.0
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_ROOT_HOST: "%"
      MYSQL_DATABASE: demo
    volumes:
      - ./.docker/mysql/my.cnf:/etc/mysql/conf.d/my.cnf
      - mysqldata:/var/lib/mysql
    healthcheck:
      test: mysqladmin ping -h 127.0.0.1 -u root --password=$$MYSQL_ROOT_PASSWORD
      interval: 5s
      retries: 10

# Volumes
volumes:

  mysqldata:
```

El servicio Nginx es el mismo, pero al servicio PHP se le han hecho algunas modificaciones, añadiendo la directiva `depends`, para indicar que el nuevo servicio MySQL debe iniciarse antes que PHP. 

La otra diferencia es la presencia del parámetro `condition` que veremos su uso después.

Además se ha añadido la directiva `build` al servicio PHP que reemplaza la directiva `image`. En lugar de usar la imagen oficial de PHP tal cual, le decimos a Docker Compose que utilice el fichero de Docker (DockerFile) almacenado en `.docker/php` para construir la nueva imagen.

Un Dockerfile es una especie de receta para construir una imagen. Creamos la carpeta que lo va a contener y el fichero de configuración:

```bash
$ mkdir .docker/php
$ nano .docker/php/Dockerfile
```

Y le insertamos el siguiente contenido:

```dockerfile
FROM php:8.0-fpm

RUN docker-php-ext-install pdo_mysql
```
PHP necesita la extensión `pdo_mysql` para poder acceder a bases de datos MySQL. Las instrucciones las podemos obtener de la documentación de la imagen oficial de PHP en Docker Hub.

Básicamente indicamos que la imagen la construya a partir de la imagen oficial de php y que le añada la extensión `pdo_mysql` con el comando `RUN`

Vamos a modificar el fichero `src/index.php` con un ejemplo que use una base de datos:

```htmlembedded
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Hello there</title>
        <style>
            body {
                font-family: "Arial", sans-serif;
                font-size: larger;
            }

            .center {
                display: block;
                margin-left: auto;
                margin-right: auto;
                width: 50%;
            }
        </style>
    </head>
    <body>
        <img src="https://tech.osteel.me/images/2020/03/04/hello.gif" alt="Hello there" class="center">
        <?php
        $connection = new PDO('mysql:host=mysql;dbname=demo;charset=utf8', 'root', 'root');
        $query      = $connection->query("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'demo'");
        $tables     = $query->fetchAll(PDO::FETCH_COLUMN);

        if (empty($tables)) {
            echo '<p class="center">There are no tables in database <code>demo</code>.</p>';
        } else {
            echo '<p class="center">Database <code>demo</code> contains the following tables:</p>';
            echo '<ul class="center">';
            foreach ($tables as $table) {
                echo "<li>{$table}</li>";
            }
            echo '</ul>';
        }
        ?>
    </body>
</html>
```

Si nos fijamos ahora en la configuración del servicio MySQL en `docker-compose.yml`

```yaml
# MySQL Service
mysql:
  image: mysql/mysql-server:8.0
  environment:
    MYSQL_ROOT_PASSWORD: root
    MYSQL_ROOT_HOST: "%"
    MYSQL_DATABASE: demo
  volumes:
    - ./.docker/mysql/my.cnf:/etc/mysql/conf.d/my.cnf
    - mysqldata:/var/lib/mysql
  healthcheck:
    test: mysqladmin ping -h 127.0.0.1 -u root --password=$$MYSQL_ROOT_PASSWORD
    interval: 5s
    retries: 10
```

Vemos que `image` especifica que usamos una imagen oficial.

A continuación aparece una sección `environment` que no habíamos visto hasta ahora. Contiene 3 parámetros `MYSQL_ROOT_PASSWORD`, `MYSQL_ROOT_HOST` y `MYSQL_DATABASE` que son variables de entorno que se crearán al iniciar el contenedor. Nos permiten indicar la contraseña del administrador de la base de datos, autorizar conexiones de cualquier IP y crear una base de datos de ejemplo.

Básicamente, se creará la base de datos `demo` de ejemplo al iniciar el contenedor.

A continuación se crea el apartado `volumes`. El primero es para crear el fichero de configuración. Creamos la carpeta para el mismo:

```bash
$ mkdir .docker/mysql
```

E insertamos en `.docker/mysql/my.cnf`  el siguiente contenido

```bash
[mysqld]
collation-server     = utf8mb4_unicode_ci
character-set-server = utf8mb4
```

El segundo volumen tiene una apariencia distinta los que jemos creado hasta ahora. En lugar de apuntar a una carpeta local, hace referencia hace referencia a un nuevo volumen que se define en la sección `volumes` que se define al mismo nivel que `services`:

```yaml
# Volumes
volumes:

  mysqldata:
```

Necesitamos dicho volumen, porque de lo contrario, cada vez que el servicio del contenedor `mysql` es destruido se destruiría también la base de datos. Para hacer persistente la base de datos lo que hacemos es decirle al contenedor MySQL que use el volumen `mysqldata`para almacenar los datos localmente. `local` es el driver que se usará por defecto, pero [existen otras opciones](https://docs.docker.com/compose/compose-file/#volumes-for-services-swarms-and-stack-files). Lo que se hará es montar una carpeta local en el contenedor, pero en lugar de especificar nosotros la carpeta local será docker quién se encargue de hacerlo y los datos se guardarán de manera persistente en dicha ubicación.

La última sección es `healthcheck`. Permite especificar que condición se ha de cumplir para considerar que el contenedor está preparado (`ready`) en lugar de iniciado (`started`). No solo se ha de iniciar el contenedor, también le deberemos dar tiempo para que cree la base de datos antes de que el contenedor PHP intente acceder al mismo. Es por eso que la comprobación se reintente hasta 10 veces cada 5 segundor.

Ya podemos iniciar el servicio:

```bash
$ docker-compose up -d
```

Si recargamos la página en el navegador deberíamos obtener algo como:

![](https://i.imgur.com/6M1rkDj.jpg)

Ya estamos sirviendo ficheros PHP desde NGINX y que pueden conectar a una base de datos MySQL. 

El siguiente paso será hacer que podamos interaccionar con la base de datos de una forma más amigable

### phpMyAdmin

Docker provee una imagen de phpMyAdmin que nos permite tratar de forma sencialla con MySQL.

Editamos el fichero `docker-compose.yml` y añadimos al final de la sección de `services` (antes de `volumes`):

```yaml
  # PhpMyAdmin Service
  phpmyadmin:
    image: phpmyadmin/phpmyadmin:5
    ports:
      - 8080:80
    environment:
      PMA_HOST: mysql
    depends_on:
      mysql:
        condition: service_healthy

```
Basicamente:
* Mapeamos el puerto local 8080 al puerto 80 del contenedor para acceder phpMyAdmin
* Especificamos que debe estar iniciado el contenedor `mysql` para que se inicie
* Para que el contenedor de phpMyAdmin pueda conectar al de MySQL creamos la variable de entorno `PMA_HOST`

Guardamos los cambios y volvemos a lanzar los contenedores:

```bash
$ docker-compose up -d
```
Si en el navegador introducimos la URL `http://localhost:8080` se abrirá la web de **phpMyAdmin**

![](https://i.imgur.com/gfNCUdh.png)

Con `root` / `root` de usuario y contraseña iniciamos sesión.

Si creamos un par de tablas a la base de datos `demo` y recargamos `http://localhost` veremos que se listarán.

![](https://i.imgur.com/K4UMx3u.png)

### Aplicando variables de entorno a todo el proyecto

Para añadir variables de entorno cuyo ámbito sea todo el proyecto (no un contenedor en concreto) usamos la sección `environment` en el fichero `docker-compose.yml`

Si ejecutamos:

```bash
$ docker-compose ps
```

Vemos que todos los contenedores tienen como prefijo el nombre de la carpeta del proyecto.  Vamos a cambiarlo, pero antes tenemos que destruir los contenedores y volúmenes para empezar de cero. Para ello ejecutamos:

```bash
$ docker-compose down -v
Stopping docker-local_phpmyadmin_1 ... done
Stopping docker-local_nginx_1      ... done
Stopping docker-local_php_1        ... done
Stopping docker-local_mysql_1      ... done
Removing docker-local_phpmyadmin_1 ... done
Removing docker-local_nginx_1      ... done
Removing docker-local_php_1        ... done
Removing docker-local_mysql_1      ... done
Removing network docker-local_default
Removing volume docker-local_mysqldata
```

Creamos en la carpeta raíz del proyecto un fichero de nombre `.env` con el siguiente contenido:

```
COMPOSE_PROJECT_NAME=demo
```

Si lanzamos docker-compose de nuevo y ejecutamos `docker-compose ps` veremos que ahora cada contenedor tiene el prefijo `demo_`

```bash
$ docker-compose up -d
$ docker-compose ps
      Name                     Command                  State                      Ports                
--------------------------------------------------------------------------------------------------------
demo_mysql_1        /entrypoint.sh mysqld            Up (healthy)   3306/tcp, 33060/tcp, 33061/tcp      
demo_nginx_1        /docker-entrypoint.sh ngin ...   Up             0.0.0.0:80->80/tcp,:::80->80/tcp    
demo_php_1          docker-php-entrypoint php-fpm    Up             9000/tcp                            
demo_phpmyadmin_1   /docker-entrypoint.sh apac ...   Up             0.0.0.0:8080->80/tcp,:::8080->80/tcp
```

Esto es importante porque al asignar un nombre único al proyecto nos aseguramos de que no haya colisiones con contenedores de otros proyectos que ejecutan los mismos servicios en la misma máquina.

Si usaramos Git para el contro de versiones deberíamos añadir `.env` al fichero `.gitignore` y crear un fichero `.env.example` para ser usado de referencia para quienes clonen nuestro proyecto.

Los archivos y carpetas del mismo deberían ser:

```bash
.
├── .docker
│   ├── mysql
│   │   └── my.cnf
│   ├── nginx
│   │   └── conf.d
│   │       └── php.conf
│   └── php
│       └── Dockerfile
├── docker-compose.yml
├── .env
├── .env.example
└── src
    └── index.php
```
### Images rebuid

En caso de que se cambie la configuración de una de los servicios que implique la **reconstrucción** de la imagen. Después se deberá ejecutar orden para realizar dicho  **rebuild**

Por ejemplo, si queremos añadir soporte para acceso a base de datos usando **mysqli** a la imagen de PHP, debemos modificar el `Dockerfile`de la misma y añadir:

```dockerfile
FROM php:8.0-fpm

RUN docker-php-ext-install pdo_mysql mysqli
```
Además añadimos un fichero `info.php` con el siguiente contenido a la carpeta `src` del proyecto:

```php
<?php
phpinfo();
```
Si iniciamos `docker-compose`:

```bash
$ docker-compose up -d
```

Y abrimos la dirección [http://localhost/info.php](http://localhost/info.php)

Si buscamos `mysqli` en la misma vemos que no se ha instalado el módulos correspondiente:

Tenemos que hacer un **rebuild**. Si queremos hacerlo solo del servicio que hemos modificado (php) ejecutamos:

```bash
$ docker-compose up -d --no-deps --build php
```

Donde:

```
Options:
    -d, --detach        Detached mode: Run containers in the background,
                        print new container names. Incompatible with
                        --abort-on-container-exit.
    --no-deps           Don't start linked services.
    --force-recreate    Recreate containers even if their configuration
                        and image haven't changed.
    --build             Build images before starting containers.
```
Si ahora buscamos `mysqli` en la página `info.php` vemos que el módulo aparece cómo habilitado:

![](https://i.imgur.com/1HHI4jG.png)

Si quisiereamos hacer **rebuild**  a todos los servicios ejecuraíamos:

```bash
$ docker-compose up --force-recreate --build -d
$ docker image prune -f
```

### cheatsheet
Comandos
```bash
$ sudo usermod -aG docker $USER
$ docker-compose up -d
$ docker-compose ps
$ docker-compose stop
$ docker-compose down -v  # destruye contenedores y volúmenes.
$ docker compose down -v --rmi all --remove-orphans # destruye completamente
$ docker-compose exec container_name bash
$ docker-compose logs -f
$ docker-compose up -d --no-deps --build <service-name> # reconstruye imagen después de modificar
$ docker-compose up --force-recreate --build -d
```

## Actividad

A partir de esta guía, crea un nuevo proyecto con Docker y Docker Compose que utilice una de las actividades que hayas hecho en clase con PHP y MySQL.

Cuando hayas terminado, avisa al profesor para que lo revise. 

Además, clona el proyecto en un repositorio público de tu cuenta y entrega en el Aula Virtual la dirección del mismo

## Recursos
* [Docker for local web development - osteel´s blog](https://tech.osteel.me/posts/docker-for-local-web-development-conclusion-where-to-go-from-here)
* [Listado de imágenes de docker-compose](https://hub.docker.com/search?q=&type=image&image_filter=official)
###### tags: `dpl` `ut5` `docker` `lemp`