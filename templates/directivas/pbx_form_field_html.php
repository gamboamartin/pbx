<?php

namespace html;

use gamboamartin\errores\errores;
use gamboamartin\pbx\models\pbx_campaign_external_url;
use gamboamartin\pbx\models\pbx_form_field;
use gamboamartin\system\html_controler;
use PDO;


class pbx_form_field_html extends html_controler {
    public function select_campaign_external_url_id(int $cols, bool $con_registros, int $id_selected, PDO $link,
                                                  bool $required = false): array|string
    {
        $modelo = new pbx_form_field($link);

        $select = $this->select_catalogo(cols:$cols,con_registros:$con_registros,id_selected:$id_selected,
            modelo: $modelo, label: "Form Field",required: $required);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select', data: $select);
        }
        return $select;
    }
}
