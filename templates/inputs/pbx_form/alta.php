<?php /** @var gamboamartin\pbx\controllers\controlador_pbx_form $controlador  controlador en ejecucion */ ?>
<?php use config\views; ?>
<?php echo $controlador->inputs->codigo; ?>
<?php echo $controlador->inputs->descripcion; ?>
<?php echo $controlador->inputs->nombre; ?>
<?php echo $controlador->inputs->estatus; ?>
<?php include (new views())->ruta_templates.'botons/submit/alta_bd.php';?>
<div class="error"></div>


