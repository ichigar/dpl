# UT3-A3. Servidor LEMP en Ubuntu (E-2)

## Tarea

Uno de los servidores web más populares actualmente es NGINX

En una máquina virtual de Ubuntu Server clonada a partir de la plantilla nos aseguramos de que no tenga aapche instalado. En caso de estar ejecutado lo desinstalamos ejecutando:

```bash
$ sudo apt purge apache2
```
Configura la máquina virtual con la **IP** 10.11.202.x/16

Instala en la misma un servidor LEMP para el HostVirtual `www.valsequillo.com`.

Comprueba que el servidor tiene soporte para PHP y Mysql.

Te puedes ayudar del [siguiente tutorial](https://www.digitalocean.com/community/tutorials/how-to-install-linux-nginx-mysql-php-lemp-stack-on-ubuntu-20-04-es)