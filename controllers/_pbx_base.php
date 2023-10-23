<?php
namespace gamboamartin\pbx\controllers;
use gamboamartin\errores\errores;

use gamboamartin\system\_ctl_base;
use stdClass;

class _pbx_base extends _ctl_base {
    public function alta(bool $header, bool $ws = false): array|string
    {
        $r_alta = $this->init_alta();
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al inicializar alta', data: $r_alta, header: $header, ws: $ws);
        }

        $keys_selects = array('codigo','descripcion');
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al maquetar key_selects',data:  $keys_selects, header: $header,ws:  $ws);
        }

        $inputs = $this->inputs(keys_selects: $keys_selects);
        if (errores::$error) {
            return $this->retorno_error(
                mensaje: 'Error al obtener inputs', data: $inputs, header: $header, ws: $ws);
        }

        return $r_alta;
    }

    /**
     * Funcion declarado y sobreescrita en cada controlador en uso
     * @return array
     */
    protected function key_selects_txt(array $keys_selects): array
    {

        $place_holder_desc = $this->tabla;
        $place_holder_desc = str_replace('pbx_', '',  $place_holder_desc );
        $place_holder_desc = str_replace('_', ' ', $place_holder_desc);
        $place_holder_desc = ucwords($place_holder_desc);

        $keys_selects = (new \base\controller\init())->key_select_txt(
            cols: 6,key: 'codigo', keys_selects:$keys_selects, place_holder: 'Cod');
        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al maquetar key_selects',data:  $keys_selects);
        }
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6,key: 'descripcion',
            keys_selects:$keys_selects, place_holder: $place_holder_desc);
        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al maquetar key_selects',data:  $keys_selects);
        }

        return $keys_selects;
    }
}
