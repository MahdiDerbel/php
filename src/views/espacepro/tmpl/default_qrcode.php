<?php require_once('head.php'); ?>	
<div class="backoffice">

	<section class="panel center"><img src="qrcode/qrcode.php?s=qrh&d=<?php echo $this->qrcode; ?>">
	<div class="clear"></div>
	<div  class=" btn btn-success imprimer right"><span><?php echo $lang->text('IMPRIMER');  ?></span></div>
		<div class="clear"></div>
	</section>  
	
	<div class="clear"></div>
</div>  
<div class="clear"></div>	
	<div class="clear"></div>

<script type="text/javascript">
	jQuery(document).ready(function($) {
   
	jQuery('body').on('click','.imprimer' , function() {
		$('.navbar1').addClass('hide');
		jQuery(".imprimer").css({"display":"none"});
		 
		window.print() ; 
		document.location.href="<?php echo Router::base().'admin-qrcode?qrcode='.$this->qrcode; ?>"
		
	});	});
	
</script>
