# 🐾 Clínica Veterinaria

Sistema completo para la gestión de clínicas veterinarias.

---

## 📝 Descripción

Plataforma profesional para la administración integral de clínicas veterinarias. Gestiona clientes, mascotas, razas, vacunas, consultas, cirugías y tratamientos.

### ¿Qué hace este proyecto?

- **Gestión de Clientes**: Registro de dueños de mascotas
- **Gestión de Mascotas**: Datos completos (nombre, especie, raza, edad, peso, propietario)
- **Razas**: Catálogo de razas por especie
- **Vacunas**: Control de vacunas y recordatorios
- **Consultas**: Registro de consultas veterinarias
- **Cirugías**: Programación y seguimiento de cirugías
- **Tratamientos**: Control de tratamientos médicos
- **Historial Médico**: Historial completo por mascota
- **Subida de Fotos**: Fotos de mascotas
- **Dashboard**: Mascotas registradas, vacunas pendientes

---

## ✨ Características Principales

| Característica | Descripción |
|----------------|-------------|
| 👥 **Gestión de Clientes** | CRUD de dueños de mascotas |
| 🐕 **Gestión de Mascotas** | Datos completos con fotos |
| 🐈 **Razas** | Catálogo por especie |
| 💉 **Vacunas** | Control y recordatorios |
| 🏥 **Consultas** | Registro de consultas |
| 🔪 **Cirugías** | Programación de cirugías |
| 💊 **Tratamientos** | Control de tratamientos |
| 📋 **Historial** | Historial médico completo |
| 📸 **Fotos** | Subida de fotos de mascotas |
| 📊 **Dashboard** | Métricas en tiempo real |

---

## 🛠️ Stack Tecnológico

- **Backend**: PHP 8.3, Laravel 11, Livewire 3
- **Frontend**: HTML5, CSS3, Bootstrap 5, JavaScript Vanilla
- **Base de datos**: MySQL/MariaDB

---

## 🚀 Instalación y Uso

### Requisitos

- PHP 8.2+
- Composer
- MySQL/MariaDB

### Instalación

```bash
# Clonar el repositorio
git clone <repositorio>

# Instalar dependencias
composer install

# Copiar archivo de entorno
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate

# Ejecutar migraciones
php artisan migrate

# Poblar base de datos con datos de ejemplo
php artisan db:seed

# Iniciar servidor
php artisan serve
```

### Usar Docker

```bash
# Construir y levantar contenedores
docker compose up -d --build

# Ver estado de los contenedores
docker compose ps

# Acceder al contenedor
docker compose exec app bash

# Ejecutar migraciones dentro del contenedor
php artisan migrate

# Poblar base de datos
php artisan db:seed

# Ver logs
docker compose logs -f app
```

### Credenciales por defecto

| Rol | Email | Contraseña |
|-----|-------|------------|
| Administrador | admin@veterinaria.com | password |

---

## 📁 Estructura del Proyecto

```
├── app/
│   ├── Livewire/           # Componentes Livewire
│   ├── Models/             # Modelos Eloquent
├── database/
│   ├── migrations/         # Migraciones
│   ├── seeders/            # Seeders
├── resources/views/        # Vistas Blade
├── docker-compose.yml      # Docker
└── Dockerfile              # Configuración Docker
```

---

## 📊 Módulos del Sistema

1. **Dashboard**: Mascotas registradas, vacunas pendientes, consultas recientes
2. **Clientes**: CRUD de dueños de mascotas
3. **Mascotas**: Gestión con fotos, datos completos
4. **Razas**: Catálogo por especie
5. **Vacunas**: Control y recordatorios
6. **Consultas**: Registro de consultas
7. **Cirugías**: Programación y seguimiento
8. **Tratamientos**: Control de tratamientos

---

## ⚠️ Requisitos del Sistema

- PHP 8.2 o superior
- Composer
- MySQL 8.0 o MariaDB

---

## 📦 Paquetes Utilizados

- `laravel/framework` - Framework Laravel
- `livewire/livewire` - Componentes reactivos
- `bootstrap` - Framework CSS

---

## 👨‍💻 Desarrollado por Isaac Esteban Haro Torres

**Ingeniero en Sistemas · Full Stack · Automatización · Data**

- 📧 Email: zackharo1@gmail.com
- 📱 WhatsApp: 098805517
- 💻 GitHub: https://github.com/ieharo1
- 🌐 Portafolio: https://ieharo1.github.io/portafolio-isaac.haro/

---

© 2026 Isaac Esteban Haro Torres - Todos los derechos reservados.
