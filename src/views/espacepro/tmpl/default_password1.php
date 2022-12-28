
<form action="<?php echo Router::base();?>user" method="post" class="form-horizontal">
<input type="hidden" name="task" value="forgetpassword" />
<img src="<?php echo Router::root();?>media/logo.png" />
        
 <div class="form-group ">
    
        <label class="col-lg-3 control-label"> <?php echo $lang->text('ESP_EMAIL');?> :</label>
      <div class="col-lg-8" > <input autofocus="false"  class="form-control required" name="email" placeholder="<?php echo $lang->text('ESP_EMAIL'); ?>" type="text" />
      </div>
        <div class="clear"></div>
      
 </div>

    
	<div class="valider ">
    <div class="backpanel left "><i class="fa fa-arrow-left"></i> <?php echo $lang->text('ESP_CANCEL');?></div>
    <button type="submit" class="btn bouton bg_gold transition right" ><?php echo $lang->text('ESP_ENVOYER');?></button>
    <div class="clear"></div>
    </div>
</form>
