<?php /** @var gamboamartin\cat_sat\controllers\controlador_cat_sat_producto $controlador  controlador en ejecucion */ ?>
<?php use config\views; ?>
<?php echo $controlador->inputs->codigo; ?>
<?php echo $controlador->inputs->descripcion; ?>
<?php echo $controlador->inputs->name; ?>
<?php echo $controlador->inputs->datetime_end; ?>
<?php echo $controlador->inputs->daytime_init; ?>
<?php echo $controlador->inputs->daytime_end; ?>
<?php echo $controlador->inputs->retries; ?>
<?php echo $controlador->inputs->context; ?>
<?php echo $controlador->inputs->queue; ?>
<?php echo $controlador->inputs->max_canales; ?>
<?php echo $controlador->inputs->script; ?>
<?php echo $controlador->inputs->estatus; ?>
<?php include (new views())->ruta_templates.'botons/submit/modifica_bd.php';?>
<div class="error" style="margin-bottom: 20px"></div>

