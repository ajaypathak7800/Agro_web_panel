<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .container label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .container input[type="text"],
        .container input[type="password"],
        .container input[type="email"] {
            width: 93%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .container button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .container button:hover {
            background-color: #45a049;
        }
        .container .link {
            text-align: center;
            margin-top: 10px;
        }
        .container .link a {
            color: #4CAF50;
            text-decoration: none;
        }
        .container .link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container" id="login-form">
        <h2>Login</h2>
        <form action="/login" method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Login</button>
        </form>
        <div class="link">
            <a href="#" onclick="showRegistrationForm()">Create an account</a>
        </div>
    </div>

    <div class="container" id="registration-form" style="display: none;">
        <h2>Register</h2>
        <form action="/register" method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Register</button>
        </form>
        <div class="link">
            <a href="#" onclick="showLoginForm()">Already have an account? Login</a>
        </div>
    </div>

    <script>
        function showRegistrationForm() {
            document.getElementById('login-form').style.display = 'none';
            document.getElementById('registration-form').style.display = 'block';
        }

        function showLoginForm() {
            document.getElementById('registration-form').style.display = 'none';
            document.getElementById('login-form').style.display = 'block';
        }
    </script>
</body>
</html>
