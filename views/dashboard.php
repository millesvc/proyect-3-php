<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control — AuthSystem</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg:        #0b0e14;
            --surface:   #13171f;
            --surface2:  #181d27;
            --border:    #1e2530;
            --accent:    #4f8cff;
            --accent2:   #7c5cfc;
            --success:   #22d3a5;
            --text:      #e8eaf0;
            --muted:     #6b7588;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 50% 40% at 10% 10%, rgba(79,140,255,.07) 0%, transparent 70%),
                radial-gradient(ellipse 40% 30% at 90% 80%, rgba(124,92,252,.07) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        /* ── NAVBAR ── */
        nav {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(11,14,20,.85);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--border);
            padding: 0 2rem;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: .6rem;
            text-decoration: none;
        }

        .brand-icon {
            width: 30px; height: 30px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: .85rem;
        }

        .brand-name {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1rem;
            background: linear-gradient(90deg, var(--accent), var(--accent2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-badge {
            display: flex;
            align-items: center;
            gap: .6rem;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 30px;
            padding: .35rem .85rem .35rem .4rem;
            font-size: .875rem;
        }

        .avatar {
            width: 28px; height: 28px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: .75rem;
            color: #fff;
            flex-shrink: 0;
        }

        .btn-logout {
            background: rgba(255,92,106,.1);
            border: 1px solid rgba(255,92,106,.2);
            border-radius: 8px;
            color: #ff7c87;
            font-family: inherit;
            font-size: .85rem;
            font-weight: 500;
            padding: .4rem .9rem;
            cursor: pointer;
            text-decoration: none;
            transition: background .2s, border-color .2s;
        }

        .btn-logout:hover {
            background: rgba(255,92,106,.18);
            border-color: rgba(255,92,106,.35);
        }

        /* ── CONTENIDO ── */
        main {
            position: relative;
            z-index: 1;
            max-width: 1000px;
            margin: 0 auto;
            padding: 3rem 1.5rem;
            animation: fadeUp .4s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .welcome-section {
            margin-bottom: 2.5rem;
        }

        .welcome-label {
            font-size: .8rem;
            font-weight: 500;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: .4rem;
        }

        .welcome-title {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: clamp(1.8rem, 4vw, 2.8rem);
            letter-spacing: -.04em;
            line-height: 1.1;
        }

        .welcome-title span {
            background: linear-gradient(90deg, var(--accent), var(--accent2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .welcome-sub {
            color: var(--muted);
            margin-top: .75rem;
            font-size: .95rem;
            font-weight: 300;
        }

        /* ── STATS ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.4rem 1.5rem;
            position: relative;
            overflow: hidden;
            transition: border-color .2s, transform .2s;
        }

        .stat-card:hover {
            border-color: rgba(79,140,255,.35);
            transform: translateY(-2px);
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--accent), var(--accent2));
            opacity: 0;
            transition: opacity .2s;
        }

        .stat-card:hover::after { opacity: 1; }

        .stat-icon {
            font-size: 1.4rem;
            margin-bottom: .7rem;
        }

        .stat-value {
            font-family: 'Syne', sans-serif;
            font-size: 1.6rem;
            font-weight: 800;
            letter-spacing: -.03em;
        }

        .stat-label {
            font-size: .8rem;
            color: var(--muted);
            margin-top: .2rem;
            font-weight: 300;
        }

        /* ── INFO CARD ── */
        .info-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.8rem;
            margin-bottom: 1rem;
        }

        .info-card h2 {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: -.02em;
            margin-bottom: 1.2rem;
        }

        .info-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: .75rem 0;
            border-bottom: 1px solid var(--border);
        }

        .info-row:last-child { border-bottom: none; }

        .info-key {
            font-size: .8rem;
            color: var(--muted);
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .info-val {
            font-size: .925rem;
            font-weight: 500;
        }

        .badge-active {
            background: rgba(34,211,165,.1);
            border: 1px solid rgba(34,211,165,.2);
            color: var(--success);
            border-radius: 20px;
            padding: .2rem .65rem;
            font-size: .78rem;
            font-weight: 500;
        }

        /* ── SECURITY CARD ── */
        .security-card {
            background: linear-gradient(135deg, rgba(79,140,255,.06), rgba(124,92,252,.06));
            border: 1px solid rgba(79,140,255,.15);
            border-radius: 16px;
            padding: 1.5rem 1.8rem;
            display: flex;
            align-items: center;
            gap: 1.2rem;
        }

        .security-icon {
            font-size: 2rem;
            flex-shrink: 0;
        }

        .security-text h3 {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: .25rem;
        }

        .security-text p {
            font-size: .86rem;
            color: var(--muted);
            line-height: 1.5;
            font-weight: 300;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav>
    <a class="brand" href="<?= BASE_URL ?>?route=dashboard/index">
        <div class="brand-icon">🔐</div>
        <span class="brand-name">AuthSystem</span>
    </a>

    <div class="nav-right">
        <div class="user-badge">
            <div class="avatar"><?= strtoupper(substr($user['name'], 0, 1)) ?></div>
            <?= htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') ?>
        </div>
        <a href="<?= BASE_URL ?>?route=auth/logout" class="btn-logout">Cerrar sesión</a>
    </div>
</nav>

<!-- CONTENIDO PRINCIPAL -->
<main>

    <!-- BIENVENIDA -->
    <section class="welcome-section">
        <p class="welcome-label">Panel de Control</p>
        <h1 class="welcome-title">
            Hola, <span><?= htmlspecialchars(explode(' ', $user['name'])[0], ENT_QUOTES, 'UTF-8') ?></span> 👋
        </h1>
        <p class="welcome-sub">Has iniciado sesión correctamente. Tu sesión está activa y protegida.</p>
    </section>

    <!-- STATS -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">🔒</div>
            <div class="stat-value">Activa</div>
            <div class="stat-label">Sesión actual</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">📅</div>
            <div class="stat-value"><?= date('d MMM', strtotime($user['created_at'])) ?></div>
            <div class="stat-label">Fecha de registro</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🛡️</div>
            <div class="stat-value">bcrypt</div>
            <div class="stat-label">Hash de contraseña</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">⚡</div>
            <div class="stat-value">PDO</div>
            <div class="stat-label">Driver de base de datos</div>
        </div>
    </div>

    <!-- INFORMACIÓN DEL USUARIO -->
    <div class="info-card">
        <h2>Información de tu cuenta</h2>

        <div class="info-row">
            <span class="info-key">ID de usuario</span>
            <span class="info-val">#<?= (int) $user['id'] ?></span>
        </div>
        <div class="info-row">
            <span class="info-key">Nombre</span>
            <span class="info-val"><?= htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') ?></span>
        </div>
        <div class="info-row">
            <span class="info-key">Email</span>
            <span class="info-val"><?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?></span>
        </div>
        <div class="info-row">
            <span class="info-key">Miembro desde</span>
            <span class="info-val"><?= date('d/m/Y H:i', strtotime($user['created_at'])) ?></span>
        </div>
        <div class="info-row">
            <span class="info-key">Estado</span>
            <span class="badge-active">● Activo</span>
        </div>
    </div>

    <!-- SEGURIDAD INFO -->
    <div class="security-card">
        <div class="security-icon">🛡️</div>
        <div class="security-text">
            <h3>Tu cuenta está protegida</h3>
            <p>Contraseña hasheada con bcrypt (cost 12) · Sesión con ID regenerado · Queries con Prepared Statements · Inputs sanitizados contra XSS e inyección SQL</p>
        </div>
    </div>

</main>
</body>
</html>
