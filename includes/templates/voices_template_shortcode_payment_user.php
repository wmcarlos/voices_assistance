<?php if(is_user_logged_in()){
$user = wp_get_current_user();
?>
<h1><?php print $user->display_name; ?></h1>
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
	<?php
		$args = [
					'post_type' => 'voa_cpt_payment',
					'orderby' => 'asc'
				];

				$loop = new WP_Query($args);
				$strdate = "";
				while($loop->have_posts()){
					$loop->the_post();

					$data = get_post_meta(get_the_id(),'voa_payment');
					$arrd = $data[0];
					$corist = $arrd['corist'];
					if($user->display_name == $corist){
						$strdate.="'".$data[0]['date_payment']."',";
					}
					
				}
	?>

	jQuery(document).ready(function(){

		jQuery("#voa_payment_filtrar").click(function(){
			var url = "<?php print admin_url('admin-ajax.php'); ?>";

			var data = {
				action : 'voa_filter_payment_user',
				'date_from': jQuery("#voa_date_from").val(),
				'date_to': jQuery("#voa_date_to").val()
			}

			jQuery.post(url,data,function(response){
				jQuery("#load_data").html(response);
			});
		});

		//For Payment
	     jQuery("#voa_date_from").datepicker({
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

	     jQuery("#voa_date_to").datepicker({
	        dateFormat: 'dd-mm-yy',
	        changeMonth : true,
	        changeYear : true,
	        beforeShowDay : function(date){

	        	var pdate = new Array(<?php print $strdate; ?>);

				var d = ("0" + date.getDate()).slice(-2)+"-"+("0" + (date.getMonth()+1)).slice(-2)+"-"+date.getFullYear();

				for(i = 0; i < pdate.length; i++){
					//console.log(pdate[i]);
					if(pdate[i] == d){
						console.log(pdate[i]+" == "+d);
						return [true,"Highlighted","Existen Pagos Registrados!!"];
					}
				}
				return [true,""];
	        }
	     });  
	     //End Payment
	});
</script>
<?php }else{
?>
	<h1>Debes estar logueado</h1>
<?php
}
?>