<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Jayusman</title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Poppins&display=swap');
        * {
            box-sizing: border-box;
            font-family: 'Poppins';
        }
        body {
            margin: 0;
            padding: 0;
            background: url('/asset/img/logo.jpg') no-repeat center center / cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-form {
            width: 100%;
            max-width: 400px;
            border-radius: 24px;
            padding: 15px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2), 0 6px 20px rgba(0, 0, 0, 0.19);
        }
        .login-form h1 {
            text-align: center;
            font-size: 20px;
            margin-top: 20px;
        }
        .login-form p {
            text-align: center;
            margin: 10px 0;
        }
        .login-form input[type="text"],
        .login-form input[type="password"],
        .login-form select {
            width: 100%;
            border: none;
            border-radius: 24px;
            font-size: 12px;
            background-color: gainsboro;
            padding: 10px;
            margin-top: 10px;
        }
        .login-form input:focus,
        .login-form select:focus {
            border: 2px solid #21D4FD;
            outline: none;
        }
        .login-form button {
            background-image: linear-gradient(19deg, #21D4FD 0%, #0099ff 100%);
            width: 100%;
            color: white;
            border: none;
            margin-top: 20px;
            padding: 10px;
            font-size: 12px;
            font-weight: bold;
            border-radius: 24px;
            cursor: pointer;
            transition: opacity 0.25s;
        }
        .login-form button:hover {
            opacity: 0.8;
        }
        .invalid-feedback {
            display: block;
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }
        @media (max-width: 600px) {
            .login-form {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="login-form">
        <form action="{{ route('login') }}" method="POST">
            <center>
                <img src="{{ asset('/asset/img/logo.jpg') }}" alt="Logo" class="img img-thumbnail border-0" width="200">
            </center>
            <h1>Aplikasi Jayusman</h1>
            @csrf
            <input type="text" name="email" placeholder="Email">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <input type="password" name="password" placeholder="Password" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <select name="level" class="form-control @error('level') is-invalid @enderror" required>
                <option value="">Select Role</option>
                <option value="owner" {{ old('role') == 'owner' ? 'selected' : '' }}>Owner</option>
                <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                <option value="supervisor" {{ old('role') == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                <option value="cashier" {{ old('role') == 'cashier' ? 'selected' : '' }}>Cashier</option>
                <option value="warehouse_staff" {{ old('role') == 'warehouse_staff' ? 'selected' : '' }}>Warehouse Staff</option>
            </select>
            @error('level')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
