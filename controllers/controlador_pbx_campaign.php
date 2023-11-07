<?php
/**
 * @author Martin Gamboa Vazquez
 * @version 1.0.0
 * @created 2022-05-14
 * @final En proceso
 *
 */

namespace gamboamartin\pbx\controllers;

use base\controller\controler;
use base\orm\modelo;
use config\generales;
use gamboamartin\errores\errores;
use gamboamartin\importador\models\_conexion;
use gamboamartin\importador\models\imp_database;
use gamboamartin\pbx\models\campaign;
use gamboamartin\pbx\models\form;
use gamboamartin\pbx\models\pbx_call;
use gamboamartin\pbx\models\pbx_call_attribute;
use gamboamartin\pbx\models\pbx_call_sinc;
use gamboamartin\pbx\models\pbx_campaign;
use gamboamartin\pbx\models\pbx_campaign_sinc;
use gamboamartin\pbx\models\pbx_ultimo;
use gamboamartin\system\links_menu;
use gamboamartin\template\html;
use html\pbx_campaign_html;
use Mosquitto\Exception;
use PDO;
use stdClass;
use Throwable;

class controlador_pbx_campaign extends _pbx_base {

    public string $link_sincroniza_datos = '';

    public string $select_queue = '';
    public string $select_form = '';
    public string $select_status = '';
    public string $select_morosidad = '';

    public function __construct(PDO $link, html $html = new \gamboamartin\template_1\html(),
                                stdClass $paths_conf = new stdClass()){
        $modelo = new pbx_campaign(link: $link);
        $html_ = new pbx_campaign_html(html: $html);
        $obj_link = new links_menu(link: $link, registro_id: $this->registro_id);

        $datatables = $this->init_datatable();
        if (errores::$error) {
            $error = $this->errores->error(mensaje: 'Error al inicializar datatable', data: $datatables);
            print_r($error);
            die('Error');
        }

        parent::__construct(html: $html_, link: $link, modelo: $modelo, obj_link: $obj_link, datatables: $datatables,
            paths_conf: $paths_conf);

        $configuraciones = $this->init_configuraciones();
        if (errores::$error) {
            $error = $this->errores->error(mensaje: 'Error al inicializar configuraciones', data: $configuraciones);
            print_r($error);
            die('Error');
        }
        $this->lista_get_data = true;

        $this->link_sincroniza_datos = $this->obj_link->link_con_id(accion: "sincroniza_datos",
            link: $this->link, registro_id: $this->registro_id, seccion: $this->seccion);
        if (errores::$error) {
            $error = $this->errores->error(mensaje: 'Error al obtener link',
                data: $this->link_sincroniza_datos);
            print_r($error);
            exit;
        }

    }

    protected function campos_view(): array
    {
        $keys = new stdClass();
        $keys->inputs = array('codigo','descripcion', 'name','datetime_init', 'datetime_end', 'daytime_init', 'daytime_end',
            'retries', 'context', 'queue', 'max_canales', 'script', 'estatus', 'trunk', 'num_completadas',
            'promedio', 'desviacion');
        $keys->selects = array();

        $init_data = array();
        $init_data['pbx_queues_config'] = "gamboamartin\\pbx";
        $init_data['pbx_campaign_external_url'] = "gamboamartin\\pbx";
        $init_data['pbx_form'] = "gamboamartin\\pbx";

        $campos_view = $this->campos_view_base(init_data: $init_data, keys: $keys);
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al inicializar campo view', data: $campos_view);
        }

        return $campos_view;
    }

    private function init_configuraciones(): controler
    {
        $this->titulo_lista = 'Formulario de Campaign';

        return $this;
    }

    private function init_datatable(): stdClass
    {
        $columns["pbx_campaign_id"]["titulo"] = "Id";
        $columns["pbx_campaign_codigo"]["titulo"] = "Código";
        $columns["pbx_campaign_descripcion"]["titulo"] = "Descripcion";
        $columns["pbx_campaign_name"]["titulo"] = "Nombre";
        $columns["pbx_campaign_datetime_init"]["titulo"] = "Inicio hora-fecha";
        $columns["pbx_campaign_datetime_end"]["titulo"] = "Fin hora-fecha";
        $columns["pbx_campaign_daytime_init"]["titulo"] = "Inicio diurno";
        $columns["pbx_campaign_daytime_end"]["titulo"] = "Fin del dia";
        $columns["pbx_campaign_retries"]["titulo"] = "Reintentos";
        $columns["pbx_campaign_context"]["titulo"] = "Contexto";
        $columns["pbx_campaign_queue"]["titulo"] = "Cola";
        $columns["pbx_campaign_max_canales"]["titulo"] = "Max canales";
        $columns["pbx_campaign_script"]["titulo"] = "Guion";
        $columns["pbx_campaign_estatus"]["titulo"] = "Estatus";
        $columns["pbx_campaign_trunk"]["titulo"] = "Truncada";
        $columns["pbx_campaign_num_completadas"]["titulo"] = "Num completadas";
        $columns["pbx_campaign_promedio"]["titulo"] = "Promedio";
        $columns["pbx_campaign_desviacion"]["titulo"] = "Desviacion";

        $filtro = array("pbx_campaign.id", "pbx_campaign.codigo", "pbx_campaign.descripcion", "pbx_campaign.name", "pbx_campaign.datetime_end",
            "pbx_campaign.daytime_init", "pbx_campaign.daytime_end", "pbx_campaign.retries", "pbx_campaign.context", "pbx_campaign.queue", "pbx_campaign.max_canales",
            "pbx_campaign.script", "pbx_campaign.estatus", "pbx_campaign.trunk", "pbx_campaign.num_completadas",
            "pbx_campaign.promedio", "pbx_campaign.desviacion");

        $datatables = new stdClass();
        $datatables->columns = $columns;
        $datatables->filtro = $filtro;

        return $datatables;
    }

    private function init_selects(array $keys_selects, string $key, string $label, int $id_selected = -1, int $cols = 6,
                                  bool  $con_registros = true, array $filtro = array()): array
    {
        $keys_selects = $this->key_select(cols: $cols, con_registros: $con_registros, filtro: $filtro, key: $key,
            keys_selects: $keys_selects, id_selected: $id_selected, label: $label);
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }

        return $keys_selects;
    }
    public function init_selects_inputs(): array
    {
        $keys_selects = $this->init_selects(keys_selects:  array(), key: "pbx_queues_config_id", label: "Cola",
            cols: 12);
        $keys_selects = $this->init_selects(keys_selects:  $keys_selects, key: "pbx_form_id", label: "Formulario",
            cols: 12);
        return $this->init_selects(keys_selects: $keys_selects, key: "pbx_campaign_external_url_id", label: "Llamada",
            cols: 12);
    }
    protected function key_selects_txt(array $keys_selects): array
    {
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'codigo',
            keys_selects: $keys_selects, place_holder: 'Código');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'descripcion',
            keys_selects: $keys_selects, place_holder: 'Descripcion');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 12, key: 'name',
            keys_selects: $keys_selects, place_holder: 'Nombre');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'datetime_init',
            keys_selects: $keys_selects, place_holder: 'Inicio hora-fecha');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'datetime_end',
            keys_selects: $keys_selects, place_holder: 'Fin hora-fecha');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'daytime_init',
            keys_selects: $keys_selects, place_holder: 'Inicio diurno');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'daytime_end',
            keys_selects: $keys_selects, place_holder: 'Fin del dia');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'retries',
            keys_selects: $keys_selects, place_holder: 'Reintentos');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'context',
            keys_selects: $keys_selects, place_holder: 'Contexto');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }

        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'queue',
            keys_selects: $keys_selects, place_holder: 'Cola');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'max_canales',
            keys_selects: $keys_selects, place_holder: 'Max canales');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 12, key: 'script',
            keys_selects: $keys_selects, place_holder: 'Guion');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'estatus',
            keys_selects: $keys_selects, place_holder: 'Estatus');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'trunk',
            keys_selects: $keys_selects, place_holder: 'Truncada');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'num_completadas',
            keys_selects: $keys_selects, place_holder: 'Num_completadas');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'promedio',
            keys_selects: $keys_selects, place_holder: 'Promedio');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'desviacion',
            keys_selects: $keys_selects, place_holder: 'Desviacion');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }

        return $keys_selects;
    }

    public function modifica(bool $header, bool $ws = false): array|stdClass
    {
        $r_modifica = $this->init_modifica();
        if (errores::$error) {
            return $this->retorno_error(
                mensaje: 'Error al generar salida de template', data: $r_modifica, header: $header, ws: $ws);
        }

       /* $select = $this->select_consulta_status();
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al generar select', data: $select, header: $header, ws: $ws);
        }

        $select = $this->select_consulta_morosidad();
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al generar select', data: $select, header: $header, ws: $ws);
        }*/

        $keys_selects = $this->init_selects_inputs();
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al inicializar selects', data: $keys_selects, header: $header,
                ws: $ws);
        }

        $keys_selects['pbx_campaign_external_url_id']->id_selected = $this->registro['pbx_campaign_external_url_id'];

        $base = $this->base_upd(keys_selects: $keys_selects, params: array(), params_ajustados: array());
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al integrar base', data: $base, header: $header, ws: $ws);
        }

        return $r_modifica;
    }

    public function sincroniza_datos(bool $header, bool $ws =  false){
        $generales = new generales();

        $filtro = array();
        if(isset($_POST['plaza_descripcion']) && $_POST['plaza_descripcion'] !== '') {
            $filtro['plaza_descripcion']['tipo_dato'] = 'texto';
            $filtro['plaza_descripcion']['operador'] = 'igual';
            $filtro['plaza_descripcion']['valor'] = $_POST['plaza_descripcion'];
        }

        if(isset($_POST['contrato_fecha_validacion_inicio']) && $_POST['contrato_fecha_validacion_inicio'] !== '' &&
            isset($_POST['contrato_fecha_validacion_fin']) && $_POST['contrato_fecha_validacion_fin'] === '') {
            $fecha_inicio = strtotime($_POST['contrato_fecha_validacion_inicio']);
            $fecha_fin = strtotime(date('Y-m-d'));

            if($fecha_inicio > $fecha_fin) {
                $_POST['contrato_fecha_validacion_inicio'] = date('Y-m-d');
            }

            $filtro['contrato_fecha_validacion']['tipo_dato'] = 'fecha';
            $filtro['contrato_fecha_validacion']['operador'] = 'between';
            $filtro['contrato_fecha_validacion']['valor'] = $_POST['contrato_fecha_validacion_inicio'];
            $filtro['contrato_fecha_validacion']['valor2'] = date('Y-m-d');
        }

        if(isset($_POST['contrato_fecha_validacion_inicio']) && $_POST['contrato_fecha_validacion_inicio'] === '' &&
            isset($_POST['contrato_fecha_validacion_fin']) && $_POST['contrato_fecha_validacion_fin'] !== '') {
            $fecha_inicio = strtotime(date('Y-m-d'));
            $fecha_fin = strtotime($_POST['contrato_fecha_validacion_fin']);

            if($fecha_inicio > $fecha_fin) {
                $_POST['contrato_fecha_validacion_fin'] = date('Y-m-d');
            }
            $filtro['contrato_fecha_validacion']['tipo_dato'] = 'fecha';
            $filtro['contrato_fecha_validacion']['operador'] = 'between';
            $filtro['contrato_fecha_validacion']['valor'] = date('Y-m-d');
            $filtro['contrato_fecha_validacion']['valor2'] = $_POST['contrato_fecha_validacion_fin'];
        }

        if(isset($_POST['contrato_fecha_validacion_inicio']) && $_POST['contrato_fecha_validacion_inicio'] !== '' &&
            isset($_POST['contrato_fecha_validacion_fin']) && $_POST['contrato_fecha_validacion_fin'] !== '') {
            $fecha_inicio = strtotime($_POST['contrato_fecha_validacion_inicio']);
            $fecha_fin = strtotime($_POST['contrato_fecha_validacion_fin']);

            if($fecha_inicio > $fecha_fin) {
                $tem_ini = $_POST['contrato_fecha_validacion_inicio'];
                $tem_fin =  $_POST['contrato_fecha_validacion_fin'];
                $_POST['contrato_fecha_validacion_inicio'] = $tem_fin;
                $_POST['contrato_fecha_validacion_fin'] = $tem_ini;
            }

            $filtro['contrato_fecha_validacion']['tipo_dato'] = 'fecha';
            $filtro['contrato_fecha_validacion']['operador'] = 'between';
            $filtro['contrato_fecha_validacion']['valor'] = $_POST['contrato_fecha_validacion_inicio'];
            $filtro['contrato_fecha_validacion']['valor2'] = $_POST['contrato_fecha_validacion_fin'];
        }

        if(isset($_POST['contrato_status']) && $_POST['contrato_status'] !== '') {
            $filtro['contrato_status']['tipo_dato'] = 'texto';
            $filtro['contrato_status']['operador'] = 'like';
            $filtro['contrato_status']['valor'] = $_POST['contrato_status'];
        }
        if(isset($_POST['contrato_morosidad']) && $_POST['contrato_morosidad'] !== '') {
            $filtro['contrato_morosidad']['tipo_dato'] = 'texto';
            $filtro['contrato_morosidad']['operador'] = 'like';
            $filtro['contrato_morosidad']['valor'] = $_POST['contrato_morosidad'];
        }

        $filto_encode = json_encode($filtro);

        $numero_empresa = 1;
        $offset = 0;
        $limit = $generales->limit;
        $token = 'PF0+orvaeWUp1ld5MoLJ62qu/vxjAl04Zog3JGxvahKEIL70A9uozeD0BZsr2oxZYSexclCRPYOtaWGrzkW+lQ==';

        $fields = array('numero_empresa' => $numero_empresa, 'offset' => $offset,'limit' => $limit,'token' => $token,
            'filtros' => $filto_encode);
        $fields_string = http_build_query($fields);

        $registro_ultimo['inicio']= 0;
        $registro_ultimo['limite']= $generales->limit;
        $registro_ultimo['sentencia']= $fields_string;
        $registro_ultimo['pbx_campaign_id']= $this->registro_id;
        $modelo_pbx_ultimo = new pbx_ultimo($this->link);
        $modelo_pbx_ultimo->registro = $registro_ultimo;
        $pbx_calls = $modelo_pbx_ultimo->alta_bd();
        if (errores::$error) {
            $this->retorno_error(mensaje: 'Error al integrar base', data: $pbx_calls, header: $header, ws: $ws);
        }


        $registro_campaign['status_sincronizador'] = 'activo';
        $r_mod_pbx_campaign = (new pbx_campaign($this->link))->modifica_bd(registro: $registro_campaign,
            id: $this->registro_id);
        if (errores::$error) {
            $this->retorno_error(mensaje: 'Error al integrar base', data: $r_mod_pbx_campaign, header: $header, ws: $ws);
        }

        header('Location:' . $this->link_modifica);
        exit;
    }

    /*public function sincroniza_datos(bool $header, bool $ws =  false){
        $server = 'http://144.126.152.44/api/api_contrato.php?metodo=consulta_contratos';

        $filtro = array();
        if(isset($_POST['contrato_id']) && $_POST['contrato_id'] !== '') {
            $filtro['contrato_id']['tipo_dato'] = 'texto';
            $filtro['contrato_id']['operador'] = 'igual';
            $filtro['contrato_id']['valor'] = $_POST['contrato_id'];
        }
        if(isset($_POST['plaza_descripcion']) && $_POST['plaza_descripcion'] !== '') {
            $filtro['plaza_descripcion']['tipo_dato'] = 'texto';
            $filtro['plaza_descripcion']['operador'] = 'igual';
            $filtro['plaza_descripcion']['valor'] = $_POST['plaza_descripcion'];
        }
        if(isset($_POST['contrato_contrato']) && $_POST['contrato_contrato'] !== '') {
            $filtro['contrato_contrato']['tipo_dato'] = 'texto';
            $filtro['contrato_contrato']['operador'] = 'igual';
            $filtro['contrato_contrato']['valor'] = $_POST['contrato_contrato'];
        }

        if(isset($_POST['contrato_fecha_validacion_inicio']) && $_POST['contrato_fecha_validacion_inicio'] !== '' &&
            isset($_POST['contrato_fecha_validacion_fin']) && $_POST['contrato_fecha_validacion_fin'] !== '') {
            $filtro['contrato_fecha_validacion']['tipo_dato'] = 'fecha';
            $filtro['contrato_fecha_validacion']['operador'] = 'between';
            $filtro['contrato_fecha_validacion']['valor'] = $_POST['contrato_fecha_validacion_inicio'];
            $filtro['contrato_fecha_validacion']['valor2'] = $_POST['contrato_fecha_validacion_fin'];
        }

        if(isset($_POST['contrato_status']) && $_POST['contrato_status'] !== '') {
            $filtro['contrato_status']['tipo_dato'] = 'texto';
            $filtro['contrato_status']['operador'] = 'like';
            $filtro['contrato_status']['valor'] = $_POST['contrato_status'];
        }
        if(isset($_POST['contrato_morosidad']) && $_POST['contrato_morosidad'] !== '') {
            $filtro['contrato_morosidad']['tipo_dato'] = 'texto';
            $filtro['contrato_morosidad']['operador'] = 'like';
            $filtro['contrato_morosidad']['valor'] = $_POST['contrato_morosidad'];
        }

        $filto_encode = json_encode($filtro);

        $numero_empresa = 1;
        $offset = 0;
        $limit = 4;
        $token = 'PF0+orvaeWUp1ld5MoLJ62qu/vxjAl04Zog3JGxvahKEIL70A9uozeD0BZsr2oxZYSexclCRPYOtaWGrzkW+lQ==';

        $fields = array('numero_empresa' => $numero_empresa, 'offset' => $offset,'limit' => $limit,'token' => $token,
            'filtros' => $filto_encode);
        $fields_string = http_build_query($fields);

        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $fields_string
            )
        );
        $context  = stream_context_create($opts);

        $result = file_get_contents($server, false, $context);
        $results = json_decode($result,true);

        $filtro_camp['pbx_campaign.id'] = $this->registro_id;
        $pbx_campaign_sinc = (new pbx_campaign_sinc($this->link))->filtro_and(filtro: $filtro_camp);
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al integrar campaña', data: $pbx_campaign_sinc,
                header: $header, ws: $ws);
        }

        $id_campaign = $pbx_campaign_sinc->registros[0]['pbx_campaign_sinc_campaign_id'];

        $registro_campaign = (new pbx_campaign($this->link))->registro(registro_id: $this->registro_id);
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al integrar campaña', data: $registro_campaign,
                header: $header, ws: $ws);
        }

        $pbx_cola = (new pbx_campaign($this->link))->obten_colas_issabel(id_cola: $registro_campaign['pbx_campaign_queue']);
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al integrar call', data: $pbx_cola, header: $header, ws: $ws);
        }

        $extensiones = $pbx_cola['results'][0]['dynamic_members'];

        $extensiones_lim =  array();
        foreach ($extensiones as $extension){
            $extensiones_tem = str_replace('S',"",$extension);
            $extensiones_tem = str_replace(',0',"",$extensiones_tem);
            $extensiones_lim[] = $extensiones_tem;
        }

        $cantidad_total = count($extensiones_lim)-1;
        $cantidad_extensiones = $cantidad_total;
        foreach ($results as $res){
            $registro_call = array();

            if($cantidad_extensiones < 0){
                $cantidad_extensiones = $cantidad_total;
            }

            if(!isset($res['phone'])){
                $tel_tem = trim($res['contrato_telefono']);
                $tel_tem = str_replace('+',"",$tel_tem);
                $num_tel = strlen($tel_tem);
                if($num_tel < 10){
                    continue;
                }
                $registro_call[]['phone'] = $extensiones_lim[$cantidad_extensiones].$tel_tem;
            }

            $registro_call['id_campaign'] = $id_campaign;
            $registro_call['pbx_campaign_id'] = $this->registro_id;

            $modelo_pbx_call = new pbx_call($this->link);
            $modelo_pbx_call->registro = $registro_call;
            $pbx_calls = $modelo_pbx_call->alta_bd();
            if (errores::$error) {
                return $this->retorno_error(mensaje: 'Error al integrar call', data: $pbx_calls, header: $header, ws: $ws);
            }

            $filtro_call['pbx_call.id'] = $pbx_calls->registro_id;
            $pbx_call_sinc = (new pbx_call_sinc($this->link))->filtro_and(filtro: $filtro_call);
            if (errores::$error) {
                return $this->retorno_error(mensaje: 'Error al integrar campaña', data: $pbx_campaign_sinc,
                    header: $header, ws: $ws);
            }

            $id_call = $pbx_call_sinc->registros[0]['pbx_call_sinc_call_id'];

            $lugar = 1;
            foreach ($res as $r => $valor){
                $registro_attr['id_call'] = $id_call;
                $registro_attr['columna'] = $r;
                $registro_attr['value'] = $valor;
                $registro_attr['column_number'] = $lugar;
                $registro_attr['pbx_call_id'] = $pbx_calls->registro_id;
                $modelo_pbx_call_attr = new pbx_call_attribute($this->link);
                $modelo_pbx_call_attr->registro = $registro_attr;
                $pbx_calls_attr = $modelo_pbx_call_attr->alta_bd();
                if (errores::$error) {
                    return $this->retorno_error(mensaje: 'Error al integrar call', data: $pbx_calls_attr, header: $header, ws: $ws);
                }
                $lugar++;
            }

            $cantidad_extensiones--;
        }

        header('Location:' . $this->link_modifica);
        exit;
    }*/

    public function alta(bool $header, bool $ws = false): array|string
    {
        $select = $this->select_cols();
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al generar select', data: $select, header: $header, ws: $ws);
        }

        $select = $this->select_form();
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al generar select', data: $select, header: $header, ws: $ws);
        }

        $alta = parent::alta($header, $ws);
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al generar alta', data: $alta, header: $header, ws: $ws);
        }

        return $alta;
    }

    public function select_cols(){
        $pbx_cola = (new pbx_campaign($this->link))->obten_colas_issabel();
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al integrar call', data: $pbx_cola);
        }

        $values = array();
        foreach ($pbx_cola['results'] as $cola){
            $values[$cola['extension']] = array('descripcion_select' => $cola['name']);
        }

        $select = $this->html_base->select(cols: '6', id_selected: -1, label: 'Cola', name: 'queue',
            values: $values);
        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al generar select', data: $select);
        }

        $this->select_queue = $select;

        return $this->select_queue;
    }

    public function select_form(){
        $filtro['imp_database.descripcion'] = 'call_center';
        $databases = (new imp_database($this->link))->filtro_and(filtro: $filtro);
        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al obtener destinos',data:  $databases);
        }

        if($databases->n_registros <= 0){
            return $this->errores->error(mensaje: 'Error no existen destinos',data:  $databases);
        }

        $imp_destinos = (new imp_database($this->link))->destinos(imp_database_id: $databases->registros[0]['imp_database_id']);
        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al obtener destinos',data:  $imp_destinos);
        }

        $pbx_campaign = new pbx_campaign($this->link);
        $values = array();
        foreach ($imp_destinos as $imp_destino) {
            $link_destino = (new _conexion())->link_destino(imp_database_id: $imp_destino['imp_database_id'],
                link: $this->link);
            if(errores::$error){
                return $this->errores->error(mensaje: 'Error al conectar con destino',data:  $link_destino);
            }

            $modelo = new form($link_destino);

            $modelo->usuario_id = $pbx_campaign->usuario_id;
            $modelo->integra_datos_base = false;

            $res = $modelo->registros();
            if(errores::$error){
                return $this->errores->error(mensaje: 'Error al conectar con destino',data:  $link_destino);
            }

            foreach ($res as $form){
                $values[$form['form_id']] = array('descripcion_select' => $form['form_nombre']);
            }
        }

        $select = $this->html_base->select(cols: '6', id_selected: -1, label: 'Form', name: 'pbx_form_id',
            values: $values);
        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al generar select', data: $select);
        }

        $this->select_form = $select;

        return $this->select_form;
    }

    public function select_consulta_status(){
        $generales = new generales();

        $numero_empresa = 1;
        $fields = array('numero_empresa' => $numero_empresa,'token' => $generales->token_em3);
        $fields_string = http_build_query($fields);

        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $fields_string
            )
        );
        $context  = stream_context_create($opts);

        $result = @file_get_contents($generales->url_consulta_status, false, $context);
        $results = json_decode($result,true);
        if ($result === false) {
            $results = array();
        }

        $values = array();
        if(count($results)>0) {
            foreach ($results as $status) {
                if ($status['contrato_status'] !== '') {
                    $values[$status['contrato_status']] = array('descripcion_select' => $status['contrato_status']);
                }
            }
        }

        $select = $this->html_base->select(cols: '6', id_selected: -1, label: 'Estatus Contrato', name:
            'contrato_status', values: $values);
        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al generar select', data: $select);
        }

        $this->select_status = $select;

        return $this->select_status;
    }

    public function select_consulta_morosidad(){
        $generales = new generales();

        $numero_empresa = 1;
        $fields = array('numero_empresa' => $numero_empresa,'token' => $generales->token_em3);
        $fields_string = http_build_query($fields);

        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $fields_string
            )
        );
        $context  = stream_context_create($opts);

        $result = @file_get_contents($generales->url_consulta_morosidades, false, $context);
        $results = json_decode($result,true);
        if ($result === false) {
            $results = array();
        }
        $values = array();
        if(count($results)>0) {
            foreach ($results as $status) {
                if ($status['contrato_morosidad'] !== '') {
                    $values[$status['contrato_morosidad']] = array('descripcion_select' => $status['contrato_morosidad']);
                }
            }
        }

        $select = $this->html_base->select(cols: '12', id_selected: -1, label: 'Morosidad', name:
            'contrato_morosidad', values: $values);
        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al generar select', data: $select);
        }

        $this->select_morosidad = $select;

        return $this->select_morosidad;
    }
}
