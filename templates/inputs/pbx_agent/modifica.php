<?php /** @var gamboamartin\pbx\controllers\controlador_pbx_agent $controlador  controlador en ejecucion */ ?>
<?php use config\views; ?>
<?php echo $controlador->inputs->codigo; ?>
<?php echo $controlador->inputs->descripcion; ?>
<?php echo $controlador->inputs->type; ?>
<?php echo $controlador->inputs->number; ?>
<?php echo $controlador->inputs->name; ?>
<?php echo $controlador->inputs->password; ?>
<?php echo $controlador->inputs->eccp_password; ?>
<?php echo $controlador->inputs->estatus; ?>
<?php include (new views())->ruta_templates.'botons/submit/modifica_bd.php';?>
<div class="error" style="margin-bottom: 20px"></div>

