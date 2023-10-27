<?php

namespace gamboamartin\pbx\models;

use base\orm\_base;
use base\orm\_modelo_parent;
use gamboamartin\errores\errores;
use PDO;
use stdClass;

class cdr extends _base
{
    public function __construct(PDO $link)
    {
        $tabla = 'cdr';
        $columnas = array($tabla => false);
        $campos_obligatorios = array();

        $no_duplicados = array();

        parent::__construct(link: $link, tabla: $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas, no_duplicados: $no_duplicados);

        $this->NAMESPACE = __NAMESPACE__;

        $this->etiqueta = 'cdr';
    }

    public function alta_bd(): array|stdClass
    {
        $horaActual = date("H:i:s");
        $this->registro['calldate'] .= " " . $horaActual;

        $r_alta_bd = parent::alta_bd();
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al insertar cdr', data: $r_alta_bd);
        }

        return $r_alta_bd;
    }

}