# 💼 EmpleoApp — DDD + Arquitectura Hexagonal en PHP

CRUDL de **Empleos** construido con PHP 8.1+, aplicando
**Domain-Driven Design (DDD)** y **Arquitectura Hexagonal (Ports & Adapters)**,
siguiendo la metodología de las guías de aprendizaje.

---

## Tabla de contenidos

1. [Arquitectura](#arquitectura)
2. [Estructura del proyecto](#estructura-del-proyecto)
3. [Requisitos](#requisitos)
4. [Instalación](#instalación)
5. [Configuración](#configuración)
6. [Base de datos](#base-de-datos)
7. [Autenticación](#autenticación)
8. [Uso](#uso)
9. [Pruebas unitarias](#pruebas-unitarias)
10. [Flujo de commits (Git)](#flujo-de-commits-git)

---

## Arquitectura

```
┌──────────────────────────────────────────────────────┐
│                  INFRAESTRUCTURA                      │
│  ┌─────────────┐    ┌──────────────────────────────┐ │
│  │  HTTP / Web │    │   MySQL / Persistencia        │ │
│  │ Controllers │    │  MySQLEmpleoRepository        │ │
│  └──────┬──────┘    └──────────────┬───────────────┘ │
│         │   Llama casos de uso     │ Implementa puerto│
├─────────▼──────────────────────────▼─────────────────┤
│                  APLICACIÓN                           │
│   CreateEmpleoHandler  UpdateEmpleoHandler            │
│   DeleteEmpleoHandler  GetEmpleoHandler               │
│   ListEmpleosHandler                                  │
├──────────────────────────────────────────────────────-┤
│                   DOMINIO  (núcleo)                   │
│   Empleo (Entity)   EmpleoRepository (port/interface) │
│   EmpleoId, EmpleoNombre, EmpleoSueldo… (VO)          │
│   EmpleoNotFoundException, InvalidEmpleoDataException │
└──────────────────────────────────────────────────────-┘
```

**Regla de dependencia:** las capas internas (Dominio, Aplicación) no dependen de
las externas (Infraestructura). La inversión de dependencia se logra mediante la
interface `EmpleoRepository` definida en el Dominio e implementada en MySQL.

---

## Estructura del proyecto

```
empleo-app/
├── src/
│   ├── Domain/Empleo/
│   │   ├── Entity/Empleo.php
│   │   ├── ValueObject/          (EmpleoId, Nombre, Categoria…)
│   │   ├── Repository/EmpleoRepository.php   ← PUERTO
│   │   └── Exception/
│   ├── Application/Empleo/
│   │   ├── CreateEmpleo/{Command,Handler}.php
│   │   ├── UpdateEmpleo/{Command,Handler}.php
│   │   ├── DeleteEmpleo/{Command,Handler}.php
│   │   ├── GetEmpleo/{Query,Handler}.php
│   │   └── ListEmpleos/{Query,Handler}.php
│   └── Infrastructure/
│       ├── Persistence/MySQL/
│       │   ├── DatabaseConnection.php
│       │   └── MySQLEmpleoRepository.php     ← ADAPTADOR
│       ├── Http/Controller/
│       │   ├── BaseController.php
│       │   ├── Auth/AuthController.php
│       │   └── Empleo/EmpleoController.php
│       └── View/
│           ├── assets/css/app.css
│           └── templates/
│               ├── layout/{header,footer}.php
│               ├── auth/login.php
│               └── empleo/{index,form,show}.php
├── config/
│   ├── database.php
│   ├── container.php     ← Inyección de dependencias
│   └── router.php
├── public/
│   ├── index.php         ← Punto de entrada único
│   └── .htaccess
├── database/schema.sql
├── tests/
│   ├── Unit/Domain/EmpleoTest.php
│   └── Unit/Application/EmpleoHandlersTest.php
├── composer.json
├── phpunit.xml
├── .env.example
└── .gitignore
```

---

## Requisitos

| Herramienta | Versión mínima |
|-------------|---------------|
| PHP         | 8.1           |
| MySQL       | 8.0 / MariaDB 10.5 |
| Composer    | 2.x           |
| Apache      | 2.4 (con `mod_rewrite`) |

> **Recomendado:** Laragon (Windows) o MAMP/ServBay (macOS).

---

## Instalación

```bash
# 1. Clonar el repositorio
git clone https://github.com/TU_USUARIO/empleo-hexagonal.git
cd empleo-hexagonal

# 2. Instalar dependencias PHP
composer install

# 3. Copiar y editar la configuración
cp .env.example .env
# → Editar .env con tus credenciales de MySQL

# 4. Crear la base de datos y usuario por defecto
mysql -u root < database/schema.sql

# 5. Iniciar el servidor de desarrollo
php -S localhost:8000 -t public public/router.php
```

---

## Configuración

Edita el archivo `.env`:

```dotenv
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=empleo_db
DB_USERNAME=root
DB_PASSWORD=tu_contraseña
APP_URL=http://localhost/empleo-app/public
```

---

## Base de datos

El schema incluye dos tablas:

### Tabla `empleos`

| Campo          | Tipo          | Descripción                        |
|----------------|---------------|------------------------------------|
| `id`           | VARCHAR(16)   | Identificador hexadecimal único    |
| `nombre`       | VARCHAR(150)  | Nombre del cargo                   |
| `categoria`    | VARCHAR(50)   | Tecnología, Salud, Finanzas…       |
| `area_trabajo` | VARCHAR(100)  | Área dentro de la empresa          |
| `empresa`      | VARCHAR(150)  | Nombre de la empresa               |
| `nivel`        | VARCHAR(30)   | Junior / Senior / Lead…            |
| `sueldo`       | DECIMAL(15,2) | Salario mensual en COP             |
| `funciones`    | TEXT          | Descripción de responsabilidades   |
| `cargo_jefe`   | VARCHAR(150)  | Cargo del jefe directo             |
| `creado_en`    | DATETIME      | Fecha de creación                  |
| `actualizado_en`| DATETIME     | Última modificación                |

### Tabla `users`

| Campo       | Tipo         | Descripción                     |
|-------------|--------------|---------------------------------|
| `id`        | INT UNSIGNED | Autoincremental                 |
| `nombre`    | VARCHAR(100) | Nombre del usuario              |
| `email`     | VARCHAR(150) | Correo (único)                  |
| `password`  | VARCHAR(255) | Hash bcrypt                     |
| `creado_en` | DATETIME     | Fecha de registro               |

---

## Autenticación

La aplicación usa sesiones PHP con contraseñas hasheadas en bcrypt.

### Credenciales por defecto

| Campo    | Valor             |
|----------|-------------------|
| Correo   | `admin@empleo.com` |
| Contraseña | `admin123`      |

### Rutas de autenticación

| URL       | Método | Acción                              |
|-----------|--------|-------------------------------------|
| `/login`  | GET    | Muestra el formulario de login      |
| `/login`  | POST   | Valida credenciales e inicia sesión |
| `/logout` | GET    | Cierra la sesión y redirige a login |

> Para agregar más usuarios, inserta una fila en la tabla `users` con la contraseña hasheada:
> ```sql
> INSERT INTO users (nombre, email, password)
> VALUES ('Nuevo Usuario', 'usuario@empleo.com', PASSWORD_HASH('tu_contraseña'));
> ```
> O desde PHP: `password_hash('tu_contraseña', PASSWORD_BCRYPT)`

---

## Uso

| URL                        | Método | Acción                                     |
|----------------------------|--------|--------------------------------------------|
| `/empleos`                 | GET    | Listar empleos (con búsqueda y paginación) |
| `/empleos/crear`           | GET    | Formulario de creación     |
| `/empleos/guardar`         | POST   | Guardar nuevo empleo       |
| `/empleos/editar?id=XXX`   | GET    | Formulario de edición      |
| `/empleos/actualizar`      | POST   | Guardar cambios            |
| `/empleos/ver?id=XXX`      | GET    | Detalle del empleo         |
| `/empleos/eliminar`        | POST   | Eliminar empleo            |

---

## Pruebas unitarias

```bash
# Ejecutar todos los tests con salida descriptiva
./vendor/bin/phpunit --testdox

# Solo la capa de Dominio
./vendor/bin/phpunit tests/Unit/Domain

# Solo la capa de Aplicación
./vendor/bin/phpunit tests/Unit/Application
```

Cobertura de tests:

- ✅ Entidad `Empleo`: creación, actualización, serialización
- ✅ Value Objects: validaciones de negocio
- ✅ `CreateEmpleoHandler`, `UpdateEmpleoHandler`
- ✅ `DeleteEmpleoHandler`, `GetEmpleoHandler`
- ✅ `ListEmpleosHandler` (paginación)
- ✅ Casos de error (excepciones de dominio)

---

## Flujo de commits (Git)

Siguiendo el estándar GitLab / Conventional Commits:

```bash
# Rama por guía / funcionalidad
git checkout -b feat/domain-empleo

# Commits atómicos por clase funcional probada
git commit -m "feat(domain): add Empleo entity with value objects"
git commit -m "feat(domain): add EmpleoRepository port interface"
git commit -m "feat(app): add CreateEmpleo command and handler"
git commit -m "feat(app): add ListEmpleos query and handler"
git commit -m "feat(infra): implement MySQLEmpleoRepository adapter"
git commit -m "feat(infra): add EmpleoController with CRUDL actions"
git commit -m "feat(view): add empleo list, form and show templates"
git commit -m "test(unit): add EmpleoTest for entity and value objects"
git commit -m "test(unit): add EmpleoHandlersTest for use cases"

# Pull Request con < 20 archivos → merge a main
```

---

## Conceptos clave aplicados

| Concepto DDD          | Clase                          |
|-----------------------|--------------------------------|
| **Entidad**           | `Empleo`                       |
| **Value Object**      | `EmpleoId`, `EmpleoSueldo`…    |
| **Repositorio**       | `EmpleoRepository` (interface) |
| **Excepción dominio** | `EmpleoNotFoundException`      |
| **Comando**           | `CreateEmpleoCommand`          |
| **Handler**           | `CreateEmpleoHandler`          |

| Concepto Hexagonal    | Implementación                 |
|-----------------------|--------------------------------|
| **Puerto primario**   | `EmpleoRepository` interface   |
| **Adaptador primario**| `EmpleoController` (HTTP)      |
| **Puerto secundario** | Repositorio → BD               |
| **Adaptador secundario**| `MySQLEmpleoRepository`      |
