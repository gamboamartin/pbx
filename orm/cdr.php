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


        parent::__construct(link: $link, tabla: $tabla, columnas: $columnas);

        $this->NAMESPACE = __NAMESPACE__;

        $this->etiqueta = 'cdr';

    }

}