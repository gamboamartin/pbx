<?php

$file_lock = 'sincroniza_datos.lock';

if(file_exists($file_lock)){
    echo 'Se esta corriendo servicio';
    exit;
}
else{
    file_put_contents($file_lock, '');
}

use base\conexion;
use config\generales;
use gamboamartin\errores\errores;
use gamboamartin\importador\models\imp_database;
use gamboamartin\pbx\models\pbx_call;
use gamboamartin\pbx\models\pbx_call_attribute;
use gamboamartin\pbx\models\pbx_call_sinc;
use gamboamartin\pbx\models\pbx_campaign;
use gamboamartin\pbx\models\pbx_campaign_sinc;
use gamboamartin\pbx\models\pbx_ultimo;

require "init.php";
require 'vendor/autoload.php';



$con = new conexion();
$link = conexion::$link;
$pbx_campaign_modelo = (new pbx_campaign(link: $link));
$_SESSION['usuario_id'] = 2;
$_SESSION['session_id'] = mt_rand(10000000,99999999);
$_GET['session_id'] = $_SESSION['session_id'];

$filtro['pbx_campaign.status_sincronizador'] = 'activo';
$campaigns = $pbx_campaign_modelo->filtro_and(filtro: $filtro);
if(errores::$error){
    $error = (new errores())->error(mensaje: 'Error',data:  $campaigns);
    print_r($error);
    unlink($file_lock);
    exit;
}

foreach ($campaigns as $campaign){
    $pbx_ultimo_modelo = new pbx_ultimo(link: $link);
    $filtro_ultimo['pbx_ultimo.pbx_campaign_id'] = $campaign['pbx_campaign_id'];
    $registro_ultimo = $pbx_ultimo_modelo->filtro_and(filtro: $filtro_ultimo);
    if(errores::$error){
        $error = (new errores())->error(mensaje: 'Error',data:  $registro_ultimo);
        print_r($error);
        unlink($file_lock);
        exit;
    }

    if($registro_ultimo->n_registros <= 0){
        $registro_campaign['status_sincronizador'] = 'inactivo';
        $r_mod_pbx_campaign = $pbx_campaign_modelo->modifica_bd(registro: $registro_campaign,
            id: $campaign['pbx_campaign_id']);
        if(errores::$error){
            $error = (new errores())->error(mensaje: 'Error',data:  $registro_ultimo);
            print_r($error);
            unlink($file_lock);
            exit;
        }
        continue;
    }

    $fields_string = $registro_ultimo->registros[0]['pbx_ultimo_sentencia'];
    $opts = array('http' =>
        array(
            'method'  => 'POST',
            'header'  => 'Content-Type: application/x-www-form-urlencoded',
            'content' => $fields_string
        )
    );
    $context  = stream_context_create($opts);

    $result = file_get_contents((new generales())->url_consulta_contratos, false, $context);
    $results = json_decode($result,true);

    $filtro_camp['pbx_campaign.id'] = $campaign['pbx_campaign_id'];
    $pbx_campaign_sinc = (new pbx_campaign_sinc($this->link))->filtro_and(filtro: $filtro_camp);
    if(errores::$error){
        $error = (new errores())->error(mensaje: 'Error',data:  $registro_ultimo);
        print_r($error);
        unlink($file_lock);
        exit;
    }

    $id_campaign = $pbx_campaign_sinc->registros[0]['pbx_campaign_sinc_campaign_id'];

    $pbx_cola = (new pbx_campaign($this->link))->obten_colas_issabel(id_cola: $campaign['pbx_campaign_queue']);
    if(errores::$error){
        $error = (new errores())->error(mensaje: 'Error',data:  $registro_ultimo);
        print_r($error);
        unlink($file_lock);
        exit;
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
        if(errores::$error){
            $error = (new errores())->error(mensaje: 'Error',data:  $registro_ultimo);
            print_r($error);
            unlink($file_lock);
            exit;
        }

        $filtro_call['pbx_call.id'] = $pbx_calls->registro_id;
        $pbx_call_sinc = (new pbx_call_sinc($this->link))->filtro_and(filtro: $filtro_call);
        if(errores::$error){
            $error = (new errores())->error(mensaje: 'Error',data:  $registro_ultimo);
            print_r($error);
            unlink($file_lock);
            exit;
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
            if(errores::$error){
                $error = (new errores())->error(mensaje: 'Error',data:  $registro_ultimo);
                print_r($error);
                unlink($file_lock);
                exit;
            }
            $lugar++;
        }

        $cantidad_extensiones--;
    }

    $registro_ultimo['offset'] =  $registro_ultimo->registros[0]['pbx_ultimo_offset'] +
        $registro_ultimo->registros[0]['pbx_ultimo_limit'];
    $r_mod_pbx_ultimo = $pbx_ultimo_modelo->modifica_bd(registro: $registro_ultimo,
        id: $registro_ultimo->registros[0]['pbx_ultimo_id']);
    if(errores::$error){
        $error = (new errores())->error(mensaje: 'Error',data:  $r_mod_pbx_ultimo);
        print_r($error);
        unlink($file_lock);
        exit;
    }

}

unlink($file_lock);
exit;
