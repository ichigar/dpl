# DPL-UT4-A4. Webdav

WebDAV (“Edición y versionado distribuidos sobre la web”) es un protocolo para hacer que la www sea un medio **legible y editable**. Este protocolo proporciona funcionalidades para **crear, cambiar y mover documentos en un servidor remoto** (típicamente un servidor web). Esto se utiliza sobre todo para permitir la edición de los documentos que sirve un servidor web, pero puede  también aplicarse a sistemas de almacenamiento generales basados en web  como los NAS. La mayoría de los sistemas operativos modernos  proporcionan soporte para WebDAV, haciendo que los ficheros de un  servidor WebDAV aparezcan como almacenados en un directorio local.

#### Actividad

A partir del [siguiente tutorial](https://www.digitalocean.com/community/tutorials/how-to-configure-webdav-access-with-apache-on-ubuntu-20-04) configura una máquina virtual de Ubuntu Server para que apache2 permita webdav. El servidor deberemos configurarlo con las siguientes  características:

1. Asigna a Ubuntu Server una IP estática de la red de clase, instala  Apche2 y Modifica el host virtual almacenado en la carpeta /etc/apache2/sites-availbable/default-ssl.conf con las siguientes características:
   - Nombre de dominio principal lapalmera.com. Nombre alternativo www.lapalmera.com
   - Carpeta raiź de la web: /var/www/lapalmera.com/public_html
   - Acceso por **https**: mantener la configuración por defecto del host virtual. 
   - Renonmbra el archivo de confiugarción del host virtual a /etc/apache2/sites-available/lapalmera.com.conf
   - No te olvides de habilitar el módulo de **ssl** y de reiniciar apache cuando hayas terminado la configuración

2. Crea una página de inicio (index.html) y accede a la misma (https://lapalmera.com) para comprobar la configuración actual.

3. Basándote en el tutorial que se indica al principio de la actividad da  los pasos necesarios para habilitar webdav y que podamos acceder usando  dicho protocolo a la carpeta /var/www/lapalmera.com/webdav al poner en el navegador la URL https://lapalmera.com/webdav. Tendrás que crear un **alias** en el fichero de configuración.

4. Crea en la carpeta /var/www/lapalamera.com/webdav uno o varios ficheros, asignales como usuario y grupo propietario **www-data**

5. 5. Restringe mediante autenticación Digest la carpeta /var/www/lapalmera.com/webdav de forma que:

   - El realm sea webdav

   - Solo puedan acceder los usuarios **pepe** y **pepa** con la contraseña **daw1234**

6. Comprueba desde Xubuntu usando el explorador de archivos que al acceder a la dirección [davs://lapalmera.com/webdav](davs://lapalmera.com/webdav) puedes acceder a los ficheros.

7. Crea una unidad de red en Windows 10 que acceda usando el protocolo webdav a https://lapalmera.com/webdav

**Cuando termines avisa al profesor para que revise la actividad**