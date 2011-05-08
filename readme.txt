=== URL Auth ===
Contributors: chadparry
Tags: authentication, feeds
Requires at least: 2.0
Tested up to: 3.1.2
Stable tag: 0.2

This plugin allows users to authenticate using a password in the URL. This is especially useful to allow feed readers to access private feeds.

== Description ==

Some (half-baked) feed readers do not support private blogs.
They will fail to retrieve content if you protect your site with either the regular WordPress signon or HTTP authentication.
As a work-around, it's useful to be able to create a URL that contains the login information.
That way, even the most basic feed reader will be able to show the private posts you have access to.
(But see the warnings below).

== Installation ==

1. Upload `url-auth.php` to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. You need an existing username and password. Verify that you can successfully sign on to your blog.
1. Access your site using a special URL that contains your username and password. The format is described below.

Your login credentials should be placed in a URL parameter called `login`.
Separate your username and password with a colon.
The syntax is `?login=username:password`.
For example, suppose your feed is at `http://fullofit.parry.org/feed/atom` and your username is `chad` and your password is `xyzzy`.
You can access your feed using the link `http://fullofit.parry.org/feed/atom?login=chad:xyzzy`. 
If your username or password contain special characters, (e.g. + or = or &), then you should
[URL encode](http://www.blooberry.com/indexdot/html/topics/urlencoding.htm) them.

== Changelog ==

= 0.2 =
* Add support for WordPress 3.0

= 0.1 =
* Initial version

== Warnings ==

Writing your password in a URL is one of the least secure ways to supply it.
The URL is accessible to various untrusted parties during its transmission from the client to the server.
It is also frequently stored in logs for long durations.

To retain some control over your security, consider creating a special low-privileged account.
This account should have read-only access to your site.
Only use the special account with this plugin, and avoid putting any other passwords in a URL.

