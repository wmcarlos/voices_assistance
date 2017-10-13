<?php 
    $nonce = wp_create_nonce('voa_assistance_ajax');
	
?>	


	<!--FECHA -->
<table width="50%" align="center"> 
	<tr>
		<td colspan="3" align="center"><b>Todos los Dias Marcados con <i style="color:green">Verde</i> Tiene Pagos Realizados!!!</b></td>
	</tr>
	<tr>
		<td>
			<p>
				<span>Fecha Desde:</span>
				<br>
				<input value="" placeholder="DD/MM/YY" type="text" id="voa_date_assistance" name="voa_date_assistance">
			</p>
		</td>
		<td>
			<p>
				<span>Fecha Hasta:</span>
				<br>
				<input value="" placeholder="DD/MM/YY" type="text" id="voa_date_until_assistance" name="voa_date_until_assistance">
			</p>
		</td>
		<!--<td>
			<p>
				<span>Tipo de Evento:</span>
				<br>
				<select id="voa_event_type" name="voa_event_type">
					<option  value="ENSAYO">Ensayo</option>
					<option  value="ASAMBLEA">Asamblea</option>
				</select>
			</p>
		</td>-->
		<td>
			<input type="button" id="voa_assistence_filtrar" value="Filtrar" class="button button-primary">	
		</td>
	</tr>
</table>

<div id="voa_ajax_message" style="font-size:25px; font-weight:bold; padding:5px; background-color:#ccc; display:none;"></div>
<br>
<div id="div-filter-tab">
<table id="table-filter-assistance">
</table>
</div>
<script type="text/javascript">
  	var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
  	<?php
		$args = [
					'post_type' => 'voa_cpt_assistence',
					'orderby' => 'asc'
				];

				$loop = new WP_Query($args);
				$strdate = "";
				while($loop->have_posts()){
					$loop->the_post();

					$data = get_post_meta(get_the_id(),'voa_event_date_assistance');
					$arrd = $data[0];
					$strdate.="'".$data[0]."',";
					
		}
	?>

  	jQuery(document).ready(function($){
  		//datepiker
  		 $("#voa_date_assistance,#voa_date_until_assistance").datepicker({
	        dateFormat: 'dd-mm-yy',
	        changeMonth : true,
	        changeYear : true,
	        beforeShowDay : function(date){

	        	var pdate = new Array(<?php print $strdate; ?>);

				var d = ("0" + date.getDate()).slice(-2)+"-"+("0" + (date.getMonth()+1)).slice(-2)+"-"+date.getFullYear();

				for(i = 0; i < pdate.length; i++){
					//console.log(pdate[i]+"="+d);
					if(pdate[i] == d){
						console.log(pdate[i]+" == "+d);
						return [true,"Highlighted","Existen Pagos Registrados!!"];
					}
				}
				return [true,""];
	        }

	     });



  		//filtros
		jQuery("#voa_assistence_filtrar").click(function(){
			$("#div-filter-tab").html("");
				$("#voa_ajax_message").text("Cargando Eventos....").show(100);
	              var date = $("#voa_date_assistance").val();
	              var event = $("#voa_event_type").val();

	              var data = {
	               // 'action': 'voa_assistance_ajax',
	               	'action':'voa_all_date_assistance',
	                _ajax_nonce : "<?php echo $nonce; ?>",
	                'voa_date_assistance':$("#voa_date_assistance").val(),
	                'voa_date_until_assistance':$("#voa_date_until_assistance").val()
	               // 'voa_event_type':$("#voa_event_type").val()
	             };	             
	             $("#voa_ajax_message").val('Cargando Asisentes....').fadeIn(500);
	          		jQuery.post(ajaxurl, data, function(response) {
	           			$("#div-filter-tab").html(response);
	           			$("#voa_ajax_message").delay(1000).hide(100);
	           			console.log(response);
	          	 });

	        });
			jQuery(document).on('click','.voa_buscar_ajax',function(){
				$("#voa_ajax_message").text("Cargando Asisentes...");
				idevent = $(this).attr('idevent');
				$("#div-filter-tab").html("");
	              var data = {
	               	'action': 'voa_assistance_ajax',
	                _ajax_nonce : "<?php echo $nonce; ?>",
	                'idevent':idevent
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