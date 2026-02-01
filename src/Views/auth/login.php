<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>CMS | Login</title>
    <link rel="stylesheet" href="/vjezbe/cms/public/assets/css/auth.css">
</head>
<body>

<div class="auth-card">
    <h2>Sign in to CMS</h2>

    <form method="post" action="index.php/login">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <button class="auth-button" type="submit" name="login">
            Login
        </button>
    </form>

    <div class="auth-footer">
        No account?
        <a href="index.php/register">Register</a>
    </div>
</div>

</body>
</html>
