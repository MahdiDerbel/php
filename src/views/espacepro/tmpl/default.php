<div id="login-panel">
	<div class="flip-container">
		<div class="flipper">
			<div class="front front_login panel">
				<form action="<?php echo Router::base();?>user" method="post" class="form-horizontal">
					<input type="hidden" name="task" value="connect" />
					<img src="<?php echo Router::root();?>media/logo.png" />
					<div class="form-group ">
                    	<label class="col-lg-3 control-label"> <?php echo $lang->text('ESP_EMAIL');?> :</label>
      					<div class="col-lg-8" >
                        	<input autofocus="false"  class="form-control required" name="email" placeholder="<?php echo $lang->text('ESP_EMAIL'); ?>" type="text" />
						</div>
						<div class="clear"></div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label"> <?php echo $lang->text('ESP_MOT_PASSE');?> :</label>
						<div class="col-lg-8" >
                        	<input  class="form-control required" name="password" placeholder="<?php echo $lang->text('ESP_MOT_PASSE'); ?>" id="password" type="password" value="" />
						</div>
						<div class="clear"></div>
					</div>
					<div class="valider ">
						<button type="submit" class="btn bouton bg_gold transition right" ><?php echo $lang->text('ESP_IDENTIFIER');?></button>
						<div class="clear"></div>
					</div>
				</form>
			</div>
		
			<div class="message"></div>
         
		</div>
</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function($) {
   
	$('body').on('submit','form',function(){
		var elem=$(this);	
		var $return =true;
		elem.find('.required').each(function(){
				if($.trim($(this).val())=='' || ($(this).attr('name')=='email' && (!IsEmail($(this).val()) ||$(this).hasClass('echec'))) || ($(this).attr('name')=='password' && $(this).val().length<6)){
					$(this).addClass('error');
					$return =false;
				}else{
					$(this).removeClass('error');
					$(this).removeClass('email');
				}
		});
	return $return;
	});
	
	 window.IsEmail=function (email) {
				  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				  return regex.test(email);
				}
});
</script>
