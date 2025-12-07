# Event Ticketing System

A modern, PHP-based event ticketing application that allows users to browse events, purchase tickets, and manage their orders.

## Features

- ✅ User Registration & Authentication
- ✅ Event Browsing & Details
- ✅ Ticket Purchasing
- ✅ Order Management
- ✅ Modern, Responsive UI/UX
- ✅ Secure Password Hashing
- ✅ Input Validation & Sanitization
- ✅ Flash Message System
- ✅ MVC Architecture

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server (or AMPPS/XAMPP/WAMP)
- PDO MySQL extension enabled

## Installation

1. **Clone or download the project** to your web server directory (e.g., `htdocs`, `www`, etc.)

2. **Create the database** by running the SQL file:

   ```sql
   mysql -u root -p < event_ticketing.sql
   ```

   Or import `event_ticketing.sql` through phpMyAdmin or your MySQL client.

3. **Configure database connection** in `config/database.php`:

   ```php
   $host = "127.0.0.1";
   $dbname = "event_ticketing";
   $user = "root";
   $pass = "mysql";  // Change to your MySQL password
   ```

4. **Set up your web server**:
   - Point your document root to the `public` directory
   - Or access via: `http://localhost/event-ticketing/public/`

5. **Set proper permissions** (if needed):
   chmod -R 755 /path/to/event-ticketing

## Project Structure & File Documentation

### Root Level Files

- **README.md**: This file. Provides installation instructions, usage guide, and project overview.
- **event_ticketing.sql**: Database schema file containing all table definitions (events, users, orders, tickets). Import this to set up the database.

### `/config` Directory

**database.php**: Database configuration and connection file. Sets up PDO connection parameters (host, database name, username, password). Called by index.php to establish database connectivity.

### `/libs` Directory (Core Framework Libraries)

- **autoload.php**: Class autoloader that automatically includes model and controller files when instantiated. Implements PSR-4 style auto-loading from the models/ and app/controllers/ directories.

- **Controller.php**: Base controller class that all application controllers inherit from. Provides common methods like `view()` for rendering views and `isAuthenticated()` for checking user login status.

- **helpers.php**: Utility functions used throughout the application including:
  - `setFlash()`: Store flash messages in session
  - `getFlash()`: Retrieve and display flash messages
  - `redirect()`: Redirect to a different page
  - `sanitize()`: Sanitize user input
  - `isLoggedIn()`: Check if user is authenticated

### `/app/controllers` Directory (Request Handlers)

- **AuthController.php**: Handles user authentication. Methods include:
  - `register()`: Display registration form and process new user signups
  - `login()`: Display login form and authenticate users
  - `logout()`: Destroy session and log out users

- **EventController.php**: Manages event-related requests. Methods include:
  - `home()`: Display home page with list of all events
  - `show(int $id)`: Display detailed view of a specific event with available ticket count

- **OrderController.php**: Handles order and ticket purchasing. Methods include:
  - `buy(int $id)`: Process ticket purchase for an event
  - `show(int $id)`: Display order confirmation details
  - `myOrders()`: Display list of user's past orders

### `/app/views` Directory (User Interface Templates)

- **layout.php**: Master layout template that wraps all pages. Contains HTML structure, header/navigation, footer, and CSS styling. All other views are rendered within this layout.

- **home.php**: Home page view that displays list of all upcoming events with basic info and links to event details.

- **event.php**: Event detail page view showing full event information, description, location, date/time, ticket availability, and purchase button.

- **login.php**: Login form view with email and password input fields.

- **register.php**: Registration form view with name, email, password, and password confirmation fields.

- **order.php**: Order confirmation page view showing order details, purchased tickets, and total cost.

- **my-orders.php**: User dashboard view displaying all past orders with status and details.

### `/models` Directory (Data Layer)

- **User.php**: User model handling user-related database operations:
  - `create()`: Register new user with hashed password
  - `findByEmail()`: Retrieve user by email
  - `findById()`: Retrieve user by ID
  - `verify()`: Verify password during login

- **Event.php**: Event model managing event data:
  - `all()`: Get all events ordered by date
  - `findById()`: Get specific event details
  - `getAvailableTickets()`: Count remaining tickets
  - `hasAvailableTickets()`: Check if tickets are available

- **Order.php**: Order model for purchase history:
  - `create()`: Create new order record
  - `findById()`: Get order details
  - `getUserOrders()`: Get all orders for a user
  - `getOrderWithTickets()`: Get order and associated tickets

- **Ticket.php**: Ticket model for individual tickets:
  - `create()`: Create ticket record
  - `getEventTickets()`: Get all tickets for an event
  - `markAsSold()`: Mark ticket as purchased

### `/public` Directory (Web Root)

- **index.php**: Application entry point and main router. Handles:
  - Session initialization
  - Loading configuration and dependencies
  - Route parsing from `?page=` query parameter
  - Dispatcher that calls appropriate controller methods based on route
  - Routes handled: home, register, login, logout, event, buy, order, my-orders

## Usage

### Accessing the Application

1. Navigate to: `http://localhost/event-ticketing/public/` (or your configured URL)

2. **Register a new account** or **login** with existing credentials

3. **Browse events** on the home page

4. **View event details** by clicking on any event

5. **Purchase tickets** by selecting quantity and clicking "Buy Tickets"

6. **View your orders** in the "My Orders" section

### Adding Events

To add events to the database, you can use SQL:

```sql
INSERT INTO events (title, slug, description, location, start_datetime, end_datetime, capacity, price)
VALUES (
    'Concert Night',
    'concert-night-2024',
    'An amazing night of live music!',
    'Nairobi Arena',
    '2024-12-25 19:00:00',
    '2024-12-25 23:00:00',
    500,
    1500.00
);
```

## Architecture

The application follows an **MVC (Model-View-Controller)** pattern:

- **Models**: Handle database operations (`models/`)
- **Views**: Display data and user interface (`app/views/`)
- **Controllers**: Process requests and coordinate between models and views (`app/controllers/`)

### Key Components

- **Autoloader**: Automatically loads classes from their directories
- **Base Controller**: Provides common functionality (view rendering, authentication checks)
- **Helper Functions**: Utility functions for common tasks (sanitization, formatting, etc.)
- **Flash Messages**: User feedback system for success/error messages

## Security Features

- ✅ Password hashing using `password_hash()` with `PASSWORD_DEFAULT`
- ✅ Prepared statements to prevent SQL injection
- ✅ Input sanitization with `htmlspecialchars()`
- ✅ Session-based authentication
- ✅ CSRF protection ready (can be added)
- ✅ Input validation on all forms

## Customization

### Styling

The application uses inline CSS in `app/views/layout.php`. You can:

- Extract CSS to a separate file
- Modify colors, fonts, and spacing
- Add custom animations or effects

### Database

Modify `config/database.php` to change database connection settings.

### Routes

Add new routes in `public/index.php` by adding cases to the switch statement.

## Troubleshooting

### Database Connection Errors

- Verify MySQL is running
- Check database credentials in `config/database.php`
- Ensure database `event_ticketing` exists

### Page Not Found / 404 Errors

- Verify web server is pointing to the `public` directory
- Check `.htaccess` file if using Apache
- Ensure `mod_rewrite` is enabled (if using clean URLs)

### Session Issues

- Ensure `session_start()` is called before any output
- Check PHP `session.save_path` is writable
- Verify cookies are enabled in browser

## Future Enhancements

Potential features to add:

- [ ] Admin panel for event management
- [ ] PDF ticket generation
- [ ] Email notifications
- [ ] Payment gateway integration
- [ ] QR code generation for tickets
- [ ] Event search and filtering
- [ ] User profile management
- [ ] Ticket transfer functionality

## License

This project is open source and available for educational purposes.

## Support

For issues or questions, please check the code comments for detailed explanations of each component.
