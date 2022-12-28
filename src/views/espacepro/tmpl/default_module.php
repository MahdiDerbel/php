<?php require_once('head.php'); ?>

<div class="backoffice">
<div class="return_backoffice">
                  <a href="<?php echo Router::base().'admin-module?id_produit='.$this->id_produit; ?>" class="transition btn btn-success right" >
                        <i class="fa fa-arrow-left"></i>
                        <?php echo $lang->text('ESP_RETURN_TO_LIST'); ?>
                    </a>
                </div>
                <br clear="all" />
	<section class="  panel">
		<h1  class="left">Date dernière soumission: <?php if($this->dateInsert) echo $this->dateInsert->date; ?></h1>
		<div class="clear"></div>
		<h1 class="titre-module"><?php echo $this->module[$this->id]->nom;  ?>    <a href="<?php echo Router::base().'admin-import?id=' .$this->id.'&id_produit='.$this->id_produit; ?>" class="transition btn btn-success " style="margin-left: 20px;font-size: 20px;" >
                         Importer
                    </a></h1>

		<hr>
		<div class="bloc2">
			<?php if ($this->chapitre > 0) {
				foreach ($this->chapitre as $k => $m) {

			?>
					<div class="margin<?php echo $m->parent; ?>"><a class="btn btn-warning " href="<?php echo Router::base() . 'admin-detailsmodule?id_produit='.$this->id_produit.'&id=' . $m->id; ?>"><?php echo $m->nom; ?></a></div>
			<?php }
			} ?>
		</div>
		<div class="clear"></div>
	</section>
	<div class="clear"></div>
</div>