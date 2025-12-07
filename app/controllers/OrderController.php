<?php
/**
 * Order Controller
 * Handles ticket purchasing and order management
 */
class OrderController extends Controller {

    /**
     * Process ticket purchase
     * 
     * @param int|null $eventId Event ID
     */
    public function buy($eventId) {
        // Require authentication
        $this->requireAuth();

        // Validate event ID
        if (!$eventId || !is_numeric($eventId)) {
            setFlash('error', 'Invalid event ID.');
            redirect('home');
        }

        // Only process POST requests
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('event', ['id' => $eventId]);
        }

        // Get and validate quantity
        $qty = max(1, intval($_POST['qty'] ?? 1));
        
        if ($qty < 1) {
            setFlash('error', 'Quantity must be at least 1.');
            redirect('event', ['id' => $eventId]);
        }

        // Find event using Event model
        $event = Event::findById($eventId);
        
        if (!$event) {
            setFlash('error', 'Event not found.');
            redirect('home');
        }

        // Check ticket availability
        if (!Event::hasAvailableTickets($eventId, $qty)) {
            $available = Event::getAvailableTickets($eventId);
            $message = $available === 0 
                ? 'Sorry, this event is sold out.' 
                : "Only {$available} ticket(s) available.";
            setFlash('error', $message);
            redirect('event', ['id' => $eventId]);
        }

        // Calculate total
        $total = $event['price'] * $qty;

        // Create order using Order model
        $orderId = Order::create(getUserId(), $eventId, $qty, $total, 'paid');
        
        if (!$orderId) {
            setFlash('error', 'Failed to create order. Please try again.');
            redirect('event', ['id' => $eventId]);
        }

        // Get user information for ticket holder name
        $user = User::findById(getUserId());
        $holderName = $user['name'] ?? 'Attendee';

        // Generate tickets using Ticket model
        for ($i = 0; $i < $qty; $i++) {
            // Generate unique ticket code
            $code = generateTicketCode();
            
            // Ensure code is unique (retry if needed)
            while (!Ticket::isCodeUnique($code)) {
                $code = generateTicketCode();
            }
            
            // Create ticket
            Ticket::create($orderId, $code, $holderName);
        }

        // Redirect to order confirmation page
        setFlash('success', 'Tickets purchased successfully!');
        redirect('order', ['id' => $orderId]);
    }

    /**
     * Display order details and tickets
     * 
     * @param int|null $orderId Order ID
     */
    public function show($orderId) {
        // Validate order ID
        if (!$orderId || !is_numeric($orderId)) {
            setFlash('error', 'Invalid order ID.');
            redirect('home');
        }

        // Find order using Order model
        $order = Order::findById($orderId);
        
        if (!$order) {
            setFlash('error', 'Order not found.');
            redirect('home');
        }

        // Check if user owns this order (unless admin)
        if (!isLoggedIn() || (getUserId() != $order['user_id'] && !$this->isAdmin())) {
            setFlash('error', 'You do not have permission to view this order.');
            redirect('home');
        }

        // Get tickets for this order using Ticket model
        $tickets = Ticket::findByOrderId($orderId);

        // Render order view
        $this->view('order', [
            'order' => $order,
            'tickets' => $tickets
        ]);
    }

    /**
     * Display user's order history
     */
    public function myOrders() {
        // Require authentication
        $this->requireAuth();

        // Get user's orders using Order model
        $orders = Order::findByUserId(getUserId());

        // Render my orders view
        $this->view('my-orders', [
            'orders' => $orders
        ]);
    }
}
