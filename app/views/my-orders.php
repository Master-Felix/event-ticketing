<?php
/**
 * My Orders View
 * Displays user's order history
 */
?>

<h1>My Orders</h1>

<?php if (empty($orders)): ?>
    <div class="empty-state">
        <h3>No orders yet</h3>
        <p>Start browsing events to purchase tickets!</p>
        <a href="?page=home" class="btn" style="margin-top: 1rem;">Browse Events</a>
    </div>
<?php else: ?>
    <div style="margin-top: 2rem;">
        <?php foreach ($orders as $order): ?>
            <div class="event-card" style="margin-bottom: 1.5rem;">
                <h3>
                    <a href="?page=order&id=<?php echo $order['id']; ?>" style="color: #667eea;">
                        Order #<?php echo $order['id']; ?> - <?php echo e($order['event_title']); ?>
                    </a>
                </h3>
                <div class="event-meta">
                    <p><strong>Quantity:</strong> <?php echo $order['quantity']; ?> ticket(s)</p>
                    <p><strong>Total:</strong> <?php echo formatCurrency($order['total']); ?></p>
                    <p><strong>Status:</strong> 
                        <span style="color: <?php echo $order['status'] === 'paid' ? '#28a745' : '#ffc107'; ?>;">
                            <?php echo strtoupper($order['status']); ?>
                        </span>
                    </p>
                    <p><strong>Order Date:</strong> <?php echo formatDateTime($order['created_at']); ?></p>
                </div>
                <a href="?page=order&id=<?php echo $order['id']; ?>" class="btn" style="margin-top: 1rem;">View Details</a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

