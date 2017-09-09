<?php

	add_action('init', 'voa_postype_payment_fn');
	function voa_postype_payment_fn(){
		$labels = array(
			'name' => 'Pagos',
			'singular_name' => 'Pagos',
			'add_new' => 'Registrar Pagos',
			'all_items'=> 'Listar Pagos',
			'add_new_item'=> 'Agregar Nuevo Pago',
			'edit_item' => 'Editar Pago',
			'view_item ' => 'Visualizar Pago',
			'search_item' => 'Buscar Pago',
			'not_found' => 'No Existe el Pago',
			'not_found_in_trash ' => 'No Enlace found in trash',
			'parent_item_colon' => 'Parent Item'
		);
		$args = array(
			'labels'=> $labels,
			'public'=> true,
			'has_archive'=>true,
			'publicly_queryable'=>true,
			'query_var'=>true,
			'rewrite'=>true,
			'capability_type'=>'post',
			'menu_icon' => 'dashicons-list-view',
			'hierarchical' => false,
			'supports'=> array('title'),
			'taxonomies' => array(''),
			'menu_position'=>5,
			'exclude_from_search'=>true
		);
		register_post_type('voa_cpt_payment',$args);
	}
	add_action('add_meta_boxes','voa_mtbx_payment');
	function voa_mtbx_payment()
	{
		add_meta_box('voa_mtbx_payment', 'Datos del Pago','voa_mtbx_paymentx_callback', array('voa_cpt_payment'), 'normal', 'default');
	}
	add_action('save_post','voa_payment_savemetabox');
	function voa_payment_savemetabox($post){

		$data = array(
			'date_payment'=> date_i18n('d-m-Y', strtotime($_REQUEST['date_payment'])),
			'corist'=> $_REQUEST['corist'],
			'payment_type'=> $_REQUEST['payment_type'],
			'count'=> $_REQUEST['count']
		);

		update_post_meta($post,'voa_payment',$data);
	}

//template
function voa_mtbx_paymentx_callback($post){
	$voa_users = get_users();
	$voa_meta = get_post_meta($post->ID,'voa_payment');
?>

<table width="100%" cellspacing="1" cellpadding="1"  id="voa_table_payment">
<tbody>
<tr>
	<td>Fecha:</td>
	<td><input type="text" value="<?php print $voa_meta[0]['date_payment']; ?>" id="voa_date_payment" name="date_payment"></td>
</tr>
<tr>
	<td>Corista:</td>
	<td><input type="text" value="<?php print $voa_meta[0]['corist']; ?>" id="users" name="corist"></td>
</tr>
<tr>
	<td>Tipo de Pago:</td>
	<td><select name="payment_type" id="payment_type">
			<option value="">Seleccione</option>
			<?php 
				$args = [
					'post_type' => 'voa_cpt_payment_type',
					'orderby' => 'asc',
				];

				$loop = new WP_Query($args);

				while($loop->have_posts()){
					$loop->the_post();
					$data = get_post_meta(get_the_id(), 'voa_payment_type');
					$arrData = $data[0];
					?>
					<option data-price='<?php print $arrData['price']; ?>' data-fixed='<?php print $arrData['fixed']; ?>' value='<?php print get_the_id(); ?>'><?php the_title(); ?></option>
					<?php
				}
			?>
	</select></td>
</tr>
<tr>
	<td>Cantidad</td>
	<td><input type="text" value="<?php print $voa_meta[0]['count']; ?>" name="count" id="count"></td>
</tr>
</tbody>
</table>
<script>
	jQuery(document).ready(function(){

		<?php 
			if(isset($voa_meta[0]['payment_type']) and !empty($voa_meta[0]['payment_type'])){
		?>
			jQuery("#payment_type").val("<?php print $voa_meta[0]['payment_type']; ?>");
		<?php

			}
		?>


		var availableTags = [
			<?php 
				foreach ($voa_users as $key) { 
					if($key->roles[0]=='subscriber'){	
						$ctem++;
					}
				}

				$count = 0;

				foreach ($voa_users as $key) { 
					if($key->roles[0]=='subscriber'){	
						$count++;
						if($count < $ctem){
							print "'".$key->data->display_name."',";
						}else{
							print "'".$key->data->display_name."'";
						}

					}
				}
			?>
	    ];

	    jQuery( "#users" ).autocomplete({
	      source: availableTags
	    });

	    jQuery("#payment_type").change(function(){
	    	var price = jQuery(this).find(':selected').attr("data-price");
	    	var fixed = jQuery(this).find(':selected').attr("data-fixed");
	    	
	    	if(fixed == 'Y'){
	    		jQuery("#count").attr("readonly","readonly").val(price);
	    	}else{
	    		jQuery("#count").removeAttr("readonly").val(price);
	    	}
	    });
	});
</script>
<?php		
}