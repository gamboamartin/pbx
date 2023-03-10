<?php
namespace gamboamartin\pbx\models;

use base\orm\_modelo_parent;
use PDO;

class pbx_form_field extends _modelo_parent {
    public function __construct(PDO $link){
        $tabla = 'pbx_call_attribute';
        $columnas = array($tabla=>false);
        $campos_obligatorios[] = 'codigo';
        $campos_obligatorios[] = 'descripcion';
        $campos_obligatorios[] = 'etiqueta';
        $campos_obligatorios[] = 'value';
        $campos_obligatorios[] = 'tipo';
        $campos_obligatorios[] = 'orden';

        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas);
        $this->NAMESPACE = __NAMESPACE__;

        $this->etiqueta = 'Form Field';
    }
}