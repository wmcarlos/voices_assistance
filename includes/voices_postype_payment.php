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
			'ID' => $_REQUEST['voa_ids'],
			'assist'=> $_REQUEST['assist'],
			'justify'=> $_REQUEST['justify']
		);
		update_post_meta($post,'voa_payment',$data);
	}

//template
function voa_mtbx_paymentx_callback($post){
	$voa_users = get_users();
	$voa_meta = get_post_meta($post->ID,'voa_payment');
	//print_r($voa_meta);
?>

<table width="100%" cellspacing="1" cellpadding="1"  id="voa_table_payment">
<caption>Registro de Pago de 35 Coristas</caption>
<thead>
<tr>
<th align="right" style="vertical-align: middle;border-right:1px solid #b9c9fe;border-left:1px solid #b9c9fe;">RUT</th><th align="right" style="vertical-align: middle;border-right:1px solid #b9c9fe;border-left:1px solid #b9c9fe;">NOMBRE</th><th align="right" style="vertical-align: middle;border-right:1px solid #b9c9fe;border-left:1px solid #b9c9fe;">CUERDA</th><th align="right" style="vertical-align: middle;border-right:1px solid #b9c9fe;border-left:1px solid #b9c9fe;">ASISTE</th><th align="center" style="vertical-align: middle;border-right:1px solid #b9c9fe;border-left:1px solid #b9c9fe;">JUSTIFICA</th></tr>
</thead>
<tbody>
<?php 
$i=0;
foreach ($voa_users as $key) { 
	if($key->roles[0]=='subscriber'){
?>
<tr>
	<input type="hidden" name="voa_ids[]" value="<?php echo $key->data->ID; ?>">
	<td align="center" width="10%">17188576-0</td>
	<td align="left" width="30%"><?php echo $key->data->display_name; ?></td>
	<td align="center" width="5%">Soprano</td>
	<td width="5%">
	<select id="assist" name="assist[]">
		<option <?php selected($voa_meta[0]['assist'][$i],'S'); ?> value="S">Si</option>
		<option <?php selected($voa_meta[0]['assist'][$i],'N'); ?>  value="N">No</option>
	</select>
	</td>
	<td width="5%" align="right" style="vertical-align: middle;border-right:1px solid #b9c9fe;border-left:1px solid #b9c9fe;">
		<input type="checkbox" <?php checked($voa_meta[0]['justify'][$i],'yes'); ?> name="justify[]" value="yes"  id="justify[]" style="margin:0px">
	</td>
</tr>
<?php 
	$i++;
	} 
}
?>
</tbody>
</table>

	
<?php		
}