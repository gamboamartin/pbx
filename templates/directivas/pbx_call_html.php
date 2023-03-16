<?php

namespace html;

use gamboamartin\errores\errores;
use gamboamartin\pbx\models\pbx_call;
use gamboamartin\system\html_controler;
use PDO;


class pbx_call_html extends html_controler {
    public function select_pbx_call_id(int $cols, bool $con_registros, int $id_selected, PDO $link,
                                                  bool $required = false): array|string
    {
        $modelo = new pbx_call($link);

        $select = $this->select_catalogo(cols:$cols,con_registros:$con_registros,id_selected:$id_selected,
            modelo: $modelo, label: "Call",required: $required);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select', data: $select);
        }
        return $select;
    }
}
