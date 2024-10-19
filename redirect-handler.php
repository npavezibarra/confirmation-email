<?php
// Check if the user has clicked the confirmation link and redirect based on the form
function confirmation_email_handle_redirect() {
    // Check if the user is logging in and has a form parameter in the URL
    if (isset($_GET['form'])) {
        $form_type = sanitize_text_field($_GET['form']);

        // Redirect based on the form type
        switch ($form_type) {
            case 'color':
                wp_redirect('http://mail.local/favorite-color/');
                exit;
            case 'band':
                wp_redirect('http://mail.local/favorite-band/');
                exit;
            case 'country':
                wp_redirect('http://mail.local/favorite-country/');
                exit;
        }
    }
}
add_action('template_redirect', 'confirmation_email_handle_redirect');
