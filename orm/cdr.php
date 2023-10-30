<?php

namespace gamboamartin\pbx\models;

use base\orm\_base;
use PDO;

class cdr extends _base
{
    public function __construct(PDO $link)
    {
        $tabla = 'cdr';
        $columnas = array($tabla => false);
        $campos_obligatorios = array();

        $no_duplicados = array();

        parent::__construct(link: $link, tabla: $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas, no_duplicados: $no_duplicados);

        $this->NAMESPACE = __NAMESPACE__;

        $this->etiqueta = 'cdr';
    }

}