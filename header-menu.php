<?php
/**
 * This file generates the main menu for the header on the back-end
 * and also for the default template.
 *
 * @package ProjectSend
 */

$items = array();

/**
 * Items for system users
 */
if ( in_session_or_cookies( array( 9,8,7 ) ) )
{

	/** Count inactive CLIENTS */
	$sql_inactive = $dbh->prepare( "SELECT DISTINCT user FROM " . TABLE_USERS . " WHERE active = '0' AND level = '0' AND account_requested='0'" );
	$sql_inactive->execute();
	define('COUNT_CLIENTS_INACTIVE', $sql_inactive->rowCount());

	/** Count new CLIENTS account requests */
	$sql_requests = $dbh->prepare( "SELECT DISTINCT user FROM " . TABLE_USERS . " WHERE account_requested='1' AND account_denied='0'" );
	$sql_requests->execute();
	define('COUNT_CLIENTS_REQUESTS', $sql_requests->rowCount());

	/** Count new CLIENTS account requests */
	$sql_requests = $dbh->prepare( "SELECT DISTINCT user FROM " . TABLE_USERS . " WHERE account_requested='1' AND account_denied='1'" );
	$sql_requests->execute();
	define('COUNT_CLIENTS_DENIED', $sql_requests->rowCount());

	/** Count inactive USERS */
	$sql_inactive = $dbh->prepare( "SELECT DISTINCT user FROM " . TABLE_USERS . " WHERE active = '0' AND level != '0'" );
	$sql_inactive->execute();
	define('COUNT_USERS_INACTIVE', $sql_inactive->rowCount());


	$items['dashboard'] = array(
								'nav'	=> 'dashboard',
								'level'	=> array( 9,8,7 ),
								'main'	=> array(
												'label'	=> __('Dashboard', 'cftp_admin'),
												'link'	=> 'home.php',
											),
							);

	$items['files']		= array(
								'nav'	=> 'files',
								'level'	=> array( 9,8,7 ),
								'main'	=> array(
												'label'	=> __('Files', 'cftp_admin'),
											),
								'sub'	=> array(
												array(
													'label'	=> __('Upload', 'cftp_admin'),
													'link'	=> 'upload-from-computer.php',
												),
												array(
													'divider'	=> true,
												),
												array(
													'label'	=> __('Manage files', 'cftp_admin'),
													'link'	=> 'manage-files.php',
												),
												array(
													'label'	=> __('Find orphan files', 'cftp_admin'),
													'link'	=> 'upload-import-orphans.php',
												),
												array(
													'divider'	=> true,
												),
												array(
													'label'	=> __('Categories', 'cftp_admin'),
													'link'	=> 'categories.php',
												),
											),
							);

	$items['clients']	= array(
								'nav'	=> 'clients',
								'level'	=> array( 9,8 ),
								'main'	=> array(
												'label'	=> __('Clients', 'cftp_admin'),
											),
								'sub'	=> array(
												array(
													'label'	=> __('Add new', 'cftp_admin'),
													'link'	=> 'clients-add.php',
												),
												array(
													'label'	=> __('Manage clients', 'cftp_admin'),
													'link'	=> 'clients.php',
													'badge'	=> COUNT_CLIENTS_INACTIVE,
												),
												array(
													'divider'	=> true,
												),
												array(
													'label'	=> __('Account requests', 'cftp_admin'),
													'link'	=> 'clients-requests.php',
													'badge'	=> COUNT_CLIENTS_REQUESTS,
												),
											),
							);

	$items['groups']	= array(
								'nav'	=> 'groups',
								'level'	=> array( 9,8 ),
								'main'	=> array(
												'label'	=> __('Clients groups', 'cftp_admin'),
											),
								'sub'	=> array(
												array(
													'label'	=> __('Add new', 'cftp_admin'),
													'link'	=> 'groups-add.php',
												),
												array(
													'label'	=> __('Manage groups', 'cftp_admin'),
													'link'	=> 'groups.php',
												),
											),
							);

	$items['users']		= array(
								'nav'	=> 'users',
								'level'	=> array( 9 ),
								'main'	=> array(
												'label'	=> __('System Users', 'cftp_admin'),
											),
								'sub'	=> array(
												array(
													'label'	=> __('Add new', 'cftp_admin'),
													'link'	=> 'users-add.php',
												),
												array(
													'label'	=> __('Manage system users', 'cftp_admin'),
													'link'	=> 'users.php',
													'badge'	=> COUNT_USERS_INACTIVE,
												),
											),
							);

	$items['options']	= array(
								'nav'	=> 'options',
								'level'	=> array( 9 ),
								'main'	=> array(
												'label'	=> __('Options', 'cftp_admin'),
											),
								'sub'	=> array(
												array(
													'label'	=> __('General options', 'cftp_admin'),
													'link'	=> 'options.php?section=general',
												),
												array(
													'label'	=> __('Clients', 'cftp_admin'),
													'link'	=> 'options.php?section=clients',
												),
												array(
													'label'	=> __('E-mail notifications', 'cftp_admin'),
													'link'	=> 'options.php?section=email',
												),
												array(
													'label'	=> __('Security', 'cftp_admin'),
													'link'	=> 'options.php?section=security',
												),
												array(
													'label'	=> __('Thumbnails', 'cftp_admin'),
													'link'	=> 'options.php?section=thumbnails',
												),
												array(
													'label'	=> __('Branding', 'cftp_admin'),
													'link'	=> 'options.php?section=branding',
												),
												array(
													'label'	=> __('Social Login', 'cftp_admin'),
													'link'	=> 'options.php?section=social_login',
												),
												array(
													'divider'	=> true,
												),
												array(
													'label'	=> __('E-mail templates', 'cftp_admin'),
													'link'	=> 'email-templates.php',
												),
											),
							);
}
/**
 * Items for clients
 */
else
{
	if (CLIENTS_CAN_UPLOAD == 1)
	{
		$items['upload'] = array(
									'nav'	=> 'upload',
									'level'	=> array( 9,8,7,0 ),
									'main'	=> array(
													'label'	=> __('Upload', 'cftp_admin'),
													'link'	=> 'upload-from-computer.php',
												),
								);
	}

	$items['manage_files'] = array(
								'nav'	=> 'manage',
								'level'	=> array( 9,8,7,0 ),
								'main'	=> array(
												'label'	=> __('Manage files', 'cftp_admin'),
												'link'	=> 'manage-files.php',
											),
							);

	$items['view_files'] = array(
								'nav'	=> 'template',
								'level'	=> array( 9,8,7,0 ),
								'main'	=> array(
												'label'	=> __('View my files', 'cftp_admin'),
												'link'	=> 'my_files/',
											),
							);
}

/**
 * Build the menu
 */
$menu_output = "<ul class='nav navbar-nav'>\n";

foreach ( $items as $item )
{
	if ( in_session_or_cookies( $item['level'] ) )
	{
		$current	= ( !empty( $active_nav ) && $active_nav == $item['nav'] ) ? 'active' : '';
		$badge		= ( !empty( $item['main']['badge'] ) ) ? ' <span class="badge">' . $item['main']['badge'] . '</span>' : '';

		/** Top level tag */
		if ( !isset( $item['sub'] ) )
		{
			$format			= "<li class='%s'>\n\t<a href='%s'>%s%s</a>\n</li>\n";
			$menu_output 	.= sprintf( $format, $current, BASE_URI . $item['main']['link'], $badge, $item['main']['label'] );
		}

		else
		{
			$format			= "<li class='dropdown %s'>\n\t<a href='#' class='dropdown-toggle' data-toggle='dropdown'>%s%s <b class='caret'></b></a>\n\t<ul class='dropdown-menu'>\n";
			$menu_output 	.= sprintf( $format, $current, $item['main']['label'], $badge );
			/**
			 * Submenu
			*/
			foreach ( $item['sub'] as $subitem )
			{
				$badge		= ( !empty( $subitem['badge'] ) ) ? ' <span class="badge">' . $subitem['badge'] . '</span>' : '';
				if ( !empty( $subitem['divider'] ) )
				{
					$menu_output .= "\t\t<li class='divider'></li>\n";
				}
				else
				{
					$format			= "\t\t<li>\n\t\t\t<a href='%s'>%s%s</a>\n\t\t</li>\n";
					$menu_output 	.= sprintf( $format, BASE_URI . $subitem['link'], $subitem['label'], $badge );
				}
			}
			$menu_output 	.= "\t</ul>\n</li>\n";
		}
	}
}

$menu_output .= "</ul>\n";

$menu_output = str_replace( "'", '"', $menu_output );

/**
 * Print to screen
 */
echo $menu_output;
?>