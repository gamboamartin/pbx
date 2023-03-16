<?php
namespace gamboamartin\pbx\models;

use base\orm\_modelo_parent;
use PDO;

class pbx_campaign extends _modelo_parent {
    public function __construct(PDO $link){
        $tabla = 'pbx_campaign';
        $columnas = array($tabla=>false);
        $campos_obligatorios[] = 'codigo';
        $campos_obligatorios[] = 'descripcion';
        $campos_obligatorios[] = 'name';
        $campos_obligatorios[] = 'datetime_end';
        $campos_obligatorios[] = 'daytime_init';
        $campos_obligatorios[] = 'daytime_end';
        $campos_obligatorios[] = 'retries';
        $campos_obligatorios[] = 'context';
        $campos_obligatorios[] = 'queue';
        $campos_obligatorios[] = 'max_canales';
        $campos_obligatorios[] = 'script';
        $campos_obligatorios[] = 'estatus';

        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas);
        $this->NAMESPACE = __NAMESPACE__;

        $this->etiqueta = 'campaign';
    }
}
