<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Administrateur - Medilink</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-card {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .logo {
            color: var(--color-primary-blue);
            font-size: 2em;
            margin-bottom: 20px;
            display: block;
        }

        .admin-badge {
            background-color: var(--color-admin);
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8em;
            margin-bottom: 20px;
            display: inline-block;
            text-transform: uppercase;
            font-weight: bold;
        }

        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background-color: var(--color-admin);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-login:hover {
            background-color: #c0392b;
        }

        .error-msg {
            color: #dc3545;
            font-size: 0.9em;
            margin-top: 5px;
            display: block;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="logo"><i class="fas fa-heartbeat"></i> MediLink</div>
        <span class="admin-badge">Espace Administration</span>

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf

            <div class="input-group">
                <label for="email">Email Administrateur</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="input-group">
                <label for="password">Mot de Passe</label>
                <input type="password" id="password" name="password" required>
                @error('password') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn-login"><i class="fas fa-sign-in-alt"></i> Se Connecter</button>
        </form>

        <div style="margin-top: 20px;">
            <a href="{{ route('connexion') }}" style="color: #777; font-size: 0.9em; text-decoration: none;">&larr;
                Retour au site</a>
        </div>
    </div>
</body>

</html>