-- ============================================================
-- auth_system — Esquema de base de datos
-- ============================================================

CREATE DATABASE IF NOT EXISTS auth_system
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE auth_system;

-- ── Tabla de usuarios ──────────────────────────────────────
CREATE TABLE IF NOT EXISTS users (
    id         INT UNSIGNED     NOT NULL AUTO_INCREMENT,
    name       VARCHAR(100)     NOT NULL,
    email      VARCHAR(255)     NOT NULL,
    password   VARCHAR(255)     NOT NULL,  -- bcrypt hash
    created_at TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    UNIQUE  KEY uq_users_email (email)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- ── Índice de búsqueda por email (optimización de login) ───
-- Ya cubierto por el UNIQUE KEY, pero se documenta explícitamente:
-- INDEX idx_users_email (email)

-- ── Datos de prueba (opcional) ─────────────────────────────
-- Contraseña de ejemplo: Test1234  (bcrypt cost 12)
-- INSERT INTO users (name, email, password) VALUES
--   ('Admin Demo', 'admin@ejemplo.com', '$2y$12$exampleHashHere...');
