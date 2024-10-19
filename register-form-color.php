<?php
// Shortcode for the first registration form with favorite color
function confirmation_email_register_form_color() {
    // Check if the user is already logged in
    if (is_user_logged_in()) {
        return 'You are already registered and logged in.';
    }

    // Output the registration form
    ob_start(); ?>

    <form id="registration-form-color" action="" method="POST">
        <p>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>
        </p>
        <p>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
        </p>
        <p>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </p>
        <p>
            <label for="favorite_color">Favorite Color</label>
            <input type="text" name="favorite_color" id="favorite_color" required>
        </p>
        <p>
            <input type="submit" name="submit_registration_color" value="Register">
        </p>
    </form>

    <?php
    return ob_get_clean();
}
add_shortcode('register_form_color', 'confirmation_email_register_form_color');

// Handle the form submission and user registration
function confirmation_email_handle_registration_color() {
    if (isset($_POST['submit_registration_color'])) {
        // Sanitize and validate the form input
        $username = sanitize_user($_POST['username']);
        $email = sanitize_email($_POST['email']);
        $password = sanitize_text_field($_POST['password']);
        $favorite_color = sanitize_text_field($_POST['favorite_color']);

        // Check if username and email are valid
        if (username_exists($username) || email_exists($email)) {
            echo 'Username or email already exists.';
            return;
        }

        // Create the user
        $user_id = wp_create_user($username, $password, $email);

        if (!is_wp_error($user_id)) {
            // Store favorite color in user meta
            update_user_meta($user_id, 'favorite_color', $favorite_color);

            // Send the default confirmation email
            wp_new_user_notification($user_id, null, 'user');
            
            // Success message
            echo 'Registration successful! Please check your email to confirm your account.';
        } else {
            // Error message
            echo 'There was an error in registration: ' . $user_id->get_error_message();
        }
    }
}
add_action('template_redirect', 'confirmation_email_handle_registration_color');
