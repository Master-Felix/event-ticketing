<?php
/**
 * Ticket Model
 * Handles all database operations related to tickets
 */
class Ticket {
    
    /**
     * Create a new ticket
     * 
     * @param int $orderId Order ID
     * @param string $ticketCode Unique ticket code
     * @param string $holderName Name of ticket holder
     * @return int|false New ticket ID on success, false on failure
     */
    public static function create($orderId, $ticketCode, $holderName) {
        try {
            $stmt = db()->prepare("INSERT INTO tickets (order_id, ticket_code, holder_name) VALUES (?, ?, ?)");
            $stmt->execute([$orderId, $ticketCode, $holderName]);
            return db()->lastInsertId();
        } catch (PDOException $e) {
            error_log("Ticket creation failed: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Find ticket by ID
     * 
     * @param int $id Ticket ID
     * @return array|null Ticket data or null if not found
     */
    public static function findById($id) {
        $stmt = db()->prepare("SELECT * FROM tickets WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    /**
     * Get all tickets for an order
     * 
     * @param int $orderId Order ID
     * @return array Array of ticket records
     */
    public static function findByOrderId($orderId) {
        $stmt = db()->prepare("SELECT * FROM tickets WHERE order_id = ? ORDER BY created_at ASC");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll();
    }
    
    /**
     * Find ticket by code
     * 
     * @param string $code Ticket code
     * @return array|null Ticket data or null if not found
     */
    public static function findByCode($code) {
        $stmt = db()->prepare("SELECT * FROM tickets WHERE ticket_code = ?");
        $stmt->execute([$code]);
        return $stmt->fetch();
    }
    
    /**
     * Mark ticket as used
     * 
     * @param int $ticketId Ticket ID
     * @return bool True on success, false on failure
     */
    public static function markAsUsed($ticketId) {
        $stmt = db()->prepare("UPDATE tickets SET used = TRUE WHERE id = ?");
        return $stmt->execute([$ticketId]);
    }
    
    /**
     * Check if ticket code is unique
     * 
     * @param string $code Ticket code to check
     * @return bool True if unique, false if already exists
     */
    public static function isCodeUnique($code) {
        $stmt = db()->prepare("SELECT COUNT(*) FROM tickets WHERE ticket_code = ?");
        $stmt->execute([$code]);
        return $stmt->fetchColumn() == 0;
    }
}

