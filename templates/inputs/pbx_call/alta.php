<?php /** @var gamboamartin\pbx\controllers\controlador_pbx_call $controlador  controlador en ejecucion */ ?>
<?php use config\views; ?>
<?php echo $controlador->inputs->codigo; ?>
<?php echo $controlador->inputs->descripcion; ?>
<?php echo $controlador->inputs->phone; ?>
<?php echo $controlador->inputs->retries; ?>
<?php echo $controlador->inputs->dnc; ?>
<?php echo $controlador->inputs->scheduled; ?>
<?php include (new views())->ruta_templates.'botons/submit/alta_bd.php';?>
<div class="error"></div>

