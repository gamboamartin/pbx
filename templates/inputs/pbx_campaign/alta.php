<?php /** @var gamboamartin\pbx\controllers\controlador_pbx_campaign $controlador  controlador en ejecucion */ ?>
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
<?php echo $controlador->inputs->trunk; ?>
<?php echo $controlador->inputs->num_completadas; ?>
<?php echo $controlador->inputs->promedio; ?>
<?php echo $controlador->inputs->desviacion; ?>
<?php echo $controlador->inputs->pbx_campaign_external_url_id; ?>
<?php include (new views())->ruta_templates.'botons/submit/alta_bd.php';?>
<div class="error"></div>
