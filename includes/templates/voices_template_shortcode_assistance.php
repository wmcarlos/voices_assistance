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

<div id="voa_ajax_message"></div>
<div id="div-filter-tab">
<table id="table-filter-assistance">
		<h4>Registro de Asistencia de 35 Coristas</h4>
			<tr>
				<th>RUT</th>
				<th>NOMBRE</th>
				<th>CUERDA</th>
				<th>ASISTE</th>
				<th>JUSTIFICA</th>
			</tr>
			<tbody>
				<tr>
					<td>17188576-0</td>
					<td>Acosta Aguirre Andrea Eugenia</td>
					<td>Soprano</td>
					<td>
					
					<select name="" id="">
						<option value="Si">Si</option>
						<option value="No">No</option>
					</select>				
					
					</td>
					
					<td>
					<input type="checkbox" name="" id=""></input>
					</td>
				</tr>
			</tbody>		
		</table>
</div>
<script type="text/javascript">
  	var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";

  	jQuery(document).ready(function($){
		jQuery("#voa_assistence_filtrar").click(function(){
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
	           			console.log(response);
	          	 	});

	        });
	});

</script>