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

    public static function setDB($database)
    {
        self::$db = $database; // establece la conexión de la base de datos mediante la instancia de la clase `mysqli`
    }

    public function guardar()
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

    // Identificar y unir los atributos de la BD
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach($atributos as $key => $value ) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    //Subida de archivos
    public function setImagen($imagen) {
        //Asignar al atributo de imagen el nombre de la imagen
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

    public static function consultarSQL($query) {
        //Consultar la base de datos
        $resultado = self::$db->query($query);

        //Iterar los resultados
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
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

}
