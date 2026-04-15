<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión — EmpleoApp</title>
    <link rel="stylesheet" href="/assets/css/app.css">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>💼</text></svg>">
    <style>
        .login-wrap {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
        }
        .login-brand {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-brand__logo {
            font-size: 2.5rem;
            display: block;
            margin-bottom: .75rem;
        }
        .login-brand__name {
            font-family: 'Syne', sans-serif;
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--amber);
            letter-spacing: -.02em;
        }
        .login-brand__name span { color: var(--white); }
        .login-brand__sub {
            font-size: .85rem;
            color: var(--muted);
            margin-top: .35rem;
        }
        .login-card .form-group { margin-bottom: 1.1rem; }
        .login-btn { width: 100%; justify-content: center; padding: .7rem; font-size: .95rem; margin-top: .5rem; }
    </style>
</head>
<body>
<div class="login-wrap">
    <div class="login-card">

        <div class="login-brand">
            <span class="login-brand__logo">💼</span>
            <div class="login-brand__name">Empleo<span>App</span></div>
            <p class="login-brand__sub">Accede para gestionar las ofertas de empleo</p>
        </div>

        <?php if (!empty($_SESSION['flash'])): ?>
            <?php $flash = $_SESSION['flash']; unset($_SESSION['flash']); ?>
            <div class="flash flash--<?= $flash['type'] === 'success' ? 'success' : 'error' ?>">
                <?= htmlspecialchars($flash['message']) ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <form method="POST" action="/login">

                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="admin@empleo.com"
                        required
                        autofocus
                        autocomplete="email"
                    >
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="••••••••"
                        required
                        autocomplete="current-password"
                    >
                </div>

                <button type="submit" class="btn btn-primary login-btn">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                        <polyline points="10 17 15 12 10 7"/>
                        <line x1="15" y1="12" x2="3" y2="12"/>
                    </svg>
                    Entrar
                </button>

            </form>
        </div>

    </div>
</div>
</body>
</html>
