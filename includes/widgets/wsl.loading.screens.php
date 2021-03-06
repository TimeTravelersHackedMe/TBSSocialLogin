<?php
/*!
* WordPress Social Login
*
* http://miled.github.io/wordpress-social-login/ | https://github.com/miled/wordpress-social-login
*  (c) 2011-2015 Mohamed Mrassi and contributors | http://wordpress.org/plugins/wordpress-social-login/
*/

/**
* Generate WSL loading screens.
*/

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// --------------------------------------------------------------------

/**
* Display a loading screen while the WSL is redirecting the user to a given provider for authentication
*
* Note:
*   In case you want to customize the content generated, you may redefine this function
*   This function should redirect to the current url PLUS '&redirect_to_provider=true', see javascript function init() defined bellow
*   And make sure the script DIES at the end.
*
*   The $provider name is passed as a parameter.
*/
if( ! function_exists( 'wsl_render_redirect_to_provider_loading_screen' ) )
{
	function wsl_render_redirect_to_provider_loading_screen( $provider )
	{
		$assets_base_url  = WORDPRESS_SOCIAL_LOGIN_PLUGIN_URL . 'assets/img/';
?>
<!DOCTYPE html>
	<head>
		<meta name="robots" content="NOINDEX, NOFOLLOW">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title><?php _wsl_e("Redirecting...", 'wordpress-social-login') ?> - <?php bloginfo('name'); ?></title>
		<link rel="stylesheet" id="cb-main-stylesheet-css" href="https://thebestsites.com/wp-content/themes/15zine/library/css/style.css?ver=3.0.2" type="text/css" media="all">
		<link rel="stylesheet" id="fontawesome-css" href="https://thebestsites.com/wp-content/themes/15zine/library/css/font-awesome-4.6.3/css/font-awesome.min.css?ver=4.6.3" type="text/css" media="all">
		<style type="text/css">
			html {
				background: white;
			}
			body {
				background: white;
				color: #000;
				font-family: "Open Sans", sans-serif;
			}
            .outer {
    display: table;
    position: absolute;
    height: 100%;
    width: 100%;
}

.middle {
    display: table-cell;
    vertical-align: middle;
}

.inner {
    margin-left: auto;
    margin-right: auto; 
    width: /*whatever width you want*/;
}
		</style>
		<script>
			function init()
			{
				window.location.replace( window.location.href + "&redirect_to_provider=true" );
			}
		</script>
	</head>
	<body id="loading-screen" onload="init()">
<div class="outer">
<div class="middle">
<div class="inner">
				<span id="cb-alp-loader" class="cb-alp-ld"><i class="fa fa-circle-o-notch fa-3x fa-fw"></i></span>
			</div>
            </div>
            </div>
	</body>
</html>
<?php
		die();
	}
}

/**
* Display a loading screen after a user come back from provider and while WSL is procession his profile, contacts, etc.
*
* Note:
*   In case you want to customize the content generated, you may redefine this function
*   Just make sure the script DIES at the end.
*/
if( ! function_exists( 'wsl_render_return_from_provider_loading_screen' ) )
{
	function wsl_render_return_from_provider_loading_screen( $provider, $authenticated_url, $redirect_to, $wsl_settings_use_popup )
	{
		/*
		* If Authentication displayis undefined or eq Popup ($wsl_settings_use_popup==1)
		* > create a from with javascript in parent window and submit it to wp-login.php ($authenticated_url)
		* > with action=wordpress_social_authenticated, then close popup
		*
		* If Authentication display eq In Page ($wsl_settings_use_popup==2)
		* > create a from in page then submit it to wp-login.php with action=wordpress_social_authenticated
		*/

		$assets_base_url  = WORDPRESS_SOCIAL_LOGIN_PLUGIN_URL . 'assets/img/';
?>
<!DOCTYPE html>
	<head>
		<meta name="robots" content="NOINDEX, NOFOLLOW">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title><?php _wsl_e("Redirecting...", 'wordpress-social-login') ?> - <?php bloginfo('name'); ?></title>
		<link rel="stylesheet" id="cb-main-stylesheet-css" href="https://thebestsites.com/wp-content/themes/15zine/library/css/style.css?ver=3.0.2" type="text/css" media="all">
		<link rel="stylesheet" id="fontawesome-css" href="https://thebestsites.com/wp-content/themes/15zine/library/css/font-awesome-4.6.3/css/font-awesome.min.css?ver=4.6.3" type="text/css" media="all">
		<style type="text/css">
			html {
				background: white;
			}
			body {
				background: #fff;
				color: #000;
				font-family: "Open Sans", sans-serif;
			}
			.outer {
    display: table;
    position: absolute;
    height: 100%;
    width: 100%;
}

.middle {
    display: table-cell;
    vertical-align: middle;
}

.inner {
    margin-left: auto;
    margin-right: auto; 
    width: /*whatever width you want*/;
}
		</style>
		<script>
			function init()
			{
				<?php
					if( $wsl_settings_use_popup == 1 || ! $wsl_settings_use_popup ){
						?>
							if( window.opener )
							{
								window.opener.wsl_wordpress_social_login({
									'action'   : 'wordpress_social_authenticated',
									'provider' : '<?php echo $provider ?>'
								});

								window.close();
							}
							else
							{
								document.loginform.submit();
							}
						<?php
					}
					elseif( $wsl_settings_use_popup == 2 ){
						?>
							document.loginform.submit();
						<?php
					}
				?>
			}
		</script>
	</head>
	<body id="loading-screen" onload="init();">
<div class="outer">
<div class="middle">
<div class="inner">
				<span id="cb-alp-loader" class="cb-alp-ld"><i class="fa fa-circle-o-notch fa-3x fa-fw"></i></span>
			</div>
            </div>
            </div>
            		<form name="loginform" method="post" action="<?php echo $authenticated_url; ?>">
			<input type="hidden" id="redirect_to" name="redirect_to" value="<?php echo esc_url( $redirect_to ); ?>">
			<input type="hidden" id="provider" name="provider" value="<?php echo $provider ?>">
 <input type="hidden" id="action" name="action" value="wordpress_social_authenticated">
 </form>
	</body>
</html>
<?php
		die();
	}
}

// --------------------------------------------------------------------
