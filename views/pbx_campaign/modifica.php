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
                            <label class="control-label" for="plaza_descripcion">Plaza Descripcion</label>
                            <div class="controls">
                                <input type="text" name="plaza_descripcion" class="form-control"  id="plaza_descripcion" placeholder="Plaza Descripcion" title="Plaza Descripcion">
                            </div>
                        </div>
                        <div class="control-group col-sm-6">
                            <label class="control-label" for="contrato_status">Contrato Status</label>
                            <div class="controls">
                                <input type="text" name="contrato_status" class="form-control"  id="contrato_status" placeholder="Contrato Status" title="Contrato Status">
                            </div>
                        </div>
                        <?php //echo $controlador->select_status; ?>
                        <div class="control-group col-sm-6">
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
                        </div>
                        <div class="control-group col-sm-12">
                            <label class="control-label" for="plaza_descripcion">Contrato Morosidad</label>
                            <div class="controls">
                                <input type="text" name="contrato_morosidad" class="form-control"  id="contrato_morosidad" placeholder="Contrato Morosidad" title="Contrato Morosidad">
                            </div>
                        </div>

                        <?php //echo $controlador->select_morosidad; ?>

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
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="widget widget-box box-container widget-mylistings">
                    <div class="widget-header"
                         style="display: flex;justify-content: space-between;align-items: center;">
                        <h2>Ultimo</h2>
                    </div>

                    <div class="table-responsive">
                        <table id="table-gt_autorizantes" class="table mb-0 table-striped table-sm ">
                            <thead>
                            <tr>
                                <th data-breakpoints="xs sm md" data-type="html" >Id</th>
                                <th data-breakpoints="xs sm md" data-type="html" >Offset</th>
                                <th data-breakpoints="xs sm md" data-type="html" >Limite</th>
                                <th data-breakpoints="xs sm md" data-type="html" >Sentencia</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($controlador->registros_ultimo as $registro){?>
                                <tr>
                                    <td><?php echo $registro['pbx_ultimo_id']; ?></td>
                                    <td><?php echo $registro['pbx_ultimo_salto']; ?></td>
                                    <td><?php echo $registro['pbx_ultimo_limite']; ?></td>
                                    <td><?php echo $registro['pbx_ultimo_sentencia']; ?></td>
                                </tr>
                            <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
</main>














