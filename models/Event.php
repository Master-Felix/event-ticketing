<?php
/**
 * Event Model
 * Handles all database operations related to events
 */
class Event {
    
    /**
     * Get all events, optionally ordered
     * 
     * @param string $orderBy Column to order by (default: start_datetime)
     * @param string $order Direction (ASC or DESC)
     * @return array Array of event records
     */
    public static function all($orderBy = 'start_datetime', $order = 'ASC') {
        $allowedColumns = ['start_datetime', 'title', 'price', 'created_at'];
        $orderBy = in_array($orderBy, $allowedColumns) ? $orderBy : 'start_datetime';
        $order = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';
        
        $stmt = db()->query("SELECT id, title, location, start_datetime, end_datetime, price, capacity FROM events ORDER BY {$orderBy} {$order}");
        return $stmt->fetchAll();
    }
    
    /**
     * Find event by ID
     * 
     * @param int $id Event ID
     * @return array|null Event data or null if not found
     */
    public static function findById($id) {
        $stmt = db()->prepare("SELECT * FROM events WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    /**
     * Get available tickets count for an event
     * 
     * @param int $eventId Event ID
     * @return int Number of available tickets
     */
    public static function getAvailableTickets($eventId) {
        $event = self::findById($eventId);
        if (!$event) {
            return 0;
        }
        
        // If capacity is 0, assume unlimited
        if ($event['capacity'] == 0) {
            return -1; // -1 means unlimited
        }
        
        // Count sold tickets
        $stmt = db()->prepare("SELECT SUM(quantity) FROM orders WHERE event_id = ? AND status = 'paid'");
        $stmt->execute([$eventId]);
        $sold = $stmt->fetchColumn() ?: 0;
        
        return max(0, $event['capacity'] - $sold);
    }
    
    /**
     * Check if event has available tickets
     * 
     * @param int $eventId Event ID
     * @param int $quantity Desired quantity
     * @return bool True if tickets are available, false otherwise
     */
    public static function hasAvailableTickets($eventId, $quantity = 1) {
        $available = self::getAvailableTickets($eventId);
        // -1 means unlimited
        return $available === -1 || $available >= $quantity;
    }
}

