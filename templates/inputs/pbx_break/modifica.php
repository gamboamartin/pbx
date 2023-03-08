<?php /** @var gamboamartin\pbx\controllers\controlador_pbx_break $controlador controlador en ejecucion */ ?>
<?php use config\views; ?>
<?php echo $controlador->inputs->name; ?>
<?php echo $controlador->inputs->descripcion; ?>
<?php echo $controlador->inputs->estatus; ?>
<?php echo $controlador->inputs->tipo; ?>
<?php include (new views())->ruta_templates.'botons/submit/modifica_bd.php';?>
<div class="error" style="margin-bottom: 20px"></div>

