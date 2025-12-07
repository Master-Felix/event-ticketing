<?php
/**
 * Login View
 * Displays login form for user authentication
 */
?>

<div style="max-width: 400px; margin: 0 auto;">
    <h1>Login</h1>
    <p style="margin-bottom: 1.5rem; color: #666;">Welcome back! Please login to your account.</p>

    <form method="post" action="?page=login">
        <div class="form-group">
            <label for="email">Email Address:</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                placeholder="your@email.com" 
                required 
                autofocus
            >
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                placeholder="Enter your password" 
                required
            >
        </div>

        <button type="submit" class="btn" style="width: 100%;">Login</button>
    </form>

    <div style="text-align: center; margin-top: 1.5rem;">
        <p style="color: #666;">Don't have an account? <a href="?page=register" style="color: #667eea;">Register here</a></p>
    </div>
</div>
