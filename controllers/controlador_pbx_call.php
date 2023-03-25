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
use gamboamartin\errores\errores;
use gamboamartin\pbx\models\pbx_call;
use gamboamartin\system\_ctl_base;
use gamboamartin\system\links_menu;
use gamboamartin\template\html;
use html\pbx_call_html;
use PDO;
use stdClass;

class controlador_pbx_call extends _pbx_base {

    public function __construct(PDO $link, html $html = new \gamboamartin\template_1\html(),
                                stdClass $paths_conf = new stdClass()){
        $modelo = new pbx_call(link: $link);
        $html_ = new pbx_call_html(html: $html);
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
    }

    protected function campos_view(): array
    {
        $keys = new stdClass();
        $keys->inputs = array('codigo','descripcion', 'phone', 'retries', 'dnc', 'scheduled', 'estatus', 'uniqueid',
            'fecha_llamada', 'start_time', 'end_time', 'duration', 'transfer', 'datetime_entry_queue', 'duration_wait',
            'date_init', 'date_end', 'time_init', 'time_end', 'agent', 'failure_cause', 'failure_cause_txt', 'datetime_originate',
            'trunk' );

        $keys->selects = array();

        $init_data = array();
        $init_data['pbx_agent'] = "gamboamartin\\pbx";
        $init_data['pbx_campaign'] = "gamboamartin\\pbx";

        $campos_view = $this->campos_view_base(init_data: $init_data, keys: $keys);
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al inicializar campo view', data: $campos_view);
        }

        return $campos_view;
    }

    private function init_configuraciones(): controler
    {
        $this->titulo_lista = 'Formulario de call';

        return $this;
    }

    private function init_datatable(): stdClass
    {
        $columns["pbx_call_id"]["titulo"] = "Id";
        $columns["pbx_call_codigo"]["titulo"] = "Código";
        $columns["pbx_call_descripcion"]["titulo"] = "Descripcion";
        $columns["pbx_call_phone"]["titulo"] = "Telefono";
        $columns["pbx_call_retries"]["titulo"] = "Reintentos";
        $columns["pbx_call_estatus"]["titulo"] = "Estatus";
        $columns["pbx_call_uniqueid"]["titulo"] = "ÚnicoId";
        $columns["pbx_call_fecha_llamada"]["titulo"] = "Fecha de llamada";
        $columns["pbx_call_start_time"]["titulo"] = "Inicio tiempo";
        $columns["pbx_call_end_time"]["titulo"] = "Final tiempo";
        $columns["pbx_call_duration"]["titulo"] = "Duration";
        $columns["pbx_call_transfer"]["titulo"] = "transferir";
        $columns["pbx_call_datetime_entry_queue"]["titulo"] = "Fecha y hora entrada a cola";
        $columns["pbx_call_duration_wait"]["titulo"] = "Duración de espera";
        $columns["pbx_call_date_init"]["titulo"] = "Fecha inicial";
        $columns["pbx_call_date_end"]["titulo"] = "Fecha final";
        $columns["pbx_call_time_init"]["titulo"] = "Tiempo inicial";
        $columns["time_end"]["titulo"] = "tiempo final";
        $columns["pbx_call_agent"]["titulo"] = "Agente";
        $columns["pbx_call_failure_cause"]["titulo"] = "Causa de fallas";
        $columns["pbx_call_failure_cause_txt"]["titulo"] = "Causa de fallas txt";
        $columns["pbx_call_datetime_originate"]["titulo"] = "Origen de fecha y hora";
        $columns["pbx_call_trunk"]["titulo"] = "Truncal";
        $columns["pbx_call_dnc"]["titulo"] = "DNC";
        $columns["pbx_call_scheduled"]["titulo"] = "Programada";
        $columns["pbx_agent_descripcion"]["titulo"] = "Formulario";
        $columns["pbx_campaign_descripcion"]["titulo"] = "Formulario";


        $filtro = array("pbx_call.id", "pbx_call.codigo", "pbx_call.descripcion", "pbx_call.phone", "pbx_call.retries",
            "pbx_call.dnc", "pbx_call.estatus", "pbx_call.uniqueid", "pbx_call.fecha_llamada", "pbx_call.start_time",
            "pbx_call.end_time", "pbx_call.duration", "pbx_call.transfer", "pbx_call.datetime_entry_queue", "pbx_call.duration_wait",
            "pbx_call.date_init", "pbx_call.date_end", "pbx_call.time_init", "pbx_call.time_end", "pbx_call.agent",
            "pbx_call.failure_cause", "pbx_call.failure_cause_txt", "pbx_call.datetime_originate", "pbx_call.trunk",  "pbx_agent_descripcion", "pbx_campaign_descripcion");

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
        $keys_selects = $this->init_selects(keys_selects: array(), key: "pbx_campaign_id", label: "Campaña",
            cols: 12);
        return $this->init_selects(keys_selects: $keys_selects, key: "pbx_agent_id", label: "Agente",
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

        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'phone',
            keys_selects: $keys_selects, place_holder: 'Telefono');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }

        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'retries',
            keys_selects: $keys_selects, place_holder: 'Reintentos');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }

        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'dnc',
            keys_selects: $keys_selects, place_holder: 'DNC');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }

        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'scheduled',
            keys_selects: $keys_selects, place_holder: 'Programada');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'estatus',
            keys_selects: $keys_selects, place_holder: 'Estatus');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'uniqueid',
            keys_selects: $keys_selects, place_holder: 'ÚnicoId');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'fecha_llamada',
            keys_selects: $keys_selects, place_holder: 'Fecha de llamada');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'start_time',
            keys_selects: $keys_selects, place_holder: 'Inicio tiempo');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'end_time',
            keys_selects: $keys_selects, place_holder: 'Final tiempo');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'duration',
            keys_selects: $keys_selects, place_holder: 'Duration');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'transfer',
            keys_selects: $keys_selects, place_holder: 'transferir');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'datetime_entry_queue',
            keys_selects: $keys_selects, place_holder: '"Fecha y hora entrada a cola');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'duration_wait',
            keys_selects: $keys_selects, place_holder: 'Duración de espera');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'date_init',
            keys_selects: $keys_selects, place_holder: 'Fecha inicial');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'date_end',
            keys_selects: $keys_selects, place_holder: 'Fecha final');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'time_init',
            keys_selects: $keys_selects, place_holder: 'Tiempo inicial');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'time_end',
            keys_selects: $keys_selects, place_holder: 'tiempo final');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'agent',
            keys_selects: $keys_selects, place_holder: 'Agente');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'failure_cause',
            keys_selects: $keys_selects, place_holder: 'Causa de fallas');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'failure_cause_txt',
            keys_selects: $keys_selects, place_holder: 'Causa de fallas txt');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'datetime_originate',
            keys_selects: $keys_selects, place_holder: 'Origen de fecha y hora');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'trunk',
            keys_selects: $keys_selects, place_holder: 'Truncal');
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
        $keys_selects = $this->init_selects_inputs();
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al inicializar selects', data: $keys_selects, header: $header,
                ws: $ws);
        }

        $keys_selects['pbx_agent_id']->id_selected = $this->registro['pbx_agent_id'];
        $keys_selects['pbx_campaign_id']->id_selected = $this->registro['pbx_campaign_id'];

        $base = $this->base_upd(keys_selects: array(), params: array(), params_ajustados: array());
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al integrar base', data: $base, header: $header, ws: $ws);
        }

        return $r_modifica;
    }


}
