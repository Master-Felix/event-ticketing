<?php
/**
 * Authentication Controller
 * Handles user registration, login, and logout functionality
 */
class AuthController extends Controller {

    /**
     * Show registration form or process registration
     */
    public function register() {
        // If user is already logged in, redirect to home
        if (isLoggedIn()) {
            redirect('home');
        }

        // Handle POST request (form submission)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize and validate input
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Validation
            $errors = [];

            if (empty($name)) {
                $errors[] = 'Name is required.';
            } elseif (strlen($name) < 2) {
                $errors[] = 'Name must be at least 2 characters.';
            }

            if (empty($email)) {
                $errors[] = 'Email is required.';
            } elseif (!isValidEmail($email)) {
                $errors[] = 'Please enter a valid email address.';
            } elseif (User::emailExists($email)) {
                $errors[] = 'This email is already registered.';
            }

            if (empty($password)) {
                $errors[] = 'Password is required.';
            } elseif (strlen($password) < 6) {
                $errors[] = 'Password must be at least 6 characters.';
            }

            if ($password !== $confirmPassword) {
                $errors[] = 'Passwords do not match.';
            }

            // If no errors, create user
            if (empty($errors)) {
                $userId = User::create($name, $email, $password);
                
                if ($userId) {
                    // Set session and redirect
                    $_SESSION['user_id'] = $userId;
                    setFlash('success', 'Registration successful! Welcome to Event Ticketing.');
                    redirect('home');
                } else {
                    $errors[] = 'Registration failed. Please try again.';
                }
            }

            // If there are errors, show them
            if (!empty($errors)) {
                setFlash('error', implode(' ', $errors));
            }
        }

        // Render registration view
        $this->view('register', [
            'errors' => $errors ?? []
        ]);
    }

    /**
     * Show login form or process login
     */
    public function login() {
        // If user is already logged in, redirect to home
        if (isLoggedIn()) {
            redirect('home');
        }

        // Handle POST request (form submission)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize input
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            // Validation
            if (empty($email) || empty($password)) {
                setFlash('error', 'Email and password are required.');
            } else {
                // Verify credentials using User model
                $user = User::verify($email, $password);
                
                if ($user) {
                    // Set session and redirect
                    $_SESSION['user_id'] = $user['id'];
                    setFlash('success', 'Welcome back!');
                    redirect('home');
                } else {
                    setFlash('error', 'Invalid email or password.');
                }
            }
        }

        // Render login view
        $this->view('login');
    }

    /**
     * Logout user and destroy session
     */
    public function logout() {
        // Destroy session
        session_destroy();
        
        // Start new session for flash message
        session_start();
        setFlash('success', 'You have been logged out successfully.');
        
        redirect('home');
    }
}

