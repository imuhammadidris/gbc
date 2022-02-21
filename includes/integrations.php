<?php

if ( defined('TRIBE_EVENTS_FILE') ) {

	$tribe_events_ical = new Tribe__Events__iCal();

	add_action( 'tribe_events_in_nav', array( $tribe_events_ical, 'maybe_add_link' ), 10, 1 );

}
