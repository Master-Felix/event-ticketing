<?php
/**
 * Base Controller class
 * Provides common functionality for all controllers
 */
class Controller {
    
    /**
     * Render a view file
     * 
     * @param string $viewName The name of the view file (without .php extension)
     * @param array $data Optional data to pass to the view
     */
    protected function view($viewName, $data = []) {
        // Extract data array to variables for use in view
        extract($data);
        
        // Start output buffering
        ob_start();
        
        // Include the view file
        $viewPath = __DIR__ . '/../app/views/' . $viewName . '.php';
        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            die("View not found: {$viewName}");
        }
        
        // Get the buffered content
        $content = ob_get_clean();
        
        // Include layout if it exists
        $layoutPath = __DIR__ . '/../app/views/layout.php';
        if (file_exists($layoutPath)) {
            require $layoutPath;
        } else {
            // If no layout, just output the content
            echo $content;
        }
    }
    
    /**
     * Render JSON response
     * 
     * @param array $data Data to encode as JSON
     * @param int $statusCode HTTP status code
     */
    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    /**
     * Check if user is authenticated, redirect if not
     * 
     * @param string $redirectPage Page to redirect to if not authenticated
     */
    protected function requireAuth($redirectPage = 'login') {
        if (!isLoggedIn()) {
            setFlash('error', 'Please login to access this page.');
            redirect($redirectPage);
        }
    }
    
    /**
     * Check if user is admin
     * 
     * @return bool True if user is admin, false otherwise
     */
    protected function isAdmin() {
        if (!isLoggedIn()) {
            return false;
        }
        
        $stmt = db()->prepare("SELECT role FROM users WHERE id = ?");
        $stmt->execute([getUserId()]);
        $user = $stmt->fetch();
        
        return $user && $user['role'] === 'admin';
    }
    
    /**
     * Require admin access, redirect if not admin
     */
    protected function requireAdmin() {
        $this->requireAuth();
        if (!$this->isAdmin()) {
            setFlash('error', 'Access denied. Admin privileges required.');
            redirect('home');
        }
    }
}

