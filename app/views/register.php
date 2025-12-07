<?php
/**
 * Registration View
 * Displays registration form for new users
 */
?>

<div style="max-width: 400px; margin: 0 auto;">
    <h1>Create Account</h1>
    <p style="margin-bottom: 1.5rem; color: #666;">Join us to purchase tickets for amazing events!</p>

    <form method="post" action="?page=register">
        <div class="form-group">
            <label for="name">Full Name:</label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                placeholder="John Doe" 
                required 
                autofocus
                minlength="2"
            >
        </div>

        <div class="form-group">
            <label for="email">Email Address:</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                placeholder="your@email.com" 
                required
            >
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                placeholder="At least 6 characters" 
                required
                minlength="6"
            >
            <small style="color: #666;">Password must be at least 6 characters long</small>
        </div>

        <div class="form-group">
            <label for="confirm_password">Confirm Password:</label>
            <input 
                type="password" 
                id="confirm_password" 
                name="confirm_password" 
                placeholder="Re-enter your password" 
                required
                minlength="6"
            >
        </div>

        <button type="submit" class="btn" style="width: 100%;">Register</button>
    </form>

    <div style="text-align: center; margin-top: 1.5rem;">
        <p style="color: #666;">Already have an account? <a href="?page=login" style="color: #667eea;">Login here</a></p>
    </div>
</div>
