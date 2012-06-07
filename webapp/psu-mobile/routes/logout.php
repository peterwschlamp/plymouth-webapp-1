<?php

// Generic response (don't force the trailing slash: this should catch any accidental laziness)
respond( '/?', function( $request, $response, $app ) {
	// Let's create a session variable, so we know where to redirect back to
	$_SESSION['called_url'] = $request->param( 'redirect_to' );

	// Let's log the user out
	IDMObject::setupCAS();
	IDMObject::unauthN();

	// If the "ajax" parameter was not sent along with the request
	if ( ! $request->param( 'ajax' ) ) {
		// Redirect by changing the URL to send a success Flag to the JavaScript onLocationChange API
		header('Location: logout-success/');
	}
});

// Let's make sure to redirect them to the originally called URL if they requested to
respond( '/logout-success/?', function( $request, $response, $app ) {
	if ( ! empty( $_SESSION['called_url'] ) ) {
		// Redirect to the originally intended authentication url
		header('Location: ' . $_SESSION['called_url']);
	}
});

// Let's create a cute little message page... so that PhoneGap users just see a flashing page
respond( '/logout-message/?', function( $request, $response, $app ) {
	// Display the template
	$app->tpl->assign( 'show_page', 'logout-message' );
	$app->tpl->display( '_wrapper.tpl' );
});
