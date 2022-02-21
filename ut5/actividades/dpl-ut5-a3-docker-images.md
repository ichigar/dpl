# DPL-UT5-A3. Docker. Creación de imágenes.

## Imágenes de docker. 

### Obteniendo imágenes en DockerHub

En [Docker Hub](https://hub.docker.com/explore/) hay un repositorio de imágenes de docker que podemos utilizar, pero en ocasiones tenemos que crear nuestra propia imagen con las características específicas que necesitamos.

En caso de querer usar una imagen del repositorio oficial la localizamos por su nombre y la descargamos con:

```bash
$ docker pull <imagen>
```

Por ejemplo:

```bash
$ docker pull nginx:1.10.1-alpine
```

### Ejecutando una imagen

Una vez descargada la imagen la ejecutamos con:

```bash
$ docker run
```

Por ejemplo:

```bash
docker run --name my-nginx -d -p 8090:80 nginx:1.10.1-alpine
```

Donde:

* `--name` es opcional, pero nos ayuda a identificar la imagen si hay varias en ejecución.
* `-d` ejecuta contenedor en segundo plano
* `-p 8090:80` mapea el puerto 80 del contenedor con el 8090 del equipo. Permite poder acceder al servicio. De lo contrario el contendor no sería funcional

Podemos comprobar que la imagen se está ejecutando accediendo en el navegador a [http://localhost:8090](http://localhost:8090)

### Trabajando con contenedores

Los contenedores se ejecutan en segundo plano. Para obtener un listado de los contenedores en ejecución:

```bash
$ docker ps
```

Obtenemos algo como:

```bash
$ docker ps
CONTAINER ID        IMAGE                 COMMAND
CREATED             STATUS              PORTS                         NAMES

01041c82947c        nginx:1.10.1-alpine   "nginx -g 'daemon off"
41 minutes ago      Up 41 minutes       0.0.0.0:80->80/tcp, 443/tcp   my-nginx
3 weeks ago         54.03 MB
```

Si queremos ver los contenedores detenidos:

```bash
$ docker ps -a
```
Para parar, iniciar, reiniciar o eliminar un contenedor ejecutamos:

```bash
$ docker stop my-nginx
$ docker start my-nginx
$ docker restart my-nginx
$ docker rm my-nginx
```

Las órdenes anteriores se aplican al contenedor que creamos anteriormente; no permiten cambiar los parámetros del mismo. Los contenedores se consideran **inmutables**. Una vez creados mantienen su configuración.

Para cambiar la configuración de un contenedor debemos parárlo, eliminarlo y crear uno nuevo:

```bash
$ docker stop my-nginx
$ docker rm my-nginx
docker run --name my-nginx -d -p 8091:80 nginx:1.10.1-alpine
```

Para ver los detalles del contenedor:

```bash
$ docker inspect my-nginx
```

Ver los logs:

```bash
$ docker logs my-nginx
```

Ver logs en vivo:

```bash
$ docker logs -f my-nginx
```

### Ejecutando comandos en un contenedor

Si queremos iniciar una sesión interactiva de comandos dentro del contenedor:

```bash
$ docker exec -ti my-nginx /bin/sh
```

Para salir:

```bash
$ exit
```

### Datos en contenedores

Como hemos visto los contenedores no tienen estado. Se inician tal y como fueron definidos. Si cambiamos cualquier información dentro del contenedor en tiempo de ejecución dicha información solo estará disponible mientras se ejecute la imagen. Si paramos la imagen o la borramos y la volvemos a iniciar no se mantendrán las modificaciones que le hayamos hecho.

Para poder gestionar datos que se modifican con el tiempo se usan **volumenes** que permiten compartir información entre el **host** y el contenedor.

De esa forma, si nuestro contenedor usa una base de datos podemos hacer un volumen en el que se guarde localmente la información que creemos o modifiquemos dentro del contenedor.

Si, por ejemplo queremos modificar `index.html` en nginx empezamos creando localmente una carpeta para los archivos de la imagen y dentro una carpeta `src` con el código fuente de nuestro proyecto:

```bash
$ mkdir -p my-nginx/src
$ nano my-nginx/src/index.html    # insertamos contenido
```

A continuación eliminamos la imagen actual:

```bash
$ docker stop my-nginx
$ docker rm my-nginx
```

Y creamos la nueva imagen montando la carpeta `src` en la carpeta de inicio del host virtual por defecto de nginx:

```bash
$ docker run --name my-nginx -d -p 8090:80 -v /home/cfgs2/temp/my-nginx/src:/usr/share/nginx/html:ro nginx:1.10.1-alpine
```

Para crear un volumen en docker usamos la opción `-v` y a continuación especificamos la carpeta local y la carpeta del contenedor que queremos montar. Como caracter separador usamos los ':'

Hemos de usar rutas absolutas a la hora de especificar las carpetas local y remota.

La opción `:ro` al final de la ruta de la carpeta en el contenedor especifica que el volumen se montará en modo **solo lectura**

Si ahora accedemos a `http://localhost:8090` en el navegador, se mostrará el contenido de la página que creamos.

Si ya no necesitamos la imagen podemos eliminarla:

```bash
$ docker stop my-nginx
$ docker rm my-nginx
```

## Dockerfiles

Un **Dockerfile** es un fichero de texto que contiene la definición de una imagen. El contenido del mismo tiene el siguiente formato:

```dockerfile
#Comentario
INSTRUCTION arguments
```

La primera instrucción debe ser `FROM` que nos permite especificar de que imagen vamos a derivar la que estamos creando.

Otras instrucciones que podemos usar son:

| INSTRUCTION | Description                                                  |
| ----------- | ------------------------------------------------------------ |
| FROM        | iIt sets the Base Image for subsequent instructions.         |
| MAINTAINER  | It sets the Author field of the generated images.            |
| RUN         | It will execute any commands when Docker image will be created. |
| CMD         | It will execute any commands when Docker container will be executed. |
| ENTRYPOINT  | It will execute any commands when Docker container will be executed. |
| LABEL       | It adds metadata to an image.                                |
| EXPOSE      | It informs Docker that the container will listen on the specified network ports at runtime. |
| ENV         | It sets the environment variable.                            |
| ADD         | It copies new files, directories or remote file URLs.        |
| COPY        | It copies new files or directories.  The differences of [ADD] are that it's impossible to specify remore URL  and also it will not extract archive files automatically. |
| VOLUME      | It creates a mount point with the specified name and marks it as holding  externally mounted volumes from native host or other containers |
| USER        | It sets the user name or UID.                                |
| WORKDIR     | It sets the working directory.                               |


Crea en la carpeta de tu proyecto un fichero de nombre `Dockerfile` con el siguiente contenido:

```dockerfile
FROM nginx:1.10.1-alpine
MAINTAINER me@example.com
COPY ./src/index.html /usr/share/nginx/html/index.html
```
Para crear la imagen, dentro de la carpeta en la que guardamos el `Dockerfile` ejecutamos:

```bash
$ docker build -t perso-nginx:1.0 .
```
La opción `-t perso-nginx:1.0` permite especificar un nombre y versión para la imagen.

Para ver las imágenes disponibles ejecutamos:

```bash
$ docker images
REPOSITORY              TAG             IMAGE ID       CREATED              SIZE
perso-nginx             1.0             2fee3b690073   About a minute ago   54MB
nginx                   1.10.1-alpine   2cd900f340dd   5 years ago          54MB
```

Podemos iniciar la imagen con:

```bash
$ docker run --name my-nginx-2 -d -p 8100:80 perso-nginx:1.0
```

Comprobamos que está en ejecución:

```bash
docker ps                                                  
CONTAINER ID   IMAGE             COMMAND                  CREATED          STATUS          PORTS                                            NAMES
9fc6de3abf96   perso-nginx:1.0   "nginx -g 'daemon of…"   42 seconds ago   Up 41 seconds   443/tcp, 0.0.0.0:8100->80/tcp, :::8100->80/tcp   my-nginx-2
```

Si en el navegador accedemos a `http://localhost:8100` se debería abrir el fichero HTML que copiamos a la imagen.

## Eliminado imágenes
Para ver todas las imágenes existentes en nuestro sistema:

```bash
$ docker images -a
```

Para eliminar una imagen:

```bash
$ docker rmi -f <imagen>
```

En caso que queramos regenerar eliminar toda la cache de Docker en nuestro equipo:

```bash
$ docker prune -a
```
Más información en el [siguiente enlace](https://www.digitalocean.com/community/tutorials/how-to-remove-docker-images-containers-and-volumes)

## Actividad

A partir de la imagen en docker de Ubuntu `ubuntu:20.04` usando un `Dockerfile` crea una imagen con las siguientes especificaciones:

* Debe contener el servidor web Apache
* Host Virtual para el dominio `testdocker.local` y `www.testdocker.local`
* Carpeta raíz de la web `/var/www/testdocker.local/html`
* Al acceder desde la máquina virtual de Xubuntu a `testdocker.local` o `www.testdocker.local` se debe ver una página que informe de que estamos en dicha web.

**Nota:** Debes crear localmente los archivos de configuración y usando la instrucción `COPY` copiarlos en el contenedor. Con la instrucción `RUN` debes ejecutar los comandos necesarios para que la imagen base de Ubuntu instale el software necesario.

En el [siguiente tutorial](https://serverok.in/build-a-docker-container-with-apache) tienes un ejemplo de cómo crear una imagen de Ubuntu con Apache, aunque no es exactamente igual a lo que se pide.

Entrega la carpeta del proyecto comprimida o un enlace a Github que contenga todos los archivos y carpetas. 

La carpeta debe contener:

* Un fichero `README.md` con las instrucciones para crear y ejecutar la imagen
* El fichero `Dockerfile` 
* Los archivos que son copiados a la imagen.

## Complemetario

1. Hacer que los logs de Apache2 se muestren al ejecutar `docker logs imagen` en el [siguente tutorial](https://docs.docker.com/config/containers/logging/) se encuentra la información de cómo hacerlo.

2. Realizar los mismos pasos para conseguir una imagen docker para `testdocker.local` tomando como imagen base `alpine`

## Recursos

* [Getting started with docker - Takacsmark.com](https://takacsmark.com/getting-started-with-docker-in-your-project-step-by-step-tutorial/)
* [Dockerfile tutorial by example - basics and best practices - Takacsmark.com](https://takacsmark.com/dockerfile-tutorial-by-example-dockerfile-best-practices-2018/)
* [Buenas prácticas al crear imágenes con Docker](https://docs.docker.com/develop/develop-images/dockerfile_best-practices/)
* [Build a docker container with apache - Serverok](https://serverok.in/build-a-docker-container-with-apache)
* [Eliminar imágenes de docker - Digital Ocean](https://www.digitalocean.com/community/tutorials/how-to-remove-docker-images-containers-and-volumes)

###### tags: `dpl` `ut5` `contenedores` `docker` `dockerfile`
