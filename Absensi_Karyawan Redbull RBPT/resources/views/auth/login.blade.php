<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Red Bull Racing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Rajdhani', sans-serif;
            background: linear-gradient(135deg, #0c0e16 0%, #1a1d2e 50%, #0c0e16 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Animated Background */
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }

        .bg-animation span {
            position: absolute;
            display: block;
            width: 20px;
            height: 20px;
            background: rgba(220, 0, 0, 0.2);
            animation: move 25s infinite linear;
            bottom: -150px;
        }

        .bg-animation span:nth-child(1) {
            left: 25%;
            width: 80px;
            height: 80px;
            animation-delay: 0s;
        }

        .bg-animation span:nth-child(2) {
            left: 10%;
            width: 20px;
            height: 20px;
            animation-delay: 2s;
            animation-duration: 12s;
        }

        .bg-animation span:nth-child(3) {
            left: 70%;
            width: 20px;
            height: 20px;
            animation-delay: 4s;
        }

        .bg-animation span:nth-child(4) {
            left: 40%;
            width: 60px;
            height: 60px;
            animation-delay: 0s;
            animation-duration: 18s;
        }

        .bg-animation span:nth-child(5) {
            left: 65%;
            width: 20px;
            height: 20px;
            animation-delay: 0s;
        }

        .bg-animation span:nth-child(6) {
            left: 75%;
            width: 110px;
            height: 110px;
            animation-delay: 3s;
        }

        .bg-animation span:nth-child(7) {
            left: 35%;
            width: 150px;
            height: 150px;
            animation-delay: 7s;
        }

        .bg-animation span:nth-child(8) {
            left: 50%;
            width: 25px;
            height: 25px;
            animation-delay: 15s;
            animation-duration: 45s;
        }

        @keyframes move {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
                border-radius: 0;
            }
            100% {
                transform: translateY(-1000px) rotate(720deg);
                opacity: 0;
                border-radius: 50%;
            }
        }

        /* Racing Stripe */
        .racing-stripe {
            position: fixed;
            top: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(to right, #DC0000, #FCD700, #0600EF);
            z-index: 9999;
            animation: raceStripe 2s linear infinite;
        }

        @keyframes raceStripe {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        /* Login Container */
        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(220, 0, 0, 0.3);
            border-radius: 30px;
            padding: 3rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            animation: slideIn 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.05), transparent);
            transform: rotate(45deg);
            animation: shine 3s infinite;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-100px) scale(0.8);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes shine {
            0% { transform: translateX(-100%) rotate(45deg); }
            100% { transform: translateX(100%) rotate(45deg); }
        }

        /* Logo */
        .rb-logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .rb-logo-img {
            max-width: 400px;
            width: 100%;
            height: auto;
            margin: 0 auto;
            display: block;
            animation: pulse 2s ease-in-out infinite;
            filter: brightness(1.1);
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .rb-logo h2 {
            color: #FCD700;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-top: 1rem;
            font-size: 1.5rem;
        }

        .rb-logo p {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }

        /* Form Controls */
        .form-floating {
            margin-bottom: 1.5rem;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(220, 0, 0, 0.3);
            color: #fff;
            border-radius: 15px;
            padding: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: #DC0000;
            box-shadow: 0 0 20px rgba(220, 0, 0, 0.5);
            color: #fff;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .form-floating label {
            color: rgba(255, 255, 255, 0.7);
            padding-left: 1rem;
        }

        .form-floating .form-control:focus ~ label,
        .form-floating .form-control:not(:placeholder-shown) ~ label {
            color: #FCD700;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #DC0000;
            z-index: 10;
        }

        /* Button */
        .btn-rb {
            background: linear-gradient(135deg, #DC0000 0%, #0600EF 100%);
            border: none;
            color: #fff;
            padding: 1rem 2rem;
            border-radius: 15px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(220, 0, 0, 0.4);
            position: relative;
            overflow: hidden;
            width: 100%;
        }

        .btn-rb::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: left 0.3s;
        }

        .btn-rb:hover::before {
            left: 100%;
        }

        .btn-rb:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(220, 0, 0, 0.6);
        }

        /* Remember Me */
        .form-check {
            margin: 1rem 0;
        }

        .form-check-input {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(220, 0, 0, 0.3);
        }

        .form-check-input:checked {
            background-color: #DC0000;
            border-color: #DC0000;
        }

        .form-check-label {
            color: rgba(255, 255, 255, 0.8);
            margin-left: 0.5rem;
        }

        /* Alert */
        .alert {
            background: rgba(220, 0, 0, 0.2);
            border: 2px solid #DC0000;
            border-radius: 15px;
            color: #fff;
            margin-bottom: 1.5rem;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .login-card {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="racing-stripe"></div>
    
    <div class="bg-animation">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>

    <div class="login-container">
        <div class="login-card">
            <div class="rb-logo">
                <img src="https://1000logos.net/wp-content/uploads/2021/04/Red-Bull-logo.png" alt="Oracle Red Bull Racing" class="rb-logo-img">
                <h2>Attendance System</h2>
                <p>Login to Continue</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-floating mb-3">
                    <input type="email" 
                           class="form-control ps-5 @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           placeholder="name@example.com" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus>
                    <label for="email">
                        <i class="fas fa-envelope me-2"></i>Email Address
                    </label>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input type="password" 
                           class="form-control ps-5 @error('password') is-invalid @enderror" 
                           id="password" 
                           name="password" 
                           placeholder="Password" 
                           required>
                    <label for="password">
                        <i class="fas fa-lock me-2"></i>Password
                    </label>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check">
                    <input class="form-check-input" 
                           type="checkbox" 
                           name="remember" 
                           id="remember" 
                           {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        Remember Me
                    </label>
                </div>

                <button type="submit" class="btn btn-rb">
                    <i class="fas fa-sign-in-alt me-2"></i>Login
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
