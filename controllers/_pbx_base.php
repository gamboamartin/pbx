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

        $keys_selects = $this->init_selects_inputs();
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al inicializar selects', data: $keys_selects, header: $header,
                ws: $ws);
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
    public function init_selects_inputs(): array
    {
        return array();
    }
}
