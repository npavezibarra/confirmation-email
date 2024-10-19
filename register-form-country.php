<?php
// Shortcode for the registration form with favorite country
function confirmation_email_register_form_country() {
    // Check if the user is already logged in
    if (is_user_logged_in()) {
        return 'You are already registered and logged in.';
    }

    // Output the registration form
    ob_start(); ?>

    <form id="registration-form-country" action="" method="POST">
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
            <label for="favorite_country">Favorite Country</label>
            <input type="text" name="favorite_country" id="favorite_country" required>
        </p>
        <p>
            <input type="submit" name="submit_registration_country" value="Register">
        </p>
    </form>

    <?php
    return ob_get_clean();
}
add_shortcode('register_form_country', 'confirmation_email_register_form_country');

// Handle the form submission and user registration
function confirmation_email_handle_registration_country() {
    if (isset($_POST['submit_registration_country'])) {
        // Sanitize and validate the form input
        $username = sanitize_user($_POST['username']);
        $email = sanitize_email($_POST['email']);
        $password = sanitize_text_field($_POST['password']);
        $favorite_country = sanitize_text_field($_POST['favorite_country']);

        // Check if username and email are valid
        if (username_exists($username) || email_exists($email)) {
            echo 'Username or email already exists.';
            return;
        }

        // Create the user
        $user_id = wp_create_user($username, $password, $email);

        if (!is_wp_error($user_id)) {
            // Store favorite country in user meta
            update_user_meta($user_id, 'favorite_country', $favorite_country);

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
add_action('template_redirect', 'confirmation_email_handle_registration_country');
