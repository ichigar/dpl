# DPL - Apuntes. Configuración de la red en Ubuntu Server
## Mostrar la configuración
* Dirección IP y máscara
```bash
$ ip a
1: lo: <LOOPBACK,UP,LOWER_UP> mtu 65536 qdisc noqueue state UNKNOWN group default qlen 1000
    link/loopback 00:00:00:00:00:00 brd 00:00:00:00:00:00
    inet 127.0.0.1/8 scope host lo
       valid_lft forever preferred_lft forever
    inet6 ::1/128 scope host 
       valid_lft forever preferred_lft forever
2: eno1: <BROADCAST,MULTICAST,UP,LOWER_UP> mtu 1500 qdisc fq_codel state UP group default qlen 1000
    link/ether 3c:52:82:6a:8e:91 brd ff:ff:ff:ff:ff:ff
    altname enp0s31f6
    inet 10.11.100.0/16 brd 10.11.255.255 scope global noprefixroute eno1
       valid_lft forever preferred_lft forever
    inet6 fe80::429:987d:8d4:93d2/64 scope link noprefixroute 
       valid_lft forever preferred_lft forever
```

* Puerta de enlace
```bash
$ ip route
default via 10.11.0.1 dev eno1 proto static metric 100 
10.11.0.0/16 dev eno1 proto kernel scope link src 10.11.100.0 metric 100
```
* Servidores de DNS
```bash
$ systemd-resolve --status
...
Link 2 (eno1)
      Current Scopes: DNS    
DefaultRoute setting: yes    
       LLMNR setting: yes    
MulticastDNS setting: no     
  DNSOverTLS setting: no     
      DNSSEC setting: no     
    DNSSEC supported: no     
  Current DNS Server: 8.8.8.8
         DNS Servers: 8.8.8.8
          DNS Domain: ~.     

```
## Cambiar configuración
### Estática
Editamos fichero de Netplan
```
$ sudo nano /etc/netplan/00-installer-config.yaml
```
Lo dejamos de la siguiente manera
```bash
# This is the network config written by 'subiquity'
network:
  ethernets:
    enp0s3:
      dhcp4: false
      addresses: [10.100.50.0/16]
      gateway4: 10.11.0.1
      nameservers:
        search: [alb.local]
        addresses: [9.9.9.9, 1.1.1.1]
  version: 2

```
Aplicar cambios
```bash
$ sudo netplan apply
```
### Dinámica

Editamos fichero de Netplan
```
$ sudo nano /etc/netplan/00-installer-config.yaml
```
Lo dejamos de la siguiente manera
```bash
# This is the network config written by 'subiquity'
network:
  ethernets:
    enp0s3:
      dhcp4: true
  version: 2

```
Aplicar cambios
```bash
$ sudo netplan apply
```
###### tags: `dpl` `configuración` `red` `netplan` `ubuntu` `server`