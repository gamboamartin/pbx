<?php /** @var gamboamartin\pbx\controllers\controlador_pbx_campaign_form $controlador  controlador en ejecucion */ ?>
<?php use config\views; ?>
<?php echo $controlador->inputs->codigo; ?>
<?php echo $controlador->inputs->descripcion; ?>
<?php echo $controlador->inputs->pbx_form_id; ?>
<?php echo $controlador->inputs->pbx_campaign_id; ?>

<?php include (new views())->ruta_templates.'botons/submit/alta_bd.php';?>
<div class="error"></div>

