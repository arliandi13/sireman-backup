<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style login.css">
</head>

<body>
    <div class="hero">
        <div class="wrapper">
            <div class="card-switch">
                <label class="switch">
                    <input class="toggle" type="checkbox">
                    <span class="slider"></span>
                    <span class="card-side"></span>

                    <div class="flip-card__inner">
                        <!-- Bagian Login -->
                        <div class="flip-card__front">
                            <div class="title">Log in</div>

                            <!-- Tampilkan notifikasi error jika ada -->
                            @if ($errors->any())
                                <div class="error-messages">
                                    @foreach ($errors->all() as $error)
                                        <p style="color: red;">{{ $error }}</p>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Form Login -->
                            <form action="{{ route('customer.login.post') }}" method="POST" class="flip-card__form">
                                @csrf
                                <input type="email" placeholder="Email" name="email" class="flip-card__input" required>
                                <input type="password" placeholder="Password" name="password" class="flip-card__input" required>
                                <button type="submit" class="flip-card__btn">Let`s go!</button>
                            </form>
                        </div>

                        <!-- Bagian Sign Up -->
                        <div class="flip-card__back">
                            <div class="title">Sign in</div>
                            <form action="{{ route('customer.register') }}" method="POST">
                                @csrf
                                <input type="text" name="name" placeholder="Nama" class="flip-card__input" required>
                                <input type="email" name="email" placeholder="Email" class="flip-card__input" required>
                                <input type="password" name="password" placeholder="Password" class="flip-card__input" required>
                                <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" class="flip-card__input" required>
                                <button class="flip-card__btn" type="submit">Create Account!</button>
                            </form>
                            </div>
                        </div>
                    </div>
                </label>
            </div>
        </div>
    </div>
</body>

</html>
