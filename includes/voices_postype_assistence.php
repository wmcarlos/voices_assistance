<?php

	add_action('init', 'voa_postype_fn');
	function voa_postype_fn(){
		$labels = array(
			'name' => 'Asistencias',
			'singular_name' => 'Asistencias',
			'add_new' => 'Registrar Asistencias',
			'all_items'=> 'Listar Asistencias',
			'add_new_item'=> 'Agregar Nueva Asistencia',
			'edit_item' => 'Editar Asistencia',
			'view_item ' => 'Visualizar Asistencia',
			'search_item' => 'Buscar Asistencia',
			'not_found' => 'No Existe la Asistencia',
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
		register_post_type('voa_cpt_assistence',$args);
	}
	add_action('add_meta_boxes','voa_mtbx_assistence');
	function voa_mtbx_assistence()
	{
		add_meta_box('voa_mtbx_assistence', 'Datos de asistencia','voa_mtbx_assistencex_callback', array('voa_cpt_assistence'), 'normal', 'default');
	}
	add_action('save_post','voa_assistence_savemetabox');
	function voa_assistence_savemetabox($post){
		$date_event =  date_i18n('d-m-Y', strtotime($_REQUEST['voa_date_assistance']));
		$type_event = $_REQUEST['voa_event_type'];
		$data = array(
			'ID' => $_REQUEST['voa_ids'],
			'assist'=> $_REQUEST['assist'],
			'justify'=> $_REQUEST['justify']
		);
		update_post_meta($post,'voa_assistence',$data);
		update_post_meta($post,'voa_event_date_assistance',$date_event);
		update_post_meta($post,'voa_event_type_assistance',$type_event);
	}

function voa_checked_assistence($post){
	$voa_meta = get_post_meta($post->ID,'voa_assistence');
	if(!isset($_GET['action'])){
		$voa_meta[0]['assist'][0] = '';
		$voa_meta[0]['justify'][0] = '';
	}
	return $voa_meta;
}

//template
function voa_mtbx_assistencex_callback($post){
	$voa_users = get_users();
	$voa_meta = voa_checked_assistence($post);
	$voa_event_date = get_post_meta($post->ID,'voa_event_date_assistance');
	$voa_event_date = date_i18n('d-m-Y', strtotime($voa_event_date[0]));
	$voa_event_type = get_post_meta($post->ID,'voa_event_type_assistance');

?>

<!--FECHA -->
<table width="50%" align="center"> 
	<tr>
		<td>
			<p>
				<span>Fecha:</span>
				<br>
				<input value="<?php echo $voa_event_date;  ?>" type="text" id="voa_date_assistance" name="voa_date_assistance">
			</p>
		</td>
		<td>
			<p>
				<span>Tipo de Evento:</span>
				<br>
				<select id="voa_event_type" name="voa_event_type">
					<option <?php selected($voa_event_type[0],'ENSAYO');  ?>  value="ENSAYO">Ensayo</option>
					<option <?php selected($voa_event_type[0],'ASAMBLEA');  ?> value="ASAMBLEA">Asamblea</option>
				</select>
			</p>
		</td>
	</tr>
</table>


<table width="100%" cellspacing="1" cellpadding="1"  id="voa_table_assistence">
<caption>Registro de Asistencia de 35 Coristas</caption>
<thead>
<tr>
<th align="right" style="vertical-align: middle;border-right:1px solid #b9c9fe;border-left:1px solid #b9c9fe;">RUT</th><th align="right" style="vertical-align: middle;border-right:1px solid #b9c9fe;border-left:1px solid #b9c9fe;">NOMBRE</th><th align="right" style="vertical-align: middle;border-right:1px solid #b9c9fe;border-left:1px solid #b9c9fe;">CUERDA</th><th align="right" style="vertical-align: middle;border-right:1px solid #b9c9fe;border-left:1px solid #b9c9fe;">ASISTE</th><th align="center" style="vertical-align: middle;border-right:1px solid #b9c9fe;border-left:1px solid #b9c9fe;">JUSTIFICA</th></tr>
</thead>
<tbody>
<?php 
$i=0;
foreach ($voa_users as $key) { 
	if($key->roles[0]=='subscriber'){	
		$cont_data = 0;
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
		<?php foreach($voa_meta[0]['justify'] as $key_justify){
			if($key_justify==$key->data->ID){
		?>
		<input type="checkbox" checked="checked" id="justify"  name="justify[]" value="<?php echo $key->data->ID;  ?>"  id="justify[]" style="margin:0px">
		<?php $cont_data = 1; }}
			if($cont_data==0){
		?>
		<input type="checkbox"  id="justify"  name="justify[]" value="<?php echo $key->data->ID;  ?>"  id="justify[]" style="margin:0px">
		<?php } ?>
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