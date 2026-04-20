## Ejecutar

```bash
cd auth_system_php73_fixed
php -S localhost:8000 -t public
```

Luego abre `http://localhost:8000`.

## Base de datos

1. Crea una base llamada `auth_system`.
2. Importa `schema.sql`.
3. Revisa `config/database.php` si tu usuario/clave de MySQL es distinto.
