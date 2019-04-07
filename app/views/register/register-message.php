<!--/Register Form Message-->
<?php $error = $this->getViewError(); ?>
<section class="section-padding5">
<?php  if(isset($error)){ ?>
    <div class="container">
        <div class="error-wrapper">
            <?php echo ucfirst($error);?>
        </div>
    </div>
<?php }?>
</section>
<!--/Register Form Message-->
