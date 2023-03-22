<?php
namespace gamboamartin\pbx\models;

use base\orm\_modelo_parent;
use PDO;

class pbx_call extends _modelo_parent {
    public function __construct(PDO $link){
        $tabla = 'pbx_call';
        $columnas = array($tabla => false, "pbx_agent" => $tabla, "pbx_campaign" => $tabla);
        $campos_obligatorios[] = 'codigo';
        $campos_obligatorios[] = 'descripcion';
        $campos_obligatorios[] = 'phone';
        $campos_obligatorios[] = 'retries';
        $campos_obligatorios[] = 'dnc';
        $campos_obligatorios[] = 'scheduled';

        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas);
        $this->NAMESPACE = __NAMESPACE__;

        $this->etiqueta = 'call';
    }
}
