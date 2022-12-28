<?php require_once('head.php');?>
<div class="backoffice">
<div class="return_backoffice">
                  <a href="<?php echo Router::base().'admin-dossier'; ?>" class="transition btn btn-success right" >
                        <i class="fa fa-arrow-left"></i>
                        <?php echo $lang->text('ESP_RETURN_TO_LIST'); ?>
                    </a>
                </div>
                <br clear="all" />
	<section class=" cnopt panel">

<div class="bloc2"><img src="<?php echo Router::root(); ?>media/image.png" alt="" usemap="#workmap" /></div>
<div class="bloc2">
<?php if($this->module>0){ foreach($this->module as $k=>$m){

 ?>
<a class="btn btn-small " style="background:<?php echo $m->color; ?>" href="<?php echo Router::base().'admin-module?id_produit='.$this->id_produit.'&id='.$k; ?>"><?php echo $m->nom ; ?></a>
<?php }} ?>
</div>
<div class="clear"></div>
</section>
<div class="clear"></div>	
</div>
