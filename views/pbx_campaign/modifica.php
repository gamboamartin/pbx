<?php /** @var  \gamboamartin\facturacion\controllers\controlador_fc_factura $controlador  controlador en ejecucion */ ?>
<?php use config\views; ?>

<main class="main section-color-primary">
    <div class="container">

        <div class="row">

            <div class="col-lg-12">

                <div class="widget  widget-box box-container form-main widget-form-cart" id="form">

                    <form method="post" action="<?php echo $controlador->link_modifica_bd; ?>" class="form-additional">
                        <?php include (new views())->ruta_templates."head/title.php"; ?>
                        <?php include (new views())->ruta_templates."head/subtitulo.php"; ?>
                        <?php include (new views())->ruta_templates."mensajes.php"; ?>
                        <?php echo $controlador->inputs->codigo; ?>
                        <?php echo $controlador->inputs->descripcion; ?>
                        <?php echo $controlador->inputs->name; ?>
                        <?php echo $controlador->inputs->datetime_init; ?>
                        <?php echo $controlador->inputs->datetime_end; ?>
                        <?php echo $controlador->inputs->daytime_init; ?>
                        <?php echo $controlador->inputs->daytime_end; ?>
                        <?php echo $controlador->inputs->retries; ?>
                        <?php echo $controlador->inputs->queue; ?>
                        <?php echo $controlador->inputs->script; ?>
                        <?php include (new views())->ruta_templates.'botons/submit/modifica_bd.php';?>

                    </form>
                </div>

            </div>

        </div>
    </div>

    <div class="container partidas">
        <div class="row">
            <div class="col-lg-12">
                <div class="widget  widget-box box-container form-main widget-form-cart" id="form">
                    <div class="widget-header" style="display: flex;justify-content: space-between;align-items: center;">
                        <h2>Filtros</h2>
                    </div>
                    <form method="post" action="<?php echo $controlador->link_sincroniza_datos; ?>" class="form-additional" id="frm-partida">
                        <div class="control-group col-sm-6">
                            <label class="control-label" for="contrato_id">Contrato ID</label>
                            <div class="controls">
                                <input type="text" name="contrato_id" class="form-control"  id="contrato_id" placeholder="Contrato ID" title="Contrato ID">
                            </div>
                        </div>
                        <div class="control-group col-sm-6">
                            <label class="control-label" for="plaza_descripcion">Plaza Descripcion</label>
                            <div class="controls">
                                <input type="text" name="plaza_descripcion" class="form-control"  id="plaza_descripcion" placeholder="Plaza Descripcion" title="Plaza Descripcion">
                            </div>
                        </div>
                        <div class="control-group col-sm-6">
                            <label class="control-label" for="contrato_contrato">Contrato</label>
                            <div class="controls">
                                <input type="text" name="contrato_contrato" class="form-control"  id="contrato_contrato" placeholder="Contrato" title="Contrato">
                            </div>
                        </div>
                        <!--<div class="control-group col-sm-6">
                            <label class="control-label" for="contrato_fecha_validacion">Fecha Inicio Validacion</label>
                            <div class="controls">
                                <input type="date" name="contrato_fecha_validacion_inicio" class="form-control"  id="contrato_fecha_validacion" placeholder="Inicio Fecha Validacion" title="Fecha Validacion">
                            </div>
                        </div>
                        <div class="control-group col-sm-6">
                            <label class="control-label" for="contrato_fecha_validacion">Fecha Fin Validacion</label>
                            <div class="controls">
                                <input type="date" name="contrato_fecha_validacion_fin" class="form-control"  id="contrato_fecha_validacion" placeholder="Fin Fecha Validacion" title="Fecha Validacion">
                            </div>
                        </div>-->
                        <div class="control-group col-sm-6">
                            <label class="control-label" for="contrato_status">Estatus Contrato</label>
                            <div class="controls">
                                <input type="text" name="contrato_status" class="form-control"  id="contrato_status" placeholder="Estatus Contrato" title="Estatus Contrato">
                            </div>
                        </div>
                        <div class="control-group col-sm-12">
                            <label class="control-label" for="contrato_morosidad">Morosidad Contrato</label>
                            <div class="controls">
                                <input type="text" name="contrato_morosidad" class="form-control"  id="contrato_morosidad" placeholder="Morosidad Contrato" title="Morosidad Contrato">
                            </div>
                        </div>

                        <div class="control-group btn-alta">
                            <div class="controls">
                                <button type="submit" class="btn btn-success" value="modifica" name="btn_action_next" id="btn-alta-partida">Ejecuta Filtro</button><br>
                            </div>
                        </div>

                    </form>
                </div>

            </div>

        </div>
    </div>
</main>













