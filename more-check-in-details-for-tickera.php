<?php
/**
* Plugin Name: More Check In Details For Tickera
* Plugin URI:  https://github.com/nicufarmache/more-check-in-details-for-tickera
* Description: More Check In Details for Tickera
* Version:     1.2
* License:     GPL v2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Author:      Nicu Farmache
* Author URI:  https://github.com/nicufarmache
* Text Domain: more-check-in-details-for-tickera
* Domain Path: /languages
* 
* @package         More_Check_In_Details_For_Tickera
*/

add_filter('tc_checkin_custom_fields', 'mcidft_tc_checkin_custom_fields', 10, 5);

function mcidft_tc_checkin_custom_fields ($custom_fields, $ticket_instance_id, $event_id, $order, $ticket_type) {
	$ticket_instance = new Tickera\TC_Ticket( (int) $ticket_instance_id );
	$ticket	= new Tickera\TC_Ticket();
	$event_id	= $ticket->get_ticket_event( apply_filters( 'tc_ticket_type_id', $ticket_instance->details->ticket_type_id ) );
	$event_name	= get_the_title( $event_id );
  if (get_post_type($ticket_instance->details->ticket_type_id) == 'product_variation') {
    $variation = wc_get_product($ticket_instance->details->ticket_type_id);
    $details = $variation->get_title();
    $variation_data = wc_get_formatted_variation($variation->variation_data, true);
    if (isset($variation_data)) {
      $details = $variation_data;
    }
  }
	$attendee_email = get_post_meta( $ticket_instance_id, 'owner_email', true );
	$ticket_code = get_post_meta( $ticket_instance_id, 'ticket_code', true );

	if (isset($attendee_email) && !empty($attendee_email) && !is_null($attendee_email)) {
		$custom_fields[] = array('Attendee Email', $attendee_email);
	}
	if (isset($ticket_code) && !empty($ticket_code) && !is_null($ticket_code)) {
		$custom_fields[] = array('Code', $ticket_code);
	}
	if (isset($details) && !empty($details) && !is_null($details)) {
		$custom_fields[] = array('Details', $details);
	}
	if (isset($event_name) && !empty($event_name) && !is_null($event_name)) {
		$custom_fields[] = array('Event Name', $event_name);
	}
	
	return $custom_fields;
}
