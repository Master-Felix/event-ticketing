<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? e($pageTitle) . ' - ' : ''; ?>Event Ticketing</title>
    <style>
        /* Modern CSS Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header/Navigation */
        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 15px 15px;
        }

        .nav {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: #667eea;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .nav-links a {
            color: #333;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: #667eea;
        }

        .btn {
            display: inline-block;
            padding: 0.6rem 1.5rem;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s;
            box-shadow: 0 2px 10px rgba(102, 126, 234, 0.3);
        }

        .btn:hover {
            background: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: #6c757d;
            box-shadow: 0 2px 10px rgba(108, 117, 125, 0.3);
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        /* Main Content */
        .main-content {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        /* Flash Messages */
        .flash-message {
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            animation: slideIn 0.3s ease-out;
        }

        .flash-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .flash-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Forms */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #555;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
        }

        /* Event Cards */
        .event-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .event-card {
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.3s;
            cursor: pointer;
        }

        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border-color: #667eea;
        }

        .event-card h3 {
            color: #667eea;
            margin-bottom: 0.5rem;
        }

        .event-card a {
            text-decoration: none;
            color: inherit;
        }

        .event-meta {
            color: #666;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }

        .event-price {
            font-size: 1.2rem;
            font-weight: bold;
            color: #667eea;
            margin-top: 0.5rem;
        }

        /* Event Detail */
        .event-detail {
            max-width: 800px;
            margin: 0 auto;
        }

        .event-detail h1 {
            color: #667eea;
            margin-bottom: 1rem;
        }

        .event-info {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            margin: 1.5rem 0;
        }

        .event-info p {
            margin: 0.5rem 0;
        }

        .event-info strong {
            color: #555;
        }

        /* Ticket List */
        .ticket-list {
            margin-top: 2rem;
        }

        .ticket-item {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .ticket-code {
            font-family: 'Courier New', monospace;
            font-weight: bold;
            color: #667eea;
        }

        /* Order Summary */
        .order-summary {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
        }

        .order-summary h3 {
            margin-bottom: 1rem;
            color: #667eea;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .nav {
                flex-direction: column;
                gap: 1rem;
            }

            .nav-links {
                flex-wrap: wrap;
                justify-content: center;
            }

            .event-grid {
                grid-template-columns: 1fr;
            }

            .main-content {
                padding: 1rem;
            }
        }

        /* Loading and Empty States */
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #666;
        }

        .empty-state h3 {
            margin-bottom: 1rem;
            color: #999;
        }
    </style>
</head>
<body>
    <!-- Navigation Header -->
    <header class="header">
        <nav class="nav">
            <a href="?page=home" class="logo">🎫 Event Ticketing</a>
            <div class="nav-links">
                <a href="?page=home">Home</a>
                <?php if (isLoggedIn()): ?>
                    <a href="?page=my-orders">My Orders</a>
                    <span><?php echo e(User::findById(getUserId())['name'] ?? 'User'); ?></span>
                    <a href="?page=logout" class="btn btn-secondary">Logout</a>
                <?php else: ?>
                    <a href="?page=login" class="btn">Login</a>
                    <a href="?page=register" class="btn btn-secondary">Register</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <!-- Main Content Container -->
    <div class="container">
        <!-- Flash Messages -->
        <?php 
        $success = getFlash('success');
        $error = getFlash('error');
        ?>
        <?php if ($success): ?>
            <div class="flash-message flash-success">
                <?php echo e($success); ?>
            </div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="flash-message flash-error">
                <?php echo e($error); ?>
            </div>
        <?php endif; ?>

        <!-- Page Content -->
        <div class="main-content">
            <?php echo $content; ?>
        </div>
    </div>
</body>
</html>

