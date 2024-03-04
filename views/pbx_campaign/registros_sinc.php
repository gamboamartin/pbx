<?php /** @var  \gamboamartin\pbx\controllers\controlador_pbx_campaign $controlador  controlador en ejecucion */ ?>
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
                        <?php echo $controlador->inputs->name; ?>
                        <?php echo $controlador->inputs->datetime_init; ?>
                        <?php echo $controlador->inputs->datetime_end; ?>
                        <?php echo $controlador->inputs->daytime_init; ?>
                        <?php echo $controlador->inputs->daytime_end; ?>
                        <?php include (new views())->ruta_templates.'botons/submit/modifica_bd.php';?>
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
                        <h2>Registros</h2>
                    </div>

                    <div class="table-responsive">
                        <table id="table-gt_autorizantes" class="table mb-0 table-striped table-sm ">
                            <thead>
                            <tr>
                                <?php foreach ($controlador->registros_call['columnas'] as $registro){?>
                                    <th data-breakpoints="xs sm md" data-type="html" ><?php echo $registro; ?></th>
                                <?php } ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($controlador->registros_call['registros'] as $registro){?>
                                <tr>
                                <?php foreach ($registro as $campo => $valor){?>
                                    <?php foreach ($controlador->registros_call['columnas'] as $columna){?>
                                        <?php if($campo === $columna){?>

                                                <td><?php echo $valor; ?></td>
                                        <?php } ?>
                                    <?php }?>
                                <?php }?>
                                </tr>
                            <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>














