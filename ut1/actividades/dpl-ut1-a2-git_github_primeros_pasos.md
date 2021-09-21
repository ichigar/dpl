
# DPL-UT1-A2. Git y Github. Primeros pasos

## Elementos curriculares

* **RA6**. Elabora la documentación de la aplicación Web evaluando y seleccionando herramientas de generación de documentación y control de versiones.
  * **CE 6.a**: Se han identificado diferentes herramientas de generación de documentación.
  * **CE 6.c**: Se han utilizado diferentes formatos para la documentación.
  * **CE 6.d**: Se han utilizado herramientas colaborativas para la elaboración y mantenimiento de la documentación.
  * **CE 6.e**: Se ha instalado, configurado y utilizado un sistema de control de versiones.
  * **CE 6.f**: Se ha garantizado la accesibilidad y seguridad de la documentación almacenada por el sistema de control de versiones.

* ## 1. Introducción

  Git es una herramienta de control de versiones. Permite controlar el proceso de creación de software1 llevando un registro exhaustivo de todos los cambios realizados.

  Ofrece la posibilidad de crear versiones, de ramificar un proyecto en diferentes ramas e incluso de volver hacia atrás deshaciendo los últimos cambios realizados.

  Git es un programa libre y gratuito que se distribuye mediante la licencia GNU (GPL 2.0)

  **Actividad 1**. Investiga y contesta. ¿Quién es el propietario actual de github?¿En qué año lo adquirió?¿A qué precio?

  > respuesta aquí

  ## 2. Git. Instalación

  Lo tenemos instalado por defecto en nuestros equipos. Podemos comprobarlo ejecutando:

  ```bash
  $ git --version
  git version 2.25.1
  ```

  ## Configuración inicial

  Antes de usar Git es conveniente emplear unos minutos en configurar la herramienta.

  Lo primero que hay que hacer es indicar el nombre y el correo electrónico.

  ```bash
  git config --global user.name "Alan Brito Delgado"
  git config --global user.email "alan.brito.delgado@gmail.com"
  ```

  Para realizar ciertas acciones se nos pedirá una contraseña. Puede resultar tedioso tener que introducirla constantemente. Git permite “cachear” la contraseña de modo que solo hará falta introducirla una vez al principio de la sesión.

  ```bash
  git config --global credential.helper 'cache --timeout=36000'
  ```

  Para mostrar la configuración actual de **git** ejecutamos:

  ```bash
  $ git config -l
  user.email=alan.brito.delgado@gmail.com
  user.name=Alan Brito Delgado
  credential.helper=cache --timeout=36000
  ```

  **Actividad 2**. Realiza la configuración básica de Git. Inserta a continuación captura con el resultado de ejecutar `git config -l`


  ## 3. Github. Creación de una cuenta y configuración básica

  ### 3.1. ¿Qué es github?

  GitHub es una plataforma web que permite alojar proyectos controlados mediante Git. En GitHub tendremos una especie de “espejo” o duplicado de los proyectos que tenemos en nuestro propio ordenador y, además, podremos ver los proyectos de otra mucha gente.

  GitHub funciona también como una red social de programadores en la que se pueden votar los proyectos y los usuarios. Cada usuario puede establecer vínculos con otros usuarios y puede seguir lo que hace.

  Muchas empresas buscan programadores en esta plataforma hasta tal punto que hoy día GitHub es considerado el escaparate del programador.

  El uso de GitHub base es gratuito, con funcionalidades extra el plan es de pago.

  ### 3.2. Creación de una cuenta en GitHub

  Entra en la web de Github ([https://github.com](https://github.com)) y haz clic en el botón **Sign up**

  ![](https://i.imgur.com/lvgT4yl.png)

  El nombre de usuario solo puede contener letras y números. Están prohibidos los espacios, aunque se pueden usar los guiones como separadores. Una buena práctica consiste en usar el nombre completo sin espacios en formato capitalizado; por ejemplo, AlanBritoDelgado es un buen nombre de usuario.

  La dirección de correo electrónico debe tener un formato correcto y la contraseña debe tener un mínimo de siete caracteres y contener al menos un número.

  ![](https://i.imgur.com/t57qkGO.png)

  Recibimos por correo un código de verificación que deberemos introducir.

  Completamos las acciones del asistente y seleccionamos en el último paso el plan gratuito.

  **Actividad 3** Responde ¿Qué funcionalidades nos ofrece el plan gratuito?

  > Respuesta aquí

  ### 3.3. Configuración de GitHub

  Antes de realizar cualquier acción dentro de GitHub es conveniente realizar unos ajustes previos.

  Haz clic en el icono de tu avatar (inicialmente se asigna un avatar aleatorio por defecto). En el menú desplegable que aparece selecciona Your profile.

  ![](https://i.imgur.com/cnUnyrA.png)

  Ahora haz clic en el botón **Edit profile**.

  Cambia el horroroso **avatar** que te asigna GitHub. Podrías usar una foto en la que se te reconozca. No pongas una foto de una orla ni una en la que aparezcas con traje y corbata. Recuerda que GitHub es una herramienta para programadores, no para agentes de bolsa ni corredores de seguros. 

  Ni se te ocurra poner una foto de tu mascota, de tu novio/a o de tu coche. Hay muchos perfiles de buenos programadores en GitHub estropeados por una mala foto.

  Escribe tu **nombre completo** (nombre y apellidos), con los correspondientes espacios, mayúsculas y tildes si procede.

  Anota en el campo **Bio** tu actividad actual, por ejemplo, Alumno de DAW del IES Ana Luisa Benítez.

  Si tienes una web personal o un blog con contenidos relacionados con la programación o con algo que tenga que ver con la informática, escribe la dirección en el campo **URL**. Si no tienes nada de eso, escribe en este campo la dirección de tu perfil de **LinkedIn**. En caso de no tener cuenta en LinkedIn, es recomendable darse de alta; es una red social profesional muy práctica para hacer contactos a nivel corporativo y también es muy útil en la búsqueda de empleo.

  Rellena el campo **Company** si trabajas para una empresa.

  El campo **Location** es muy importante. Escribe el nombre de tu ciudad y, entre paréntesis, el nombre de tu país en **inglés**. Imagina que una compañía importante está buscando programadores en tu ciudad. Lo primero que haría la empresa es mirar el ranking de un determinado lenguaje (por ejemplo Javascript) en tu ciudad. Si no tienes relleno el campo Location simplemente no aparecerías en ese ranking (ni siquiera en los últimos puestos) y habrías perdido una buena oportunidad.

  ![](https://i.imgur.com/qE5OD1Y.png)

  Por último, si quieres decirle al mundo que estás disponible para que te contraten, marca la casilla **Available for hire**. Hay aplicaciones que sondean los perfiles de GitHub en busca de candidatos para puestos de programación y miran si esta casilla está marcada.

  > Ten cuidado de grabar correctamente los cambios, cada sección de esta página tiene un botón independiente para hacerlo.

  **Actividad 4** Inserta captura en la que se muestre tu perfil en **GitHub**

  ## Primeros pasos con Git y Github

  ### 4.1. Creación de repositorios en GitHub

  Para crear un repositorio en GitHub, en la página de inicio de GitHub, con la sesión iniciada hacemos click en **Create Repository**

  ![](https://i.imgur.com/z8Ky6m5.png)

  Escribe el nombre del repositorio en el campo **Repository name**. Vamos a llamarlo **intro-github**

  >`Debe ser un nombre lo más claro y conciso posible. No se permiten espacios en blanco ni caracteres especiales en este campo. Las palabras pueden estar separadas por guiones`


  El campo Description es opcional, no obstante es muy recomendable rellenarlo. Esta casilla debe contener la descripción del repositorio, con una línea es suficiente.

  Marca la casilla **Add a README file**. Este paso es muy importante. Al marcar esta opción, se crea el fichero README.md que contiene por defecto el nombre y la descripción del repositorio.

  ![](https://i.imgur.com/gAnBpkc.png)

  Una vez creado el repositorio, aparece una vista general desde la que se puede ver el contenido del mismo .

  ![](https://i.imgur.com/IemYEp9.png)

  ### 4.2. Clonado de repositorios (de GitHub a nuestra máquina)

  Clonar significa hacer una copia exacta; por tanto, clonar un repositorio es hacer una copia idéntica de un proyecto que existe en GitHub y llevártela a tu máquina.

  Estarás pensando ¿qué diferencia hay entre clonar un repositorio y simplemente bajar los archivos? En principio no hay diferencia, pero si el repositorio de GitHub cambia porque se añaden, se borran o se modifican ficheros, entonces tendrás en tu máquina una versión desactualizada, ya no será un clon de lo que hay en GitHub. Sin embargo, cuando se ha clonado un repositorio con Git, la actualización es algo trivial como veremos más adelante.

  Para clonar un repositorio tan solo nos hace falta saber su dirección exacta en GitHub. Unas veces se nos proporcionará ese dato y, en otras ocasiones, deberemos buscar la dirección desde el mismo GitHub.

  Vamos a ver un caso práctico clonando un repositorio:

  ```bash
  $ mkdir temp
  $ cd temp
  $ git clone https://github.com/josejuansanchez/taller-git-github
  ```

  Se nos mostrará:

  ```
  Clonando en 'taller-git-github'...
  remote: Enumerating objects: 55, done.
  remote: Total 55 (delta 0), reused 0 (delta 0), pack-reused 55
  Desempaquetando objetos: 100% (55/55), 159.37 KiB | 703.00 KiB/s, listo.
  ```

  Lo que indica que el proceso ha terminado satisfactoriamente. Ahora dentro de la carpeta **taller-git-github** tendremos todos los archivos y carpetas del repositorio. Los podemos ver ejecutando:

  ```bash
  $ tree 
  
  taller-git-github/
  ├── images
  │   ├── img-00.png
  │   └── img-01.png
  ├── LICENSE
  ├── README.md
  └── spelling.sh
  ```

  Lo habitual es que el contenido de un repositorio vaya cambiando con el tiempo: se arreglan errores, se amplía la funcionalidad con nuevas características, se cambia el aspecto de la aplicación, etc.

  Vamos a actualizar los repositorios que clonamos anteriormente. Primero accedemos a la carpeta del repositorio:

  ```bash
  $ cd taller-git-github/
  ```

  y luego ejecutamos

  ```bash
  $ git pull
  Ya está actualizado.
  ```

  > Los repositorios clonados no se actualizan automáticamente como pasa por ejemplo con GoogleDrive o Dropbox. La actualización se debe hacer de forma manual con **git pull**.

  ### 4.3. Creando y modificando archivos

  Hasta ahora hemos aprendido a sincronizar en nuestro equipo un repositorio. Ahora vamos a ver que pasos son necesarios para que en el repositorio se almacenen las modificaciones que hagamos a los archivos o los nuevos archivos que creemos.

  #### git clone

  Primero vamos a clonar el repositorio que creamos previamente. Para averiguar la URL del mismo accedemos a la web del repositorio en GitHub  y hacemos clic en **Code**

  ![](https://i.imgur.com/YPJTt21.png)

  Se nos mostrará la URL del repositorio y podremos copiarla directamente al portapapeles haciendo clic en el icono correspondiente.

  Accedemos a la carpeta en la que queremos almacenarlo:

  ```bash
  $ cd ~/Documentos
  ```

  Y lo clonamos ejecutando:

  ```bash
  $ git clone https://github.com/ichigar/intro-github.git
  ```

  > Para **pegar** del portapapeles al terminal lo podemos hacer con la combinación de teclas **ctrl + shift + v**

  Accedemos a la carpeta de inicio del repositorio:

  ```bash
  $ cd intro-github
  ```

  Si listamos el contenido de la carpeta mostrando los archivos ocultos:

  ```bash
  $ ls -a
  .  ..  .git  README.md
  ```

  Vemos que contiene el fichero README.md que añadimos al crear el repositorio y la carpeta oculta `.git` que contiene todos los ficheros de configuración que **git** necesita para funcionar.

  #### git add

  Vamos a añadir nuevo contenido. Creamos una carpeta y dentro de la misma un archivo de texto:

  ```bash
  $ mkdir test
  $ cd test
  $ nano prueba.md
  $ cd ..
  ```

  >Insertamos algun texto en el archivo y teclemaos  `CTRL + X` para guardar y salir.

  Hay un comando muy útil que, en ocasiones, nos puede ayudar a solventar posibles errores y nos da pistas sobre el estado actual del repositorio y sobre cuál es el siguiente paso que hay que dar, se trata de `git status`.

  ```bash
  $ git status
  En la rama main
  Tu rama está actualizada con 'origin/main'.
  
  Archivos sin seguimiento:
    (usa "git add <archivo>..." para incluirlo a lo que se será confirmado)
          test/
  
  no hay nada agregado al commit pero hay archivos sin seguimiento presentes (usa "git add" para hacerles seguimiento)
  ```

  Básicamente, lo que nos está diciendo `git status` es que hemos añadido el archivo `prueba.md` a nuestro repositorio pero no lo estamos teniendo en cuenta de cara a futuras actualizaciones. Además nos está dando una pista muy importante sobre elsiguiente paso: utilizar el comando **git add** seguido del nombre del archivo.


  Para que **git** haga seguimiento de un archivo se lo debemos indicar con el comando `git add test/prueba.md`. Ahora bien, lo normal es añadir, modificar y borrar con frecuencia muchos ficheros de un repositorio; hacer **git add** para cada uno de ellos puede resultar tedioso y, lo peor, se nos puede olvidar alguno.

  En la práctica, lo más cómodo es utilizar `git add . --all` (fíjate que hay un punto detrás de add), de esta manera Git chequea todos los archivos que se han añadido al directorio y a cualquiera de los subdirectorios que contiene y todas las modificaciones que se han realizado.

  ```bash
  $ git add . --all
  ```

  Si después de teclear git add . --all no se muestra ningún mensaje, todo va bien.

  #### git commit

  Veamos cual es el estado del repositorio

  ```bash
  $ git status
  En la rama main
  Tu rama está actualizada con 'origin/main'.
  
  Cambios a ser confirmados:
    (usa "git restore --staged <archivo>..." para sacar del área de stage)
          nuevo archivo:  test/prueba.md
  ```

  La línea **Cambios a ser confirmados** indica que al archivo `prueba.md`, al que se le está haciendo seguimiento tiene cambios que deben aplicarse (o en la terminología de **git** debe hacerse un *commit*) para que dichos cambios formen parte de la rama actual con la que estamos trabajando. Para ello ejecutamos:

  ```bash
  $ git commit -m "Añadido fichero prueba.md"
  [main e81d046] Añadido fichero prueba.md
   1 file changed, 1 insertion(+)
   create mode 100644 test/prueba.md
  ```

  Fíjate que debemos escribir tras la opción **-m** un mensaje explicativo indicando en qué consisten los cambios realizados.

  #### git push

  El último paso consiste en “empujar” todos los cambios realizados en local y llevarlos al repositorio que está en GitHub. Para ello se utiliza el comando **git push**. Pero antes debemos establecer un mecanismo que nos permita autenticarnos en nuestro repositorio para que sólo las personas autorizadas puedan acceder.

  Inicialmente **GitHub** pedía nuestro nombre de usuario y contraseña al ejecutar **git push**, pero a partir de agosto de 2021 cambió el mecanismo de autenticación.

  Para generar el token tienes las instrucciones del [siguiente tutorial](https://techglimpse.com/git-push-github-token-based-passwordless/)

  Al final del procedimiento obtendremos una cadena de texto de la forma `ghp_ICfUCaabcwKVEXIVcoO1pWfTwMvs4B26BGkP`

  A continuación le decimos a **git** el repositorio remoto, con el token incluido, al que debe sincronizar cambios cuando ejecutemos **git push**. Para ello, en la carpeta de inicio de nuestro repositorio ejecutamos:

  ```bash
  $ git remote set-url origin https://<TOKEN>@github.com/<username>/<repository_name>.git
  ```

  Para el repositiorio que creamos sería algo como:

  ```bash
  $ git remote set-url origin https://ghp_ICfUCaabcwKVEXIVcoO1pWfTwMvs4B26BGkP@github.com/ichigar/intro-github.git
  ```

  A partir de ahora, al ejecutar **git push** se sincronizarán los cambios en el repositorio:

  ```bash
  $ git push
  Enumerando objetos: 5, listo.
  Contando objetos: 100% (5/5), listo.
  Compresión delta usando hasta 8 hilos
  Comprimiendo objetos: 100% (2/2), listo.
  Escribiendo objetos: 100% (4/4), 339 bytes | 339.00 KiB/s, listo.
  Total 4 (delta 0), reusado 0 (delta 0)
  To https://github.com/ichigar/intro-github.git
     68645ab..e81d046  main -> main
  ```

  Si accedemos ahora a la web de nuestro repositorio veremos que se ha subido el archivo que creamos anteriormente:

  ![](https://i.imgur.com/sVWC62x.png)

  **Actividad 5**. Inserta captura en la que se muestre el contenido de la subcarpeta test en el repositorio **intro-github** de tu usuario:

  ## Referencias

  * [Guía de Supervivencia de Git y GitHub](https://leanpub.com/gitygithub)
  * [Guía para crear PAT en Github](https://techglimpse.com/git-push-github-token-based-passwordless/)

###### tags: `dpl` `ut1` `git` `github` `introducción`
