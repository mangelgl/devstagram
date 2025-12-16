# 📸 DevStagram - Red Social para Programadores

Una aplicación web estilo Instagram enfocada en la comunidad de desarrolladores. Permite compartir posts, imágenes y conectar con otros programadores.

Proyecto construido con **Laravel 12** y **Docker**.

## 🚀 Requisitos previos

Asegúrate de tener instalado en tu equipo:
* [Docker Desktop](https://www.docker.com/products/docker-desktop/) (o Docker Engine + Compose en Linux).
* [Git](https://git-scm.com/).
* [Node.js & NPM](https://nodejs.org/) (Opcional, si deseas ejecutar vite localmente).

---

## 🛠️ Instalación y Configuración

Sigue estos pasos en orden para levantar el proyecto desde cero en un entorno local.

### 1. Clonar el repositorio
Descarga el código fuente y entra en el directorio.

```bash
git clone git@github.com:mangelgl/devstagram.git devstagram
cd devstagram
```

### 2. Cambiar permisos
```bash
sudo chmod -R 775 /var/www/html/storage
sudo chmod -R 775 /var/www/html/bootstrap/cache
```

### 3. Configurar variables de entorno
```bash
cp .env.example .env
```

### 4. Levantar los contenedores
```bash
docker compose up -d --build
```

### 5. Instalar dependencias
```bash
# Instalar dependencias de PHP
docker compose exec app composer install

# Generar la key de encriptación de Laravel
docker compose exec app php artisan key:generate
```

### 6. Ejecutar Migraciones
```bash
docker compose exec app php artisan migrate

# (Opcional) Si quieres poblar la base de datos con datos falsos
docker compose exec app php artisan db:seed
```

### 7. Instalar dependencias del frontend
```bash
npm install
npm run build
```

## To Do List

-   Remember password feature
