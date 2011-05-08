<?php
/*
Plugin Name: URL auth
Description: Allows a URL to contain login information
Version: 0.2
Author: Chad Parry

This work is derived from Post Restrictions by S&ouml;ren Weber (http://soeren-weber.net/post/2006/01/01/121/)

*/

// ----------------------------------------------------------------------------
// setup
// ----------------------------------------------------------------------------

// See if we're doing URL Auth (login= is in the query string)
function enable_url_auth()
{
	if (isset($_GET['login']))
	{
		// Override WP's get_currentuserinfo in order to do the login
		// via HTTP auth. This code is copied from WP2.0's get_currentuserinfo
		// I wish there were a more targeted way to override this
		function get_currentuserinfo()
		{
			global $current_user, $wp_version;

            		if (!empty($current_user))
                		return;

			$login = explode(':', $_GET['login'], 2);
			$user = $login[0];
			$password = $login[1];

			if (version_compare($wp_version, '3.0', '<')) {
				if (!wp_login($user, $password))
				{
					header('HTTP/1.0 401 Unauthorized');
					die(__('Incorrect credentials', 'url_auth'));
				}
				wp_set_current_user(null, $user);
			} else {
				if (is_wp_error(wp_signon(array('user_login' => $user, 'user_password' => $password))))
				{
					header('HTTP/1.0 401 Unauthorized');
					die(__('Incorrect credentials', 'url_auth'));
				}
				$user_info = get_userdatabylogin($user);
				set_current_user(null, $user_info->ID);
			}

		}
	}
}

// ----------------------------------------------------------------------------
// main
// ----------------------------------------------------------------------------

// Just in case someone's loaded up the page standalone for whatever reason,
// make sure it doesn't crash in an ugly way
if (!function_exists('add_filter'))
  die(__("This page must be loaded as part of WordPress", 'url_auth'));

global $wp_version;
if (version_compare($wp_version, '2.0', '<'))
  die(__("This plugin requires at least WordPress 2.0", 'url_auth'));

enable_url_auth();

?>
