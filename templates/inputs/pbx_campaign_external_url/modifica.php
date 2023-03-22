<?php /** @var gamboamartin\pbx\controllers\controlador_pbx_campaign_external_url $controlador controlador en ejecucion */ ?>
<?php use config\views; ?>

<?php echo $controlador->inputs->codigo; ?>
<?php echo $controlador->inputs->descripcion; ?>
<?php echo $controlador->inputs->urltemplate; ?>
<?php echo $controlador->inputs->description; ?>
<?php echo $controlador->inputs->active; ?>
<?php echo $controlador->inputs->opentype; ?>
<?php include (new views())->ruta_templates.'botons/submit/modifica_bd.php';?>
<div class="error" style="margin-bottom: 20px"></div>

