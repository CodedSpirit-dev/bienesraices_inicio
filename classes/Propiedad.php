<?php

namespace App;

class Propiedad extends ActiveRecord {
    protected static $tabla = 'propiedades';
    
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedorId'];

    
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

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? NULL;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedorId = $args['vendedorId'] ?? '';
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

}