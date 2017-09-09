<?php

	add_action('init', 'voa_postype_payment_type_fn');
	function voa_postype_payment_type_fn(){
		$labels = array(
			'name' => 'Tipos de Pagos',
			'singular_name' => 'Tipos de Pagos',
			'add_new' => 'Registrar Tipos de Pagos',
			'all_items'=> 'Listar Tipos de Pagos',
			'add_new_item'=> 'Agregar Nuevo Tipo de Pago',
			'edit_item' => 'Editar Tipo de Pago',
			'view_item ' => 'Visualizar Tipo de Pago',
			'search_item' => 'Buscar Tipo de Pago',
			'not_found' => 'No Existe el Tipo Pago',
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
		register_post_type('voa_cpt_payment_type',$args);
	}
	add_action('add_meta_boxes','voa_mtbx_payment_type');
	function voa_mtbx_payment_type()
	{
		add_meta_box('voa_mtbx_payment_type', 'Datos del Tipo de Pago','voa_mtbx_payment_typex_callback', array('voa_cpt_payment_type'), 'normal', 'default');
	}
	add_action('save_post','voa_payment_type_type_savemetabox');

	function voa_payment_type_type_savemetabox($post){
		$data = array(
			'price'=> $_REQUEST['price'],
			'fixed'=> $_REQUEST['fixed']
		);

		update_post_meta($post,'voa_payment_type',$data);
	}

//template
function voa_mtbx_payment_typex_callback($post){
	$voa_payment_type = get_post_meta($post->ID,'voa_payment_type');
	//print_r($voa_payment_type);
?>

<table width="100%" cellspacing="1" cellpadding="1"  id="voa_table_payment_type">
<tbody>
<tr>
	<td>Precio:</td>
	<td><input type="text" value="<?php print $voa_payment_type[0]['price']; ?>" name="price"></td>
</tr>
<tr>
	<td>Fijo:</td>
	<td><input type="checkbox" value='Y' <?php if($voa_payment_type[0]['fixed'] =='Y'){ print "checked='checked'"; } ?> name="fixed"></td>
</tr>
</tbody>
</table>

	
<?php		
}