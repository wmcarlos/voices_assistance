<?php

	
	add_action('wp_ajax_voa_assistance_ajax','voa_assistance_ajax_callback');
	add_action("wp_ajax_nopriv_voa_assistance_ajax","voa_assistance_ajax_callback");

	function voa_checked_assistence_ajax($pid){
		$voa_meta = get_post_meta($pid,'voa_assistence');
		return $voa_meta;
	}
	function voa_assistance_ajax_callback(){
		check_ajax_referer("voa_assistance_ajax");
		$cont_coristas = 0;
		$args = array(
		    'post_type' => 'voa_cpt_assistence',
		 );
		$voa_title_assistance = 'No se encontraron resultados';
		$date_temp =  date_i18n('d-m-Y', strtotime($_REQUEST['voa_date_assistance'])); 
		$temp_event_type = $_REQUEST['voa_event_type'];

		$the_query = new WP_Query( $args );
		 while ( $the_query->have_posts() ) : $the_query->the_post();
		 	$voa_date_assistance = get_post_meta(get_the_id(),'voa_event_date_assistance');
		 	$voa_event_type = get_post_meta(get_the_id(),'voa_event_type_assistance');
		 	$voa_date =  date_i18n('d-m-Y', strtotime($voa_date_assistance[0]));
		 	if($date_temp==$voa_date && $temp_event_type == $voa_event_type[0]){
		 		$voa_title_assistance = get_the_title();
		 		$voa_users = get_users();
				$voa_meta = voa_checked_assistence_ajax(get_the_id());	
		 	}
		 endwhile;
		// print_r($voa_meta);
?>

<h2>
	Evento: <?php echo $voa_title_assistance; ?>
	<?php if($voa_title_assistance!='No se encontraron resultados'){ ?>
	<br>
	Fecha: <?php echo $date_temp; }
	?>

</h2>
<table width="100%" cellspacing="1" cellpadding="1"  id="table-filter-assistance">
<thead>
<tr>
<th align="right" style="vertical-align: middle;border-right:1px solid #b9c9fe;border-left:1px solid #b9c9fe;">RUT</th><th align="right" style="vertical-align: middle;border-right:1px solid #b9c9fe;border-left:1px solid #b9c9fe;">NOMBRE</th><th align="right" style="vertical-align: middle;border-right:1px solid #b9c9fe;border-left:1px solid #b9c9fe;">CUERDA</th><th align="right" style="vertical-align: middle;border-right:1px solid #b9c9fe;border-left:1px solid #b9c9fe;">ASISTE</th><th align="center" style="vertical-align: middle;border-right:1px solid #b9c9fe;border-left:1px solid #b9c9fe;">JUSTIFICA</th></tr>
</thead>
<tbody>
<?php 
$i=0;
foreach ($voa_users as $key) { 
	if($key->roles[0]=='subscriber'  || $key->roles[0]=='usuario'){	
		$cont_data = 0;
		$rut = get_user_meta($key->data->ID,'wpcf-rut-usuario',true);
		$cuerda = get_user_meta($key->data->ID,'wpcf-cuerda-usuario',true);
?>
<tr>
	<input type="hidden" name="voa_ids[]" value="<?php echo $key->data->ID; ?>">
	<td align="center" width="10%"><?php print $rut; ?></td>
	<td align="left" width="30%"><?php echo $key->data->display_name; ?></td>
	<td align="center" width="5%"><?php print $cuerda; ?></td>
	<td width="5%">
	 <?php 
	 	if($voa_meta[0]['assist'][$i]=='S'){
	 		echo 'SI';
			$cont_coristas+=1;

	 	}else{
	 		echo 'NO';
	 	}
	 ?>
	</td>
	<td width="5%" align="right" style="vertical-align: middle;border-right:1px solid #b9c9fe;border-left:1px solid #b9c9fe;">
		<?php 
			if(count($voa_meta[0]['justify']) > 0 ){
			foreach($voa_meta[0]['justify'] as $key_justify){
			if($key_justify==$key->data->ID){
		?>
		<input type="checkbox" checked="checked" disabled="disabled" id="justify"  name="justify[]" value="<?php echo $key->data->ID;  ?>"  id="justify[]" style="margin:0px">
		<?php $cont_data = 1; }}}
			if($cont_data==0){
		?>
		<input type="checkbox"  id="justify" disabled="disabled"  name="justify[]" value="<?php echo $key->data->ID;  ?>"  id="justify[]" style="margin:0px">
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
<h2><b>Total de coristas asistentes: </b> <?php echo $cont_coristas; ?></h2>
<?php
	wp_die( );
}
	
	add_shortcode("voa_assistence","voa_assistence_short_fn");
	function voa_assistence_short_fn(){
		ob_start();
			include_once("templates/voices_template_shortcode_assistance.php");
	    return ob_get_clean();

	}

