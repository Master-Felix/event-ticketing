<?php
/**
 * Event Controller
 * 
 * This controller handles all event-related functionality including:
 * - Displaying a list of all events on the home page
 * - Showing detailed views of individual events
 * - Managing event-related operations
 */
class EventController extends Controller {

    /**
     * Display home page with list of all events
     * 
     * Fetches all events from the database, ordered by start_datetime in ascending order,
     * and passes them to the home view for display.
     * 
     * @return void
     */
    public function home() {
        // Retrieve all events from the database, ordered by start_datetime in ascending order
        // The 'ASC' parameter ensures events are shown from soonest to latest
        $events = Event::all('start_datetime', 'ASC');

        // Render the home view template and pass the events data to it
        // The 'events' variable will be available in the home view
        $this->view('home', [
            'events' => $events  // Pass the events array to the view
        ]);
    }

    /**
     * Display detailed view of a specific event
     * 
     * This method handles the display of a single event's details by its ID.
     * It performs validation, checks for event existence, and retrieves ticket availability
     * before rendering the event view.
     * 
     * @param int|null $id The unique identifier of the event to display
     * @return void
     */
    public function show(int $id = null) {
        // Validate that the provided ID is not null and is numeric
        // This prevents SQL injection and ensures data integrity
        if (is_null($id) || !is_numeric($id)) {
            // Set an error flash message to be displayed to the user
            setFlash('error', 'Invalid event ID.');
            // Redirect to the home page if validation fails
            redirect('home');
            return;  // Stop further execution
        }

        // Attempt to find the event in the database using the provided ID
        $event = Event::findById($id);
        
        // If no event is found with the given ID
        if (!$event) {
            // Set an appropriate error message
            setFlash('error', 'Event not found.');
            // Redirect back to the home page
            redirect('home');
            return;  // Stop further execution
        }

        // Get the count of available tickets for this event
        $availableTickets = Event::getAvailableTickets($id);
        
        // Check if there is at least one ticket available for booking
        $hasTickets = Event::hasAvailableTickets($id, 1);

        // Render the event detail view with the retrieved data
        // The view will have access to the event details, ticket count, and availability status
        $this->view('event', [
            'event' => $event,                    // Event details
            'availableTickets' => $availableTickets, // Number of available tickets
            'hasTickets' => $hasTickets           // Boolean indicating if tickets are available
        ]);
    }
}
