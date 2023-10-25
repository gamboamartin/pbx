<?php
namespace gamboamartin\pbx\models;

use base\orm\_modelo_parent;
use gamboamartin\errores\errores;
use gamboamartin\importador\models\_conexion;
use gamboamartin\importador\models\imp_database;
use PDO;

class pbx_call extends _modelo_parent {
    public function __construct(PDO $link){
        $tabla = 'pbx_call';
        $columnas = array($tabla => false, "pbx_agent" => $tabla, "pbx_campaign" => $tabla);
        $campos_obligatorios[] = 'phone';


        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas);
        $this->NAMESPACE = __NAMESPACE__;

        $this->etiqueta = 'Call';
    }

    public function alta_bd(array $keys_integra_ds = array('codigo', 'descripcion')): array|\stdClass
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

        $pbx_campaign_id = 0;
        if(isset($this->registro['pbx_campaign_id'])){
            $pbx_campaign_id = $this->registro['pbx_campaign_id'];
            unset($this->registro['pbx_campaign_id']);
        }

        $call_id = 0;
        foreach ($imp_destinos as $imp_destino) {
            $link_destino = (new _conexion())->link_destino(imp_database_id: $imp_destino['imp_database_id'],
                link: $this->link);
            if(errores::$error){
                return $this->error->error(mensaje: 'Error al conectar con destino',data:  $link_destino);
            }

            $modelo = new calls($link_destino);

            $modelo->usuario_id = $this->usuario_id;
            $modelo->integra_datos_base = false;

            $alta = $modelo->alta_registro($this->registro);
            if(errores::$error){
                $error = (new errores())->error('Error al insertar', $alta);
                print_r($error);
                exit;
            }

            $call_id = $alta->registro_id;
        }

        if(!isset($this->registro['descripcion'])){
            $descripcion = $this->registro['phone']." - ";
            $descripcion .= $this->registro['id_campaign']. " - ".  rand(1000000,99999999);

            $this->registro['descripcion'] = $descripcion;
        }

        if(!isset($this->registro['descripcion_select'])){
            $this->registro['descripcion_select'] =  $this->registro['descripcion'];
        }

        if(!isset($this->registro['codigo'])){
            $this->registro['codigo'] =  $this->registro['descripcion']. rand(1000000,99999999);
        }

        if(!isset($this->registro['codigo_bis'])){
            $this->registro['codigo_bis'] =  $this->registro['codigo'];
        }
        $this->registro['pbx_campaign_id'] = $pbx_campaign_id;

        $r_alta_bd = parent::alta_bd(keys_integra_ds: $keys_integra_ds); // TODO: Change the autogenerated stub
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al insertar opcion', data: $r_alta_bd);
        }

        $registro_call['call_id'] = $call_id;
        $registro_call['pbx_call_id'] = $r_alta_bd->registro_id;
        $modelo_pbx_call = new pbx_call_sinc($this->link);
        $modelo_pbx_call->registro = $registro_call;
        $pbx_calls = $modelo_pbx_call->alta_bd();
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al integrar call', data: $pbx_calls);
        }

        return $r_alta_bd;
    }
}
