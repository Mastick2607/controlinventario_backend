# Backend API en Laravel - Control de Inventario


## 📋 Descripción

Esta API RESTful está diseñada para gestionar eficientemente un sistema de control de inventario, abarcando módulos clave como productos, categorías, proveedores, clientes, ventas, compras y movimientos. Ha sido desarrollada utilizando Laravel 10, con autenticación vía Laravel Sanctum, y control granular de acceso a través de Spatie Laravel Permission, lo que permite implementar un sistema robusto de roles y permisos.

La arquitectura de esta API sigue principios de diseño limpios, permitiendo su integración con cualquier frontend moderno (Angular, React, Vue, etc.), asegurando escalabilidad, seguridad y mantenibilidad.

## 🧩 Funcionalidades clave:

- 🔐 Autenticación basada en tokens (Bearer) con Laravel Sanctum.

- 🧑‍💼 Sistema de roles y permisos flexible (super_admin, admin) mediante Spatie.

- 📦 Gestión completa de productos y stock.

- 🗂 CRUD de categorías, proveedores y clientes.

- 💰 Registro y control de ventas y compras.

- 📊 Endpoints para dashboard: ventas totales, ingresos, productos con bajo stock, etc.

- ✅ Middleware de autorización por permiso específico (can:).

- 🌐 Totalmente compatible con CORS para ser consumida por aplicaciones externas (como Angular).




## 🚀 Instalación

1. Clonar el repositorio

```bash
  git clone https://github.com/Mastick2607/XYZ_Commerce_back.git
  cd XYZ_Commerce_back
  code . //para abrir el proyecto
```

2. Instalar composer sino se tiene

- Visita https://getcomposer.org/download/
- Descarga el archivo 'Composer-Setup.exe'
- Sigue las instrucciones del asistente de instalación
- Asegúrate de que la opción "Add to PATH" esté marcada para poder usar composer desde cualquier directorio
- Abre una nueva ventana de CMD o PowerShell y ejecuta:
  
```bash
 composer --version
```

3. Sí ya tienes composer ejecuta esto:
```bash
composer install
```
   
4. Copia el archivo de configuración y configura las variables de entorno:

- Abre el explorador de archivos en la raíz del proyecto.
- Busca el archivo .env.example.
- Cópialo (Ctrl + C) y pégalo (Ctrl + V).
- Renómbralo a .env.

5.Genera la clave de aplicación:

 ```bash
php artisan key:generate

```


6. Editar el archivo .env con las credenciales:


```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=controlinventario_bd
DB_USERNAME=root
DB_PASSWORD=
```
5. Crear la base de datos:
- Crear la base de datos en PhpMyAdmin con el nombre controlinventario_bd

6. Activar servicios del paquete de servidor local:

- Dar "Start" al boton de Mysql
- Dar "Start" al boton de Apache

7. En caso de que apache tenga inconvientes, escribe este comando en consola para que funcionen las peticiones:

```bash
 php artisan serve
```
8. Migrar las tablas
```bash
 php artisan migrate
```
El API estará disponible en: http://localhost:8000



# 🔌 Endpoints Principales

## Productos

*GET*  http://localhost:8000/api/products 

*GET*  http://localhost:8000/api/products/totalstock

*GET*  http://localhost:8000/api/products/low-stock

*GET*  http://localhost:8000/api//products/{id}

*POST*  http://localhost:8000/api/products/

*PUT*  http://localhost:8000/api/products/{id}
 
*DELETE*  http://localhost:8000/api/products/{id}

## Categorias

*GET*  http://localhost:8000/api/categories

*GET*  http://localhost:8000/api/categories/{id}

*posT*  http://localhost:8000/api/categories

*PUT*  http://localhost:8000/api/categories/{id}

*DELETE*  http://localhost:8000/api/categories/{id}

## Proveedores

*GET*  http://localhost:8000/api/suppliers

*GET*  http://localhost:8000/api/suppliers/{id}

*posT*  http://localhost:8000/api/suppliers

*PATCH*  http://localhost:8000/api/suppliers/{id}

*DELETE*  http://localhost:8000/api/suppliers/{id}

## Clientes

*GET*  http://localhost:8000/api/customer

*GET*  http://localhost:8000/api/customer/{id}

*posT*  http://localhost:8000/api/customer

*PATCH*  http://localhost:8000/api/customer/{id}

*DELETE*  http://localhost:8000/api/customer/{id}


## Compras

*GET*  http://localhost:8000/api/purchases

*GET*  http://localhost:8000/api/purchases/{id}

*posT*  http://localhost:8000/api/purchases

*PATCH*  http://localhost:8000/api/purchases/{id}

*DELETE*  http://localhost:8000/api/purchases/{id}


## Ventas

*GET*  http://localhost:8000/api/sales

*GET*  http://localhost:8000/api/sales/latestsales

*GET*  http://localhost:8000/api/sales/totalsales

*GET*  http://localhost:8000/api/sales/totalrevenue

*GET*  http://localhost:8000/api/sales/{id}

*posT*  http://localhost:8000/api/sales

*PUT*  http://localhost:8000/api/sales/{id}

*PATCH*  http://localhost:8000/api/sales/{id}

*DELETE*  http://localhost:8000/api/sales/{id}

*GET*  http://localhost:8000/api/SalesByProduct/{id}

## Movimientos

*GET*  http://localhost:8000/api/movements

*GET*  http://localhost:8000/api/movements/{id}

## Autenticación

*POST*  http://localhost:8000/api/register

*POST*  http://localhost:8000/api/login

*POST*  http://localhost:8000/api/logout

*GET*  http://localhost:8000/api/me

