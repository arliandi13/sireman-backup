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
                            <form action="{{ url('/login') }}" method="POST" class="flip-card__form">
                                @csrf
                                <input type="email" placeholder="Email" name="email" class="flip-card__input" required>
                                <input type="password" placeholder="Password" name="password" class="flip-card__input" required>
                                <button type="submit" class="flip-card__btn">Let`s go!</button>
                            </form>
                        </div>

                        <!-- Bagian Sign Up -->
                        <div class="flip-card__back">
                            <div class="title">Sign in</div>
                                <form action="{{ route('login') }}" method="POST">
                                    @csrf

                                    <!-- Nama -->
                                    <div>
                                        <label class="flip-card__input" for="name">Nama:</label>
                                        <input type="text" name="name" id="name" class="flip-card__input" required>
                                    </div>

                                    <!-- Email -->
                                    <div>
                                        <label class="flip-card__input" for="email">Email:</label>
                                        <input type="email" name="email" id="email" class="flip-card__input" required>
                                    </div>

                                    <!-- Password -->
                                    <div>
                                        <label class="flip-card__input" for="password">Password:</label>
                                        <input type="password" name="password" id="password" class="flip-card__input" required>
                                    </div>

                                    <!-- Konfirmasi Password -->
                                    <div>
                                        <label class="flip-card__input" for="password_confirmation">Konfirmasi Password:</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="flip-card__input" required>
                                    </div>

                                    <!-- Role -->
                                    <div class="form-group">
                                        <label class="flip-card__input" for="role">Role:</label>
                                        <select name="role" id="role" class="flip-card__input" required>
                                            <option value="pemilik">Pemilik</option>
                                            <option value="kasir">Kasir</option>
                                            <option value="waiters">Waiters</option>
                                            <option value="koki">Koki</option>
                                        </select>
                                    </div>
                                </form>
                                <div>
                                    <button class="flip-card__btn" type="submit">Create Account!</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </label>
            </div>
        </div>
    </div>
</body>

</html>
