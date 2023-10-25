<?php /** @var gamboamartin\pbx\controllers\controlador_pbx_campaign $controlador  controlador en ejecucion */ ?>
<?php use config\views; ?>
<?php echo $controlador->inputs->name; ?>
<div class="control-group col-sm-6">
    <label class="control-label" for="daytime_init">Inicio Fecha</label>
    <div class="controls">
        <input type="date" name="datetime_init" value="" class="form-control" required="" id="datetime_init" placeholder="Inicio Fecha" title="Inicio Fecha">
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="datetime_end">Fin Fecha</label>
    <div class="controls">
        <input type="date" name="datetime_end" value="" class="form-control" required="" id="datetime_end" placeholder="Fin Fecha" title="Fin Fecha">
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="daytime_init">Hora Inicio</label>
    <div class="controls">
        <input type="time" name="daytime_init"  value="00:00:00" class="form-control" required="" id="daytime_init" placeholder="Hora Inicio" title="Hora Inicio">
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="daytime_end">Hora Fin</label>
    <div class="controls">
        <input type="time" name="daytime_end"  value="00:00:00" class="form-control" required="" id="daytime_end " placeholder="Hora Fin" title="Hora Fin">
    </div>
</div>
<?php echo $controlador->inputs->retries; ?>
<?php echo $controlador->inputs->queue; ?>
<?php echo $controlador->inputs->script; ?>
<?php echo $controlador->inputs->pbx_form_id; ?>
<?php include (new views())->ruta_templates.'botons/submit/alta_bd.php';?>
<div class="error"></div>
