<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <label for="token">Enter your password reset token:</label>
    <input type="text" id="token" name="token" required>
    <label for="new_password">Enter your new password:</label>
    <input type="password" id="new_password" name="new_password" required>
    <button type="submit">Reset Password</button>
</form>