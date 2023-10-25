<?php
namespace gamboamartin\pbx\models;

use base\orm\_base;
use base\orm\_modelo_parent;
use gamboamartin\errores\errores;
use gamboamartin\importador\models\imp_database;
use gamboamartin\importador\models\imp_destino;
use stdClass;
use PDO;

class campaign extends _base {
    public function __construct(PDO $link){
        $tabla = 'campaign';
        $columnas = array($tabla=>false);

        parent::__construct(link: $link,tabla:  $tabla,
            columnas: $columnas);
        $this->NAMESPACE = __NAMESPACE__;

        $this->etiqueta = 'Campaign';
    }
}
