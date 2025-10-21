web-2-TPE-Biblioteca

Integrantes: Milagros Montero Larricq y Juanita Melina Ruleri
Emails: milagrosmontero2005@gmail.com | melinajruleri@gmail.com


---

Temática: Biblioteca

La base de datos diseñada corresponde a un sistema de gestión para una biblioteca.
Su objetivo principal es almacenar y organizar la información sobre los autores y los libros, permitiendo consultas rápidas y manteniendo la coherencia de los datos.

El modelo implementa una relación de uno a muchos (1:N) entre las tablas Autores y Libros:

Un autor puede haber escrito muchos libros.

Cada libro pertenece a un único autor.



---

Tablas principales

Autores

Contiene los datos de cada autor registrado en la biblioteca.
Atributos:

id_autor (clave primaria): Identificador único de cada autor.

nombre: Nombre del autor.

apellido: Apellido del autor.

nacionalidad: País de origen del autor.


Libros

Almacena la información de los libros disponibles en la biblioteca.
Atributos:

id_libro (clave primaria): Identificador único de cada libro.

titulo: Nombre del libro.

genero: Género literario al que pertenece el libro.

anio_publicacion: Año en que fue publicado.

editorial: Editorial responsable de su publicación.

id_autor (clave foránea): Hace referencia al autor del libro, vinculándolo con la tabla Autores.



---

Relación entre tablas

La clave foránea id_autor en la tabla Libros establece la relación con la clave primaria id_autor de la tabla Autores.
De esta manera:

Es posible consultar todos los libros escritos por un autor en particular.

Se asegura la integridad referencial, evitando que un libro quede asociado a un autor inexistente.



---

Despliegue en Servidor (Apache y MySQL)

Para desplegar la aplicación en un entorno de servidor web (Apache) y base de datos (MySQL), seguir estos pasos:

1. Requisitos previos

Asegurarse de tener instalado y funcionando un entorno LAMP, XAMPP o WAMP que incluya:

Servidor Web Apache

Servidor de Base de Datos MySQL/MariaDB

PHP


2. Configuración de la Base de Datos (MySQL)

1. Crear la base de datos: acceder al administrador de MySQL (por ejemplo, phpMyAdmin) y crear una base llamada db_biblioteca.


2. Importar el esquema y los datos: ejecutar el script SQL proporcionado para crear las tablas Autores y Libros e insertar los datos iniciales.


3. Verificar la conexión: la aplicación está configurada con las siguientes credenciales (definidas en el archivo de configuración):



Parámetro	Valor	Descripción

Host (DB_HOST)	localhost	Servidor local
Usuario (DB_USER)	root	Usuario por defecto
Contraseña (DB_PASS)	(vacía)	Sin contraseña
Base de Datos (DB_NAME)	db_biblioteca	Nombre de la base de datos



---

3. Configuración del Servidor Web (Apache)

1. Copiar los archivos: colocar todo el contenido del proyecto dentro del directorio raíz de Apache (generalmente htdocs o www).


2. Acceso: el sitio será accesible desde el navegador, por ejemplo:
http://localhost/nombre_de_la_carpeta_del_proyecto/




---

Información de Uso

Credenciales de Administrador

Para acceder al panel de administración y gestionar los libros y autores:

Rol	Usuario	Contraseña

Administrador: 
usuario:webadmin@gg.com
contraseña: admin



---

Puntos de Acceso Principales (Rutas)

El enrutador (router.php) gestiona las siguientes acciones:

URL / Acción	Descripción	Acceso

home	Muestra el listado principal de libros	Público
login	Formulario de acceso para administradores	Público
verify	Procesa el inicio de sesión	Público
logout	Cierra la sesión del administrador	Administrador
admin	Panel de administración (dashboard)	Administrador
listarLibros	Lista todos los libros	Público
listarAutores	Lista todos los autores	Público
detalleLibros/id	Muestra el detalle de un libro específico	Público
librosPorAutor/id	Lista los libros de un autor específico	Público
agregarLibroForm	Formulario para agregar un nuevo libro	Administrador
eliminarAutor/id	Elimina un autor específico	Administrador


Nota: Todas las acciones que implican agregar, editar o eliminar (por ejemplo, agregarAutor, editarLibroForm, eliminarLibro, etc.) son exclusivas para usuarios con sesión de administrador iniciada.
