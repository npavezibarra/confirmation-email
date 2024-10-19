<?php
/*
Plugin Name: Confirmation Email
Description: A plugin to customize user registration forms and modify confirmation emails based on user input.
Version: 1.0
Author: Your Name
*/

// Security check to prevent direct access to the file
if (!defined('ABSPATH')) {
    exit;
}

// Include the registration form for favorite color
require_once plugin_dir_path(__FILE__) . 'register-form-color.php';
// Include the registration form for favorite country
require_once plugin_dir_path(__FILE__) . 'register-form-country.php';
// Include the registration form for favorite band
require_once plugin_dir_path(__FILE__) . 'register-form-band.php';

// Include email modification
require_once plugin_dir_path(__FILE__) . 'email-modification.php';

// Include the redirect handler
require_once plugin_dir_path(__FILE__) . 'redirect-handler.php';
