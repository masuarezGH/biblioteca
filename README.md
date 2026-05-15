# 📚 Biblioteca

Sistema de gestión de biblioteca desarrollado con **Symfony 6.4**, **PHP 8.1+** y **MySQL**.  
Permite gestionar libros, usuarios y reservas, con panel de administración incluido.

---

## 🛠️ Requisitos previos

Instala las siguientes herramientas antes de comenzar:

| Herramienta | Descarga |
|---|---|
| [Laragon](https://laragon.org/download/) | Incluye PHP, MySQL y Apache |
| [Composer](https://getcomposer.org/download/) | Gestor de dependencias PHP |
| [Git](https://git-scm.com/downloads) | Control de versiones |
| [Symfony CLI](https://symfony.com/download) | Servidor de desarrollo |
| [Visual Studio Code](https://code.visualstudio.com/) | Editor de código (recomendado) |

---

## 🚀 Instalación con Laragon

### 1. Clonar el repositorio

Abre la terminal dentro de la carpeta `www` de Laragon (`C:\laragon\www`) y ejecuta:

```bash
git clone https://github.com/masuarezGH/biblioteca.git
cd biblioteca
```

### 2. Instalar dependencias PHP

```bash
composer install
```

### 3. Configurar el entorno

Copia el archivo de entorno y edítalo con tus datos:

```bash
copy .env .env.local
```

Abre `.env.local` y ajusta la línea de conexión a la base de datos:

```env
DATABASE_URL="mysql://root:@127.0.0.1:3306/biblioteca?serverVersion=8&charset=utf8mb4"
```

> Por defecto Laragon usa el usuario `root` sin contraseña. Si cambiaste la contraseña, actualízala aquí.

### 4. Crear la base de datos

```bash
php bin/console doctrine:database:create
```

### 5. Ejecutar las migraciones

```bash
php bin/console doctrine:migrations:migrate
```

Confirma con `yes` cuando lo pida.

### 6. Cargar datos de prueba _(opcional)_

```bash
php bin/console doctrine:fixtures:load
```

Confirma con `yes`. Esto cargará usuarios, libros y reservas de ejemplo.

### 7. Iniciar el servidor

```bash
symfony server:start
```

La aplicación estará disponible en **http://localhost:8000**

---

## 🐳 Instalación con Docker

Si prefieres usar Docker en lugar de Laragon:

### 1. Clonar el repositorio

```bash
git clone https://github.com/masuarezGH/biblioteca.git
cd biblioteca
```

### 2. Renombrar la carpeta del enum _(importante en Linux)_

```bash
# Solo necesario si la carpeta se llama "enum" en minúscula
# En Windows PowerShell:
Rename-Item src\Enum\enum.php Enums.php
```

### 3. Configurar variables de entorno

```bash
copy .env.docker .env.local
```

Edita `.env.local` si quieres cambiar contraseñas u otros valores.

### 4. Levantar los contenedores

```bash
docker compose up --build -d
```

Esto levanta automáticamente la base de datos, ejecuta las migraciones y arranca la app.

### 5. Cargar datos de prueba _(opcional)_

```bash
docker exec -it biblioteca_app php bin/console doctrine:fixtures:load --env=dev --no-interaction
```

### 6. Acceder a la aplicación

| Servicio | URL |
|---|---|
| Aplicación | http://localhost:8080 |
| phpMyAdmin | http://localhost:8081 |

---

## 👤 Usuarios de prueba

Después de cargar las fixtures, puedes iniciar sesión con:

| Email | Contraseña | Rol |
|---|---|---|
| `admin@example.com` | `1234` | Administrador |
| `juan@example.com` | `1234` | Usuario |
| `ana@example.com` | `1234` | Usuario |

> Las contraseñas pueden variar según lo definido en `src/DataFixtures/UsuarioFixture.php`.

---

## 📁 Estructura del proyecto

```
src/
├── Controller/     # Controladores de la aplicación
├── DataFixtures/   # Datos de prueba
├── Entity/         # Entidades de la base de datos
├── Enum/           # Enumeraciones (EstadoLibro, EstadoReserva)
├── Form/           # Formularios
├── Manager/        # Lógica de negocio
└── Repository/     # Repositorios de Doctrine
templates/          # Vistas Twig
migrations/         # Migraciones de base de datos
docker/             # Configuración de Docker
```

---

## ❓ Problemas comunes

**Error `Class not found` con los enums**  
Asegúrate de que la carpeta `src/Enum` tenga la `E` en mayúscula. En Linux el sistema de archivos distingue mayúsculas y minúsculas.

**Puerto 3306 ocupado con Docker**  
Detén el servicio MySQL de Laragon antes de levantar Docker, o cambia el puerto en `docker-compose.yaml`:
```yaml
ports:
  - "3307:3306"
```

**Error de conexión a la base de datos**  
Verifica que Laragon esté corriendo y que la URL en `.env.local` sea correcta.
