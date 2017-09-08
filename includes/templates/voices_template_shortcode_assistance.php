	
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


<table width="100%" cellspacing="1" cellpadding="1"  id="voa_table_assistence">
<caption>Registro de Asistencia de 35 Coristas</caption>
<thead>
<tr>
<th align="right" style="vertical-align: middle;border-right:1px solid #b9c9fe;border-left:1px solid #b9c9fe;">RUT</th><th align="right" style="vertical-align: middle;border-right:1px solid #b9c9fe;border-left:1px solid #b9c9fe;">NOMBRE</th><th align="right" style="vertical-align: middle;border-right:1px solid #b9c9fe;border-left:1px solid #b9c9fe;">CUERDA</th><th align="right" style="vertical-align: middle;border-right:1px solid #b9c9fe;border-left:1px solid #b9c9fe;">ASISTE</th><th align="center" style="vertical-align: middle;border-right:1px solid #b9c9fe;border-left:1px solid #b9c9fe;">JUSTIFICA</th></tr>
</thead>
<tbody>
<tr>
	<input type="hidden" name="voa_ids[]" value="<?php echo $key->data->ID; ?>">
	<td align="center" width="10%">17188576-0</td>
	<td align="left" width="30%">Nombre</td>
	<td align="center" width="5%">Soprano</td>
	<td width="5%">
		SI
	</td>
	<td width="5%" align="right" style="vertical-align: middle;border-right:1px solid #b9c9fe;border-left:1px solid #b9c9fe;">
		SI	
	</td>
</tr>
</tbody>
</table>