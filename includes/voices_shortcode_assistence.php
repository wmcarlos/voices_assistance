<?php

	
	add_action('wp_ajax_voa_assistance_ajax','voa_assistance_ajax_callback');
	add_action("wp_ajax_nopriv_voa_assistance_ajax","voa_assistance_ajax_callback");

	function voa_checked_assistence_ajax($pid){
		$voa_meta = get_post_meta($pid,'voa_assistence');
		if(!isset($_GET['action'])){
			$voa_meta[0]['assist'][0] = '';
			$voa_meta[0]['justify'][0] = '';
		}
		return $voa_meta;
	}
	function voa_assistance_ajax_callback(){
		check_ajax_referer("voa_assistance_ajax");
		/*$args = array(
		    'post_type' => 'voa_cpt_assistence',
		 );
		$date_temp =  date_i18n('d-m-Y', strtotime($_REQUEST['voa_date_assistance'])); 
		$the_query = new WP_Query( $args );
		 while ( $the_query->have_posts() ) : $the_query->the_post();
		 	$voa_date_assistance = get_post_meta(get_the_id(),'voa_event_date_assistance');
		 	$voa_date_assistance =  date_i18n('d-m-Y', strtotime($voa_date_assistance));
		 	if($date_temp==$voa_date_assistance){
		 		

		 	}
		 endwhile;*/
	$voa_users = get_users();
	$voa_meta = voa_checked_assistence_ajax(get_the_id());



?>

<table width="100%" cellspacing="1" cellpadding="1"  id="table-filter-assistance">
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
	wp_die( );
}
	
	add_shortcode("voa_assistence","voa_assistence_short_fn");
	function voa_assistence_short_fn(){
		include_once("templates/voices_template_shortcode_assistance.php");
	}

