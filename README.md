# Omnix Core - Tienda Online de Tecnología

Proyecto TFG - Tienda online de productos tecnológicos desarrollada con PHP, MySQL y Docker.

## ¿Qué es esto?

Una tienda online funcional donde puedes comprar productos tecnológicos como TVs, móviles, monitores y ordenadores. Tiene carrito de compras, gestión de pedidos y panel de administración.

## Tecnologías usadas

- **Backend**: PHP 8.2
- **Base de datos**: MySQL 8.0
- **Frontend**: TailwindCSS + DaisyUI
- **Contenedores**: Docker + Docker Compose
- **Arquitectura**: MVC (Modelo-Vista-Controlador)

## Cómo ejecutarlo

### Requisitos
- Docker Desktop instalado

### Pasos
1. Abre la terminal en la carpeta del proyecto
2. Ejecuta:
```bash
docker-compose up -d
```
3. Espera unos segundos a que la base de datos se inicialice
4. Abre el navegador en: **http://localhost**

### Accesos

**phpMyAdmin**: http://localhost:8080
- Usuario: `omnix_user`
- Contraseña: `omnix_pass`

**Usuarios de prueba**:
- Admin: `admin@omnix.com` / `password`
- Usuario: `usuario1@test.com` / `password`

## Funcionalidades

### Usuario Normal
- Ver catálogo de productos con 56 productos
- Añadir productos al carrito
- Modificar cantidades en el carrito
- Realizar pedidos con dirección de envío
- Ver historial de pedidos

### Administrador
- Gestionar productos (crear, editar, eliminar)
- Gestionar categorías
- Ver todos los pedidos
- Ver estadísticas de ventas

## Estructura del Proyecto
```
omnix-repository/
├── app/
│   ├── controllers/      # Controladores (HomeController, ProductController, etc)
│   ├── models/          # Modelos y Repositorios
│   ├── views/           # Vistas HTML/PHP
│   └── libs/            # Clases auxiliares (Router, Auth, Database)
├── config/              # Configuración (params.php)
├── public/              # Punto de entrada (index.php)
│   └── assets/
│       └── images/
│           └── products/    # Imágenes de productos
├── database.sql         # Script de base de datos
└── docker-compose.yml   # Configuración Docker
```

## Características Técnicas

- **Arquitectura MVC**: Separación clara de lógica, datos y presentación
- **Sistema de autenticación**: Login, registro y sesiones
- **CRUD completo**: Para productos, categorías y pedidos
- **AJAX**: Carrito dinámico sin recargar página
- **Responsive**: Funciona en móvil, tablet y desktop
- **Stock automático**: Se resta al confirmar pedidos

## Comandos Docker
```bash
# Iniciar
docker-compose up -d

# Ver logs
docker-compose logs -f

# Parar
docker-compose down

# Reiniciar desde cero (borra todo)
docker-compose down -v
docker-compose up -d
```

## Notas

- Las contraseñas están hasheadas con bcrypt
- La base de datos se crea automáticamente al iniciar Docker
- Las imágenes de productos van en `/public/assets/images/products/`
- Si cambias código PHP, reinicia con `docker-compose restart web`

## Autores
Oualid Bouchnafa Bouchnafa
Cristian López Ponce
Ramón Rueda Pérez
Proyecto TFG - DAW 2026