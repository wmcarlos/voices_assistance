<?php
	
	add_shortcode("voa_payment","voa_payment_short_fn");
	function voa_payment_short_fn(){
		ob_start();
			include_once("templates/voices_template_shortcode_payment.php");
	    return ob_get_clean();
	}
	add_action("wp_ajax_voa_filter_payment","voa_filter_payment_callback");

	add_action("wp_ajax_nopriv_voa_filter_payment","voa_filter_payment_callback");

	function voa_filter_payment_callback(){

		$date_from = strtotime($_REQUEST['date_from']);
		$date_to = strtotime($_REQUEST['date_to']);
		$args = [
			'post_type' => 'voa_cpt_payment',
			'orderby' => 'asc'
		];

		$loop = new WP_Query($args);
		$total = 0;
		while($loop->have_posts()){
			$loop->the_post();

			$data = get_post_meta(get_the_id(),'voa_payment');
			$arrd = $data[0];

			$date_payment = strtotime($arrd['date_payment']);
			$corist = $arrd['corist'];
			$payment_type = $arrd['payment_type'];
			$price = $arrd['count'];

			if($date_payment >= $date_from && $date_payment <= $date_to){
				$cad.="<tr>";
					$cad.="<td>".$corist."</td>";
					$cad.="<td>".$arrd['date_payment']."</td>";

					$args = array(
					   'post_type' => 'voa_cpt_payment_type',
					   'p'      => $payment_type
					);
					// The Query
					$the_query = new WP_Query( $args );
					$the_query->have_posts();
					$the_query->the_post();

					$cad.="<td>".get_the_title()."</td>";
					$cad.="<td>".$price."</td>";
				$cad.="</tr>";
				$total+=$price;
			}
		}

		$cad.="<tr><td colspan='3'>Total</td><td>".$total."</td></tr>";
		print $cad;

		wp_die();
	}