<?php /** @var gamboamartin\cat_sat\controllers\controlador_pbx_campaign $controlador  controlador en ejecucion */ ?>
<?php use config\views; ?>
<?php echo $controlador->inputs->codigo; ?>
<?php echo $controlador->inputs->descripcion; ?>
<?php echo $controlador->inputs->name; ?>
<?php echo $controlador->inputs->datetime_init; ?>
<?php echo $controlador->inputs->datetime_end; ?>
<?php echo $controlador->inputs->daytime_init; ?>
<?php echo $controlador->inputs->daytime_end; ?>
<?php echo $controlador->inputs->retries; ?>
<?php echo $controlador->inputs->queue; ?>
<?php echo $controlador->inputs->script; ?>
<?php include (new views())->ruta_templates.'botons/submit/modifica_bd.php';?>
<div class="error" style="margin-bottom: 20px"></div>

