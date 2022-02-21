<?php
require_once( get_theme_file_path( 'admin/CryptoxBase.php' ));


class Cryptox_lic {
	public $plugin_file=__FILE__;
	public $responseObj;
	public $licenseMessage;
	public $showMessage=false;
	public $slug="cryptex";
	function __construct() {
		add_action( 'admin_print_styles', [ $this, 'SetAdminStyle' ] );
		$licenseKey=get_option("Cryptox_lic_Key","");
		$liceEmail=get_option( "Cryptox_lic_email","");
		if(CryptoxBase::CheckWPPlugin($licenseKey,$liceEmail,$this->licenseMessage,$this->responseObj,get_template_directory()."/style.css")){
			add_action( 'admin_menu', [$this,'ActiveAdminMenu'],99999);
			add_action( 'admin_post_Cryptox_el_deactivate_license', [ $this, 'action_deactivate_license' ] );

			/*  Include Plugins
			/* ---------------------------------------------------------------------- */
			require_once get_template_directory() . '/admin/class-tgm-plugin-activation.php';
			require_once( get_theme_file_path('admin/plugin-bundle.php') );

			// Cryptex Theme Settings Options
			require_once( get_template_directory() . '/admin/framework/theme-options/settings.php' );
			require_once( get_template_directory() . '/admin/framework/theme-options/save-settings.php' );

		}else{
			if(!empty($licenseKey) && !empty($this->licenseMessage)){
				$this->showMessage=true;
			}
			update_option("Cryptox_lic_Key","") || add_option("Cryptox_lic_Key","");
			add_action( 'admin_post_Cryptox_el_activate_license', [ $this, 'action_activate_license' ] );
			add_action( 'admin_menu', [$this,'InactiveMenu']);
		}
	}
	function SetAdminStyle() {
		wp_register_style( "CryptoxLic", get_theme_file_uri("css/_lic_style.css"),10);
		wp_enqueue_style( "CryptoxLic" );
	}
	function ActiveAdminMenu(){
		add_theme_page (  "Cryptox", "Cryptox", "activate_plugins", $this->slug, [$this,"Activated"]);
	}
	function InactiveMenu() {
		add_theme_page( "Cryptox", "Cryptox", 'activate_plugins', $this->slug,  [$this,"LicenseForm"]);
	}
	function action_activate_license(){
		check_admin_referer( 'el-license' );
		$licenseKey=!empty($_POST['el_license_key'])?$_POST['el_license_key']:"";
		$licenseEmail=!empty($_POST['el_license_email'])?$_POST['el_license_email']:"";
		update_option("Cryptox_lic_Key",$licenseKey) || add_option("Cryptox_lic_Key",$licenseKey);
		update_option("Cryptox_lic_email",$licenseEmail) || add_option("Cryptox_lic_email",$licenseEmail);
		wp_safe_redirect(admin_url( 'admin.php?page='.$this->slug));
	}
	function action_deactivate_license() {
		check_admin_referer( 'el-license' );
		$message="";
		if(CryptoxBase::RemoveLicenseKey(__FILE__,$message)){
			update_option("Cryptox_lic_Key","") || add_option("Cryptox_lic_Key","");
		}
		wp_safe_redirect(admin_url( 'admin.php?page='.$this->slug));
	}
	function Activated(){
		?>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="Cryptox_el_deactivate_license"/>
			<div class="el-license-container">
				<h3 class="el-license-title"><i class="dashicons-before dashicons-star-filled"></i> <?php _e("Cryptox License Info",$this->slug);?> </h3>
				<hr>
				<ul class="el-license-info">
					<li>
						<div>
							<span class="el-license-info-title"><?php _e("Status",$this->slug);?></span>

							<?php if ( $this->responseObj->is_valid ) : ?>
								<span class="el-license-valid"><?php _e("Valid",$this->slug);?></span>
							<?php else : ?>
								<span class="el-license-valid"><?php _e("Invalid",$this->slug);?></span>
							<?php endif; ?>
						</div>
					</li>

					<li>
						<div>
							<span class="el-license-info-title"><?php _e("License Type",$this->slug);?></span>
							<?php echo $this->responseObj->license_title; ?>
						</div>
					</li>

					<li>
						<div>
							<span class="el-license-info-title"><?php _e("License Expired on",$this->slug);?></span>
							<?php echo $this->responseObj->expire_date; ?>
						</div>
					</li>

					<li>
						<div>
							<span class="el-license-info-title"><?php _e("Support Expired on",$this->slug);?></span>
							<?php echo $this->responseObj->support_end; ?>
						</div>
					</li>
					<li>
						<div>
							<span class="el-license-info-title"><?php _e("Your License Key",$this->slug);?></span>
							<span class="el-license-key"><?php echo esc_attr( substr($this->responseObj->license_key,0,9)."XXXXXXXX-XXXXXXXX".substr($this->responseObj->license_key,-9) ); ?></span>
						</div>
					</li>
				</ul>
				<div class="el-license-active-btn">
					<?php wp_nonce_field( 'el-license' ); ?>
					<?php submit_button('Deactivate'); ?>
				</div>
			</div>
		</form>
		<?php
	}

	function LicenseForm() {
		?>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="Cryptox_el_activate_license"/>
			<div class="el-license-container">
				<h3 class="el-license-title"><i class="dashicons-before dashicons-star-filled"></i> <?php _e("Cryptox Theme Licensing",$this->slug);?></h3>
				<hr>
				<?php
				if(!empty($this->showMessage) && !empty($this->licenseMessage)){
					?>
					<div class="notice notice-error is-dismissible">
						<p><?php echo $this->licenseMessage; ?></p>
					</div>
					<?php
				}
				?>
				<p><?php _e("Enter your license key here, to activate the product, and get full feature updates and premium support. <br><br>Log into your Envato Market account
				Hover the mouse over your username at the top of the screen.<br>
				Click ‘Downloads’ from the drop down menu.`<br>
				Click ‘License certificate & purchase code’ (available as PDF or text file). or <a href='https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-' target='_blank'>Click Here</a> to watch video<br>",$this->slug);?></p>

				<div class="el-license-field">
					<label for="el_license_key"><?php _e("License code",$this->slug);?></label>
					<input type="text" class="regular-text code" name="el_license_key" size="50" placeholder="xxxxxxxx-xxxxxxxx-xxxxxxxx-xxxxxxxx" required="required">
				</div>
				<div class="el-license-field">
					<label for="el_license_key"><?php _e("Email Address",$this->slug);?></label>
					<?php
					$purchaseEmail   = get_option( "Cryptox_lic_email", get_bloginfo( 'admin_email' ));
					?>
					<input type="text" class="regular-text code" name="el_license_email" size="50" value="<?php echo $purchaseEmail; ?>" placeholder="" required="required">
					<div><small><?php _e("We will send update news of this product by this email address, don't worry, we hate spam",$this->slug);?></small></div>
				</div>
				<div class="el-license-active-btn">
					<?php wp_nonce_field( 'el-license' ); ?>
					<?php submit_button('Activate'); ?>
				</div>
			</div>
		</form>
		<?php
	}
}

new Cryptox_lic();