<?php
/**
 * Home Page View
 * Displays list of all available events
 */
?>

<h1>Upcoming Events</h1>

<?php if (empty($events)): ?>
    <div class="empty-state">
        <h3>No events available at the moment</h3>
        <p>Check back soon for exciting events!</p>
    </div>
<?php else: ?>
    <div class="event-grid">
        <?php foreach ($events as $event): ?>
            <div class="event-card">
                <a href="?page=event&id=<?php echo $event['id']; ?>">
                    <h3><?php echo e($event['title']); ?></h3>
                    <div class="event-meta">
                        <p>📍 <?php echo e($event['location']); ?></p>
                        <p>📅 <?php echo formatDateTime($event['start_datetime']); ?></p>
                        <?php if ($event['end_datetime']): ?>
                            <p>⏰ Ends: <?php echo formatDateTime($event['end_datetime']); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="event-price">
                        <?php echo formatCurrency($event['price']); ?>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

