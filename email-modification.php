<?php

function confirmation_email_custom_email($wp_new_user_notification_email, $user, $blogname) {
    error_log("Custom email modification function is triggered!");

    // Retrieve user meta
    $user_id = $user->ID;
    $favorite_color = get_user_meta($user_id, 'favorite_color', true);
    $favorite_band = get_user_meta($user_id, 'favorite_band', true);
    $favorite_country = get_user_meta($user_id, 'favorite_country', true);

    // Debugging: Log the retrieved metadata values
    error_log("Favorite Color: " . $favorite_color);
    error_log("Favorite Band: " . $favorite_band);
    error_log("Favorite Country: " . $favorite_country);

    // Detect which custom page to use
    if ($favorite_band) {
        $custom_page = 'favorite-band';
    } elseif ($favorite_color) {
        $custom_page = 'favorite-color';
    } elseif ($favorite_country) {
        $custom_page = 'favorite-country';
    }

    // Debug: Log the original email message
    error_log("Original email message: " . $wp_new_user_notification_email['message']);

    // Replace the full reset link with the custom page URL
    if (isset($custom_page)) {
        // Extract the password reset URL pattern
        $message = preg_replace(
            '/http:\/\/mail\.local\/wp-login\.php\?action=rp&key=.*&login=.*$/m',
            "http://mail.local/{$custom_page}/",
            $wp_new_user_notification_email['message']
        );

        // Debug: Log the modified email message
        error_log("Modified email message: " . $message);

        // Update the email message
        $wp_new_user_notification_email['message'] = $message;
    }

    return $wp_new_user_notification_email;
}

add_filter('wp_new_user_notification_email', 'confirmation_email_custom_email', 10, 3);
