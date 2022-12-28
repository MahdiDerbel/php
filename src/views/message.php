<script type="text/javascript" src="<?php echo Router::root().'assets/js/jquery.noty.js';?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Router::root().'assets/css/noty_theme_default.css';?>" />
<link rel="stylesheet" type="text/css" href="<?php echo Router::root().'assets/css/jquery.noty.css';?>" />
<div class="message">
<?php 
/*$params['msg']='Votre session est expirée!';
 $params['type']='warning';*/
if(count($params)>0 && isset($params['msg']) ){?>
<?php /*?>	<div class="<?php switch( $params['type']){
	case 'error': echo 'alert alert-danger';
	break;
	case 'warning':echo 'alert alert-warning alert-block';
	break;
	case 'success': echo 'alert alert-success';
	break;
	default:
	echo ' ';
	break;
}
	?>">
    <button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button>
    <?php echo $params['msg'];?>
    </div><?php */?>
    <script type="text/javascript">
	jQuery(document).ready(function($) {
       	var note=noty({
					text: " <?php echo $params['msg'];?>",
					layout:"topRight",
					type:"<?php echo $params['type'];?>",
					animateOpen:{"height":"toggle"},
					animateClose:{"height":"toggle"},
					speed:500,
					timeout:5000,
					closeButton:false,
					closeOnSelfClick:true,
					closeOnSelfOver:false,
					modal:false
				});
    });
	</script>
<?php }?>

    
    
</div>