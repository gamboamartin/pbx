<?php
namespace gamboamartin\pbx\models;

use base\orm\_modelo_parent;
use PDO;

class pbx_campaign_form extends _modelo_parent {
    public function __construct(PDO $link){
        $tabla = 'pbx_campaign_form';
        $columnas = array($tabla=>false);
        $campos_obligatorios[] = 'codigo';
        $campos_obligatorios[] = 'descripcion';


        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas);
        $this->NAMESPACE = __NAMESPACE__;

        $this->etiqueta = 'campaign_form';
    }
}
