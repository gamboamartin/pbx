<?php /** @var gamboamartin\pbx\controllers\controlador_pbx_extensions $controlador  controlador en ejecucion */ ?>
<?php use config\views; ?>
<?php echo $controlador->inputs->context; ?>
<?php echo $controlador->inputs->extension; ?>
<?php echo $controlador->inputs->priority; ?>
<?php echo $controlador->inputs->args; ?>
<?php echo $controlador->inputs->descr; ?>
<?php echo $controlador->inputs->application; ?>
<?php echo $controlador->inputs->flags; ?>
<?php include (new views())->ruta_templates.'botons/submit/alta_bd.php';?>


