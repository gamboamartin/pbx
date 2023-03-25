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
        $campos_obligatorios[] = 'estatus';
        $campos_obligatorios[] = 'uniqueid';
        $campos_obligatorios[] = 'fecha_llamada';
        $campos_obligatorios[] = 'start_time';
        $campos_obligatorios[] = 'end_time';
        $campos_obligatorios[] = 'duration';
        $campos_obligatorios[] = 'transfer';
        $campos_obligatorios[] = 'datetime_entry_queue';
        $campos_obligatorios[] = 'duration_wait';
        $campos_obligatorios[] = 'date_init';
        $campos_obligatorios[] = 'date_end';
        $campos_obligatorios[] = 'time_init';
        $campos_obligatorios[] = 'time_end';
        $campos_obligatorios[] = 'agent';
        $campos_obligatorios[] = 'failure_cause';
        $campos_obligatorios[] = 'failure_cause_txt';
        $campos_obligatorios[] = 'datetime_originate';
        $campos_obligatorios[] = 'trunk';


        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas);
        $this->NAMESPACE = __NAMESPACE__;

        $this->etiqueta = 'call';
    }
}
