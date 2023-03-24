<?php
namespace gamboamartin\pbx\models;

use base\orm\_modelo_parent;
use PDO;

class pbx_form_data_recolected extends _modelo_parent {
    public function __construct(PDO $link){
        $tabla = 'pbx_form_data_recolected';
        $columnas = array($tabla => false, "pbx_call" => $tabla, "pbx_form_field" => $tabla);
        $campos_obligatorios[] = 'codigo';
        $campos_obligatorios[] = 'descripcion';
        $campos_obligatorios[] = 'value';
        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas);
        $this->NAMESPACE = __NAMESPACE__;

        $this->etiqueta = 'form';
    }
}