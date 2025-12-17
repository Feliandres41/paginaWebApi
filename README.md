📌 Gestor de Tareas – Página Web

Este proyecto es una aplicación web desarrollada en Laravel que consume una API REST para la gestión de proyectos y tareas.

La aplicación permite a los usuarios:

Registrarse

Iniciar sesión

Crear proyectos

Agregar tareas a los proyectos

Marcar tareas como completadas o pendientes

🚀 Tecnologías utilizadas

Laravel 10

PHP 8.2

Blade (Vistas)

HTML / CSS

MySQL

API REST (Laravel)

🔗 Relación con la API

Esta aplicación NO maneja directamente la base de datos de proyectos y tareas.
Toda la información se obtiene y se envía a través de una API externa.

Repositorio de la API:
👉 https://github.com/Feliandres41/projecTask

⚙️ Requisitos

Antes de ejecutar el proyecto debes tener instalado:

PHP 8.1 o superior

Composer

MySQL

Servidor local (Laragon, XAMPP o similar)

La API corriendo en un puerto (por defecto 8000)

🛠️ Instalación

1️⃣ Clonar el repositorio:

git clone https://github.com/Feliandres41/paginaWebApi.git


2️⃣ Entrar al proyecto:

cd paginaWebApi


3️⃣ Instalar dependencias:

composer install


4️⃣ Crear archivo .env:

cp .env.example .env


5️⃣ Generar la clave de la aplicación:

php artisan key:generate

🔧 Configuración de la API

En el archivo .env, configura la URL de la API:

API_URL=http://127.0.0.1:8000/api


⚠️ Asegúrate de que la API esté corriendo antes de usar la aplicación web.

▶️ Ejecutar la aplicación
php artisan serve --port=8001


Luego abre en el navegador:

http://127.0.0.1:8001

👤 Funcionalidades principales
🔐 Autenticación

Registro de usuarios

Inicio y cierre de sesión

Manejo de sesión mediante token de la API

📁 Proyectos

Crear proyectos

Listar proyectos

Ver detalle de un proyecto

Eliminar proyectos

✅ Tareas

Crear tareas dentro de un proyecto

Marcar tareas como completadas / pendientes

Visualización clara del estado de la tarea

📂 Estructura básica del proyecto
app/
 └── Http/
     └── Controllers/
         └── Web/
             ├── AuthWebController.php
             ├── DashboardController.php
             ├── ProjectWebController.php
             └── TaskWebController.php

resources/
 └── views/
     ├── auth/
     ├── dashboard/
     └── projects/

routes/
 └── web.php

