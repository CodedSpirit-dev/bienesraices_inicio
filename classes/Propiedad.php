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
        $this->vendedorId = $args['vendedorId'] ?? 1;
    }



}