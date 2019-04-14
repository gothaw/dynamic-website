<!--/View Error Form Message-->
<?php $error = $this->getViewError();
if (isset($error)) { ?>
    <section class="section-padding5">
        <div class="container">
            <div class="error-wrapper">
                <?php echo ucfirst($error); ?>
            </div>
        </div>
    </section>
<?php } ?>
<!--/View Error Form Message-->
