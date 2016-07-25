<?php
/**
 * File Type: Registration
 */
if (!class_exists('SC_Law_Firm_Registration')) {

    class SC_Law_Firm_Registration {

        public function __construct() {
            add_shortcode('themeheap_registration' , array (&$this , 'shortCodeCallBack'));
        }

        /**
         * return Registration Data
         *
         */
        public function shortCodeCallBack($args , $content = '') {
			if (function_exists('fw_get_db_settings_option')) {
				$enable_registration = fw_get_db_settings_option('enable_registration');
				$enable_signin 	   = fw_get_db_settings_option('enable_signin');
			} else{
				$enable_registration = 'off';
				$enable_signin 	   = 'off';
			}
         ?>
         	<?php if( isset( $enable_signin ) && $enable_signin === 'on' && !is_user_logged_in() ){?>
            <!--Login Form-->
            <div class="modal fade login-modalbox" tabindex="-1" role="dialog">
                <div class="th-login-modalbox">
                    <h2><?php esc_html_e('LOGIN FORM' , 'law_core'); ?></h2>
                    <form class="login-form do-login-form">
                        <div class="login-message alert alert-info law-ajax-message elm-display-none"></div>
                        <div class="login_wrap">
                            <div class="form-group">
                                <i class="fa fa-envelope"></i>
                                <input type="text" name="username" placeholder="<?php esc_html_e('Username' , 'law_core'); ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <i class="fa fa-lock"></i>
                                <input type="password" name="password" placeholder="<?php esc_html_e('Password' , 'law_core'); ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox">
                                    <em><?php esc_html_e('Remember?' , 'law_core'); ?></em>
                                </label>
                                <a class="forgetpassword" href="<?php echo esc_url(wp_lostpassword_url()); ?>">
                                    <em><?php esc_html_e('Forgot Password' , 'law_core'); ?></em>
                                    <i class="fa fa-question-circle"></i>
                                </a>
                            </div>
                            <input type="hidden" name="user-cookie" value="1" />
                            <button class="th-theme-btn th-theme-btn-lg do-login-button" type="submit"><?php esc_html_e('login' , 'law_core'); ?></button>
                        </div>
                    </form>
                    <?php if( isset( $enable_registration ) && $enable_registration === 'on' ){?>
                    <p><?php esc_html_e('Not a Member?' , 'law_core'); ?> <a class="register-me" href="javascript:;"><?php esc_html_e('Sign Up' , 'law_core'); ?></a></p><?php }?>
                </div>
            </div>
            <?php }?>
            <?php 
			if( isset( $enable_registration ) && $enable_registration === 'on'  && !is_user_logged_in() ){
				$popClass	= 'signup-modalbox';
				if( $enable_signin === 'off' ){
					$popClass	= 'login-modalbox';
				}
			?>
            <!--Signup Form-->
			<div class="modal fade <?php echo sanitize_html_class( $popClass );?>" tabindex="-1" role="dialog">
                <div class="th-signup-modalbox th-login-modalbox">
                    <h2><?php esc_html_e('SIGN UP' , 'law_core'); ?></h2>
                    <form class="login-form do-registration-form">
                        <div class="registration-message alert alert-info elm-display-none"></div>
                        <div class="registration_wrap">
                            <div class="form-group">
                                <input type="text" name="username" placeholder="<?php esc_html_e('Username' , 'law_core'); ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" placeholder="<?php esc_html_e('Password' , 'law_core'); ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="password" name="confirm-password" placeholder="<?php esc_html_e('Confirm Password' , 'law_core'); ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="email" name="useremail" placeholder="<?php esc_html_e('Email Address' , 'law_core'); ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="text" name="firstname" placeholder="<?php esc_html_e('First Name' , 'law_core'); ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="text" name="lastname" placeholder="<?php esc_html_e('Last Name' , 'law_core'); ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <input name="terms" type="hidden" value="0"  />
                                <label><input name="terms" type="checkbox"><em><?php esc_html_e(' I agree with the terms and conditions' , 'law_core'); ?></em></label>
    
                            </div>
                            <button class="th-theme-btn th-theme-btn-lg  do-register-button" type="button"><?php esc_html_e('Sign Up' , 'law_core'); ?></button>
                        </div>
                    </form>
                    <?php if( isset( $enable_signin ) && $enable_signin === 'on' ){?>
                    	<p><?php esc_html_e('Already Member?' , 'law_core'); ?> <a class="login-me" href="javascript:;"><?php esc_html_e('Sign In' , 'law_core'); ?></a></p><?php }?>
                </div>
            </div>
            <?php }?>
         <?php   
        }
    }

    new SC_Law_Firm_Registration();
}