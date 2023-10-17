<?php
namespace gamboamartin\pbx\models;

use base\orm\_modelo_parent;
use gamboamartin\errores\errores;
use gamboamartin\importador\models\imp_database;
use gamboamartin\importador\models\imp_destino;
use stdClass;
use PDO;

class pbx_campaign extends _modelo_parent {
    public function __construct(PDO $link){
        $tabla = 'pbx_campaign';
        $columnas = array($tabla=>false, "pbx_campaign_external_url" => $tabla);
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
        $campos_obligatorios[] = 'trunk';
        $campos_obligatorios[] = 'num_completadas';
        $campos_obligatorios[] = 'promedio';
        $campos_obligatorios[] = 'desviacion';

        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas);
        $this->NAMESPACE = __NAMESPACE__;

        $this->etiqueta = 'Campaign';
    }

    public function alta_bd(array $keys_integra_ds = array('codigo', 'descripcion')): array|stdClass
    {
        $filtro['imp_database.descripcion'] = 'call_center';
        $databases = (new imp_database($this->link))->filtro_and(filtro: $filtro);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al obtener destinos',data:  $databases);
        }

        if($databases->n_registros <= 0){
            return $this->error->error(mensaje: 'Error no existen destinos',data:  $databases);
        }

        $imp_destinos = (new imp_database($this->link))->destinos(imp_database_id: $databases->registros[0]['imp_database_id']);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al obtener destinos',data:  $imp_destinos);
        }

        $r_alta_bd = parent::alta_bd(keys_integra_ds: $keys_integra_ds); // TODO: Change the autogenerated stub
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al insertar opcion', data: $r_alta_bd);
        }

        return $r_alta_bd;
    }
}
