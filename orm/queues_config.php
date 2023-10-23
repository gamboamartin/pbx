<?php
namespace gamboamartin\pbx\models;

use base\orm\_modelo_parent;
use gamboamartin\errores\errores;
use gamboamartin\importador\models\imp_database;
use PDO;

class queues_config extends _modelo_parent {
    public function __construct(PDO $link){
        $tabla = 'queues_config';
        $columnas = array($tabla=>false);
        $campos_obligatorios[] = 'codigo';
        $campos_obligatorios[] = 'descripcion';
        $campos_obligatorios[] = 'type';
        $campos_obligatorios[] = 'number';
        $campos_obligatorios[] = 'name';
        $campos_obligatorios[] = 'password';
        $campos_obligatorios[] = 'estatus';
        $campos_obligatorios[] = 'eccp_password';

        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas);
        $this->NAMESPACE = __NAMESPACE__;

        $this->etiqueta = 'Colas';

        $this->valida_existe_entidad = false;
    }
}