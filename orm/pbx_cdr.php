<?php
namespace gamboamartin\pbx\models;

use base\orm\_modelo_parent;
use gamboamartin\errores\errores;
use gamboamartin\importador\models\_conexion;
use gamboamartin\importador\models\imp_database;
use PDO;

class pbx_cdr extends _modelo_parent {
    public function __construct(PDO $link){
        $tabla = 'pbx_cdr';
        $columnas = array($tabla => false);
        $campos_obligatorios = array();


        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas);
        $this->NAMESPACE = __NAMESPACE__;

        $this->etiqueta = 'Cdr';
    }

    public function alta_bd(array $keys_integra_ds = array('codigo', 'descripcion')): array|\stdClass
    {
        $filtro['imp_database.descripcion'] = 'asteriskcdrdb';
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

        foreach ($imp_destinos as $imp_destino) {
            $link_destino = (new _conexion())->link_destino(imp_database_id: $imp_destino['imp_database_id'],
                link: $this->link);
            if(errores::$error){
                return $this->error->error(mensaje: 'Error al conectar con destino',data:  $link_destino);
            }

            $modelo = new cdr($link_destino);

            $alta = $modelo->alta_registro($this->registro);
            if(errores::$error){
                $error = (new errores())->error('Error al insertar', $alta);
                print_r($error);
                exit;
            }
        }


        $horaActual = date("H:i:s");
        $this->registro['calldate'] .= " " . $horaActual;

        if(!isset($this->registro['descripcion'])){
            $this->registro['descripcion'] = $this->registro['calldate'];
        }

        if(!isset($this->registro['descripcion_select'])){
            $this->registro['descripcion_select'] =  $this->registro['descripcion'];
        }

        if(!isset($this->registro['codigo'])){
            $this->registro['codigo'] =  $this->get_codigo_aleatorio();
            if(errores::$error){
                return $this->error->error(mensaje: 'Error al generar codigo', data: $this->registro);
            }
        }

        if(!isset($this->registro['codigo_bis'])){
            $this->registro['codigo_bis'] =  $this->registro['codigo'];
        }

        $r_alta_bd = parent::alta_bd(keys_integra_ds: $keys_integra_ds);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al insertar cdr', data: $r_alta_bd);
        }

        return $r_alta_bd;
    }

}
