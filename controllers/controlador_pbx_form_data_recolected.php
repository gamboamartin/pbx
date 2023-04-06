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
use gamboamartin\pbx\models\pbx_form_data_recolected;
use gamboamartin\system\links_menu;
use gamboamartin\template\html;
use html\pbx_form_data_recolected_html;
use PDO;
use stdClass;

class controlador_pbx_form_data_recolected extends _pbx_base {

    public function __construct(PDO $link, html $html = new \gamboamartin\template_1\html(),
                                stdClass $paths_conf = new stdClass()){
        $modelo = new pbx_form_data_recolected(link: $link);
        $html_ = new pbx_form_data_recolected_html(html: $html);
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
        $keys->inputs = array('codigo', 'descripcion', 'value');
        $keys->selects = array();

        $init_data = array();
        $init_data['pbx_call'] = "gamboamartin\\pbx";
        $init_data['pbx_form_field'] = "gamboamartin\\pbx";
        $campos_view = $this->campos_view_base(init_data: $init_data, keys: $keys);
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al inicializar campo view', data: $campos_view);
        }

        return $campos_view;
    }

    private function init_configuraciones(): controler
    {
        $this->titulo_lista = 'Formulario de Form Data Recolected';

        return $this;
    }

    private function init_datatable(): stdClass
    {
        $columns["pbx_form_data_recolected_id"]["titulo"] = "Id";
        $columns["pbx_form_data_recolected_codigo"]["titulo"] = "Código";
        $columns["pbx_form_data_recolected_descripcion"]["titulo"] = "Descripción";
        $columns["pbx_form_data_recolected_value"]["titulo"] = "Type";
        $columns["pbx_call_descripcion"]["titulo"] = "Formulario";
        $columns["pbx_form_field_descripcion"]["titulo"] = "Formulario";


        $filtro = array("pbx_form_data_recolected.id", "pbx_form_data_recolected.codigo", "pbx_form_data_recolected.descripcion", "pbx_form_data_recolected.value",
            "pbx_call_descripcion", "pbx_form_field_descripcion");

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
        $keys_selects = $this->init_selects(keys_selects: array(), key: "pbx_call_id", label: "Campaña",
            cols: 12);
        return $this->init_selects(keys_selects: $keys_selects, key: "pbx_form_field_id", label: "Formulario",
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
            keys_selects: $keys_selects, place_holder: 'Descripción');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }

        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'value',
            keys_selects: $keys_selects, place_holder: 'Value');
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

        $keys_selects['pbx_call_id']->id_selected = $this->registro['pbx_call_id'];
        $keys_selects['pbx_form_field_id']->id_selected = $this->registro['pbx_form_field_id'];

        $base = $this->base_upd(keys_selects: array(), params: array(), params_ajustados: array());
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al integrar base', data: $base, header: $header, ws: $ws);
        }

        return $r_modifica;
    }


}
