<?php /** @var gamboamartin\pbx\controllers\controlador_pbx_agent $controlador  controlador en ejecucion */ ?>
<?php use config\views; ?>
<?php echo $controlador->inputs->type; ?>
<?php echo $controlador->inputs->number; ?>
<?php echo $controlador->inputs->name; ?>
<?php echo $controlador->inputs->password; ?>
<?php echo $controlador->inputs->eccp_password; ?>
<?php echo $controlador->inputs->estatus; ?>
<?php include (new views())->ruta_templates.'botons/submit/alta_bd.php';?>
<div class="error"></div>


