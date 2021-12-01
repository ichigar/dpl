## DPL-UT3-A2. IIS con soporte par aPHP

Utilizaremos la máquina que hemos utilizado para hacer prácticas de IIS

##  Instalar rol CGI a IIS

En la herramienta de administración de Windows Server seleccionamos la opción de agregar roles y características.

![Windows 2012 add role](https://d1ny9casiyy5u5.cloudfront.net/wp-content/uploads/2018/08/Windows-2012-add-role-1.webp)

Nos aseguramos de que en la ventana de selección de roles esté marcado el Web Server (IIS) y hacemos clic en siguiente.

![IIS Installation](https://d1ny9casiyy5u5.cloudfront.net/wp-content/uploads/2018/08/IIS-Installation.webp)

En la seiguiente ventana seleccionamos la opción de añadir características:

![IIS Features](https://d1ny9casiyy5u5.cloudfront.net/wp-content/uploads/2018/08/IIS-Features.webp)

En la ventana de selección de servicios del rol seleccionanamos la opción **CGI** en el apartado de desarrollo de aplicaciones:

![IIS enable CGI](https://d1ny9casiyy5u5.cloudfront.net/wp-content/uploads/2018/08/IIS-enable-CGI.webp)

Hacemos click en siguiente y en instalar. 

## Instalación de PHP

Lo primero que tendremos que hacer ex acceder al  [página de PHP para Windows](https://windows.php.net/download)

Localizamos la versión Non-Thread Safe (NTS) de PHP  y descargamos el archivo comprimido en formato zip de la misma

![php_8.1_nonthread](img/php_8.1_nonthread.png)

Creamos una carpeta de nombre PHP en la carpeta raíz del disco C y extraemos en el mismo el archivo comprimido que descargamos. 

![Windows PHP Folder](https://d1ny9casiyy5u5.cloudfront.net/wp-content/uploads/2018/08/Windows-PHP-Folder.webp)

## Instalación librerías requerida

La versión 8.1 de PHP que acabamos de descargar fue generada con Visual Studio Code v16. Para su funcionamiento PHP necesita de librerías que para obtenerlas debemos instalar la misma versión VS, En concreto VS16 x64. La podemos descargar e instalar del [siguiente enlace](https://aka.ms/vs/16/release/VC_redist.x64.exe

Después de descargar e instalar Visual Studio tendremos que reiniciar la máquina para que se apliquen los cambios.

## Configurar variables de entorno del sistema

Necesitamos añadir el directorio de PHP a las rutas incluidas en la variable de entorno del sistema  PATH. Tecleamos en el menú de inicio del sistema **variables de entorno** y se nos abrirán las propiedades del sistema.

Accedemos a la pestaña **Opciones avanzadas** y hacemos clic en **Variables de entorno**

![System properties windows](https://d1ny9casiyy5u5.cloudfront.net/wp-content/uploads/2018/08/System-properties-windows.webp)

Seleccionamos la variable PATH y hacemos clic en **editar**.

![path variable](https://d1ny9casiyy5u5.cloudfront.net/wp-content/uploads/2018/08/path-variable.webp)

Hacemos clic en **Nuevo** y añadimos la ruta de PHP `C:\PHP`

Hacemos clic en **Aceptar**

## Comprobación

Para comprobar que funciona correctamete abrimos una consola **cmd** y ejecutamos

```
C:\> php -v
PHP 8.1.0 (cli) (built: Nov 23 2021 21:46:10) (NTS Visual C++ 2019 x64)
Copyright (c) The PHP Group
Zend Engine v4.1.0, Copyright (c) Zend Technologies
```

## Configuración de PHP para aplicaciones web

Localiza en la carpeta `c:\php'  el fichero `php.ini-production` y renómbralo a `php.ini`

![php ini production](https://d1ny9casiyy5u5.cloudfront.net/wp-content/uploads/2018/08/php-ini-production.webp)

En el **Panel de administración/herramientas** selecciona **Administrador de Internet Information Services (IIS)**

Selecciona el servidor y accede al la opción **Asignaciones de controlador**

![IIS Handles Mappings](https://d1ny9casiyy5u5.cloudfront.net/wp-content/uploads/2018/08/IIS-Handles-Mappings.webp)

En la parte derecha haz clic en **Agregar asignación de módulo** y rellena el formulario con los siguientes valores:

```
Request Path - *.php
Module - FastCGIModule
Executable - C:\php\php-cgi.exe
Name - PHP
```

![PHP Module IIS](https://d1ny9casiyy5u5.cloudfront.net/wp-content/uploads/2018/08/PHP-Module-IIS.webp)

Haz clic en **Restricciones de solicitudes** y selecciona la opción **Archivo o carpeta**

![IIS PHP Request Restrictions](https://d1ny9casiyy5u5.cloudfront.net/wp-content/uploads/2018/08/IIS-PHP-Request-Restrictions.webp)

Selecciona **OK** y **Si** en el mensaje de confirmación

![IIS Module mapping](https://d1ny9casiyy5u5.cloudfront.net/wp-content/uploads/2018/08/IIS-Module-mapping.webp)

En los documentos predeterminados añadimos **index.php** a las opciones que le aparecerán a los Hosts Virtuales que creemos a partir de ahora.

![IIS default page PHP](https://d1ny9casiyy5u5.cloudfront.net/wp-content/uploads/2018/08/IIS-default-page-PHP.webp)

Seleccionamos en la parte derecha agregar e introducimos:

```
index.php
```

![IIS PHP support](https://d1ny9casiyy5u5.cloudfront.net/wp-content/uploads/2018/08/IIS-PHP-support.webp)

Para finalizar la instalación paramos 

![IIS stop](https://d1ny9casiyy5u5.cloudfront.net/wp-content/uploads/2018/08/IIS-stop.webp)

E iniciamos IIS

![IIS start](https://d1ny9casiyy5u5.cloudfront.net/wp-content/uploads/2018/08/IIS-start.webp)

## Comprobación

Accede a la carpeta raíz del host virtual por defecto `C:\inetpub\wwwroot` y crea dentro de la misma un fichero de nombre `test.php` e inserta en el mismo:

```php
<?php
phpinfo();
```

Abre el navegador en la máquina virtual u accede a http://localhost/test.php

Se debería mostrar algo como

![php configuration file](https://d1ny9casiyy5u5.cloudfront.net/wp-content/uploads/2018/08/php-configuration-file.webp)

## Tareas

1. Crea un host virtual en IIS para el dominio www.alb.com con carpeta raíz en `C:\inetpub\www.alb.com\html`. Crea un archivo de prueba que contenga PHP en el mismo y comprueba su funcionamiento accediendo desde la máquina virtual de Windows

2. En el [siguiente tutorial](https://hostadvice.com/how-to/how-to-install-and-configure-mysql-for-php-applications-on-windows-iis-7/) se explica cómo instalar **mysql** en Windows Server y confiugrar PHP para acceder al mismo. Da los pasos necesarios para obtener los mismos resultados que en el último apartado de la actividad UT3-A1: al poner la URL:

   ```
   http://www.alb.com/todo_list.php
   ```

   nos lleve al servidor de Windows y el resultado sea del tipo

   ![todo_list.php](/home/ivan/mega/clases/github/dpl/ut3/recursos/img/todo_list.php.png)

   

#### Cuando termines avisa al profesor para que revise la actividad

