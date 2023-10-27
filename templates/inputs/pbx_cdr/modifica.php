<?php /** @var gamboamartin\pbx\controllers\controlador_pbx_cdr $controlador  controlador en ejecucion */ ?>
<?php use config\views; ?>
<?php echo $controlador->inputs->calldate; ?>
<?php echo $controlador->inputs->clid; ?>
<?php echo $controlador->inputs->src; ?>
<?php echo $controlador->inputs->dst; ?>
<?php echo $controlador->inputs->dcontext; ?>
<?php echo $controlador->inputs->channel; ?>
<?php echo $controlador->inputs->dstchannel; ?>
<?php echo $controlador->inputs->lastapp; ?>
<?php echo $controlador->inputs->lastdata; ?>
<?php echo $controlador->inputs->duration; ?>
<?php echo $controlador->inputs->billsec; ?>
<?php echo $controlador->inputs->disposition; ?>
<?php echo $controlador->inputs->amaflags; ?>
<?php echo $controlador->inputs->accountcode; ?>
<?php echo $controlador->inputs->uniqueid; ?>
<?php echo $controlador->inputs->userfield; ?>
<?php echo $controlador->inputs->recordingfile; ?>
<?php echo $controlador->inputs->cnum; ?>
<?php echo $controlador->inputs->cnam; ?>
<?php echo $controlador->inputs->outbound_cnum; ?>
<?php echo $controlador->inputs->outbound_cnam; ?>
<?php echo $controlador->inputs->dst_cnam; ?>
<?php echo $controlador->inputs->did; ?>
<?php include (new views())->ruta_templates.'botons/submit/modifica_bd.php';?>
<div class="error" style="margin-bottom: 20px"></div>

