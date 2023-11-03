<?php
namespace gamboamartin\pbx\tests\orm;


use config\generales;
use gamboamartin\errores\errores;
use gamboamartin\pbx\models\pbx_campaign;
use gamboamartin\pbx\tests\base_test;
use gamboamartin\test\liberator;
use gamboamartin\test\test;


use stdClass;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertStringContainsStringIgnoringCase;


class pbx_campaignTest extends test {
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

    public function test_alta_bd(): void
    {
        errores::$error = false;

        $_GET['seccion'] = 'pbx_campaign';
        $_GET['accion'] = 'lista';
        $_SESSION['grupo_id'] = 1;
        $_SESSION['usuario_id'] = 2;
        $_GET['session_id'] = '1';

        $pbx = new pbx_campaign(link: $this->link);
        //$pbx = new liberator($inm);

        $resultado = $pbx->genera_token_api_issabel();
      //  print_r($resultado);exit;
        $this->assertIsString($resultado);
        $this->assertNotTrue(errores::$error);

        errores::$error = false;
    }

}

