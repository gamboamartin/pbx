<?php /** @var gamboamartin\cat_sat\controllers\controlador_cat_sat_producto $controlador  controlador en ejecucion */ ?>
<?php use config\views; ?>
<?php echo $controlador->inputs->codigo; ?>
<?php echo $controlador->inputs->descripcion; ?>
<?php echo $controlador->inputs->phone; ?>
<?php echo $controlador->inputs->retries; ?>
<?php echo $controlador->inputs->dnc; ?>
<?php echo $controlador->inputs->scheduled; ?>
<?php include (new views())->ruta_templates.'botons/submit/modifica_bd.php';?>
<div class="error" style="margin-bottom: 20px"></div>

