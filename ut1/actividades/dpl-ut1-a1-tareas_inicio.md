# DPL-UT1-A1. Preparación inicial de servidores y tareas básicas

[TOC]

## Elementos curriculares
**Resultado de aprendizaje 1**: Implanta arquitecturas Web analizando y aplicando criterios de funcionalidad.

**Criterios de evaluación:**
* **1.c.** Se ha realizado la instalación y configuración básica de servidores Web.
* **1.f.** Se han realizado pruebas de funcionamiento de los servidores web y de aplicaciones.
* **1.i.** Se han documentado los procesos de instalación y configuración realizados sobre los servidores Web y sobre las aplicaciones.

## Tarea
Sigue los pasos que se indican
### 1. Preparación de maquetas
Crea las siguientes máquinas virtuales en VirtualBox. Asegúrate que se almacenan en el disco SSD del equipo anfitrión. Organiza las máquinas virtuales en un grupo llamado plantillas

![](https://i.imgur.com/YXPJur1.png)

#### 1.1. Ubuntu Server
**Hardware  virtual:**
* Opciones por defecto.
* Tarjeta de red:
    * Modo puente
    * Tipo de adaptador: **virtio-net**

![](https://i.imgur.com/jT4VTUR.png)

Para la instalación del sistema operativo conectaremos a la unidad óptica virtual la iso de la versión de ubuntu Server **20.04**

**Configuración:**
* Instalación por defecto. Parámetros:
    * Nombre del equipo: **userver-xy**, donde xy es tu número de equipo en el aula.
    * Usuario por defecto: **usuario**
    * Contraseña: **daw1234**
* Configuración de red:
    * Ip estática: 10.11.101.xy/16
    * Puerta de enlace: 10.11.0.1
    * DNS: 9.9.9.9, 1.1.1.1
* Actualizar paquetes
* Instalar ssh y apache2
* Cortafuegos activado con todo el tráfico entrante denegado salvo a los puertos del ssh y http
#### 1.2. Xubuntu
**Hardware  virtual:**
* Opciones por defecto.
* Tarjeta de red:
    * Modo puente
    * Tipo de adaptador: **virtio-net**

![](https://i.imgur.com/jT4VTUR.png)

Para la instalación del sistema operativo conectaremos a la unidad óptica virtual la iso de la versión de Xubuntu **21.04**

**Configuración:**
* Instalación por defecto. Parámetros:
    * Nombre del equipo: **xubuntu-xy**, donde xy es tu número de equipo en el aula.
    * Usuario por defecto: **usuario**
    * Contraseña: **daw1234**
* Configuración de red: **DHCP**
* Actualizar paquetes
### 2. Tareas básicas
#### 2.1. Acceso por ssh
Da los pasos necesarios para poder acceder por ssh desde el anfitrión a Ubuntu Server sin usar contraseña. Inserta captura de pantalla en la que se muestre como al acceder no se te pide la contraseña

#### 2.2. Acceso web
Modifica la web que se muestra por defecto en Apache para que muestre tu nombre. A continuación accede desde el navegador de Xubuntu a la web que acabas de modificar de las siguientes formas:

a) Poniendo en el navegador la IP del servidor. Inserta captura:

b) Poniendo en el navegador la URL **testapache.local** (tendrás que añadir una fila al ficher **/etc/hosts** de Xubuntu). Inserta captura de pantalla en la que se muertra cómo accedes:

#### 3. Rediección de puertos

Clona la máquina virtual de Ubuntu Server. Configura la tarjeta de red en modo **NAT**
![](https://i.imgur.com/B4nRSQu.png)

a) Configura la red por DHCP en Ubuntu Server. A continuación redirecciona puertos en VirtualBox de forma que puedas acceder a Ubuntu server por ssh utilizando el puerto 2022 por http utilizando el puerto 8080

![](https://i.imgur.com/Ylqn9ku.png)


b) Inserta **captura** en la que se muestre la redirección de puertos de VirtualBox:



c) Inserta captura de pantalla en la que se muestre como accedes por ssh desde el anfitrión a Ubuntu Server:



d) Inserta captura de pantalla en la que se muestre como acceder desde el navegador de Xubuntu a la web por defecto de apache utilizando el puerto redireccionado:


Cuando termines exporta este archivo a PDF y entrégalo en el aula virtual. La máquina virtual clonada para este apartado la puedes eliminar.
