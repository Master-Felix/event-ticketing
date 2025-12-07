<?php
/**
 * User Model
 * Handles all database operations related to users
 */
class User {
    
    /**
     * Find user by ID
     * 
     * @param int $id User ID
     * @return array|null User data or null if not found
     */
    public static function findById($id) {
        $stmt = db()->prepare("SELECT id, name, email, role, created_at FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    /**
     * Find user by email
     * 
     * @param string $email User email
     * @return array|null User data or null if not found
     */
    public static function findByEmail($email) {
        $stmt = db()->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
    
    /**
     * Create a new user
     * 
     * @param string $name User's full name
     * @param string $email User's email address
     * @param string $password Plain text password (will be hashed)
     * @return int|false New user ID on success, false on failure
     */
    public static function create($name, $email, $password) {
        // Hash the password
        $hash = password_hash($password, PASSWORD_DEFAULT);
        
        try {
            $stmt = db()->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $hash]);
            return db()->lastInsertId();
        } catch (PDOException $e) {
            // Check for duplicate email error
            if ($e->errorInfo[1] == 1062) {
                return false;
            }
            throw $e;
        }
    }
    
    /**
     * Verify user credentials
     * 
     * @param string $email User email
     * @param string $password Plain text password
     * @return array|false User data if credentials are valid, false otherwise
     */
    public static function verify($email, $password) {
        $user = self::findByEmail($email);
        
        if ($user && password_verify($password, $user['password'])) {
            // Remove password from returned data
            unset($user['password']);
            return $user;
        }
        
        return false;
    }
    
    /**
     * Check if email already exists
     * 
     * @param string $email Email to check
     * @return bool True if email exists, false otherwise
     */
    public static function emailExists($email) {
        $stmt = db()->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }
}

