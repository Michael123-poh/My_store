<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - M&Y STORE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #f8f9fa, #e8f0ff);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .login-card {
            max-width: 400px;
            width: 100%;
            border: none;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 1rem;
        }
        .login-card .card-body {
            padding: 2rem;
        }
        .brand-icon {
            font-size: 3rem;
            color: #0d6efd;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #0d6efd;
        }
        .btn-primary {
            background-color: #0d6efd;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0b5ed7;
        }
    </style>
</head>
<body>
    <div class="card login-card">
        <div class="card-body text-center">
            <div class="mb-4">
                <i class="bi bi-box-seam brand-icon"></i>
                <h4 class="mt-2">Connexion</h4>
                <p class="text-muted">Bienvenue chez <strong>M&Y STORE</strong></p>
            </div>
            <form method="post" >
                <div class="mb-3 text-start">
                    <label for="username" class="form-label">Nom d'utilisateur</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Entrez votre identifiant" required>
                </div>
                <div class="mb-3 text-start">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Entrez votre mot de passe" required>
                </div>
                <div class="d-grid">
                    <button type="submit" name="connecter" class="btn btn-primary">Se connecter</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
