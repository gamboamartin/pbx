<?php
namespace gamboamartin\pbx\models;

use base\orm\_modelo_parent;
use PDO;

class pbx_call_attribute extends _modelo_parent {
    public function __construct(PDO $link){
        $tabla = 'pbx_call_attribute';
        $columnas = array($tabla=>false);
        $campos_obligatorios[] = 'codigo';
        $campos_obligatorios[] = 'descripcion';
        $campos_obligatorios[] = 'value';
        $campos_obligatorios[] = 'column_number';
        $campos_obligatorios[] = 'pbx_call_id';

        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas);
        $this->NAMESPACE = __NAMESPACE__;

        $this->etiqueta = 'Call Attribute';
    }
}