# web-2-TPE-Biblioteca
integrantes: Milagros Montero Larricq y Juanita Melina Ruleri

Emails:
milagrosmontero2005@gmail.com
melinajruleri@gmail.com 

Temática: Biblioteca

La base de datos diseñada corresponde a un sistema de gestión para una biblioteca. Su objetivo principal es almacenar y organizar la información sobre los autores y los libros, permitiendo consultas rápidas y manteniendo la coherencia de los datos.

El modelo implementa una relación de uno a muchos (1:N) entre las tablas Autores y Libros:

Un autor puede haber escrito muchos libros.

Cada libro pertenece a un único autor.

Tablas principales

Autores
Contiene los datos de cada autor registrado en la biblioteca. Sus atributos son:

id_autor (clave primaria): Identificador único de cada autor.

nombre: Nombre del autor.

apellido: Apellido del autor.

nacionalidad: País de origen del autor.

Libros
Almacena la información de los libros disponibles en la biblioteca. Sus atributos son:

id_libro (clave primaria): Identificador único de cada libro.

titulo: Nombre del libro.

genero: Género literario al que pertenece el libro.

anio_publicacion: Año en el que fue publicado.

editorial: Editorial responsable de su publicación.

id_autor (clave foránea): Hace referencia al autor del libro, vinculándolo con la tabla Autores.

Relación entre tablas

La clave foránea id_autor en la tabla Libros establece la relación con la clave primaria id_autor de la tabla Autores. De esta manera:

Es posible consultar todos los libros escritos por un autor en particular.

Se asegura la integridad referencial, evitando que un libro quede asociado a un autor inexistente.
