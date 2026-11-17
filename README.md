# Portal Municipal de Ahualulco de Mercado

Proyecto integrador de **Tópicos Selectos de Tecnologías II** (Centro Universitario de los Valles, Universidad de Guadalajara).
Autor: Omar Figueroa Pérez.

## ¿Qué hace?

Portal web del municipio donde los ciudadanos pueden **levantar reportes** de fallas en su colonia (agua, alumbrado, bacheo y basura),
recibir un **folio** de seguimiento, consultar el estado de su reporte y **descargar un comprobante en PDF** cuando ya fue atendido.
El personal del ayuntamiento inicia sesión en un **panel administrativo** para dar seguimiento a los reportes según su rol.

**Flujo principal:** el ciudadano reporta → recibe su folio → el administrador atiende el reporte y escribe la causa → el ciudadano descarga su comprobante.

## Funcionalidades

**Sitio público**
- Página de inicio, historia del municipio y página de ubicación con mapa (Leaflet + OpenStreetMap) y contorno del municipio obtenido de la API Nominatim.
- Formulario de reporte con validación (en el navegador y en el servidor) y folio único de 8 caracteres.
- Consulta del estado de un reporte con su folio.
- Comprobante en PDF, que solo se genera cuando el reporte está atendido y tiene su causa.
- Límite de envío de reportes para evitar duplicados.

**Panel administrativo** (requiere iniciar sesión)
- Inicio y cierre de sesión, con dos roles: **administrador general** y **administrador de área**.
- Lista de reportes con filtro por estado, paginación, cambio de estado (al marcar "Atendido" se captura la causa) y eliminación de reportes atendidos (solo el administrador general).
- Alta y baja de administradores (solo el administrador general).
- Cambio de contraseña del administrador que inició sesión.

**Seguridad:** protección CSRF, contraseñas con hash (bcrypt), límite de intentos de inicio de sesión, rutas protegidas con middleware por rol,
validación y sanitización de datos, y registro de eventos en un log.

**Servicios de Laravel usados:** comando de Artisan propio (`reportes:resumen`), Collections, Cache y logging.

## Tecnologías

- Laravel 12 y PHP 8.2 o superior
- MySQL (Eloquent ORM, migraciones y seeders)
- Blade, CSS y JavaScript propios
- Leaflet 1.9.4 y OpenStreetMap
- API externa: Nominatim (OpenStreetMap)
- Paquete adicional: `barryvdh/laravel-dompdf` (generación del PDF)

## Requisitos

- PHP 8.2 o superior (con las extensiones `mbstring`, `dom` y `pdo_mysql`; XAMPP ya las incluye)
- Composer
- MySQL

## Instalación

1. Descargar o clonar el proyecto y entrar a la carpeta:
   cd portal-ahualulco
2. Instalar las dependencias:
   composer install
3. Crear el archivo de configuración a partir del ejemplo:
   copy .env.example .env        (Windows)
   cp .env.example .env          (Linux o Mac)
4. Generar la llave de la aplicación:
   php artisan key:generate
5. Crear en MySQL una **base de datos vacía** llamada `ahualulco_portal` (con el cotejamiento `utf8mb4_unicode_ci`).
6. En el archivo `.env`, escribir una contraseña en la línea `ADMIN_PASSWORD=`. Esa será la contraseña de todas las cuentas de prueba.
7. Crear las tablas y los datos iniciales (tipos de reporte, colonias y administradores):
   php artisan migrate --seed
8. Iniciar el servidor y abrir <http://127.0.0.1:8000>:
   php artisan serve

## Cuentas de prueba

La contraseña de todas es la que escribiste en `ADMIN_PASSWORD`. No hay enlace público al inicio de sesión; se entra en
<http://127.0.0.1:8000/login>.

| Correo | Rol | Qué puede hacer |
|---|---|---|
| `admin@ahualulco.test` | Administrador general | Ve todos los reportes, cambia su estado, elimina los atendidos y administra las cuentas de administrador |
| `agua@ahualulco.test` | Administrador de área (Agua) | Ve y cambia el estado solo de los reportes de agua |
| `alumbrado@ahualulco.test` | Administrador de área (Alumbrado) | Solo reportes de alumbrado |
| `bacheo@ahualulco.test` | Administrador de área (Bacheo) | Solo reportes de bacheo |
| `basura@ahualulco.test` | Administrador de área (Basura) | Solo reportes de basura |

## Cómo probar el flujo principal

1. Abrir `/reportes/crear`, llenar el formulario y anotar el **folio** que aparece.
2. Abrir `/seguimiento` y consultar ese folio (estado "Pendiente").
3. Iniciar sesión como `admin@ahualulco.test` y abrir **Panel**.
4. Cambiar el reporte a **Atendido**, escribir la causa en el cuadro "Se encontró..." y guardar.
5. Volver a `/seguimiento` con el mismo folio: aparece el botón **Descargar comprobante (PDF)**.
6. Probar permisos: con una cuenta de área, escribir `/admin/administradores` en la barra de direcciones; debe negar el acceso.

## Comandos útiles

| Comando | Para qué sirve |
|---|---|
| `php artisan migrate:fresh --seed` | Borra y vuelve a crear todas las tablas con los datos iniciales |
| `php artisan reportes:resumen` | Muestra en la terminal cuántos reportes hay por estado |
| `php artisan route:list` | Lista todas las rutas del sistema |
| `php artisan optimize:clear` | Limpia la caché de Laravel |

Los eventos del sistema (inicios de sesión, reportes, accesos denegados y errores) se registran en `storage/logs/laravel.log`.

## Estructura principal

| Carpeta o archivo | Contenido |
|---|---|
| `routes/web.php` | Rutas del sitio y del panel |
| `app/Http/Controllers/` | Controladores del sitio público y, en `Admin/`, del panel |
| `app/Http/Middleware/` | Middleware propios (límite de reportes y acceso solo del administrador general) |
| `app/Models/` | Modelos: `Reporte`, `TipoReporte`, `Colonia` y `User` |
| `app/Console/Commands/` | Comando `reportes:resumen` |
| `resources/views/` | Vistas Blade (plantilla principal, formularios, panel y comprobante PDF) |
| `database/migrations/` y `database/seeders/` | Estructura de la base de datos y datos iniciales |
| `public/css/` y `public/js/` | Estilos y scripts del navegador |

**Base de datos:** tablas `reportes`, `tipo_reportes`, `colonias` y `users` (más las tablas internas de Laravel, como `sessions`).
Un reporte pertenece a un tipo y a una colonia; un administrador de área pertenece a un tipo de reporte.

## Problemas comunes

| Mensaje o síntoma | Solución |
|---|---|
| `No application encryption key has been specified` | Ejecutar `php artisan key:generate` |
| `Unknown database 'ahualulco_portal'` | Crear la base de datos vacía (paso 5) |
| `Access denied for user` | Revisar `DB_USERNAME` y `DB_PASSWORD` en el `.env` |
| El seeder falla o no crea administradores | Escribir una contraseña en `ADMIN_PASSWORD` en el `.env` y volver a ejecutarlo |
| `Table 'sessions' doesn't exist` | Ejecutar `php artisan migrate` |
| `Class "Barryvdh\DomPDF\Facade\Pdf" not found` | Ejecutar `composer install` |

## Limitaciones y pendientes

- No hay registro público: las cuentas de administrador las crea el administrador general.
- Hay cambio de contraseña con la sesión iniciada, pero no recuperación por correo.
- Quedan planeados el marcador en el mapa al reportar, la fotografía del reporte y la administración de noticias desde el panel
  (las noticias de la página de inicio están escritas en la vista).
- Con `APP_DEBUG=true` (valor del ejemplo) el sistema muestra detalles de los errores; para publicarlo debe cambiarse a `false`.

## Repositorio

<https://github.com/omar-fp/portal-ahualulco>
