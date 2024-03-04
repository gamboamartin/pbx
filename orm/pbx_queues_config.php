<?php
namespace gamboamartin\pbx\models;

use base\orm\_modelo_parent;
use gamboamartin\errores\errores;
use gamboamartin\importador\models\imp_database;
use PDO;

class pbx_queues_config extends _modelo_parent {
    public function __construct(PDO $link){
        $tabla = 'pbx_queues_config';
        $columnas = array($tabla=>false);
        $campos_obligatorios[] = 'codigo';
        $campos_obligatorios[] = 'descripcion';

        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas);
        $this->NAMESPACE = __NAMESPACE__;

        $this->etiqueta = 'Colas';
    }

    public function sincroniza_colas(){
        $filtro['imp_database.descripcion'] = 'pbx';
        $databases = (new imp_database($this->link))->filtro_and(filtro: $filtro);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al obtener destinos',data:  $databases);
        }

        $alta = array();
        foreach ($databases->registros as $database){
            $alta = (new imp_database($this->link))->alta_full(imp_database_id: $database['imp_database_id']);
            if(errores::$error){
                return $this->error->error(mensaje: 'Error al insertar registros colas',data:  $alta);
            }
        }

        return $alta;
    }

}