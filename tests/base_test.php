<?php
namespace gamboamartin\pbx\tests;
use base\orm\modelo_base;
use gamboamartin\cat_sat\models\cat_sat_tipo_de_comprobante;
use gamboamartin\errores\errores;
use PDO;
use stdClass;

class base_test{

    public function alta_cat_sat_metodo_pago(PDO $link): array|\stdClass
    {


        $alta = (new \gamboamartin\cat_sat\tests\base_test())->alta_cat_sat_metodo_pago($link);
        if(errores::$error){
            return (new errores())->error('Error al dar de alta', $alta);
        }

        return $alta;
    }

    public function alta_cat_sat_moneda(PDO $link): array|\stdClass
    {


        $alta = (new \gamboamartin\cat_sat\tests\base_test())->alta_cat_sat_moneda($link);
        if(errores::$error){
            return (new errores())->error('Error al dar de alta', $alta);
        }

        return $alta;
    }

    public function alta_cat_sat_tipo_nomina(PDO $link, int $id = 1): array|\stdClass
    {

        $alta = (new \gamboamartin\cat_sat\tests\base_test())->alta_cat_sat_tipo_nomina(link: $link, id: $id);
        if(errores::$error){
            return (new errores())->error('Error al dar de alta', $alta);

        }

        return $alta;
    }

    public function alta_com_producto(PDO $link, int $id = 1): array|\stdClass
    {

        $alta = (new \gamboamartin\comercial\test\base_test())->alta_com_producto(link: $link, id: $id);
        if(errores::$error){
            return (new errores())->error('Error al dar de alta', $alta);

        }

        return $alta;
    }

    public function alta_com_tipo_cambio(PDO $link): array|\stdClass
    {

        $alta = (new \gamboamartin\comercial\test\base_test())->alta_com_tipo_cambio(link: $link);
        if(errores::$error){
            return (new errores())->error('Error al dar de alta', $alta);

        }

        return $alta;
    }

    public function alta_cat_sat_isr(PDO $link, int $cat_sat_periodicidad_pago_nom_id = 1, float $cuota_fija = 0,
                                     string $fecha_fin = '2020-12-31', string $fecha_inicio = '2020-01-01',
                                     float $limite_inferior= 0.01, float $limite_superior = 99999,
                                     float $porcentaje_excedente = 1.92): array|\stdClass
    {

        $alta = (new \gamboamartin\cat_sat\tests\base_test())->alta_cat_sat_isr(link: $link,
            cat_sat_periodicidad_pago_nom_id: $cat_sat_periodicidad_pago_nom_id, cuota_fija: $cuota_fija,
            fecha_fin: $fecha_fin, fecha_inicio: $fecha_inicio, limite_inferior: $limite_inferior,
            limite_superior: $limite_superior, porcentaje_excedente: $porcentaje_excedente);
        if(errores::$error){
            return (new errores())->error('Error al dar de alta', $alta);
        }

        return $alta;
    }


    public function alta_cat_sat_subsidio(PDO $link, string $alias = '1', int $cat_sat_periodicidad_pago_nom_id = 1,
                                          string $codigo = '1', string $codigo_bis = '1', float $cuota_fija = 0,
                                          string $descripcion = '1', string $descripcion_select = '1',
                                          string $fecha_fin = '2020-12-31', string $fecha_inicio = '2020-01-01',
                                          int $id = 1, float $limite_inferior = 0.01, float $limite_superior = 99999,
                                          float $porcentaje_excedente = 1.92): array|\stdClass
    {

        $alta = (new \gamboamartin\cat_sat\tests\base_test())->alta_cat_sat_subsidio(link: $link,
            alias: $alias, cat_sat_periodicidad_pago_nom_id: $cat_sat_periodicidad_pago_nom_id, codigo: $codigo,
            codigo_bis: $codigo_bis, cuota_fija: $cuota_fija, descripcion: $descripcion,
            descripcion_select: $descripcion_select, fecha_fin: $fecha_fin, fecha_inicio: $fecha_inicio, id: $id,
            limite_inferior: $limite_inferior, limite_superior: $limite_superior,
            porcentaje_excedente: $porcentaje_excedente);
        if(errores::$error){
            return (new errores())->error('Error al dar de alta', $alta);
        }

        return $alta;
    }

    public function alta_cat_sat_tipo_de_comprobante(PDO $link, int $id = 1): array|\stdClass
    {
        $cat_sat_tipo_de_comprobante = array();
        $cat_sat_tipo_de_comprobante['id'] = $id;
        $cat_sat_tipo_de_comprobante['codigo'] = 1;
        $cat_sat_tipo_de_comprobante['descripcion'] = 1;
        $cat_sat_tipo_de_comprobante['descripcion_select'] = 1;
        $cat_sat_tipo_de_comprobante['alias'] = 1;
        $cat_sat_tipo_de_comprobante['codigo_bis'] = 1;


        $alta = (new cat_sat_tipo_de_comprobante($link))->alta_registro($cat_sat_tipo_de_comprobante);
        if(errores::$error){
            return (new errores())->error(mensaje: 'Error al insertar periodo', data: $alta);

        }
        return $alta;
    }

    public function del(PDO $link, string $name_model): array
    {

        $model = (new modelo_base($link))->genera_modelo(modelo: $name_model);
        if(errores::$error){
            return (new errores())->error(mensaje: 'Error al genera modelo '.$name_model, data: $model);
        }
        $del = $model->elimina_todo();
        if(errores::$error){
            return (new errores())->error(mensaje: 'Error al eliminar '.$name_model, data: $del);
        }

        return $del;
    }

    public function del_cat_sat_tipo_de_comprobante(PDO $link): array
    {
        $del = (new \gamboamartin\cat_sat\tests\base_test())->del_cat_sat_tipo_de_comprobante($link);
        if(errores::$error){
            return (new errores())->error('Error al eliminar', $del);
        }

        return $del;
    }

    public function del_com_producto(PDO $link): array
    {

        $del = (new base_test())->del_nom_conf_factura($link);
        if(errores::$error){
            return (new errores())->error('Error al eliminar', $del);

        }

        $del = (new \gamboamartin\comercial\test\base_test())->del_com_producto($link);
        if(errores::$error){
            return (new errores())->error('Error al eliminar', $del);

        }

        return $del;
    }

    public function del_cat_sat_isr(PDO $link): array
    {

        $del = (new  \gamboamartin\cat_sat\tests\base_test())->del_cat_sat_isr($link);
        if(errores::$error){
            return (new errores())->error('Error al eliminar', $del);

        }
        return $del;
    }

    public function del_cat_sat_subsidio(PDO $link): array
    {

        $del = (new  \gamboamartin\cat_sat\tests\base_test())->del_cat_sat_subsidio($link);
        if(errores::$error){
            return (new errores())->error('Error al eliminar', $del);

        }
        return $del;
    }


    public function del_nom_concepto_imss(PDO $link): array
    {
        $del = $this->del($link, 'gamboamartin\\nomina\\models\\nom_concepto_imss');
        if(errores::$error){
            return (new errores())->error('Error al eliminar', $del);
        }
        return $del;
    }

    public function del_nom_conf_empleado(PDO $link): array
    {
        $del = $this->del($link, 'gamboamartin\\nomina\\models\\nom_conf_empleado');
        if(errores::$error){
            return (new errores())->error('Error al eliminar', $del);
        }
        return $del;
    }

    public function del_nom_conf_factura(PDO $link): array
    {

        $del = (new base_test())->del_nom_conf_nomina($link);
        if(errores::$error){
            return (new errores())->error('Error al eliminar', $del);

        }

        $del = $this->del($link, 'gamboamartin\\nomina\\models\\nom_conf_factura');
        if(errores::$error){
            return (new errores())->error('Error al eliminar', $del);
        }
        return $del;
    }

    public function del_nom_conf_nomina(PDO $link): array
    {


        $del = (new base_test())->del_nom_conf_percepcion($link);
        if(errores::$error){
            return (new errores())->error('Error al eliminar', $del);
        }

        $del = (new base_test())->del_nom_conf_empleado($link);
        if(errores::$error){
            return (new errores())->error('Error al eliminar', $del);

        }

        $del = $this->del($link, 'gamboamartin\\nomina\\models\\nom_conf_nomina');
        if(errores::$error){
            return (new errores())->error('Error al eliminar', $del);
        }
        return $del;
    }

    public function del_nom_conf_percepcion(PDO $link): array
    {

        $del = $this->del($link, 'gamboamartin\\nomina\\models\\nom_conf_percepcion');
        if(errores::$error){
            return (new errores())->error('Error al eliminar', $del);
        }
        return $del;
    }

    public function del_nom_data_subsidio(PDO $link): array
    {
        $del = $this->del($link, 'gamboamartin\\nomina\\models\\nom_data_subsidio');
        if(errores::$error){
            return (new errores())->error('Error al eliminar', $del);
        }
        return $del;
    }

    public function del_nom_par_otro_pago(PDO $link): array
    {
        $del = $this->del_nom_data_subsidio($link);
        if(errores::$error){
            return (new errores())->error('Error al eliminar', $del);
        }


        $del = $this->del($link, 'gamboamartin\\nomina\\models\\nom_par_otro_pago');
        if(errores::$error){
            return (new errores())->error('Error al eliminar', $del);
        }
        return $del;
    }

}
