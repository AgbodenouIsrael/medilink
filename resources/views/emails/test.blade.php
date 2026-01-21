<!DOCTYPE html>
<html>
<head>
    <title>Email de Test</title>
</head>
<body>
    <h1>Bonjour !</h1>
    <p>Ceci est un email de test depuis {{ config('app.name') }}</p>
    <p>Date d'envoi : {{ now()->format('d/m/Y H:i') }}</p>
    
    <hr>
    <p>Si vous recevez cet email, votre configuration SMTP fonctionne correctement !</p>
</body>
</html>