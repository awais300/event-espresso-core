<?php

//Install/update data tables in the Wordpress database
//Attention!! The WP dbDelta function cannot modify unique keys
//Please note that when updating the plugin and WordPress is in debug mode, you may see the following warning/notice:
//The plugin generated 15089 characters of unexpected output during activation. If you notice "headers already sent" messages,
//problems with syndication feeds or other issues, try deactivating or removing this plugin.
//This fix for this problem:
//The short and simple solution is to simply check the table exists and then drop the index manually before calling the dbDelta function.

/* if ($wpdb->get_var("SHOW TABLES LIKE $table") == $table) {
  $wpdb->query("ALTER TABLE $table DROP INDEX date");
  } */

//Credit: http://flav36rs.com/2010/04/02/wp-dbdelta-function-cannot-modify-unique-keys/
//This fixes some tables that may have been named wrong in an earlier version of the plugin
function event_espresso_rename_tables($old_table_name, $new_table_name) {
	global $wpdb;

	$old_table_name = $wpdb->prefix . $old_table_name;
	$new_table_name = $wpdb->prefix . $new_table_name;

	if ($wpdb->get_var("SHOW TABLES LIKE '" . $old_table_name . "'") == $old_table_name) {
		$wpdb->query("ALTER TABLE " . $old_table_name . " RENAME TO " . $new_table_name);
	}
}

//This function updates the org_options from < EE 3.2
function espresso_fix_org_options() {
	global $org_options, $espresso_wp_user;
	do_action('action_hook_espresso_log', __FILE__, __FUNCTION__, '');
	if (empty($org_options))
		return;

	//Retrive the existing $org_options, update, then unset the old one
	if (array_key_exists('display_description_on_multi_reg_page', $org_options)) {
		$org_options['template_settings']['display_description_on_multi_reg_page'] = empty($org_options['display_description_on_multi_reg_page']) ? '' : $org_options['display_description_on_multi_reg_page'];
		unset($org_options['display_description_on_multi_reg_page']);
	}

	if (array_key_exists('display_short_description_in_event_list', $org_options)) {
		$org_options['template_settings']['display_short_description_in_event_list'] = empty($org_options['display_short_description_in_event_list']) ? '' : $org_options['display_short_description_in_event_list'];
		unset($org_options['display_short_description_in_event_list']);
	}

	if (array_key_exists('display_address_in_event_list', $org_options)) {
		$org_options['template_settings']['display_address_in_event_list'] = empty($org_options['display_address_in_event_list']) ? '' : $org_options['display_address_in_event_list'];
		unset($org_options['display_address_in_event_list']);
	}

	if (array_key_exists('display_address_in_regform', $org_options)) {
		$org_options['template_settings']['display_address_in_regform'] = empty($org_options['display_address_in_regform']) ? '' : $org_options['display_address_in_regform'];
		unset($org_options['display_address_in_regform']);
	}

	if (array_key_exists('use_custom_post_types', $org_options)) {
		$org_options['template_settings']['use_custom_post_types'] = empty($org_options['use_custom_post_types']) ? false : true;
		unset($org_options['use_custom_post_types']);
	}

	if (array_key_exists('enable_default_style', $org_options)) {
		$org_options['style_settings']['enable_default_style'] = empty($org_options['enable_default_style']) ? '' : $org_options['enable_default_style'];
		unset($org_options['enable_default_style']);
	}

	if (array_key_exists('selected_style', $org_options)) {
		$org_options['style_settings']['selected_style'] = empty($org_options['selected_style']) ? '' : $org_options['selected_style'];
		unset($org_options['selected_style']);
	}

	if (array_key_exists('style_color', $org_options)) {
		$org_options['style_settings']['style_color'] = empty($org_options['style_color']) ? '' : $org_options['style_color'];
		unset($org_options['style_color']);
	}

	update_user_meta($espresso_wp_user, 'events_organization_settings', $org_options);
}

function espresso_initialize_system_questions() {
	global $wpdb;

	$system_name_data = "SELECT system_name FROM " . $wpdb->prefix . "events_question";

	$system_names = $wpdb->get_results($system_name_data);

	foreach ($system_names as $system_name) {
		switch ($system_name->system_name) {
			case 'fname':
				$fname = true;
				break;
			case 'lname':
				$lname = true;
				break;
			case 'email':
				$email = true;
				break;
			case 'address':
				$adress = true;
				break;
			case 'address2':
				$adress2 = true;
				break;
			case 'city':
				$city = true;
				break;
			case 'state':
				$state = true;
				break;
			case 'zip':
				$zip = true;
				break;
			case 'phone':
				$phone = true;
				break;
		}
	}

	if ($fname == false)
		$wpdb->insert($wpdb->prefix . "events_question", array('question' => 'First Name', 'question_type' => 'TEXT', 'system_name' => 'fname', 'required' => 'Y', 'sequence' => '0'), array('%s', '%s', '%s', '%s', '%s'));

	if ($lname == false)
		$wpdb->insert($wpdb->prefix . "events_question", array('question' => 'Last Name', 'question_type' => 'TEXT', 'system_name' => 'lname', 'required' => 'Y', 'sequence' => '1'), array('%s', '%s', '%s', '%s', '%s'));

	if ($email == false)
		$wpdb->insert($wpdb->prefix . "events_question", array('question' => 'Email', 'question_type' => 'TEXT', 'system_name' => 'email', 'required' => 'Y', 'sequence' => '2'), array('%s', '%s', '%s', '%s', '%s'));

	if ($adress == false)
		$wpdb->insert($wpdb->prefix . "events_question", array('question' => 'Address', 'system_name' => 'address', 'sequence' => '3'), array('%s', '%s', '%s'));

	if ($adress2 == false)
		$wpdb->insert($wpdb->prefix . "events_question", array('question' => 'Address 2', 'system_name' => 'address2', 'sequence' => '3'), array('%s', '%s', '%s'));

	if ($city == false)
		$wpdb->insert($wpdb->prefix . "events_question", array('question' => 'City', 'system_name' => 'city', 'sequence' => '4'), array('%s', '%s', '%s'));

	if ($state == false)
		$wpdb->insert($wpdb->prefix . "events_question", array('question' => 'State', 'system_name' => 'state', 'sequence' => '5'), array('%s', '%s', '%s'));

	if ($zip == false)
		$wpdb->insert($wpdb->prefix . "events_question", array('question' => 'Zip', 'system_name' => 'zip', 'sequence' => '6'), array('%s', '%s', '%s'));

	if ($zip == false)
		$wpdb->insert($wpdb->prefix . "events_question", array('question' => 'Country', 'system_name' => 'country', 'sequence' => '6'), array('%s', '%s', '%s'));

	if ($phone == false)
		$wpdb->insert($wpdb->prefix . "events_question", array('question' => 'Phone', 'system_name' => 'phone', 'sequence' => '7'), array('%s', '%s', '%s'));

	$system_group = $wpdb->get_row("SELECT system_group FROM " . $wpdb->prefix . "events_qst_group" . " WHERE system_group = 1");

	if ($wpdb->num_rows == 0) {

		$wpdb->insert($wpdb->prefix . "events_qst_group", array('group_name' => 'Personal Information', 'group_identifier' => sanitize_title_with_dashes('personal_information-' . time()), 'system_group' => 1), array('%s', '%s', '%d'));

		$personal_group_id = $wpdb->insert_id;

		$wpdb->insert($wpdb->prefix . "events_qst_group", array('group_name' => 'Address Information', 'group_identifier' => sanitize_title_with_dashes('address_information-' . time()), 'system_group' => 0), array('%s', '%s', '%d'));

		$address_group_id = $wpdb->insert_id;

		$system_name_data = "SELECT id, system_name FROM " . $wpdb->prefix . "events_question" . " where system_name IN ('fname', 'lname', 'email')";
		$system_names = $wpdb->get_results($system_name_data);

		foreach ($system_names as $system_name) {

			$wpdb->insert($wpdb->prefix . "events_qst_group_rel", array('group_id' => $personal_group_id, 'question_id' => $system_name->id), array('%d', '%d'));
		}

		$system_name_data = "SELECT id, system_name FROM " . $wpdb->prefix . "events_question" . " where system_name IN ('address', 'city', 'state', 'zip' )";
		$system_names = $wpdb->get_results($system_name_data);

		foreach ($system_names as $system_name) {

			$wpdb->insert($wpdb->prefix . "events_qst_group_rel", array('group_id' => $address_group_id, 'question_id' => $system_name->id), array('%d', '%d'));
		}
	}
}

function espresso_initialize_email() {
	global $wpdb;
	$test = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "events_email WHERE id=1");
	if (empty($test)) {
		$text = "***This Is An Automated Response***\nThank You [fname] [lname]\n";
		$text .= "We have just received a payment in the amount of [event_price] for your registration to [event_name].\n";
		$text .= "Transaction ID: [txn_id]";
		$wpdb->insert($wpdb->prefix . "events_email", array('email_type' => 'payment', 'email_name' => 'default payment email', 'email_subject' => 'Payment Received for [event_name]', 'email_text' => $text, 'wp_user' => 1), array('%s', '%s', '%s', '%s', '%d'));

		$text = "***This is an automated response - Do Not Reply***\n";
		$text .= "Thank you [fname] [lname] for registering for [event].\n";
		$text .= "This event starts at [start_time] on [start_date] and runs until [end_time] on [end_date].\n";
		$text .= "Location:\n";
		$text .= "[location]\n";
		$text .= "Phone: [location_phone]\n";
		$text .= "Google Map: [google_map_link]\n";
		$text .= "We hope that you will find this event both informative and enjoyable. Should you have any questions, please contact [contact].\n";
		$text .= "If you have not done so already, please submit your payment in the amount of [cost].\n";
		$text .= "Click here to review your payment information [payment_url].\n";
		$text .= "Thank You.\n";
		$wpdb->insert($wpdb->prefix . "events_email", array('email_type' => 'confirmation', 'email_name' => 'default confirmation email', 'email_subject' => 'Registration confirmation for [event_name]', 'email_text' => $text, 'wp_user' => 1), array('%s', '%s', '%s', '%s', '%d'));
	}
}

function espresso_update_event_ids() {
	global $wpdb;
	$event_data = "SELECT id FROM " . $wpdb->prefix . "events_detail WHERE event_code='0' ";
	if ($wpdb->num_rows == 0) {
		$wpdb->update($wpdb->prefix . "events_detail", array('group_name' => 'Personal Information', 'group_identifier' => sanitize_title_with_dashes('personal_information-' . time()), 'system_group' => 1), array('%s', '%s', '%d'));
	}
}

function event_espresso_update_shortcodes() {
	global $wpdb;
	$wpdb->query("SELECT id FROM " . $wpdb->prefix . "posts " . " WHERE (post_content LIKE '%{ESPRESSO_EVENTS}%' AND post_type = 'page') OR (post_content LIKE '%{ESPRESSO_PAYMENTS}%'  AND post_type = 'page') OR (post_content LIKE '%{ESPRESSO_TXN_PAGE}%'  AND post_type = 'page') ");

	if ($wpdb->num_rows > 0) {
		$wpdb->query("UPDATE " . $wpdb->prefix . "posts SET post_content = REPLACE(post_content,'{ESPRESSO_EVENTS}','[ESPRESSO_EVENTS]')");
		$wpdb->query("UPDATE " . $wpdb->prefix . "posts SET post_content = REPLACE(post_content,'{ESPRESSO_PAYMENTS}','[ESPRESSO_PAYMENTS]')");
		$wpdb->query("UPDATE " . $wpdb->prefix . "posts SET post_content = REPLACE(post_content,'{ESPRESSO_TXN_PAGE}','[ESPRESSO_TXN_PAGE]')");
	}

	$wpdb->query("SELECT id FROM " . $wpdb->prefix . "posts " . " WHERE (post_content LIKE '%{EVENTREGIS}%' AND post_type = 'page') OR (post_content LIKE '%{EVENTREGPAY}%' AND post_type = 'page') OR (post_content LIKE '%{EVENTPAYPALTXN}%' AND post_type = 'page') ");

	if ($wpdb->num_rows > 0) {
		$wpdb->query("UPDATE " . $wpdb->prefix . "posts SET post_content = REPLACE(post_content,'{EVENTREGIS}','[ESPRESSO_EVENTS]')");
		$wpdb->query("UPDATE " . $wpdb->prefix . "posts SET post_content = REPLACE(post_content,'{EVENTREGPAY}','[ESPRESSO_PAYMENTS]')");
		$wpdb->query("UPDATE " . $wpdb->prefix . "posts SET post_content = REPLACE(post_content,'{EVENTPAYPALTXN}','[ESPRESSO_TXN_PAGE]')");
	}
}

function espresso_update_attendee_qty() {
	global $wpdb;
	$sql = "SELECT id FROM " . $wpdb->prefix . "events_attendee WHERE quantity = 0 ";
	$results = $wpdb->get_results($sql);
	if ($wpdb->num_rows > 0) {
		$update_attendee_qty = $wpdb->query("UPDATE " . $wpdb->prefix . "events_attendee SET quantity = 1 OR quantity = '' WHERE quantity = 0");
		do_action('action_hook_espresso_log', __FILE__, __FUNCTION__, " sqldump = " . var_export($results, true) . " ] [ rows affected = " . var_export($update_attendee_qty, true));
	}
}

function espresso_org_option_initialization() {
	global $wpdb, $espresso_wp_user;

	$table_name = $wpdb->prefix . "events_organization";
	//Check to see if upgrading from an earlier version.
	$test = get_user_meta($espresso_wp_user, 'events_organization_settings');
	if (empty($test)) {
		if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {

			$new_org_options = array(
					'organization' => get_bloginfo('name'),
					'organization_street1' => '123 West Somewhere',
					'organization_street2' => '',
					'organization_city' => 'Some City',
					'organization_state' => 'AZ',
					'organization_zip' => '84128',
					'contact_email' => get_bloginfo('admin_email'),
					'default_mail' => 'Y',
					'country_id' => '',
					'organization_country' => '64',
					'currency_symbol' => '$',
					'default_logo_url' => '',
					'default_payment_status' => '',
					'surcharge' => '0.00',
					'surcharge_type' => 'flat_rate',
					'events_in_dasboard' => '30',
					'expire_on_registration_end' => 'Y',
					'email_before_payment' => 'N',
					'email_fancy_headers' => 'N',
					'enable_default_style' => 'Y',
					'event_ssl_active' => 'N',
					'use_venue_manager' => 'Y',
					'show_reg_footer' => 'Y',
					'template_settings' => array(
							'use_custom_post_types' => 'N',
							'display_address_in_regform' => 'N',
							'display_short_description_in_event_list' => 'Y',
							'display_description_on_multi_reg_page' => 'N',
							'display_description_in_event_list' => 'N'
					),
					'map_settings' => array(
							'ee_map_width_single' => '300',
							'ee_map_height_single' => '300',
							'ee_map_zoom_single' => '12',
							'ee_map_nav_display_single' => 'N',
							'ee_map_nav_size_single' => 'default',
							'ee_map_type_control_single' => 'default',
							'ee_map_align_single' => '',
							'ee_map_width' => '200',
							'ee_map_height' => '200',
							'ee_map_zoom' => '12',
							'ee_map_nav_display' => 'N',
							'ee_map_nav_size' => 'default',
							'ee_map_type_control' => 'default',
							'ee_map_align' => ''
					),
			);

			update_user_meta($espresso_wp_user, 'events_organization_settings', $new_org_options);

			//If an earlier version of Event Espresso is found, then we need to create the organization options.
		} else if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
			$results = $wpdb->get_results("SELECT * FROM " . EVENTS_ORGANIZATION_TABLE . " WHERE id='1'");
			foreach ($results as $result) {
				$org_id = $result->id;
				$Organization = $result->organization;
				$Organization_street1 = $result->organization_street1;
				$Organization_street2 = $result->organization_street2;
				$Organization_city = $result->organization_city;
				$Organization_state = $result->organization_state;
				$Organization_zip = $result->organization_zip;
				$contact = $result->contact_email;
				$registrar = $result->contact_email;
				$paypal_id = $result->paypal_id;
				$paypal_cur = $result->currency_format;
				$event_page_id = $result->event_page_id;
				$return_url = $result->return_url;
				$cancel_return = $result->cancel_return;
				$notify_url = $result->notify_url;
				$use_sandbox = $result->use_sandbox;
				$image_url = $result->image_url;
				$default_mail = $result->default_mail;
				$payment_subject = $result->payment_subject;
				$payment_message = $result->payment_message;
				$message = $result->message;
			}

			switch ($paypal_cur) {
				case 'USD':
				case 'HKD':
				case 'NZD':
				case 'SGD':
					$currency_symbol = '$';
					break;

				case 'AUD':
					$currency_symbol = 'A $';
					break;

				case 'GBP':
					$currency_symbol = '&pound;';
					break;

				case 'CAD':
					$currency_symbol = 'C $';
					break;

				case 'EUR':
					$currency_symbol = '&#8364;';
					break;

				case 'JPY':
					$currency_symbol = '&yen;';
					break;

				default:
					$currency_symbol = '$';
					break;
			}

			//DO NOT Create new settings here
			$org_options = array(
					'organization' => $Organization,
					'organization_street1' => $Organization_street1,
					'organization_street2' => $Organization_street2,
					'organization_city' => $Organization_city,
					'organization_state' => $Organization_state,
					'organization_zip' => $Organization_zip,
					'contact_email' => $contact,
					'paypal_id' => $paypal_id,
					'currency_format' => $paypal_cur,
					'currency_symbol' => $currency_symbol,
					'event_page_id' => $event_page_id,
					'return_url' => $return_url,
					'cancel_return' => $cancel_return,
					'notify_url' => $notify_url,
					'use_sandbox' => $use_sandbox,
					'image_url' => $image_url,
					'default_mail' => $default_mail,
					'payment_subject' => $payment_subject,
					'payment_message' => $payment_message,
					'message' => $message,
							//DO NOT Create new settings here
			);

			update_user_meta($espresso_wp_user, 'events_organization_settings', $org_options);

			//Delete the table
			$wpdb->query("DROP TABLE IF EXISTS $table_name");
		}
	}
}

//This function installs all the required database tables
function events_data_tables_install() {
	$table_version = EVENT_ESPRESSO_VERSION;

	$table_name = "events_attendee";
	$sql = " id int(11) unsigned NOT NULL AUTO_INCREMENT,
					  registration_id VARCHAR(23) DEFAULT '0',
					  is_primary INT(1) DEFAULT '0',
					  lname VARCHAR(45) DEFAULT NULL,
					  fname VARCHAR(45) DEFAULT NULL,
					  address VARCHAR(45) DEFAULT NULL,
					  address2 VARCHAR(45) DEFAULT NULL,
					  city VARCHAR(45) DEFAULT NULL,
					  state VARCHAR(45) DEFAULT NULL,
					  zip VARCHAR(45) DEFAULT NULL,
					  country_id VARCHAR(128) DEFAULT NULL,
					  organization_name VARCHAR(50) DEFAULT NULL,
					  vat_number VARCHAR(20) DEFAULT NULL,
					  email VARCHAR(45) DEFAULT NULL,
					  phone VARCHAR(45) DEFAULT NULL,
					  date timestamp NOT NULL default CURRENT_TIMESTAMP,
					  payment VARCHAR(45) DEFAULT NULL,
					  payment_status VARCHAR(45) DEFAULT 'Incomplete',
					  txn_type VARCHAR(45) DEFAULT NULL,
					  txn_id VARCHAR(45) DEFAULT NULL,
					  amount_pd decimal(20,2) DEFAULT '0.00',
					  total_cost decimal(20,2) DEFAULT '0.00',
					  price_option VARCHAR(100) DEFAULT NULL,
					  coupon_code VARCHAR(45) DEFAULT NULL,
					  quantity VARCHAR(5) DEFAULT '0',
					  payment_date VARCHAR(45) DEFAULT NULL,
					  event_id VARCHAR(45) DEFAULT NULL,
						venue_id VARCHAR(45) DEFAULT NULL,
					  event_time VARCHAR(15) DEFAULT NULL,
					  end_time VARCHAR(15) DEFAULT NULL,
					  start_date VARCHAR(45) DEFAULT NULL,
					  end_date VARCHAR(45) DEFAULT NULL,
					  attendee_session VARCHAR(250) DEFAULT NULL,
					  transaction_details TEXT,
					  pre_approve INT(11) DEFAULT '1',
					  checked_in INT(1) DEFAULT '0',
					  checked_in_quantity INT(11) DEFAULT '0',
					  hashSalt VARCHAR(250) DEFAULT NULL,
					PRIMARY KEY  (id),
					KEY registration_id (registration_id),
					KEY event_id (event_id)";
	event_espresso_run_install($table_name, $table_version, $sql);

	$table_name = "events_status";
	$sql = "id int(3) unsigned NOT NULL AUTO_INCREMENT,
					  code VARCHAR(45) DEFAULT NULL,
					  type INT(11) DEFAULT '0',
					  can_edit BOOLEAN DEFAULT '0',
					PRIMARY KEY  (id)";
	event_espresso_run_install($table_name, $table_version, $sql);

	$table_name = "events_detail";
	$sql = "id int(11) unsigned NOT NULL AUTO_INCREMENT,
				  event_code VARCHAR(26) DEFAULT '0',
				  event_name VARCHAR(100) DEFAULT NULL,
				  slug VARCHAR(100) DEFAULT NULL,
				  event_desc TEXT,
				  display_desc VARCHAR (1) DEFAULT 'Y',
				  display_reg_form VARCHAR (1) DEFAULT 'Y',
				  event_identifier VARCHAR(75) DEFAULT NULL,
				  start_date VARCHAR (15) DEFAULT NULL,
				  end_date VARCHAR (15) DEFAULT NULL,
				  registration_start VARCHAR (15) DEFAULT NULL,
				  registration_end VARCHAR (15) DEFAULT NULL,
				  registration_startT VARCHAR (15) DEFAULT NULL,
  				  registration_endT VARCHAR (15) DEFAULT NULL,
				  visible_on VARCHAR(15) DEFAULT NULL,
				  address TEXT,
				  address2 TEXT,
				  city VARCHAR(100) DEFAULT NULL,
				  state VARCHAR(100) DEFAULT NULL,
				  zip VARCHAR(11) DEFAULT NULL,
				  phone VARCHAR(15) DEFAULT NULL,
				  venue_title VARCHAR(250) DEFAULT NULL,
				  venue_url VARCHAR(250) DEFAULT NULL,
				  venue_image TEXT,
				  venue_phone VARCHAR(15) DEFAULT NULL,
				  virtual_url VARCHAR(250) DEFAULT NULL,
				  virtual_phone VARCHAR(15) DEFAULT NULL,
				  reg_limit VARCHAR (25) DEFAULT '999999',
				  allow_multiple VARCHAR (15) DEFAULT 'N',
				  additional_limit INT(10) DEFAULT '5',
				  is_active VARCHAR(1) DEFAULT 'Y',
				  event_status VARCHAR(1) DEFAULT 'A',
				  use_coupon_code VARCHAR(1) DEFAULT 'N',
				  use_groupon_code VARCHAR(1) DEFAULT 'N',
				  category_id TEXT,
				  coupon_id TEXT,
				  tax_percentage FLOAT,
				  tax_mode INT(11),
				  member_only VARCHAR(1),
					post_id INT(11) DEFAULT NULL,
					post_type VARCHAR(50) DEFAULT NULL,
					country VARCHAR(200) DEFAULT NULL,
					externalURL VARCHAR(255) DEFAULT NULL,
					early_disc VARCHAR(10) DEFAULT NULL,
					early_disc_date VARCHAR(15) DEFAULT NULL,
					early_disc_percentage VARCHAR(1) DEFAULT 'N',
					question_groups LONGTEXT NULL DEFAULT NULL,
					item_groups LONGTEXT NULL DEFAULT NULL,
					event_type VARCHAR(250) DEFAULT NULL,
					allow_overflow VARCHAR (1) DEFAULT 'N',
					overflow_event_id INT(10) DEFAULT '0',
					recurrence_id int(11) DEFAULT '0',
					alt_email TEXT,
					event_meta LONGTEXT DEFAULT NULL,
					wp_user int(22) DEFAULT '1',
					require_pre_approval int(11) DEFAULT '0',
					timezone_string VARCHAR(250) DEFAULT NULL,
					likes int(22) DEFAULT NULL,
					submitted datetime NOT NULL,
					ticket_id int(22) DEFAULT '0',
					certificate_id int(22) DEFAULT '0',
					confirmation_email_id int(22) DEFAULT '0',
					payment_email_id int(22) DEFAULT '0',
				 PRIMARY KEY  (id),
				 KEY slug (slug),
				 KEY event_code (event_code),
				 KEY wp_user (wp_user),
				 KEY event_name (event_name),
				 KEY city (city),
				 KEY state (state),
				 KEY start_date (start_date),
				 KEY end_date (end_date),
				 KEY registration_start (registration_start),
				 KEY registration_end (registration_end),
				 KEY reg_limit (reg_limit),
				 KEY event_status (event_status),
				 KEY recurrence_id (recurrence_id),
				 KEY submitted (submitted),
  				 KEY likes (likes)";
	event_espresso_run_install($table_name, $table_version, $sql);

	$table_name = "events_meta";
	$sql = "emeta_id bigint(20) NOT NULL AUTO_INCREMENT,
			  event_id int(11) DEFAULT NULL,
			  meta_key varchar(255) DEFAULT NULL,
			  meta_value longtext,
			  date_added datetime DEFAULT NULL,
  			  PRIMARY KEY  (emeta_id),
			  KEY event_id (event_id),
			  KEY meta_key (meta_key)";
	event_espresso_run_install($table_name, $table_version, $sql);

	$table_name = "events_email";
	$sql = "id int(11) unsigned NOT NULL AUTO_INCREMENT,
				email_type VARCHAR(25) DEFAULT NULL,
				email_name VARCHAR(100) DEFAULT NULL,
				email_subject VARCHAR(250) DEFAULT NULL,
				email_text TEXT,
				wp_user int(22) DEFAULT '1',
				UNIQUE KEY id (id),
				KEY wp_user (wp_user)";
	event_espresso_run_install($table_name, $table_version, $sql);

	$table_name = "events_category_detail";
	$sql = "id int(11) unsigned NOT NULL AUTO_INCREMENT,
				category_name VARCHAR(100) DEFAULT NULL,
				category_identifier VARCHAR(45) DEFAULT NULL,
				category_desc TEXT,
				display_desc VARCHAR (4) DEFAULT NULL,
				wp_user int(22) DEFAULT '1',
				UNIQUE KEY id (id),
				KEY category_identifier (category_identifier),
				KEY wp_user (wp_user)";
	event_espresso_run_install($table_name, $table_version, $sql);

	$table_name = "events_category_rel";
	$sql = "id int(11) NOT NULL AUTO_INCREMENT,
				event_id int(11) DEFAULT NULL,
				cat_id int(11) DEFAULT NULL,
				PRIMARY KEY  (id),
			  	KEY event_id (event_id)";
	event_espresso_run_install($table_name, $table_version, $sql);

	$table_name = "events_venue";
	$sql = "id int(11) unsigned NOT NULL AUTO_INCREMENT,
				name VARCHAR(250) DEFAULT NULL,
				identifier VARCHAR(26) DEFAULT '0',
				address VARCHAR(250) DEFAULT NULL,
				address2 VARCHAR(250) DEFAULT NULL,
				city VARCHAR(250) DEFAULT NULL,
				state VARCHAR(250) DEFAULT NULL,
				zip VARCHAR(250) DEFAULT NULL,
				country VARCHAR(250) DEFAULT NULL,
				phone VARCHAR(250) DEFAULT NULL,
				meta TEXT,
				wp_user int(22) DEFAULT '1',
				UNIQUE KEY id (id),
			  	KEY identifier (identifier),
				KEY wp_user (wp_user)";
	event_espresso_run_install($table_name, $table_version, $sql);

	$table_name = "events_venue_rel";
	$sql = "id int(11) NOT NULL AUTO_INCREMENT,
				event_id int(11) DEFAULT NULL,
				venue_id int(11) DEFAULT NULL,
				PRIMARY KEY  (id),
			  	KEY event_id (event_id)";
	event_espresso_run_install($table_name, $table_version, $sql);

	$table_name = "events_locale";
	$sql = "id int(11) unsigned NOT NULL AUTO_INCREMENT,
			  name varchar(250) DEFAULT NULL,
			  identifier varchar(26) DEFAULT '0',
			  wp_user int(22) DEFAULT '1',
			  UNIQUE KEY id (id),
			  KEY identifier (identifier),
			  KEY wp_user (wp_user)";
	event_espresso_run_install($table_name, $table_version, $sql);

	$table_name = "events_locale_rel";
	$sql = "id int(11) NOT NULL AUTO_INCREMENT,
				venue_id int(11) DEFAULT NULL,
				locale_id int(11) DEFAULT NULL,
				PRIMARY KEY  (id),
			  	KEY venue_id (venue_id)";
	event_espresso_run_install($table_name, $table_version, $sql);

	$table_name = "events_personnel";
	$sql = "id int(11) NOT NULL AUTO_INCREMENT,
				name VARCHAR(250) DEFAULT NULL,
				role VARCHAR(250) DEFAULT NULL,
				identifier VARCHAR(26) DEFAULT '0',
				email TEXT,
				meta TEXT,
				wp_user int(22) DEFAULT '1',
				UNIQUE KEY id (id),
			  	KEY identifier (identifier),
			  	KEY wp_user (wp_user)";
	event_espresso_run_install($table_name, $table_version, $sql);

	$table_name = "events_personnel_rel";
	$sql = "id int(11) NOT NULL AUTO_INCREMENT,
				event_id int(11) DEFAULT NULL,
				person_id int(11) DEFAULT NULL,
				PRIMARY KEY  (id),
			  	KEY event_id (event_id),
			  	KEY person_id (person_id)";
	event_espresso_run_install($table_name, $table_version, $sql);

	$table_name = "events_discount_rel";
	$sql = "id int(11) NOT NULL AUTO_INCREMENT,
				event_id int(11) DEFAULT NULL,
				discount_id int(11) DEFAULT NULL,
				PRIMARY KEY  (id),
			  	KEY event_id (event_id)";
	event_espresso_run_install($table_name, $table_version, $sql);

	$table_name = "events_start_end";
	$sql = "id int(11) NOT NULL AUTO_INCREMENT,
				event_id int(11) DEFAULT NULL,
				start_time varchar(10) DEFAULT NULL,
				end_time varchar(10) DEFAULT NULL,
				reg_limit int (15) DEFAULT '0',
				PRIMARY KEY  (id),
			  	KEY event_id (event_id)";
	event_espresso_run_install($table_name, $table_version, $sql);

	$table_name = "events_prices";
	$sql = "id int(11) NOT NULL AUTO_INCREMENT,
				event_id int(11) DEFAULT NULL,
				price_type varchar(50) DEFAULT NULL,
				event_cost decimal(20,2) NOT NULL DEFAULT '0.00',
				surcharge decimal(10,2) NOT NULL DEFAULT '0.00',
				surcharge_type varchar(10) DEFAULT NULL,
				member_price_type varchar(50) DEFAULT NULL,
				member_price decimal(20,2) NOT NULL DEFAULT '0.00',
				max_qty int(7) DEFAULT '0',
				max_qty_members int(7) DEFAULT '0',
				PRIMARY KEY  (id),
			  	KEY event_id (event_id)";
	event_espresso_run_install($table_name, $table_version, $sql);

	$table_name = "events_discount_codes";
	$sql = "id int(11) NOT NULL AUTO_INCREMENT,
				coupon_code varchar(50) DEFAULT NULL,
				coupon_code_price decimal(20,2) DEFAULT NULL,
				use_percentage VARCHAR(1) DEFAULT NULL,
				coupon_code_description TEXT,
				each_attendee VARCHAR(1) DEFAULT NULL,
				quantity int(7) NOT NULL DEFAULT '0',
				use_limit varchar(1) NOT NULL DEFAULT 'N',
				use_exp_date varchar(1) NOT NULL DEFAULT 'N',
				exp_date varchar(15) DEFAULT NULL,
				wp_user int(22) DEFAULT '1',
				PRIMARY KEY  (id),
			  	KEY coupon_code (coupon_code),
			  	KEY wp_user (wp_user)";
	event_espresso_run_install($table_name, $table_version, $sql);

	$table_name = "events_multi_event_registration_id_group";
	$sql = "primary_registration_id varchar(255) DEFAULT NULL,
			registration_id varchar(255) DEFAULT NULL  ";
	event_espresso_run_install($table_name, $table_version, $sql);

	$table_name = "events_attendee_cost";
	$sql = "attendee_id int(11) DEFAULT NULL,
			cost decimal(20,2) DEFAULT '0.00',
			quantity int(11) DEFAULT NULL,
			KEY attendee_id (attendee_id)";
	event_espresso_run_install($table_name, $table_version, $sql);

	$table_name = "events_question";
	$sql = "id int(11) unsigned NOT NULL auto_increment,
			sequence INT(11) NOT NULL default '0',
			question_type enum('TEXT','TEXTAREA','MULTIPLE','SINGLE','DROPDOWN','DATE') NOT NULL default 'TEXT',
			question text NOT NULL,
			system_name varchar(15) DEFAULT NULL,
			response text NULL,
			required ENUM( 'Y', 'N' ) NOT NULL DEFAULT 'N',
			required_text text NULL,
			admin_only ENUM( 'Y', 'N' ) NOT NULL DEFAULT 'N',
			wp_user int(22) DEFAULT '1',
			PRIMARY KEY  (id),
			KEY wp_user (wp_user),
			KEY system_name (system_name),
			KEY admin_only (admin_only)";
	event_espresso_run_install($table_name, $table_version, $sql);

	$table_name = "events_qst_group";
	$sql = "id int(11) NOT NULL AUTO_INCREMENT,
				group_name VARCHAR(100) NOT NULL default 'NULL',
				group_identifier VARCHAR(45) NOT NULL default 'NULL',
				group_description TEXT,
				group_order int(11) DEFAULT '0',
				show_group_name TINYINT( 1 ) NOT NULL DEFAULT '1',
				show_group_description TINYINT( 1 ) NOT NULL DEFAULT '1',
				system_group TINYINT( 1 ) NOT NULL DEFAULT '0',
				wp_user int(22) DEFAULT '1',
				PRIMARY KEY  (id),
			  	KEY system_group (system_group),
			  	KEY wp_user (wp_user)";
	event_espresso_run_install($table_name, $table_version, $sql);

	$table_name = "events_qst_group_rel";
	$sql = "id int(11) NOT NULL AUTO_INCREMENT,
				group_id int(11)  NOT NULL,
				question_id int(11) NOT NULL,
				PRIMARY KEY  (id),
			  	KEY group_id (group_id),
			  	KEY question_id (question_id)";
	event_espresso_run_install($table_name, $table_version, $sql);

	$table_name = "events_answer";
	$sql = "id int(11) NOT NULL AUTO_INCREMENT,
			registration_id varchar(23) NOT NULL,
			attendee_id int(11) NOT NULL default '0',
			question_id int(11) NOT NULL default '0',
			answer text NOT NULL,
			PRIMARY KEY  (id),
			KEY registration_id (registration_id),
			KEY attendee_id (attendee_id)";
	event_espresso_run_install($table_name, $table_version, $sql);


}
