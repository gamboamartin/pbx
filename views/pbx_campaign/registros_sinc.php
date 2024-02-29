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
                        <?php echo $controlador->inputs->name; ?>
                        <?php echo $controlador->inputs->datetime_init; ?>
                        <?php echo $controlador->inputs->datetime_end; ?>
                        <?php echo $controlador->inputs->daytime_init; ?>
                        <?php echo $controlador->inputs->daytime_end; ?>

                    </form>
                </div>

            </div>

        </div>
    </div>
</main>














