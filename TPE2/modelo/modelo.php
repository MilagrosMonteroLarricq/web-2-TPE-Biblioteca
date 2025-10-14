<?php
include_once 'config.php';
class Model {
    protected $db;

    function __construct() {
        // 1. Conexión sin DB para crearla
        $this->db = new PDO('mysql:host='. DB_HOST .';charset=utf8', DB_USER, DB_PASS);
        $this->createDatabase();
       
        $this->db = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME .';charset=utf8', DB_USER, DB_PASS);
        $this->deploy();
    }

    function createDatabase() {
        // Crea la base de datos si no existe
        $sql = 'CREATE DATABASE IF NOT EXISTS ' . DB_NAME . ' CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci';
        $this->db->exec($sql);
    }

    function deploy() {
        // Verifica si ya existen tablas en la base de datos
        $query = $this->db->query('SHOW TABLES');
        $tables = $query->fetchAll();

        // Si no hay tablas, ejecuta el script SQL de inicialización
        if (count($tables) == 0) {
            $sql = <<<END
            
            --
            -- Estructura de tabla para la tabla autores
            --
            CREATE TABLE autores (
                id_autor int(11) NOT NULL,
                nombre varchar(100) NOT NULL,
                apellido varchar(100) NOT NULL,
                nacionalidad varchar(50) DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

            -- --------------------------------------------------------
            
            --
            -- Estructura de tabla para la tabla libros
            --
            CREATE TABLE libros (
                id_libro int(11) NOT NULL,
                titulo varchar(150) NOT NULL,
                genero varchar(50) DEFAULT NULL,
                anio_publicacion int(11) DEFAULT NULL,
                editorial varchar(100) DEFAULT NULL,
                id_autor int(11) DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
            
            --
            -- Índices para tablas volcadas
            --
            
            --
            -- Indices de la tabla autores
            --
            ALTER TABLE autores
                ADD PRIMARY KEY (id_autor);
            
            --
            -- Indices de la tabla libros
            --
            ALTER TABLE libros
                ADD PRIMARY KEY (id_libro),
                ADD KEY id_autor (id_autor);
            
            --
            -- AUTO_INCREMENT de las tablas volcadas
            --
            
            --
            -- AUTO_INCREMENT de la tabla autores
            --
            ALTER TABLE autores
                MODIFY id_autor int(11) NOT NULL AUTO_INCREMENT;
            
            --
            -- AUTO_INCREMENT de la tabla libros
            --
            ALTER TABLE libros
                MODIFY id_libro int(11) NOT NULL AUTO_INCREMENT;
            
            --
            -- Restricciones para tablas volcadas
            --
            
            --
            -- Filtros para la tabla libros
            --
            ALTER TABLE libros
                ADD CONSTRAINT libros_ibfk_1 FOREIGN KEY (id_autor) REFERENCES autores (id_autor);
            
            COMMIT;
            END; 
            
            // Ejecuta todo el script SQL
            $this->db->exec($sql);
        }
    }
}
?>