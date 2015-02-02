<?php

return array(
	/**
	 * The following options tell Guard to work seamlessly with
	 * the the storage. We use this SQL tables to record certain
	 * information about the subscriptions.
	 */
	'tables' => array(
		/**
		 * This table is required to keep track of the
		 * various permissions of our users.
		 */
		'permission_user_app' => 'permission_user_app'
	)
);