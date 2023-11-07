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
use gamboamartin\pbx\models\campaign;
use gamboamartin\pbx\models\form;
use gamboamartin\system\links_menu;
use gamboamartin\template\html;
use html\campaign_html;
use html\form_html;
use PDO;
use stdClass;

class controlador_form extends _pbx_base {

    public function __construct(PDO $link, html $html = new \gamboamartin\template_1\html(),
                                stdClass $paths_conf = new stdClass()){
        $modelo = new form(link: $link);
        $html_ = new form_html(html: $html);
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
        $keys->inputs = array('codigo','descripcion', 'name', 'datetime_init','datetime_end', 'daytime_init',
            'daytime_end', 'retries', 'context', 'queue', 'max_canales', 'script', 'estatus', 'trunk',
            'num_completadas', 'promedio', 'desviacion');
        $keys->selects = array();

        $init_data = array();
        $init_data['pbx_queues_config'] = "gamboamartin\\pbx";
        $init_data['pbx_campaign_external_url'] = "gamboamartin\\pbx";

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
        $columns["pbx_campaign_external_url"]["titulo"] = "Url";

        $filtro = array("pbx_campaign.id", "pbx_campaign.codigo", "pbx_campaign.descripcion", "pbx_campaign.name", "pbx_campaign.datetime_init","pbx_campaign.datetime_end",
            "pbx_campaign.daytime_init", "pbx_campaign.daytime_end", "pbx_campaign.retries", "pbx_campaign.context", "pbx_campaign.queue", "pbx_campaign.max_canales",
            "pbx_campaign.script", "pbx_campaign.estatus", "pbx_campaign.trunk", "pbx_campaign.num_completadas",
            "pbx_campaign.promedio", "pbx_campaign.desviacion", "pbx_campaign_external_url");

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

        $this->init_selects(keys_selects:  array(), key: "pbx_queues_config_id", label: "Cola",
            cols: 12);
        return $this->init_selects(keys_selects:  array(), key: "pbx_campaign_external_url_id", label: "Llamada",
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


}
