<div id="login-panel">
<div class="flip-container   ">
<div class="flipper">
<div class="front front_login panel">
<img src="<?php echo Router::base();?>media/logo.png" />
<form action="<?php echo Router::base();?>user" method="post" class="form-horizontal">

<?php if(!$this->run){?>
	<div class="message inline">
    	<div class="warning">
        	<?php echo $lang->text('SITE_LIEN_EXPIRED');?>
        </div>
    </div>
<?php }else{?>
   <input type="hidden" name="task" value="resetpassword" />    
   <input type="hidden" name="code" value="<?php echo base64_encode($code[0]);?>"/> 
 <div class="form-group ">
    
        <label class="col-lg-3 control-label"> <?php echo $lang->text('ESP_NOUVELLE_MOT_PASSE');?> :</label>
      <div class="col-lg-8" > <input class="form-control" name="password1" type="text" />
      </div>
        <div class="clear"></div>
      
 </div>

    <div class="form-group">
        <label class="col-lg-3 control-label"> <?php echo $lang->text('ESP_REPETER_PASSWORD');?> :</label>
      <div class="col-lg-8" >   <input  class="form-control" name="password2" type="text" value="" />
      </div>
        <div class="clear"></div>
     </div>

	<div class="valider ">
    <button type="submit" class="btn bouton bg_gold transition" ><?php echo $lang->text('SITE_ENVOYER');?></button>
    
    </div>
    <script type="text/javascript">
	jQuery(document).ready(function($) {
        $('body').on('submit','form',function(){
			if($('[name=password1]').val()==$('[name=password2]').val() && $.trim($('[name=password2]').val())!=''){
				$(this).find('input[type=text]').removeClass('error');
				return true;
			}else{
				$(this).find('input[type=text]').addClass('error');
			return false;	
			}
		});
    });
	</script>
    <?php }?>
</form>
</div></div></div></div>
<div class="clear"></div>