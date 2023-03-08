<?php

namespace html;

use gamboamartin\errores\errores;
use gamboamartin\pbx\models\pbx_agent;
use gamboamartin\pbx\models\pbx_break;
use gamboamartin\pbx\models\pbx_call_attribute;
use gamboamartin\system\html_controler;
use PDO;


class pbx_call_attribute_html extends html_controler {
    public function select_pbx_call_attribute_id(int $cols, bool $con_registros, int $id_selected, PDO $link,
                                                  bool $required = false): array|string
    {
        $modelo = new pbx_call_attribute($link);

        $select = $this->select_catalogo(cols:$cols,con_registros:$con_registros,id_selected:$id_selected,
            modelo: $modelo, label: "Call Atribute",required: $required);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select', data: $select);
        }
        return $select;
    }
}
