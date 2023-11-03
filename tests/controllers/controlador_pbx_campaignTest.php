<?php
namespace gamboamartin\pbx\tests\controllers;


use gamboamartin\errores\errores;
use gamboamartin\pbx\controllers\controlador_pbx_campaign;
use gamboamartin\test\liberator;
use gamboamartin\test\test;


use stdClass;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertStringContainsStringIgnoringCase;


class controlador_pbx_campaignTest extends test {
    public errores $errores;
    private stdClass $paths_conf;
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->errores = new errores();
        $this->paths_conf = new stdClass();
        $this->paths_conf->generales = '/var/www/html/pbx/config/generales.php';
        $this->paths_conf->database = '/var/www/html/pbx/config/database.php';
        $this->paths_conf->views = '/var/www/html/pbx/config/views.php';
    }

   /* public function test_sincroniza_datos(): void
    {
        errores::$error = false;
        $_GET['seccion'] = 'pbx_campaign';
        $_GET['accion'] = 'lista';
        $_SESSION['grupo_id'] = 1;
        $_SESSION['usuario_id'] = 2;
        $_GET['session_id'] = '1';


        //$pbx = new controlador_pbx_campaign(link: $this->link, paths_conf: $this->paths_conf);
        //$ctl = new liberator($ctl);

        $_POST['contrato_morosidad'] = 'MOROSO SEVERO';
        $pbx->registro_id = 1;
        //$resultado = $pbx->sincroniza_datos(header: false);

        //print_r($resultado);Exit;
        /*$this->assertIsArray($resultado);
        $this->assertNotTrue(errores::$error);
        errores::$error = false;


    }*/
}

