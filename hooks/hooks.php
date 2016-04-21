<?php
/**
 *
 * Hooks
 *
 * @package   Law
 * @author    themeheap
 * @link      http://themeheap.com/
 * @copyright @2015 themeheap
 
 * @since 1.0
 */


/**
 * @Consult Now
 * @return 
 */
if (!function_exists('law_firm_contact_me')) {

    function law_firm_contact_me() {
        global $current_user,$post;
        $json = array ();
		
		if (!check_ajax_referer('consult_with_me' , 'security' , false)) {
            $json['type']    = 'error';
            $json['message'] = esc_html__('Oops! No kiddies Please.' , 'law_core');
            echo json_encode($json);
            die;
        }
		
        $bloginfo        = get_bloginfo();
        $subject_message = "(" . $bloginfo . ") Contact Form Received";

        $law_firm_message = esc_html__('Message Sent.' , 'themeheap');
		$failure_message = esc_html__('Message Fail.' , 'themeheap');

        $recipient = $_POST['email_to'];
        
		if ( $_POST['email_to'] == '' ) {
            $recipient = get_option('admin_email' , 'themeheap@gmail.com');
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get the form fields and remove whitespace.

            if ($_POST['username'] == '' || $_POST['useremail'] == '' || $_POST['subject'] == '' || $_POST['description'] == '') {
                $json['type']    = 'error';
                $json['message'] = esc_html__('Please fill all fields.' , 'law_core');
                echo json_encode($json);
                die;
            }

            if (!law_firm_isValidEmail($_POST['useremail'])) {
                $json['type']    = 'error';
                $json['message'] = esc_html__('Email address is not valid.' , 'law_core');
                echo json_encode($json);
                die;
            }

            $name    = $_POST['username'];
            $email   = $_POST['useremail'];
            $subject = $_POST['subject'];
            $message = $_POST['description'];

            // Set the recipient email address.
            // FIXME: Update this to your desired email address.
            // Set the email subject.
            $subject = $subject_message;

            // Build the email content.
            $email_content = "Name: $name\n";
            $email_content .= "Email: $email\n\n";
            $email_content .= "Subject: $subject\n\n";
            $email_content .= "Message:\n$message\n";

            // Build the email headers.
            $email_headers = "From: $name <$email>";

            // Send the email.
            if (mail($recipient , $subject , $email_content , $email_headers)) {
                // Set a 200 (okay) response code.
                // http_response_code(200);
                $json['type']    = "success";
                $json['message'] = esc_attr($law_firm_message);
                echo json_encode($json);
                die();
            } else {
                // Set a 500 (internal server error) response code.
                // http_response_code(500);
                $json['type']    = "error";
                $json['message'] = esc_attr($failure_message);
                echo json_encode($json);
                die();
            }
        } else {
            // Not a POST request, set a 403 (forbidden) response code.
            // http_response_code(403);
            $json['type']    = "error";
            $json['message'] = esc_attr($failure_message);
            echo json_encode($json);
            die();
        }
    }

    add_action('wp_ajax_law_firm_contact_me' , 'law_firm_contact_me');
    add_action('wp_ajax_nopriv_law_firm_contact_me' , 'law_firm_contact_me');
}

/**
 * @submit Order
 * @return 
 */
if (!function_exists('law_firm_submit_contact')) {

    function law_firm_submit_contact() {
        global $current_user;

        $json = array ();

        if (!check_ajax_referer('contact_form' , 'security' , false)) {
            $json['type']    = 'error';
            $json['message'] = esc_html__('Oops! No kiddies Please.' , 'law_core');
            echo json_encode($json);
            die;
        }

        $bloginfo        = get_bloginfo();
        $subject_message = "(" . $bloginfo . ") Contact Form Received";

        $law_firm_message = $_POST['success'];

        if ($_POST['success'] == '') {
            $law_firm_message = esc_html__('Message Sent.' , 'law_core');
        }

        $failure_message = $_POST['error'];
        if ($_POST['error'] == '') {
            $failure_message = esc_html__('Message Fail.' , 'law_core');
        }

        $recipient = $_POST['email'];
        if ($_POST['email'] == '') {
            $recipient = get_option('admin_email' , 'themeheap@gmail.com');
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get the form fields and remove whitespace.

            if ($_POST['username'] == '' || $_POST['useremail'] == '' || $_POST['usersubject'] == '' || $_POST['description'] == '') {
                $json['type']    = 'error';
                $json['message'] = esc_html__('Please fill all fields.' , 'law_core');
                echo json_encode($json);
                die;
            }

            if (!law_firm_isValidEmail($_POST['useremail'])) {
                $json['type']    = 'error';
                $json['message'] = esc_html__('Email address is not valid.' , 'law_core');
                echo json_encode($json);
                die;
            }

            $name        = $_POST['username'];
            $email       = $_POST['useremail'];
            $usersubject = $_POST['usersubject'];
            $message     = $_POST['description'];

            // Set the recipient email address.
            // FIXME: Update this to your desired email address.
            // Set the email subject.
            $subject = $subject_message;

            // Build the email content.
            $email_content = "Name: $name\n";
            $email_content .= "Email: $email\n\n";
            $email_content .= "Website: $usersubject\n\n";
            $email_content .= "Message:\n$message\n";

            if (isset($_POST['phone']) && !empty($_POST['phone'])) {
                $phone = $_POST['phone'];
                $email_content .= "Phone:\n$phone\n";
            }

            // Build the email headers.
            $email_headers = "From: $name <$email>";

            // Send the email.
            if (mail($recipient , $subject , $email_content , $email_headers)) {
                // Set a 200 (okay) response code.
                // http_response_code(200);
                $json['type']    = "success";
                $json['message'] = esc_attr($law_firm_message);
                echo json_encode($json);
                die();
            } else {
                // Set a 500 (internal server error) response code.
                // http_response_code(500);
                $json['type']    = "error";
                $json['message'] = esc_attr($failure_message);
                echo json_encode($json);
                die();
            }
        } else {
            // Not a POST request, set a 403 (forbidden) response code.
            // http_response_code(403);
            $json['type']    = "error";
            $json['message'] = esc_attr($failure_message);
            echo json_encode($json);
            die();
        }
    }

    add_action('wp_ajax_law_firm_submit_contact' , 'law_firm_submit_contact');
    add_action('wp_ajax_nopriv_law_firm_submit_contact' , 'law_firm_submit_contact');
}

/**
 * @Hire Attorny
 * @return 
 */
if (!function_exists('law_firm_hire_attorny')) {

    function law_firm_hire_attorny() {
        global $current_user;

        $json = array ();

        if (!check_ajax_referer('hire_me' , 'security' , false)) {
            $json['type']    = 'error';
            $json['message'] = esc_html__('Oops! No kiddies Please.' , 'law_core');
            echo json_encode($json);
            die;
        }

        $bloginfo        = get_bloginfo();
        $subject_message = "(" . $bloginfo . ") Consultancy";

        $law_firm_message     = esc_html__('Message Sent.' , 'law_core');
        $failure_message = esc_html__('Message Fail.' , 'law_core');


        $recipient = get_option('admin_email' , 'themeheap@gmail.com');

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get the form fields and remove whitespace.

            if ($_POST['practice'] == '' || $_POST['attorny'] == '' || $_POST['name'] == '' || $_POST['email'] == '' || $_POST['phone'] == '') {
                $json['type']    = 'error';
                $json['message'] = esc_html__('Please fill all fields.' , 'law_core');
                echo json_encode($json);
                die;
            }

            $practice = get_the_title($_POST['practice']);
            $attorny  = get_the_title($_POST['attorny']);
            $name     = $_POST['name'];
            $email    = $_POST['email'];
            $phone    = $_POST['phone'];

            // Set the recipient email address.
            // FIXME: Update this to your desired email address.
            // Set the email subject.
            $subject = $subject_message;

            // Build the email content.
            $email_content = "Practice: $practice\n";
            $email_content .= "Attorny: $attorny\n\n";
            $email_content .= "Name: $name\n\n";
            $email_content .= "Email:\n$email\n";
            $email_content .= "Phone: $phone\n\n";

            // Build the email headers.
            $email_headers = "From: $name <$email>";

            // Send the email.
            if (mail($recipient , $subject , $email_content , $email_headers)) {
                // Set a 200 (okay) response code.
                // http_response_code(200);
                $json['type']    = "success";
                $json['message'] = esc_attr($law_firm_message);
                echo json_encode($json);
                die();
            } else {
                // Set a 500 (internal server error) response code.
                // http_response_code(500);
                $json['type']    = "error";
                $json['message'] = esc_attr($failure_message);
                echo json_encode($json);
                die();
            }
        } else {
            // Not a POST request, set a 403 (forbidden) response code.
            // http_response_code(403);
            $json['type']    = "error";
            $json['message'] = esc_attr($failure_message);
            echo json_encode($json);
            die();
        }
    }

    add_action('wp_ajax_law_firm_hire_attorny' , 'law_firm_hire_attorny');
    add_action('wp_ajax_nopriv_law_firm_hire_attorny' , 'law_firm_hire_attorny');
}

/**
 * @Wp Login
 * @return 
 */
if (!function_exists('law_firm_ajax_login')) {

    function law_firm_ajax_login() {

        $user_array                  = array ();
        $user_array['user_login']    = esc_sql($_POST['username']);
        $user_array['user_password'] = esc_sql($_POST['password']);

        if (isset($_POST['rememberme'])) {
            $remember = esc_sql($_POST['rememberme']);
        } else {
            $remember = '';
        }

        if ($remember) {
            $user_array['remember'] = true;
        } else {
            $user_array['remember'] = false;
        }

        if ($user_array['user_login'] == '') {
            echo json_encode(array (
                'type'     => 'error' ,
                'loggedin' => false ,
                'message'  => esc_html__('User name should not be empty.' , 'law_core') ));
            exit();
        } elseif ($user_array['user_password'] == '') {
            echo json_encode(array (
                'type'     => 'error' ,
                'loggedin' => false ,
                'message'  => esc_html__('Password should not be empty.' , 'law_core') ));
            exit();
        } else {
            $status = wp_signon($user_array , false);
            if (is_wp_error($status)) {
                echo json_encode(array (
                    'type'     => 'error' ,
                    'loggedin' => false ,
                    'message'  => esc_html__('Wrong username or password.' , 'law_core') ));
            } else {
                echo json_encode(array (
                    'type'     => 'success' ,
                    'url'      => home_url('/') ,
                    'loggedin' => true ,
                    'message'  => esc_html__('Successfully Login' , 'law_core') ));
            }
        }

        die();
    }

    add_action('wp_ajax_law_firm_ajax_login' , 'law_firm_ajax_login');
    add_action('wp_ajax_nopriv_law_firm_ajax_login' , 'law_firm_ajax_login');
}

/**
 * @Wp Registration
 * @return 
 */
if (!function_exists('law_firm_user_registration')) {

    function law_firm_user_registration($atts = '') {
        global $wpdb;

        $username         = esc_sql($_POST['username']);
        $terms            = $_POST['terms'];
        $password         = esc_sql($_POST['password']);
        $confirm_password = esc_sql($_POST['confirm-password']);

        $json = array ();

        if (empty($username)) {
            $json['type']    = "error";
            $json['message'] = esc_html__("User name should not be empty." , 'law_core');
            echo json_encode($json);
            exit();
        }

        if ($terms == '0') {
            $json['type']    = "error";
            $json['message'] = esc_html__("Please Check Terms and Conditions" , 'law_core');
            echo json_encode($json);
            exit();
        }

        if (empty($password)) {
            $json['type']    = "error";
            $json['message'] = esc_html__("Password is required." , 'law_core');
            echo json_encode($json);
            exit();
        }

        if ($password != $confirm_password) {
            $json['type']    = "error";
            $json['message'] = esc_html__("Password is not matched." , 'law_core');
            echo json_encode($json);
            exit();
        }

        $email = esc_sql($_POST['useremail']);
        if (empty($email)) {
            $json['type']    = "error";
            $json['message'] = esc_html__("Email should not be empty." , 'law_core');
            echo json_encode($json);
            exit();
        }

        if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/" , $email)) {

            $json['type']    = "error";
            $json['message'] = esc_html__("Please enter a valid email." , 'law_core');
            echo json_encode($json);
            die;
        }
        $random_password = $password;

        $role = 'subscriber';

        $status = wp_create_user($username , $random_password , $email);
        if (is_wp_error($status)) {
            $json['type']    = "error";
            $json['message'] = esc_html__("User already exists. Please try another one." , 'law_core');
            echo json_encode($json);
            die;
        } else {
            global $wpdb;
            wp_update_user(array (
                'ID'          => esc_sql($status) ,
                'role'        => esc_sql($role) ,
                'user_status' => 1 ));
            $wpdb->update(
                    $wpdb->prefix . 'users' , array (
                'user_status' => 1 ) , array (
                'ID' => esc_sql($status) )
            );
            update_user_meta($status , 'show_admin_bar_front' , false);
            wp_new_user_notification(esc_sql($status) , $random_password);
            $json['type']    = "success";
            $json['message'] = esc_html__("Please check your email for login details." , 'law_core');
            echo json_encode($json);
            die;
        }
        die();
    }

    add_action('wp_ajax_law_firm_user_registration' , 'law_firm_user_registration');
    add_action('wp_ajax_nopriv_law_firm_user_registration' , 'law_firm_user_registration');
}

/**
 * @User Notification
 * Return{}
 */
if (!function_exists('wp_new_user_notification')) {

    function wp_new_user_notification($user_id , $plaintext_pass = '') {
        $user     = get_userdata($user_id);
        $blogname = wp_specialchars_decode(get_option('blogname') , ENT_QUOTES);

        $message = sprintf(esc_html__('New user registration on your site %s:' , 'law_core') , $blogname) . "\r\n\r\n";
        $message .= sprintf(esc_html__('Username: %s' , 'law_core') , $user->user_login) . "\r\n\r\n";
        $message .= sprintf(esc_html__('E-mail: %s' , 'law_core') , $user->user_email) . "\r\n";

        @wp_mail(get_option('admin_email') , sprintf(esc_html__('[%s] New User Registration' , 'law_core') , $blogname) , $message);

        if (empty($plaintext_pass))
            return;

        $message = sprintf(esc_html__('Username: %s' , 'law_core') , $user->user_login) . "\r\n";
        $message .= sprintf(esc_html__('Password: %s' , 'law_core') , $plaintext_pass) . "\r\n";
        $message .= esc_url(home_url('/')) . "\r\n";

        wp_mail($user->user_email , sprintf(esc_html__('[%s] Your username and password' , 'law_core') , $blogname) , $message);
    }

}


/**
 * @Validaet Email
 * @return {}
 */
if (!function_exists('law_firm_isValidEmail')) {
    function law_firm_isValidEmail($email) {
        return filter_var($email , FILTER_VALIDATE_EMAIL);
    }
}
