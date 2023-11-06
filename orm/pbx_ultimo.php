<?php
namespace gamboamartin\pbx\models;

use base\orm\_modelo_parent;
use PDO;

class pbx_ultimo extends _modelo_parent {
    public function __construct(PDO $link){
        $tabla = 'pbx_ultimo';
        $columnas = array($tabla=>false,'pbx_campaign'=>$tabla);
        $campos_obligatorios[] = 'codigo';
        $campos_obligatorios[] = 'descripcion';
        $campos_obligatorios[] = 'nombre';
        $campos_obligatorios[] = 'estatus';

        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas);
        $this->NAMESPACE = __NAMESPACE__;

        $this->etiqueta = 'Form';
    }
}