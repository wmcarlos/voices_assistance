<?php 
    $nonce = wp_create_nonce('voa_assistance_ajax');
	
?>	


	<!--FECHA -->
<table width="50%" align="center"> 
	<tr>
		<td>
			<p>
				<span>Fecha:</span>
				<br>
				<input value="" placeholder="DD/MM/YY" type="text" id="voa_date_assistance" name="voa_date_assistance">
			</p>
		</td>
		<td>
			<p>
				<span>Tipo de Evento:</span>
				<br>
				<select id="voa_event_type" name="voa_event_type">
					<option  value="ENSAYO">Ensayo</option>
					<option  value="ASAMBLEA">Asamblea</option>
				</select>
			</p>
		</td>
		<td>
			<input type="button" id="voa_assistence_filtrar" value="Filtrar" class="button button-primary">	
		</td>
	</tr>
</table>

<div id="voa_ajax_message" style="font-size:25px; font-weight:bold; padding:5px; background-color:#ccc; display:none;"></div>
<br>
<div id="div-filter-tab">
<table id="table-filter-assistance">
</div>
<script type="text/javascript">
  	var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";

  	jQuery(document).ready(function($){
		jQuery("#voa_assistence_filtrar").click(function(){
			$("#div-filter-tab").html("");
				$("#voa_ajax_message").text("Cargando Asistencia....").show(100);
	              var date = $("#voa_date_assistance").val();
	              var event = $("#voa_event_type").val();

	              var data = {
	                'action': 'voa_assistance_ajax',
	                _ajax_nonce : "<?php echo $nonce; ?>",
	                'voa_date_assistance':$("#voa_date_assistance").val(),
	                'voa_event_type':$("#voa_event_type").val()
	             };	             
	             $("#voa_ajax_message").val('Cargando Asisentes....').fadeIn(500);
	          		jQuery.post(ajaxurl, data, function(response) {
	           			$("#div-filter-tab").html(response);
	           			$("#voa_ajax_message").delay(1000).hide(100);
	           			console.log(response);
	          	 	});

	        });
	});

</script>