<?php
namespace gamboamartin\pbx\models;

use base\orm\_modelo_parent;
use PDO;

class pbx_break extends _modelo_parent {
    public function __construct(PDO $link){
        $tabla = 'pbx_break';
        $columnas = array($tabla=>false);
        $campos_obligatorios[] = 'codigo';
        $campos_obligatorios[] = 'descripcion';
        $campos_obligatorios[] = 'type';
        $campos_obligatorios[] = 'name';
        $campos_obligatorios[] = 'description';
        $campos_obligatorios[] = 'password';
        $campos_obligatorios[] = 'estatus';
        $campos_obligatorios[] = 'tipo';

        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas);
        $this->NAMESPACE = __NAMESPACE__;

        $this->etiqueta = 'agent';
    }
}