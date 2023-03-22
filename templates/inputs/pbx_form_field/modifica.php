<?php /** @var gamboamartin\pbx\controllers\controlador_pbx_call_attribute $controlador controlador en ejecucion */ ?>
<?php use config\views; ?>
<?php echo $controlador->inputs->codigo; ?>
<?php echo $controlador->inputs->descripcion; ?>
<?php echo $controlador->inputs->etiqueta; ?>
<?php echo $controlador->inputs->value; ?>
<?php echo $controlador->inputs->tipo; ?>
<?php echo $controlador->inputs->orden; ?>
<?php echo $controlador->inputs->pbx_form_id; ?>
<?php include (new views())->ruta_templates.'botons/submit/modifica_bd.php';?>
<div class="error" style="margin-bottom: 20px"></div>

