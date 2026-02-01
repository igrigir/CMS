<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>CMS | Register</title>
    <link rel="stylesheet" href="/vjezbe/cms/public/assets/css/auth.css">
</head>
<body>

<div class="auth-card">
    <h2>Create account</h2>

    <form method="post" action="index.php/register">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <div class="form-group">
            <label>Confirm password</label>
            <input type="password" name="confirm_password" required>
        </div>

        <button class="auth-button" type="submit" name="register">
            Register
        </button>
    </form>

    <div class="auth-footer">
        Already have an account?
        <a href="index.php/login">Login</a>
    </div>
</div>

</body>
</html>
