<?php
namespace gamboamartin\pbx\models;

use base\orm\_modelo_parent;
use PDO;

class pbx_campaign_external_url extends _modelo_parent {
    public function __construct(PDO $link){
        $tabla = 'pbx_campaign_external_url';
        $columnas = array($tabla=>false);
        $campos_obligatorios[] = 'codigo';
        $campos_obligatorios[] = 'descripcion';
        $campos_obligatorios[] = 'urltemplate';
        $campos_obligatorios[] = 'description';
        $campos_obligatorios[] = 'active';
        $campos_obligatorios[] = 'opentype';

        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas);
        $this->NAMESPACE = __NAMESPACE__;

        $this->etiqueta = 'Campaign External Url';
    }
}