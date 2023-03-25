<?php /** @var gamboamartin\pbx\controllers\controlador_pbx_call $controlador  controlador en ejecucion */ ?>
<?php use config\views; ?>
<?php echo $controlador->inputs->codigo; ?>
<?php echo $controlador->inputs->descripcion; ?>
<?php echo $controlador->inputs->phone; ?>
<?php echo $controlador->inputs->retries; ?>
<?php echo $controlador->inputs->dnc; ?>
<?php echo $controlador->inputs->scheduled; ?>
<?php echo $controlador->inputs->estatus; ?>
<?php echo $controlador->inputs->uniqueid; ?>
<?php echo $controlador->inputs->fecha_llamada; ?>
<?php echo $controlador->inputs->start_time; ?>
<?php echo $controlador->inputs->end_time; ?>
<?php echo $controlador->inputs->duration; ?>
<?php echo $controlador->inputs->transfer; ?>
<?php echo $controlador->inputs->datetime_entry_queue; ?>
<?php echo $controlador->inputs->duration_wait; ?>
<?php echo $controlador->inputs->date_init; ?>
<?php echo $controlador->inputs->date_end; ?>
<?php echo $controlador->inputs->time_init; ?>
<?php echo $controlador->inputs->time_end; ?>
<?php echo $controlador->inputs->agent; ?>
<?php echo $controlador->inputs->failure_cause; ?>
<?php echo $controlador->inputs->failure_cause_txt; ?>
<?php echo $controlador->inputs->datetime_originate; ?>
<?php echo $controlador->inputs->trunk; ?>
<?php echo $controlador->inputs->pbx_agent_id; ?>
<?php echo $controlador->inputs->pbx_campaign_id; ?>
<?php include (new views())->ruta_templates.'botons/submit/alta_bd.php';?>
<div class="error"></div>

