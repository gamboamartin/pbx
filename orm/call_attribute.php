<?php
namespace gamboamartin\pbx\models;

use base\orm\_base;
use base\orm\_modelo_parent;
use PDO;

class call_attribute extends _base {
    public function __construct(PDO $link){
        $tabla = 'call_attribute';
        $columnas = array($tabla => false);


        parent::__construct(link: $link,tabla:  $tabla,
            columnas: $columnas);
        $this->NAMESPACE = __NAMESPACE__;

        $this->etiqueta = 'Call Attribute';
    }
}