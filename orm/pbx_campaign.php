<?php
namespace gamboamartin\pbx\models;

use base\orm\_modelo_parent;
use config\generales;
use gamboamartin\administrador\models\adm_mes;
use gamboamartin\errores\errores;
use gamboamartin\importador\models\_conexion;
use gamboamartin\importador\models\_modelado;
use gamboamartin\importador\models\imp_database;
use gamboamartin\importador\models\imp_destino;
use gamboamartin\pbx\models\pbx_form;
use stdClass;
use PDO;

class pbx_campaign extends _modelo_parent {
    public function __construct(PDO $link){
        $tabla = 'pbx_campaign';
        $columnas = array($tabla=>false, "pbx_campaign_external_url" => $tabla);
        $campos_obligatorios[] = 'name';
        $campos_obligatorios[] = 'datetime_init';
        $campos_obligatorios[] = 'datetime_end';
        $campos_obligatorios[] = 'daytime_init';
        $campos_obligatorios[] = 'daytime_end';
        $campos_obligatorios[] = 'retries';
        $campos_obligatorios[] = 'queue';
        $campos_obligatorios[] = 'max_canales';
        $campos_obligatorios[] = 'script';
        $campos_obligatorios[] = 'estatus';

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

        $pbx_form_id = 0;
        if(isset($this->registro['pbx_form_id'])){
            $pbx_form_id = $this->registro['pbx_form_id'];
            unset($this->registro['pbx_form_id']);
        }

        if(!isset($this->registro['context'])){
            $this->registro['context'] =  "from-internal";
        }

        if(!isset($this->registro['estatus'])){
            $this->registro['estatus'] =  "A";
        }

        $this->registro['script'] = $this->registro['script'].'<style type="text/css"> body { background: #FFF; } </style>';

        if(!isset($this->registro['max_canales'])){
            $this->registro['max_canales'] =  "0";
        }

        $registro_cam_pbx = 0;
        foreach ($imp_destinos as $imp_destino) {
            $link_destino = (new _conexion())->link_destino(imp_database_id: $imp_destino['imp_database_id'],
                link: $this->link);
            if(errores::$error){
                return $this->error->error(mensaje: 'Error al conectar con destino',data:  $link_destino);
            }

            $modelo = new campaign($link_destino);

            $modelo->usuario_id = $this->usuario_id;
            $modelo->integra_datos_base = false;

            $alta = $modelo->alta_registro($this->registro);
            if(errores::$error){
                $error = (new errores())->error('Error al insertar', $alta);
                print_r($error);
                exit;
            }
            $registro_cam_pbx = $alta->registro_id;
        }

        if(!isset($this->registro['descripcion'])){
            $descripcion = $this->registro['name']." - ";
            $descripcion .= $this->registro['datetime_init']. " a ".  $this->registro['datetime_end'];

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

        $filtro_queues['pbx_queues_config.id'] = $this->registro['queue'];
        $existe = (new pbx_queues_config($this->link))->existe(filtro: $filtro_queues);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al insertar opcion', data: $existe);
        }

        if(!$existe){
            $modelo_pbx_queues = new pbx_queues_config($this->link);
            $modelo_pbx_queues->registro['id'] = $this->registro['queue'];
            $modelo_pbx_queues->registro['descripcion'] = $this->registro['queue'];
            $modelo_pbx_queues->registro['codigo'] = $this->registro['queue'];
            $modelo_pbx_queues->registro['descr'] = $this->registro['queue'];
            $modelo_pbx_queues->registro['destcontiune'] = "app-blackhole,hangup,1";

            $r_alta_queues = $modelo_pbx_queues->alta_bd();
            if(errores::$error){
                return $this->error->error(mensaje: 'Error al insertar opcion', data: $r_alta_queues);
            }
        }

        $r_alta_bd = parent::alta_bd(keys_integra_ds: $keys_integra_ds); // TODO: Change the autogenerated stub
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al insertar opcion', data: $r_alta_bd);
        }

        $registro_call['campaign_id'] = $registro_cam_pbx;
        $registro_call['pbx_campaign_id'] = $r_alta_bd->registro_id;
        $modelo_pbx_call = new pbx_campaign_sinc($this->link);
        $modelo_pbx_call->registro = $registro_call;
        $pbx_calls = $modelo_pbx_call->alta_bd();
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al integrar call', data: $pbx_calls);
        }

        $filtro_form['pbx_form.id'] = $pbx_form_id;
        $existe = (new pbx_form($this->link))->existe(filtro: $filtro_form);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al insertar opcion', data: $existe);
        }

        if(!$existe){
            $modelo_pbx_form_c = new pbx_form($this->link);
            $modelo_pbx_form_c->registro['id'] = $pbx_form_id;
            $modelo_pbx_form_c->registro['descripcion'] = $pbx_form_id;
            $modelo_pbx_form_c->registro['codigo'] = $pbx_form_id;
            $modelo_pbx_form_c->registro['nombre'] = $pbx_form_id;
            $modelo_pbx_form_c->registro['estatus'] = "A";

            $r_alta_form = $modelo_pbx_form_c->alta_bd();
            if(errores::$error){
                return $this->error->error(mensaje: 'Error al insertar opcion', data: $r_alta_form);
            }
        }

        $registro_form['pbx_form_id'] = $pbx_form_id;
        $registro_form['pbx_campaign_id'] = $r_alta_bd->registro_id;
        $registro_form['campaign_id'] = $registro_cam_pbx;
        $modelo_pbx_form = new pbx_campaign_form($this->link);
        $modelo_pbx_form->registro = $registro_form;
        $pbx_calls = $modelo_pbx_form->alta_bd();
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al integrar call', data: $pbx_calls);
        }

        return $r_alta_bd;
    }

    public function genera_token_api_issabel(){

        $generales =  new generales();

        if(!isset($generales->url_api) || $generales->url_api === ''){
            return $this->error->error(mensaje: 'Error no existe url api issabel', data:$generales);
        }

        $url_authenticate = $generales->url_api."authenticate";

        if(!isset($generales->user_issabel) || $generales->user_issabel === ''){
            return $this->error->error(mensaje: 'Error no existe url api issabel', data:$generales);
        }

        if(!isset($generales->pass_issabel) || $generales->pass_issabel === ''){
            return $this->error->error(mensaje: 'Error no existe url api issabel', data:$generales);
        }

        $fields = array('user'=>$generales->user_issabel, 'password'=>$generales->pass_issabel);
        $fields_string = http_build_query($fields);

        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $fields_string
            )
        );
        $context  = stream_context_create($opts);

        $result = file_get_contents($url_authenticate, false, $context);
        $results = json_decode($result,true);

        return $results['access_token'];
    }

    public function obten_colas_issabel(string $id_cola = ''){
        $pbx_token = $this->genera_token_api_issabel();
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al integrar call', data: $pbx_token);
        }

        $generales =  new generales();

        if(!isset($generales->url_api) || $generales->url_api === ''){
            return $this->error->error(mensaje: 'Error no existe url api issabel', data:$generales);
        }

        $url_authenticate = $generales->url_api."queues/".$id_cola;

        $opts = array('http' =>
            array(
                'method'  => 'GET',
                'header' => 'Authorization: Bearer '.$pbx_token,
            )
        );
        $context  = stream_context_create($opts);

        $result = file_get_contents($url_authenticate, false, $context);

        return json_decode($result,true);
    }

    public function obten_registros_call(int $registro_id){
        $filtro_call['pbx_call.pbx_campaign_id'] = $registro_id;
        $pbx_call = (new pbx_call($this->link))->filtro_and(filtro: $filtro_call);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error',data:  $pbx_call);
        }

        $columnas = array();
        $registros_call_comp = array();
        foreach ($pbx_call->registros as $registro){
            $filtro_call['pbx_call_attribute.pbx_call_id'] = $registro['pbx_call_id'];
            $pbx_call_attribute = (new pbx_call_attribute($this->link))->filtro_and(filtro: $filtro_call);
            if(errores::$error){
                return $this->error->error(mensaje: 'Error',data:  $pbx_call_attribute);
            }

            $temp = array();
            foreach ($pbx_call_attribute->registros as $pbx_att){
                $temp[$pbx_att['pbx_call_attribute_columna']] = $pbx_att['pbx_call_attribute_value'];
                $columnas[$pbx_att['pbx_call_attribute_columna']] = $pbx_att['pbx_call_attribute_columna'];
            }
            $registros_call_comp[] = $temp;
        }

        $result = array();
        $result['columnas'] = $columnas;
        $result['registros'] = $registros_call_comp;

        return $result;
    }
}
