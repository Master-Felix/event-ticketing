<?php
/**
 * Event Detail View
 * Displays detailed information about a specific event
 */
?>

<div class="event-detail">
    <h1><?php echo e($event['title']); ?></h1>

    <?php if ($event['description']): ?>
        <div class="event-info">
            <h3>Description</h3>
            <p><?php echo nl2br(e($event['description'])); ?></p>
        </div>
    <?php endif; ?>

    <div class="event-info">
        <p><strong>📍 Location:</strong> <?php echo e($event['location']); ?></p>
        <p><strong>📅 Start Date:</strong> <?php echo formatDateTime($event['start_datetime']); ?></p>
        <?php if ($event['end_datetime']): ?>
            <p><strong>⏰ End Date:</strong> <?php echo formatDateTime($event['end_datetime']); ?></p>
        <?php endif; ?>
        <p><strong>💰 Price per Ticket:</strong> <?php echo formatCurrency($event['price']); ?></p>
        
        <?php if ($event['capacity'] > 0): ?>
            <?php if ($availableTickets === -1): ?>
                <p><strong>🎫 Availability:</strong> Unlimited tickets available</p>
            <?php else: ?>
                <p><strong>🎫 Available Tickets:</strong> <?php echo $availableTickets; ?> of <?php echo $event['capacity']; ?></p>
            <?php endif; ?>
        <?php else: ?>
            <p><strong>🎫 Availability:</strong> Unlimited tickets available</p>
        <?php endif; ?>
    </div>

    <?php if (!isLoggedIn()): ?>
        <div style="text-align: center; margin-top: 2rem;">
            <p style="margin-bottom: 1rem;">Please login to purchase tickets</p>
            <a href="?page=login" class="btn">Login to Buy Tickets</a>
        </div>
    <?php elseif (!$hasTickets): ?>
        <div style="text-align: center; margin-top: 2rem;">
            <p style="color: #721c24; margin-bottom: 1rem;">⚠️ This event is sold out</p>
            <a href="?page=home" class="btn btn-secondary">Browse Other Events</a>
        </div>
    <?php else: ?>
        <div style="margin-top: 2rem;">
            <h3>Purchase Tickets</h3>
            <form method="post" action="?page=buy&id=<?php echo $event['id']; ?>" style="max-width: 400px;">
                <div class="form-group">
                    <label for="qty">Quantity:</label>
                    <input 
                        type="number" 
                        id="qty" 
                        name="qty" 
                        value="1" 
                        min="1" 
                        <?php if ($availableTickets !== -1): ?>
                            max="<?php echo $availableTickets; ?>"
                        <?php endif; ?>
                        required
                    >
                    <?php if ($availableTickets !== -1): ?>
                        <small style="color: #666;">Maximum <?php echo $availableTickets; ?> tickets available</small>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn">Buy Tickets</button>
            </form>
        </div>
    <?php endif; ?>

    <div style="margin-top: 2rem;">
        <a href="?page=home" class="btn btn-secondary">← Back to Events</a>
    </div>
</div>

