<?php
// Load WordPress
require('wp-load.php');

// The username you want to login as (Change 'admin' if yours is different)
$username = 'admin';

// Get the user account
$user = get_user_by('login', $username);

// If user exists, log them in
if ($user) {
    wp_set_current_user($user->ID, $user->user_login);
    wp_set_auth_cookie($user->ID);
    do_action('wp_login', $user->user_login, $user);
    
    // Redirect to Dashboard
    echo "<h1>Success!</h1>";
    echo "You are now logged in. <br>";
    echo "<strong><a href='" . admin_url() . "'>Click here to go to the Dashboard</a></strong>";
    exit;
} else {
    // If 'admin' wasn't found, list who DOES exist so you can copy the right name
    echo "<h1>Error: User '$username' not found.</h1>";
    echo "<h3>Available Users in this Database:</h3>";
    
    global $wpdb;
    $users = $wpdb->get_results("SELECT user_login FROM $wpdb->users");
    
    if ($users) {
        echo "<ul>";
        foreach ($users as $u) {
            echo "<li>" . $u->user_login . "</li>";
        }
        echo "</ul>";
        echo "<p>Edit this file (force-login.php) and change <code>\$username = 'admin';</code> to one of the names above.</p>";
    } else {
        echo "No users found at all! The database is empty.";
    }
}
?>
