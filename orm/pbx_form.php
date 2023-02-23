<?php
namespace gamboamartin\pbx\models;

use base\orm\modelo;
use PDO;

class pbx_form extends modelo {
    public function __construct(PDO $link){
        $tabla = 'pbx_form';
        $columnas = array($tabla=>false);
        $campos_obligatorios[] = 'descripcion';

        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas);
        $this->NAMESPACE = __NAMESPACE__;

        $this->etiqueta = 'form';
    }
}