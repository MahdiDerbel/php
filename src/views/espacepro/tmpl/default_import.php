<?php require_once('head.php');?>
<div class="backoffice">
	<section class="  panel">
  <form action="<?php echo Router::base(); ?>espacepro" method="POST" enctype="multipart/form-data" id="form_login" autocomplete="off" class="form-horizontal">	
  <input type="hidden" name="id_module" value="<?php echo $this->id; ?>"/> 
  <input type="hidden" name="id_chapitre" value="<?php echo $this->id_chapitre; ?>"/>	
  <input type="hidden" name="id_produit" value="<?php echo $this->id_produit; ?>"/>	
  <div class="col-md-6">
                                <div class="input-group">
                                  <span class="input-group-addon">fichier</span>
								                            <input type="file" name="fichier" class="validate[required] left" id="media_input" style="display:none">
                          <input type="button" id="selectfile" name="selectfile" value="<?php echo $lang->text('ESP_UPLOAD');?>" class="upload_images left btn btn-sm btn-success">
                          <div id="imageuploded" class="right"></div>
                                </div>
                           
                            </div><div class="clear"></div><hr><div class="clear"></div>
	                <input  class="right bouton  btn btn-warning btn-sm"  id="valider" type="button"  value="<?php echo $lang->text('ESP_SAVE'); ?>" />   
		<?php if($this->id>0){ ?> <a class="btn btn-danger btn-sm double right" href='<?php echo Router::base()."admin-module?id_produit=".$this->id_produit."&id=".$this->id;?>' ><?php echo $lang->text('ESP_CANCEL');?></a><?php }else{ ?>
      <a class="btn btn-danger btn-sm double right" href='<?php echo Router::base()."admin-detailsmodule?id_produit=".$this->id_produit."&id=".$this->id_chapitre;?>' ><?php echo $lang->text('ESP_CANCEL');?></a>
      <?php } ?>
      <div id="loader"></div>
<div class="clear"></div>
</form>
</section>
<div class="clear"></div>	
</div>
<script type="text/javascript">
jQuery(document).ready(function($) {

$('body').on('click','#valider',function(){	
var $return=true;
if( document.getElementById("media_input").files.length == 0 ){
  $return=false;
}		
if(!$return){alert("Echec d'envoie");}
else{
	//save 
	var form_data = new FormData($('#form_login')[0]);
$('#loader').html('<div class="lds-ring"><div></div><div></div><div></div><div></div></div>');
 <?php if($this->id_chapitre==0) { ?>                    
            $.ajax({
              type: 'POST',
              url: 'http://localhost:4557/submit/',
              data: form_data,
              contentType: false,
              cache: false,
              processData: false,
              async: true,
              success: function (dataa) {
                var test=JSON.stringify(dataa);
                $.ajax({
                   type: 'POST',
                    url: '<?php echo Router::base();?>espacepro?task=saveligneficher&id_module=<?php echo $this->id; ?>&id_produit=<?php echo $this->id_produit; ?>&dataa='+JSON.stringify(dataa),
                  asynch : true ,
                  cache: false,
                  contentType: false,
                   processData: false, 
                   success: function (a) {                    
                    $('#loader').remove();
                if(parseInt(a)==1)window.location.href="<?php echo Router::base() . 'admin-module?id_produit='.$this->id_produit.'&id='.$this->id; ?>";
          else{window.location.href="<?php echo Router::base() . 'admin-detailsmodule?id_produit='.$this->id_produit.'&id='.$this->id_chapitre; ?>";}
                  },
               });
              },
          });
   
      <?php }else{?> 
        $.ajax({
				type:'POST',
				url: '<?php echo Router::base();?>espacepro?task=saveficher'
        ,	data: form_data,
				contentType: false,
				processData: false,
				success: function(e){
          if(parseInt(e)==1)window.location.href="<?php echo Router::base() . 'admin-module?id_produit='.$this->id_produit.'&id='.$this->id; ?>";
          else{window.location.href="<?php echo Router::base() . 'admin-detailsmodule?id_produit='.$this->id_produit.'&id='.$this->id_chapitre; ?>";}
                  },
        });
        <?php } ?>
	 // Predict
 
        // Make prediction by calling api /predict
     /* $.ajax({
            type: 'POST',
            url: 'https://auscultation.herokuapp.com/predict/',
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            async: true,
            success: function (data) {
                // Get and display the result
                $('.loader').hide();
                $('#result').fadeIn(600);
				if(data=="Sain"){$('.rep').html('Vous êtes en bonne santé ');}
				else{$('.rep').html('Votre maladie est : ' + data);}
                 jQuery('#modal-name').show() ;
                console.log('Success!');
            },
        });*/
	}
});});
</script>