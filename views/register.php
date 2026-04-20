<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta — AuthSystem</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg:        #0b0e14;
            --surface:   #13171f;
            --border:    #1e2530;
            --accent:    #4f8cff;
            --accent2:   #7c5cfc;
            --success:   #22d3a5;
            --danger:    #ff5c6a;
            --text:      #e8eaf0;
            --muted:     #6b7588;
            --input-bg:  #0e1219;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 60% 50% at 80% 10%, rgba(124,92,252,.10) 0%, transparent 70%),
                radial-gradient(ellipse 50% 40% at 20% 90%, rgba(79,140,255,.09) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        .grid-overlay {
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.025) 1px, transparent 1px);
            background-size: 60px 60px;
            z-index: 0;
        }

        .container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 460px;
            padding: 1.5rem;
            animation: fadeUp .5s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .brand {
            display: flex;
            align-items: center;
            gap: .6rem;
            margin-bottom: 2rem;
        }

        .brand-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
        }

        .brand-name {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.15rem;
            letter-spacing: -.02em;
            background: linear-gradient(90deg, var(--accent), var(--accent2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 2.5rem 2rem;
        }

        h1 {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1.7rem;
            letter-spacing: -.03em;
            margin-bottom: .35rem;
        }

        .subtitle {
            color: var(--muted);
            font-size: .9rem;
            margin-bottom: 2rem;
            font-weight: 300;
        }

        .errors {
            background: rgba(255,92,106,.08);
            border: 1px solid rgba(255,92,106,.25);
            border-radius: 10px;
            padding: .75rem 1rem;
            margin-bottom: 1.25rem;
        }

        .errors ul { list-style: none; }
        .errors li {
            color: var(--danger);
            font-size: .875rem;
            padding: .15rem 0;
            display: flex; align-items: center; gap: .4rem;
        }
        .errors li::before { content: '✕'; font-size: .7rem; }

        .field { margin-bottom: 1.1rem; }

        label {
            display: block;
            font-size: .8rem;
            font-weight: 500;
            color: var(--muted);
            letter-spacing: .06em;
            text-transform: uppercase;
            margin-bottom: .5rem;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            background: var(--input-bg);
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--text);
            font-family: inherit;
            font-size: .95rem;
            padding: .75rem 1rem;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(79,140,255,.15);
        }

        input::placeholder { color: var(--muted); }

        .password-wrap { position: relative; }
        .toggle-pw {
            position: absolute; right: 1rem; top: 50%; transform: translateY(-50%);
            background: none; border: none; color: var(--muted);
            cursor: pointer; font-size: .85rem; padding: 0;
            transition: color .2s;
        }
        .toggle-pw:hover { color: var(--accent); }

        /* Indicador de fortaleza */
        .strength-bar {
            height: 3px;
            border-radius: 3px;
            background: var(--border);
            margin-top: .5rem;
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            width: 0;
            border-radius: 3px;
            transition: width .3s, background .3s;
        }

        .strength-label {
            font-size: .75rem;
            color: var(--muted);
            margin-top: .3rem;
        }

        .requirements {
            list-style: none;
            margin-top: .6rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .25rem;
        }

        .requirements li {
            font-size: .78rem;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: .35rem;
            transition: color .25s;
        }

        .requirements li.met { color: var(--success); }
        .requirements li::before { content: '○'; font-size: .65rem; }
        .requirements li.met::before { content: '●'; }

        .btn-primary {
            width: 100%;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border: none;
            border-radius: 10px;
            color: #fff;
            font-family: 'Syne', sans-serif;
            font-weight: 600;
            font-size: 1rem;
            letter-spacing: .01em;
            padding: .85rem 1rem;
            cursor: pointer;
            margin-top: .5rem;
            transition: opacity .2s, transform .15s;
        }

        .btn-primary:hover  { opacity: .9; transform: translateY(-1px); }
        .btn-primary:active { transform: translateY(0); }

        .divider {
            text-align: center;
            color: var(--muted);
            font-size: .85rem;
            margin: 1.5rem 0 1rem;
            position: relative;
        }

        .divider::before, .divider::after {
            content: '';
            position: absolute;
            top: 50%; width: 38%;
            height: 1px;
            background: var(--border);
        }

        .divider::before { left: 0; }
        .divider::after  { right: 0; }

        .link-login {
            display: block;
            text-align: center;
            color: var(--muted);
            font-size: .9rem;
            text-decoration: none;
            transition: color .2s;
        }

        .link-login span {
            color: var(--accent);
            font-weight: 500;
        }

        .link-login:hover span { text-decoration: underline; }
    </style>
</head>
<body>
<div class="grid-overlay"></div>

<div class="container">
    <div class="brand">
        <div class="brand-icon">🔐</div>
        <span class="brand-name">AuthSystem</span>
    </div>

    <div class="card">
        <h1>Crea tu cuenta</h1>
        <p class="subtitle">Únete y empieza a usar la plataforma hoy</p>

        <?php if (!empty($errors)): ?>
            <div class="errors">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>?route=auth/register" method="POST" novalidate>
            <div class="field">
                <label for="name">Nombre completo</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    placeholder="Juan García"
                    value="<?= htmlspecialchars($old_name ?? '', ENT_QUOTES, 'UTF-8') ?>"
                    required
                    autocomplete="name"
                >
            </div>

            <div class="field">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="tucorreo@empresa.com"
                    value="<?= htmlspecialchars($old_email ?? '', ENT_QUOTES, 'UTF-8') ?>"
                    required
                    autocomplete="email"
                >
            </div>

            <div class="field">
                <label for="password">Contraseña</label>
                <div class="password-wrap">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Mínimo 8 caracteres"
                        required
                        autocomplete="new-password"
                        oninput="checkStrength(this.value)"
                    >
                    <button type="button" class="toggle-pw" onclick="togglePw('password', this)" aria-label="Ver contraseña">👁</button>
                </div>
                <div class="strength-bar"><div class="strength-fill" id="strengthFill"></div></div>
                <p class="strength-label" id="strengthLabel"></p>
                <ul class="requirements" id="requirements">
                    <li id="req-length">8 caracteres</li>
                    <li id="req-upper">Mayúscula</li>
                    <li id="req-number">Número</li>
                </ul>
            </div>

            <div class="field">
                <label for="password_confirm">Confirmar contraseña</label>
                <div class="password-wrap">
                    <input
                        type="password"
                        id="password_confirm"
                        name="password_confirm"
                        placeholder="Repite tu contraseña"
                        required
                        autocomplete="new-password"
                    >
                    <button type="button" class="toggle-pw" onclick="togglePw('password_confirm', this)" aria-label="Ver contraseña">👁</button>
                </div>
            </div>

            <button type="submit" class="btn-primary">Crear cuenta →</button>
        </form>

        <div class="divider">o</div>

        <a href="<?= BASE_URL ?>?route=auth/login" class="link-login">
            ¿Ya tienes cuenta? <span>Inicia sesión</span>
        </a>
    </div>
</div>

<script>
    function togglePw(id, btn) {
        const input = document.getElementById(id);
        input.type = input.type === 'password' ? 'text' : 'password';
        btn.textContent = input.type === 'password' ? '👁' : '🙈';
    }

    function checkStrength(pw) {
        const fill  = document.getElementById('strengthFill');
        const label = document.getElementById('strengthLabel');
        const checks = {
            length: pw.length >= 8,
            upper:  /[A-Z]/.test(pw),
            number: /[0-9]/.test(pw),
        };

        // Requisitos visuales
        document.getElementById('req-length').classList.toggle('met', checks.length);
        document.getElementById('req-upper').classList.toggle('met', checks.upper);
        document.getElementById('req-number').classList.toggle('met', checks.number);

        const score = Object.values(checks).filter(Boolean).length;
        const levels = [
            { w: '0%',   color: '#1e2530', text: '' },
            { w: '33%',  color: '#ff5c6a', text: 'Débil' },
            { w: '66%',  color: '#f59e0b', text: 'Regular' },
            { w: '100%', color: '#22d3a5', text: 'Fuerte ✓' },
        ];

        const level = levels[score] ?? levels[0];
        fill.style.width      = level.w;
        fill.style.background = level.color;
        label.textContent     = pw.length > 0 ? level.text : '';
    }
</script>
</body>
</html>
