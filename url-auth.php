<?php
/*
Plugin Name: URL auth
Description: Allows a URL to contain login information
Version: 0.1
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
			global $user_login, $userdata, $user_level, $user_ID, $user_email, $user_url, $user_pass_md5, $user_identity, $current_user;

            		if (!empty($current_user))
                		return;

			$login = explode(':', $_GET['login'], 2);
			$user = $login[0];
			$password = $login[1];

			// Use HTTP auth instead of cookies
			if(!wp_login($user, $password))
			{
				header('HTTP/1.0 401 Unauthorized');
				die(__('Incorrect credentials', 'url_auth'));
			}

			set_current_user(0, $user);

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
if (substr($wp_version, 0, 2) == "1.")
  die(__("This plugin requires at least WordPress 2.0", 'url_auth'));

enable_url_auth();

?>
