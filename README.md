# php_alumnos
Para mi aplicación:
1. ## `  `**Dominio: [https://soniapaezromero.me/alumnos/**](https://soniapaezromero.me/alumnos/)**
1. ## `  `**Caractacteristicas:**
   1. ### `     `**Vps:**
- 2GB de memoria
- 50 Gb de vps
- LEMP en Ubuntu 20.04
## **Instrucciones**
`     `Lo primero que he hecho es  ir al carperta de  cd /var/www/html.

`    `He creado el directorio  alumnos mkdir alumnos

`    `He  entrado en ella una vez dentro he creado el fichero  de migracion.sql que  escribimos el  nombre del la  base de datos y he configurado las tablas notas y alumnos.

`    `Una vez hecho dentro entramos en mysql que viene en el paquete Lemp , y le migramos los datos del archivo migracion.sql

`	`**mysql -u root -p < alumnos/data/migracion.sql**



Una vez hecho hecho esto dentro de mysql creamos el usuario alumno dentro de mysql:

`	`**mysql -u root -p**

**mysql> CREATE USER 'alumno'@'localhost' IDENTIFIED BY 'Malaga20\*';**

**mysql> GRANT ALL PRIVILEGES ON tutorial\_crud.\* TO 'alumno'@'localhost';**

`   `Una vez hecho esto vamos al archivo de configuracion .php y le introducimos los datos de la base de datos  : localhost, el usario, la password y la base de datos;

`   `Una vez hecho esto vamos  creando los distintos ficheros index.php que lo vinculamos a traves del archivo fuciones.php a los archivos,: editar.php que modifica el alumno, borrar.php que borra el registro, y notas qu e te vincula con la pagina principal de notas indexnotas.php quete muestra la lista de las notas de los alumnos, tambien tiene un boton crear  que te lo vincula al fichero crear.php.

` `La tabla notas tiene la misma estructura lo unico que tiene un boton que te regresa a la pagina principal de alumnos,.



