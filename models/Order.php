<?php
/**
 * Order Model
 * Handles all database operations related to orders
 */
class Order {
    
    /**
     * Create a new order
     * 
     * @param int $userId User ID
     * @param int $eventId Event ID
     * @param int $quantity Number of tickets
     * @param float $total Total price
     * @param string $status Order status (default: 'paid')
     * @return int|false New order ID on success, false on failure
     */
    public static function create($userId, $eventId, $quantity, $total, $status = 'paid') {
        try {
            $stmt = db()->prepare("INSERT INTO orders (user_id, event_id, quantity, total, status) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$userId, $eventId, $quantity, $total, $status]);
            return db()->lastInsertId();
        } catch (PDOException $e) {
            error_log("Order creation failed: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Find order by ID
     * 
     * @param int $id Order ID
     * @return array|null Order data with event information or null if not found
     */
    public static function findById($id) {
        $stmt = db()->prepare("
            SELECT o.*, e.title as event_title, e.location, e.start_datetime 
            FROM orders o 
            JOIN events e ON o.event_id = e.id 
            WHERE o.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    /**
     * Get orders for a specific user
     * 
     * @param int $userId User ID
     * @return array Array of order records
     */
    public static function findByUserId($userId) {
        $stmt = db()->prepare("
            SELECT o.*, e.title as event_title 
            FROM orders o 
            JOIN events e ON o.event_id = e.id 
            WHERE o.user_id = ? 
            ORDER BY o.created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
    
    /**
     * Update order status
     * 
     * @param int $orderId Order ID
     * @param string $status New status
     * @return bool True on success, false on failure
     */
    public static function updateStatus($orderId, $status) {
        $allowedStatuses = ['pending', 'paid', 'cancelled'];
        if (!in_array($status, $allowedStatuses)) {
            return false;
        }
        
        $stmt = db()->prepare("UPDATE orders SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $orderId]);
    }
}

