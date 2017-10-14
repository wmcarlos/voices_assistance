<?php 

if(is_user_logged_in()){
		$post_count = 0;
		$not_assist = '';
		$args = array(
		    'post_type' => 'voa_cpt_assistence',
		    'orderby'   => 'voa_event_date_assistance',
       		'order' => 'DESC'
		 );
		$the_query = new WP_Query( $args );
		$assist = '';
		while ( $the_query->have_posts() ) : $the_query->the_post();
			$data = get_post_meta(get_the_id(),'voa_assistence');
			$date_event = get_post_meta(get_the_id(),'voa_event_date_assistance');
			$date_event =  date_i18n('d-m-Y', strtotime($date_event[0]));
			foreach ($data[0]['ID'] as $key) {
				if(get_current_user_id()==$key){
					if($data[0]['assist'][$post_count]=='N'){	
						$assist.='<article class="event_user_assist">
						<h3>'.get_the_title().' <span class="assist_event" assist="yes" style="float:right; padding-right:15px;">Asistente</span></h3>
						<span class="article_event_date">'.$date_event.'</span>
						</article>';
					}else{
						$assist.='<article class="event_user_assist">
						<h3>'.get_the_title().'<span class="assist_event" assist="no" style="float:right; padding-right:15px;">No Asistente</span></h3>
						<span class="article_event_date">'.$date_event.'</span>
						</article>';
					}
				}//cierre del user id
				$post_count++;
			}//cierre del foreach
			$post_count = 0;
		 	
endwhile;

?>
<!--Aparecera solo para los usuarios logueados-->
<h2 class="entry-title">Eventos
<span style="float:right; margin-right:10px; margin-top:-5px;"><input id="filter_event_search" type="text"  placeholder="Filtrar Evento"></span>
</h2>

<table width="100%">
	<tr>
		<td>
			<b>Desde:</b>
			<br>
			<input value="" placeholder="DD/MM/YY" type="text" id="voa_date_d">
		</td>
		<td>
			<b>Hasta:</b>
			<br>
			<input value="" placeholder="DD/MM/YY" type="text" id="voa_date_h">
		</td>

		<td>
			<b>A/N-A</b>
			<br>
			<center><input style="width:30px; height:30px;" type="checkbox" id="voa_assist_notassist_check"></center>
		</td>	
	</tr>
</table>



<?php echo $assist; ?><br>

<?php
}

