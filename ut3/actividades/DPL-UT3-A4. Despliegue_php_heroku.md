# DPL-UT3-A4. Desplegando una aplicación PHP en Heroku
## Conceptos
Investiga y contesta.

1. Qué significan las siglas PaaS, IaaS y SaaS. 

> R:

2. De qué tipo de los anteriores es Heroku

> R:

3. Qué son los Dynos

> R:

4. En qué consiste el escalado vertical y el escalado horizontal. Cómo nos permite aplicarlos Heroku

> R:

5. Qué lenguajes de programación nos permite desplegar Heroku

> R:

6. Qué características nos ofrece la cuenta gratuita de Heroku

> R:

7. Qué otras ventajas ofrece Heroku

> R:

## Práctica
Vamos a desplegar una aplicación de prueba en PHP en Heroku. Como equipo local usaremos la máquina virtual de Xubuntu.

De forma genérica, los pasos que deberemos dar son:

1. Crear una cuenta gratuita en Heroku en la dirección [https://signup.heroku.com/](https://signup.heroku.com/)
2. Instalar localmente las herramientas de Heroku. Tenemos las instrucciones en [https://devcenter.heroku.com/articles/heroku-cli](https://devcenter.heroku.com/articles/heroku-cli)

Para los pasos que vienen a continuación te puedes ayudar del [siguiente tutorial](https://medium.com/@votanlean/auto-deploy-your-php-project-via-heroku-in-5-minutes-2fd63da48f44) 

3. Crear la aplicación en PHP
5. Aplicar control de versiones con `git` a nuestra aplicación

Heroku no abre directamente ficheros php. Debemos previamente crear una app usando **composer** 

En el siguiente enlace se explica cómo instalar **composer** en Ubuntu:

* [Instalación de composer en Ubuntu 20.04 - Tutorial Digital Ocean](https://www.digitalocean.com/community/tutorials/how-to-install-composer-on-ubuntu-20-04-quickstart)

En el siguiente enlace se explica cómo crer una aplicación básica con composer:
* [composer hello world - Rivsen en github](https://github.com/Rivsen/hello-world)

6. Usar las herramientas de Heroku que instalamos previamente para desplegar desde la línea de comandos la aplicación
7. Accede a la URL en Heroku de tu aplicación e inserta a continuación una captura de pantalla en la que se muestre el texto: "Hola, soy `pon aquí tu nombre`. Esta es mi primera apliación eh Heroku." 

> Borra este texto y sustitúyelo por la captura de pantalla.

8. Si modificas tu aplicación. ¿Qué tienes que ejecutar para que los cambios se apliquen en la nube de Heroku?

> R:

## Entrega

Exporta este documento con las respuestas a **PDF** y entrégalo en el aula virtual

## Recursos
* [Introducción a Heroku - Openwebinars](https://openwebinars.net/blog/introduccion-heroku/)
* [Despliega un proyecto PHP en Heroku en 5 minutos](https://medium.com/@votanlean/auto-deploy-your-php-project-via-heroku-in-5-minutes-2fd63da48f44)
###### tags: `dpl` `UT2` `php` `heroku
`