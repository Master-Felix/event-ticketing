<?php
/**
 * Helper functions for the event ticketing application
 * Provides common utility functions used throughout the application
 */

/**
 * Sanitize output to prevent XSS attacks
 * 
 * @param string $string The string to sanitize
 * @return string Sanitized string safe for HTML output
 */
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Check if user is authenticated
 * 
 * @return bool True if user is logged in, false otherwise
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Get current user ID from session
 * 
 * @return int|null User ID if logged in, null otherwise
 */
function getUserId() {
    return $_SESSION['user_id'] ?? null;
}

/**
 * Redirect to a specific page
 * 
 * @param string $page The page to redirect to
 * @param array $params Optional query parameters
 */
function redirect($page, $params = []) {
    $query = '';
    if (!empty($params)) {
        $query = '&' . http_build_query($params);
    }
    header("Location: ?page={$page}{$query}");
    exit;
}

/**
 * Format currency (KES)
 * 
 * @param float $amount The amount to format
 * @return string Formatted currency string
 */
function formatCurrency($amount) {
    return 'KES ' . number_format($amount, 2);
}

/**
 * Format datetime for display
 * 
 * @param string $datetime The datetime string
 * @param string $format Optional format string
 * @return string Formatted datetime
 */
function formatDateTime($datetime, $format = 'F j, Y g:i A') {
    $date = new DateTime($datetime);
    return $date->format($format);
}

/**
 * Generate a unique ticket code
 * 
 * @return string Unique ticket code
 */
function generateTicketCode() {
    return strtoupper(bin2hex(random_bytes(4))) . '-' . time() . '-' . random_int(100, 999);
}

/**
 * Validate email address
 * 
 * @param string $email Email to validate
 * @return bool True if valid, false otherwise
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Get flash message from session
 * 
 * @param string $key The flash message key
 * @return string|null The message or null if not set
 */
function getFlash($key) {
    if (isset($_SESSION['flash'][$key])) {
        $message = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $message;
    }
    return null;
}

/**
 * Set flash message in session
 * 
 * @param string $key The flash message key
 * @param string $message The message to store
 */
function setFlash($key, $message) {
    if (!isset($_SESSION['flash'])) {
        $_SESSION['flash'] = [];
    }
    $_SESSION['flash'][$key] = $message;
}

