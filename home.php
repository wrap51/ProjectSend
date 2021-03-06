<?php
/**
 * Home page for logged in system users.
 *
 * @package		ProjectSend
 *
 */
$load_scripts	= array(
						'flot',
					); 

$allowed_levels = array(9,8,7);
require_once('sys.includes.php');
$page_title = __('Welcome to ProjectSend', 'cftp_admin');

$active_nav = 'dashboard';

$body_class = array('dashboard', 'home');

include('header.php');

define('CAN_INCLUDE_FILES', true);
?>

<div id="main">
	<?php /*<h2><?php echo $page_title; ?></h2>*/ ?>

	<div class="dashboard_contents">
		<div class="container-fluid">
			<div class="row">
			<?php
				$log_allowed = array(9);
				if (in_session_or_cookies($log_allowed)) {
					$show_log = true;
					$sys_info = true;
				}
			?>
					<div class="col-sm-8 <?php if ( isset( $show_log ) && $show_log != true) { echo 'col-sm-offset-2'; } ?>">
						<div class="row">
							<div class="col-sm-12">
								<div class="widget">
									<h4><?php _e('Statistics','cftp_admin'); ?></h4>
									<div class="widget_int">
										<div class="stats_change_days">
											<a href="#" class="stats_days btn btn-sm btn-default" rel="15" id="default_graph">15 <?php _e('days','cftp_admin'); ?></a>
											<a href="#" class="stats_days btn btn-sm btn-default" rel="30">30 <?php _e('days','cftp_admin'); ?></a>
											<a href="#" class="stats_days btn btn-sm btn-default" rel="60">60 <?php _e('days','cftp_admin'); ?></a>
										</div>
										<ul class="graph_legend">
											<li class="legend_color legend_color1"><div class="ref_color"></div><?php _e('Uploads by users','cftp_admin'); ?></li>
											<li class="legend_color legend_color2"><div class="ref_color"></div><?php _e('Uploads by clients','cftp_admin'); ?></li>
											<li class="legend_color legend_color3"><div class="ref_color"></div><?php _e('Downloads','cftp_admin'); ?></li>
											<li class="legend_color legend_color4"><div class="ref_color"></div><?php _e('Zip Downloads','cftp_admin'); ?></li>
											<li class="legend_color legend_color5"><div class="ref_color"></div><?php _e('Public Downloads','cftp_admin'); ?></li>
										</ul>

										<div id="statistics" style="height:320px;width:100%;"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<?php include(ROOT_DIR.'/home-news-widget.php'); ?>
							</div>
							<?php if (isset($sys_info) && $sys_info == true) { ?>
								<div class="col-sm-6">
									<div class="widget widget_system_info">
										<h4><?php _e('System information','cftp_admin'); ?></h4>
										<div class="widget_int">
											<h3><?php _e('Software','cftp_admin'); ?></h3>
											<dl class="dl-horizontal">
												<dt><?php _e('Version','cftp_admin'); ?></dt>
												<dd>
													<?php echo CURRENT_VERSION; ?> <?php
														if (defined('VERSION_NEW_NUMBER')) {
															echo ' - <strong>'; _e('New version available','cftp_admin'); echo ':</strong> <a href="'. VERSION_NEW_URL . '">' . VERSION_NEW_NUMBER . '</a>';
														}
													?>
												</dd>
		
												<dt><?php _e('Default upload max. size','cftp_admin'); ?></dt>
												<dd><?php echo MAX_FILESIZE; ?> mb.</dd>
		
												<dt><?php _e('Template','cftp_admin'); ?></dt>
												<dd><?php echo ucfirst(TEMPLATE_USE); ?></dd>
		
												<?php
													/** Get the data to show on the bars graphic */
													$statement = $dbh->query("SELECT distinct id FROM " . TABLE_FILES );
													$total_files = $statement->rowCount();
												
													$statement = $dbh->query("SELECT distinct id FROM " . TABLE_USERS . " WHERE level = '0'");
													$total_clients = $statement->rowCount();
												
													$statement = $dbh->query("SELECT distinct id FROM " . TABLE_GROUPS);
													$total_groups = $statement->rowCount();
												
													$statement = $dbh->query("SELECT distinct id FROM " . TABLE_USERS . " WHERE level != '0'");
													$total_users = $statement->rowCount();
	
													$statement = $dbh->query("SELECT distinct id FROM " . TABLE_CATEGORIES);
													$total_categories = $statement->rowCount();
												?>
		
												<dt><?php _e('Files','cftp_admin'); ?></dt>
												<dd><?php echo $total_files; ?></dd>
		
												<dt><?php _e('Clients','cftp_admin'); ?></dt>
												<dd><?php echo $total_clients; ?></dd>
		
												<dt><?php _e('System users','cftp_admin'); ?></dt>
												<dd><?php echo $total_users; ?></dd>
		
												<dt><?php _e('Groups','cftp_admin'); ?></dt>
												<dd><?php echo $total_groups; ?></dd>
	
												<dt><?php _e('Categories','cftp_admin'); ?></dt>
												<dd><?php echo $total_categories; ?></dd>
		
												<?php
													/**
													 * Hidden so it doesn't get shared by accident in any bug report
													<dt><?php _e('Root directory','cftp_admin'); ?></dt>
													<dd><?php echo ROOT_DIR; ?></dd>
		
													<dt><?php _e('Uploads folder','cftp_admin'); ?></dt>
													<dd><?php echo UPLOADED_FILES_FOLDER; ?></dd>
													*/
												?>
											</dl>
											
											<h3><?php _e('System','cftp_admin'); ?></h3>
											<dl class="dl-horizontal">
												<dt><?php _e('Server','cftp_admin'); ?></dt>
												<dd><?php echo $_SERVER["SERVER_SOFTWARE"]; ?>
	
												<dt><?php _e('PHP version','cftp_admin'); ?></dt>
												<dd><?php echo PHP_VERSION; ?></dd>
	
												<dt><?php _e('Memory limit','cftp_admin'); ?></dt>
												<dd><?php echo ini_get('memory_limit'); ?></dd>
	
												<dt><?php _e('Max execution time','cftp_admin'); ?></dt>
												<dd><?php echo ini_get('max_execution_time'); ?></dd>
	
												<dt><?php _e('Post max size','cftp_admin'); ?></dt>
												<dd><?php echo ini_get('post_max_size'); ?></dd>
											</dl>
											
											<h3><?php _e('Database','cftp_admin'); ?></h3>
											<dl class="dl-horizontal">
												<dt><?php _e('Driver','cftp_admin'); ?></dt>
												<dd><?php echo $dbh->getAttribute(PDO::ATTR_DRIVER_NAME);; ?></dd>
	
												<dt><?php _e('Version','cftp_admin'); ?></dt>
												<dd><?php echo $dbh->query('select version()')->fetchColumn(); ?></dd>
											</dl>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
					
					<?php if (isset($show_log) && $show_log == true) { ?>
						<div class="col-sm-4">
							<div class="widget">
								<h4><?php _e('Recent activites','cftp_admin'); ?></h4>
								<div class="widget_int">
									<div class="log_change_action">
										<a href="#" class="log_action btn btn-sm btn-default" rel="" id="default_log"><?php _e('All activities','cftp_admin'); ?></a>
										<a href="#" class="log_action btn btn-sm btn-default" rel="1"><?php _e('Logins','cftp_admin'); ?></a>
										<a href="#" class="log_action btn btn-sm btn-default" rel="8"><?php _e('Downloads','cftp_admin'); ?></a>
										<?php
											if (CLIENTS_CAN_REGISTER == '1') {
										?>
											<a href="#" class="log_action btn btn-sm btn-default" rel="4"><?php _e('Clients self-registrations','cftp_admin'); ?></a>
										<?php
											}
										?>
									</div>
									<ul class="activities_log">
									</ul>
									<div class="view_full_log">
										<a href="actions-log.php" class="btn btn-primary btn-wide"><?php _e('View all','cftp_admin'); ?></a>
									</div>
								</div>
							</div>
						</div>
				<?php
					}
				?>
			</div>
		</div>
	</div>
	
</div>

<script type="text/javascript">
	$(document).ready(function(){
		// Generate the graphic		
		$('.stats_days').click(function(e) {
			if ($(this).hasClass('btn-inverse')) {
				return false;
			}
			$('.stats_days').removeClass('btn-inverse');
			$(this).addClass('btn-inverse');
			$('.graph_legend').hide();
			$('#statistics').html('<div class="loading-graph">'+
										'<img src="<?php echo BASE_URI; ?>/img/ajax-loader.gif" alt="Loading" />'+
										'<p><?php _e('Please wait while the system generates the statistics graph.','cftp_admin'); ?></p></div>'
									);
			var days = $(this).attr('rel');
			$.get('<?php echo BASE_URI; ?>home-statistics.php', { days:days },
				function(data) {
					$('#statistics').html(data);
					$('.graph_legend').css('display','inline-block');
				}
			);					
			return false;
		});

		$('#default_graph').click();


		// Generate the action log
		$('.log_action').click(function(e) {
			if ($(this).hasClass('btn-inverse')) {
				return false;
			}
			$('.log_action').removeClass('btn-inverse');
			$(this).addClass('btn-inverse');
			$('.activities_log').html('<li><div class="loading-graph">'+
										'<img src="<?php echo BASE_URI; ?>/img/ajax-loader.gif" alt="Loading" />'+
										'<p><?php _e('Please wait while the system gets the information from the log.','cftp_admin'); ?></p></div></li>'
									);
			var action = $(this).attr('rel');
			$.get('<?php echo BASE_URI; ?>home-log.php', { action:action },
				function(data) {
					$('.activities_log').html(data);
				}
			);					
			return false;
		});

		$('#default_log').click();
		
	});
</script>

<?php
include('footer.php');
?>