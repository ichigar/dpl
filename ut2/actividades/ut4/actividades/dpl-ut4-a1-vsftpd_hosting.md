# DPL-UT4-A1-Servidor de FTP

## Tarea:

Contestar las preguntas que se plantean y realizar los pasos de la práctica. Como equipo servidor utilizarás la máquina virtual de Ubuntu Server y como equipo cliente tu propio equipo o una máquina virtual con Xubuntu o Windows,.

## Pasos de la práctica:

### 1. Resumen de la actividad

Nuestro servidor actuará de hosting web para diferentes usuarios, por lo que el servidor deberá tener instalado los paquetes del **LAMP server**.

Además vamos a crear subcarpetas para dos usuarios (user1 y user2) en **/var/www**

```bash
$ sudo mkdir /var/www/user1
$ sudo mkdir /var/www/user2
```

Cada uno de los usuarios ha contratado un dominio (user1 **grancanaria.ocm** y user2 **mevoyaforrar.com**) crea un host virtual para cada uno de los usuarios con el dominio que han contrarado y con **directorio raiz** la subcarpeta **public\_html** dentro del directorio raíz del usuario. Así, por ejemoplo, la carpeta raíz del host virtual del usuario user1 sería **/var/www/user1/public\_html**

### 2. Configuración inicial de máquina virtual

Máquina virtual de Ubuntu Server con tarjeta de red en modo puente y con configuración de red: 10.11.211.x/16

En el cortafuegos abriremos los puertos (todos TCP):

- 22 - ssh
- 80, 443 – http y https
- 21 – FTP
- 30000 – 30200 para el modo pasivo de FTP (investiga cómo abrir un rango de puertos con ufw)

### 3. Instalación del servidor y configuración básica

En primer lugar instalaremos vsftpd. Los pasos que tenemos que ejecutar son:

3.1) Para instalar vsftpd ejecutamos
```bash
$ sudo apt-get install vsftpd
```

3.2) Configuración inicial. Por defecto los usuarios locales pueden conectarse, sólo hemos de permitir que los usuarios puedan subir ficheros. Editamos el fichero de configuración de vsftp:

```bash
$ sudo nano /etc/vsftpd.conf
```
Modificamos la línea siguiente y nos aseguramos de que esté descomentada.
```bash
write_enable=YES  ← descomentar
```
3.3) Habilitamos el modo pasivo en el servidor añadiendo al final del archivo de configuración las siguientes líneas:

```bash
pasv_enable=Yes
pasv_max_port=30200
pasv_min_port=30000
```

3.4) Reiniciamos el servidor para que tome los cambios:
```bash
$ sudo service vsftpd restart
```
Utilizando **Filezilla** o **gFTP** como cliente de FTP accede con el usuario **usuario**, desde la máquina virtual de Xubuntu al servidor. Comprueba que tienes permiso de escritura creando la carpeta **ftp** en tu carpeta de usuario. Sube un archivo a dicha carpeta. Inserta una captura de pantalla en la que se vea en filezilla o gFTP la carpeta y el archivo subido

> Inserta aquí

Configura el cliente para que acceda en **modo pasivo** y comprueba su funcionamiento. Inserta una captura de pantalla en la que se vea como configuras Filezilla o ftp en el terminal para que acceda en modo pasivo

> Inserta aquí

**Nota**: cuando la conexión es en modo pasivo el comando que se muestra cuando el cliente sube o descarga un fichero es **PASV**, mientras que cuando no está en modo pasivo es **PORT**

### 4. Dando servicio de FTP a usuarios web

#### Entorno chroot
¿Averigua y describe qué es un entorno **chroot**?

> Respuesta: 

Conecta con el cliente FTP con el usuario **usuario** al servidor, comprueba que puedes subir de la carpeta inicial **/home/usuario** a la carpeta **/home**.

Para habilitar el entorno **chroot** debemos, en el fichero de configuración de **vsftpd** descomentar la línea:

```bash
chroot_local_users=YES  ← descomentar
```
Y añadir al final la línea:

```bash
allow_writeable_chroot=YES
```

Reinicia el servicio y vuelve a conectar. Comprueba que ya no puedes subir a la carpeta **/home** y que al conectar aparece la carpeta / aunque realmente estás en **/home/usuario**. Inserta captura que demuestre lo anterior:

> captura:

#### Crear usuarios

Vamos a crear ahora los usuarios de nuestro hosting  y configurar adecuadamente los mismo para que accedan por ftp para hospedar sus sitio web.

Una medida de seguridad que se le aplica a los usuarios FTP es que **no tengan acceso** a un interprete de comandos o Shell de sistema.

Con este objetivo, vamos a crear los usuarios

Usuario: **user1**

* Directorio de inicio del usuario: **/var/www/user1**
* Directorio de inicio del host virtual: **/var/www/user1/public_html**
* **Sin shell** en el sistema y en un **entorno chroot**

Usuario: **user2**
* Directorio de inicio del usuario: **/var/www/user2**
* Directorio de inicio del host virtual: **/var/www/user2/public_html**
* **Sin shell** en el sistema y en un **entorno chroot**

Los pasos necesarios para crear los usuarios y configurar el servidor adecuadamente son

4.1) Creamos los usuarios, les asignamos su carpeta inicial y un interprete de comandos ficticio para que no puedan iniciar sesión normal en el sistema (sólo acceder por ftp):

```bash
$ sudo useradd -d /var/www/user1 -s /usr/sbin/nologin user1
$ sudo useradd -d /var/www/user2 -s /usr/sbin/nologin user2
```

4.2) Asignamos contraseña a los usuarios

```bash
$ sudo passwd user1
$ sudo passwd user2
```

4.3) Añadimos un shell o interprete de comandos ficticio a los intérpretes del sistema disponibles

```bash
$ sudo nano /etc/shells
```
Añadimos:

```bash
/usr/bin/esh
/bin/dash
/bin/bash
/bin/rbash
/usr/bin/screen
/usr/sbin/nologin ← lo añadimos al final del fichero
```

### 5. Carpetas y permisos

5.1)  Nos aseguramos de que el usuario y el grupo propietario son www-data en /var/www para que el servidor web Apache pueda acceder al mismo

```bash
$ sudo chown -R www-data:www-data /var/www
```

5.2) Para que los usuarios puedan acceder a su carpeta han de ser los propietarios de la misma (el grupo principal seguirá siendo www-data y Apache podrá seguir accediendo a los archivos):
```bash
$ sudo chown -R user1 /var/www/user1
$ sudo chown -R user2 /var/www/user2
```

5.3) Cambiamos los permisos de la carpeta de forma que el usuario tenga todos los permisos y el servidor web Apache tenga permisos de lectura y ejecución en la carpeta web de cada usuario1
```bash
$ sudo chmod -R 750 /var/www/user1
$ sudo chmod -R 750 /var/www/user2
```

5.4) Para que los ficheros que suban los usuarios por FTP se creen con los permisos adecuados modificamos la directiva **local_umask** en el fichero de configuración de vsftp

```bash
$ sudo nano /etc/vsftpd.conf
```
En la línea correspondiente sustituimos el valor por defecto por:

**local_umask=026**

De esa forma los usuarios tendrán todos los permisos en los archivos subidos, Apache sólo tendrá permiso de lectura y el resto de usuarios ningún permiso.

5.5) Para que cuando los usuarios suban archivos **no se modifique el usuario y el grupo propietario** del mismo activamos el bit **setuid** a los permisos de las carpetas de los usuarios:

```bash
$ sudo chmod -R **g+s** /var/www/user1
$ sudo chmod -R **g+s** /var/www/user2
```

Guardamos y reiniciamos el servidor para que tome los cambios.

**Nota**: local_umask=002 permitirá que si subimos un archivo se cree con los permisos **664** (666-002 ← valor de umask) y si subimos o creamos una carpeta lo haga con los permisos **775** (777-002)

Para comprobarlo, nos conectamos por FTP con el usuario **user1** si subimos un archivo **prueba.txt** a su directorio raíz (`/var/www/user1`) si accedemos desde un terminal y mostramos el contenido de la carpeta `/var/www/user1` obtendremos:

```bash
$ ls -l
...
-rw-rw-r--  1 user1  www-data  2872 2011-11-24 21:46 prueba.txt
...
```
Vemos que el fichero se crea con permisos de lectura y **escritura** para el usuario y el **grupo**, que se crea con el usuario joomla (con el que nos conectamos) y con el grupo **www-data** (el que definimos como grupo principal cuando creamos el usuario, por lo que apache podrá acceder al archivo para leerlo y modificarlo)

Comprueba utilizando un cliente de FTP que los usuarios acceden con las características con las que se definieron. Conecta con el usuario **user2**, sube un fichero. Inserta una captura de pantalla en la que se vea que el fichero subido tiene los permisos adecuados:

> Captura: 



5.5) Comprueba el correcto funcionamiento del sistema accediendo por ftp con cada uno de los usuario y subiendo una página web a la carpeta **public_html** de cada uno de los usuario. Comprueba desde tu equipo que accediendo a los dominios de cada usuario se muestra correctamente su página.

**Cuando hayas terminado avisa al profesor para que revise la práctica**

