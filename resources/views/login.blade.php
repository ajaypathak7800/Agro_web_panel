<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
       body, html {
    height: 100%;
    margin: 0;
    font-family: Arial, Helvetica, sans-serif;
    background-color: #bbbbbb; /* Light gray background */
    display: flex;
    justify-content: center;
    align-items: center;
}

.container {
    width: 100%;
    max-width: 400px; /* Adjust as needed */
    padding: 20px;
    box-sizing: border-box;
    text-align: center;
}

.form-container {
    display: none;
    background-color: #ffffff;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.form-container.active-form {
    display: block;
}

.form-container h2 {
    margin-bottom: 20px;
    color: #333;
}

input[type=text], input[type=password], input[type=email] {
    width: calc(100% - 40px);
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

button {
    background-color: #2f3835;
    color: white;
    padding: 14px 20px;
    margin: 10px 0;
    border: none;
    cursor: pointer;
    width: calc(100% - 40px);
    border-radius: 4px;
}

button:hover {
    opacity: 0.8;
}

.btn-link {
    color: #ffffff;
    text-decoration: none;
    display: inline-block;
    margin-top: 10px;
}

.btn-link:hover {
    text-decoration: underline;
}

.alert {
    margin-top: 10px;
    padding: 15px;
    border-radius: 4px;
}

.alert-success {
    background-color: #5cb85c; /* Green */
    color: #fff;
}

.alert-danger {
    background-color: #d9534f; /* Red */
    color: #fff;
}

.close {
    float: right;
    font-size: 20px;
    font-weight: bold;
    cursor: pointer;
    color: #333;
}
.avatar {
  width: 70px; /* Adjust width as needed */
  height: 70px; /* Adjust height as needed */
}
    </style>
</head>
<body>
<div class="container">
    <!-- Login and Registration Forms -->
    <div>
        <!-- Login Form -->
        <div id="login-form" class="form-container active-form">
            <div class="imgcontainer">
                <img src="/assets/image/user.png" alt="Avatar" class="avatar">
            </div>
            <h2>Login</h2>
            
            <form method="POST" action="{{ route('auth') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit">Login</button>
               
                <button type="button" class="btn-link" id="show-register-form">Register</button>
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
               
            </form>
        </div>

        <div id="register-form" class="form-container">
            <h2>Register</h2>
            <form id="registerForm">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="reg_email">Email address</label>
                    <input type="email" class="form-control" id="reg_email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="reg_password">Password</label>
                    <input type="password" class="form-control" id="reg_password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
                <button type="submit">Register</button>
              
              
                <button type="button" class="btn-link" id="show-login-form">Login</button>
                <div id="message" class="mt-3"></div>
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Switch between forms
        $('#show-register-form').click(function() {
            $('#login-form').removeClass('active-form');
            $('#register-form').addClass('active-form');
        });
        
        $('#show-login-form').click(function() {
            $('#register-form').removeClass('active-form');
            $('#login-form').addClass('active-form');
        });

        // Handle registration form submission
        $('#registerForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: '{{ route("register") }}',
                type: 'POST',
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                message: function(response) {
                    // Use SweetAlert for success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Registration successful! Redirecting...',
                        showConfirmButton: false,
                        timer: 2000  // Auto close after 2 seconds
                    }).then(function() {
                        window.location.href = '{{ route("admin.dashboard") }}';
                    });
                },
                error: function(xhr) {
                    // Handle validation errors with SweetAlert
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = '';
                    for (let key in errors) {
                        if (errors.hasOwnProperty(key)) {
                            errorMessages += errors[key][0] + '<br>';
                        }
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Registration',
                        html: errorMessages
                    });
                }
            });
        });
    });
</script>

</body>
</html>
