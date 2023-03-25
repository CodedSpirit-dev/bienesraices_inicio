<?php

namespace App;

class ActiveRecord
{

    //Base de datos
    protected static $db;
    protected static $columnasDB = [];
    protected static $tabla = '';

    //Errores
    protected static $errores = [];

    //Definir la conexion en la base de datos
    public static function setDB($database)
    {
        self::$db = $database;
    }

    public function guardar() {
        if(!is_null($this->id)) {
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
        $query = " INSERT INTO " .  static::$tabla  . " ( ";
        $query .= join(', ', array_keys($atributos)); //array_keys: devuelve todas las claves o un subconjunto de claves de un array
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";

        $resultado = self::$db->query($query);
        
            //Mensaje de exito
            if($resultado) {
                header('Location: /admin?resultado=1');
            }
    }

    public function actualizar() {
        //Sanitizar los datos
        $atributos = $this->sanitizarAtributos();
        $valores = [];

        foreach($atributos as $key => $value) {
            $valores[] = "{$key} = '{$value}'";
        }

        // Insertar en la base de datos
        $query = " UPDATE "  . static::$tabla  .  " SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        $resultado = self::$db->query($query);
        if ($resultado) {
            // Redireccionar al usuario.
            header('Location: /admin?resultado=2');
        }
    }
    // Eliminar un registro
    public function eliminar() {
        $query = " DELETE FROM "  . static::$tabla  .  " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1 ";
        $resultado = self::$db->query($query);
        if($resultado) {
            $this->borrarImagen();
            header('Location: /admin?resultado=3');
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
        if(!is_null( $this->id )) {
            $this->borrarImagen();
        }
        // Asignar al atributo de imagen el nombre de la imagen
        if($imagen) {
            $this->imagen = $imagen;
        }
    }

    //Eliminar el archivo
    public function borrarImagen() {
        //Comprobar si existe el archivo
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if($existeArchivo) {
            unlink(CARPETA_IMAGENES . $this->imagen);
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
        $query = "SELECT * FROM " . static::$tabla; // consulta SQL para seleccionar todas las propiedades en la tabla `propiedades`
        $resultado = self::consultarSQL($query); // llama al método `consultarSQL` para ejecutar la consulta
        return $resultado; // retorna un arreglo de objetos de tipo `Propiedad`
    }

    //Buscar una propiedad por su id
    public static function find($id){
        $query = "SELECT * FROM "  . static::$tabla  .  " WHERE id = $id";
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
        $objeto = new static;

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
