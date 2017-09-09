	
	<!--FECHA -->
<table width="50%" align="center"> 
	<tr>
		<td>
			<p>
				<span>Fecha Desde:</span>
				<br>
				<input value="" placeholder="DD/MM/YY" type="text" id="voa_date_from" name="voa_date_from">
			</p>
		</td>
		<td>
			<p>
				<span>Fecha Hasta:</span>
				<br>
				<input value="" placeholder="DD/MM/YY" type="text" id="voa_date_to" name="voa_date_to">
			</p>
		</td>
		<td>
			<input type="button" id="voa_payment_filtrar" value="Filtrar" class="button button-primary">	
		</td>
	</tr>
</table>


<table width="100%" cellspacing="1" cellpadding="1"  id="voa_table_assistence">
<caption>Listado de Pagos Realizados</caption>
<thead>
<tr>
<th align="right" style="vertical-align: middle;border-right:1px solid #b9c9fe;border-left:1px solid #b9c9fe;">NOMBRE</th><th align="right" style="vertical-align: middle;border-right:1px solid #b9c9fe;border-left:1px solid #b9c9fe;">FECHA DE PAGO</th><th align="center" style="vertical-align: middle;border-right:1px solid #b9c9fe;border-left:1px solid #b9c9fe;">TIPO DE PAGO</th><th align="center" style="vertical-align: middle;border-right:1px solid #b9c9fe;border-left:1px solid #b9c9fe;">MONTO</th></tr>
</thead>
<tbody id="load_data">
</tbody>
</table>
<script type="text/javascript">
	jQuery(document).ready(function(){

		jQuery("#voa_payment_filtrar").click(function(){
			var url = "<?php print admin_url('admin-ajax.php'); ?>";

			var data = {
				action : 'voa_filter_payment',
				'date_from': jQuery("#voa_date_from").val(),
				'date_to': jQuery("#voa_date_to").val()
			}

			jQuery.post(url,data,function(response){
				jQuery("#load_data").html(response);
			});
		});

	});
</script>