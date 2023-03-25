<?php

namespace App;

class Propiedad
{

    //Base de datos
    protected static $db;
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedorId'];

    //Errores
    protected static $errores = [];

    //Definir los atributos
    public $id; // id de la propiedad
    public $titulo; // título de la propiedad
    public $precio; // precio de la propiedad
    public $imagen; // imagen de la propiedad
    public $descripcion; // descripción de la propiedad
    public $habitaciones; // número de habitaciones de la propiedad
    public $wc; // número de baños de la propiedad
    public $estacionamiento; // número de lugares de estacionamiento de la propiedad
    public $creado; // fecha de creación de la propiedad
    public $vendedorId; // id del vendedor de la propiedad

    //Definir la conexion en la base de datos
    public static function setDB($database)
    {
        self::$db = $database;
    }
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? '';
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedorId = $args['vendedorId'] ?? 1;
    }

    public function guardar() {
        if(isset($this->id)) {
            //Actualizar
            $this->actualizar();
        } else {
            //Creando un nuevo registro
            $this->crear();
        }
    }

    public function crear()
    {

        //Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Insertar en la base de datos
        $query = " INSERT INTO propiedades ( ";
        $query .= join(', ', array_keys($atributos)); //array_keys: devuelve todas las claves o un subconjunto de claves de un array
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";

        $resultado = self::$db->query($query);
        return $resultado;
    }

    public function actualizar() {
        //Sanitizar los datos
        $atributos = $this->sanitizarAtributos();
        $valores = [];

        foreach($atributos as $key => $value) {
            $valores[] = "{$key} = '{$value}'";
        }

        // Insertar en la base de datos
        $query = " UPDATE propiedades SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        $resultado = self::$db->query($query);
        if ($resultado) {
            // Redireccionar al usuario.
            header('Location: /admin?resultado=2');
        }
    }
    // Identificar y unir los atributos de la DB
    public function atributos() {
        $atributos = [];
        foreach(self::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];
 
        foreach($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }
 
    // Subida de archivos
    public function setImagen($imagen) {
        // Eliminar la imagen previa
        if(isset( $this->id )) {
            //Compribar que exista el archivo
            $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
            if($existeArchivo) {
                unlink(CARPETA_IMAGENES . $this->imagen);
            }
        }
        // Asignar al atributo de imagen el nombre de la imagen
        if($imagen) {
            $this->imagen = $imagen;
        }
    }

    //Validacion
    public static function getErrores() {
        return self::$errores;
    }

    public function validar() {

        if (!$this->titulo) {
            self::$errores[] = "Debes añadir un titulo"; // agrega un error al arreglo `$errores` si el atributo `titulo` está vacío
        }

        if (!$this->precio) {
            self::$errores[] = 'El Precio es Obligatorio'; // agrega un error al arreglo `$errores` si el atributo `precio` está vacío
        }

        if (strlen($this->descripcion) < 50) {
            self::$errores[] = 'La descripción es obligatoria y debe tener al menos 50 caracteres'; // agrega un error al arreglo `$errores` si el atributo `descripcion` tiene menos de 50 caracteres
        }

        if (!$this->habitaciones) {
            self::$errores[] = 'El Número de habitaciones es obligatorio'; // agrega un error al arreglo `$errores` si el atributo `habitaciones` está vacío
        }

        if (!$this->wc) {
            self::$errores[] = 'El Número de Baños es obligatorio'; // agrega un error al arreglo `$errores` si el atributo `wc` está vacío
        }

        if (!$this->estacionamiento) {
            self::$errores[] = 'El Número de lugares de Estacionamiento es obligatorio'; // agrega un error al arreglo `$errores` si el atributo `estacionamiento` está vacío
        }

        if (!$this->vendedorId) {
            self::$errores[] = 'Elige un vendedor'; // agrega un error al arreglo `$errores` si el atributo `vendedorId` está vacío
        }

        if (!$this->imagen) {
            self::$errores[] = 'La Imagen es Obligatoria'; // agrega un error al arreglo `$errores` si el atributo `imagen` está vacío
        }

        return self::$errores; // retorna los errores de validación almacenados en el arreglo `$errores`

    }

    //Lista todas las propiedades
    public static function all()
    {
        $query = "SELECT * FROM propiedades"; // consulta SQL para seleccionar todas las propiedades en la tabla `propiedades`
        $resultado = self::consultarSQL($query); // llama al método `consultarSQL` para ejecutar la consulta
        return $resultado; // retorna un arreglo de objetos de tipo `Propiedad`
    }

    //Buscar una propiedad por su id
    public static function find($id){
        $query = "SELECT * FROM propiedades WHERE id = $id";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    public static function consultarSQL($query) {
        //Consultar la base de datos
        $resultado = self::$db->query($query);

        //Iterar los resultados
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = self::crearObjeto($registro);
        }


        //Liberar la memoria
        $resultado->free();


        //Retornar los resultados
        return $array;
    }

    protected static function crearObjeto($registro) {
        $objeto = new self;

        foreach($registro as $key => $value) {
            if(property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }

        return $objeto;

    }

    //Sincroniza el objeto en memoria con los cambios realizados por el usuario
    public function sincronizar($args = []) {
        foreach($args as $key => $value) {
            if(property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

}
