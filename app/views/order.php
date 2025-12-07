<?php
/**
 * Order Detail View
 * Displays order confirmation and ticket details
 */
?>

<h1>Order Confirmation</h1>

<div class="order-summary">
    <h3>Order #<?php echo $order['id']; ?></h3>
    <p><strong>Event:</strong> <?php echo e($order['event_title']); ?></p>
    <p><strong>Location:</strong> <?php echo e($order['location']); ?></p>
    <p><strong>Date:</strong> <?php echo formatDateTime($order['start_datetime']); ?></p>
    <p><strong>Quantity:</strong> <?php echo $order['quantity']; ?> ticket(s)</p>
    <p><strong>Total Amount:</strong> <?php echo formatCurrency($order['total']); ?></p>
    <p><strong>Status:</strong> 
        <span style="color: <?php echo $order['status'] === 'paid' ? '#28a745' : '#ffc107'; ?>;">
            <?php echo strtoupper($order['status']); ?>
        </span>
    </p>
    <p><strong>Order Date:</strong> <?php echo formatDateTime($order['created_at']); ?></p>
</div>

<div class="ticket-list">
    <h3>Your Tickets (<?php echo count($tickets); ?>)</h3>
    
    <?php if (empty($tickets)): ?>
        <p style="color: #666;">No tickets found for this order.</p>
    <?php else: ?>
        <?php foreach ($tickets as $ticket): ?>
            <div class="ticket-item">
                <div>
                    <p><strong>Ticket Code:</strong> <span class="ticket-code"><?php echo e($ticket['ticket_code']); ?></span></p>
                    <p style="color: #666; font-size: 0.9rem;">Holder: <?php echo e($ticket['holder_name']); ?></p>
                    <?php if ($ticket['used']): ?>
                        <p style="color: #721c24; font-size: 0.9rem;">⚠️ This ticket has been used</p>
                    <?php else: ?>
                        <p style="color: #28a745; font-size: 0.9rem;">✓ Valid</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div style="margin-top: 2rem;">
    <a href="?page=home" class="btn btn-secondary">← Back to Events</a>
    <a href="?page=my-orders" class="btn">View All Orders</a>
</div>

