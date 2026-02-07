<?php require_once __DIR__ . '/../../libs/Auth.php'; ?>
<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Omnix Core - Tienda Online' ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<div class="navbar bg-base-100 shadow-lg sticky top-0 z-50">
    <div class="navbar-start">
        <div class="dropdown">
            <label tabindex="0" class="btn btn-ghost lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                </svg>
            </label>
            <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                <li><a href="/">Inicio</a></li>
                <li><a href="/products">Productos</a></li>
                <?php if (Auth::check() && Auth::isAdmin()): ?>
                    <li><a href="/admin">Admin</a></li>
                <?php endif; ?>
            </ul>
        </div>
        <a href="/" class="btn btn-ghost normal-case text-xl">
            <span class="text-primary font-bold">Omnix</span>Core
        </a>
    </div>
    
    <div class="navbar-center hidden lg:flex">
        <ul class="menu menu-horizontal px-1">
            <li><a href="/">Inicio</a></li>
            <li><a href="/products">Productos</a></li>
            <?php if (Auth::check() && Auth::isAdmin()): ?>
                <li><a href="/admin" class="text-primary">Panel Admin</a></li>
            <?php endif; ?>
        </ul>
    </div>
    
    <div class="navbar-end gap-2">
        <?php if (Auth::check()): ?>
            <a href="/cart" class="btn btn-ghost btn-circle relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span id="cart-count" class="badge badge-sm badge-primary absolute -top-1 -right-1">0</span>
            </a>
            
            <div class="dropdown dropdown-end">
                <label tabindex="0" class="btn btn-ghost btn-circle avatar placeholder">
                    <div class="bg-neutral-focus text-neutral-content rounded-full w-10">
                        <span><?= strtoupper(substr(Auth::user()->username, 0, 1)) ?></span>
                    </div>
                </label>
                <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                    <li class="menu-title"><span><?= htmlspecialchars(Auth::user()->username) ?></span></li>
                    <li><a href="/orders">Mis Pedidos</a></li>
                    <li><a href="/cart">Mi Carrito</a></li>
                    <li><a href="/logout">Cerrar Sesión</a></li>
                </ul>
            </div>
        <?php else: ?>
            <a href="/login" class="btn btn-primary btn-sm">Iniciar Sesión</a>
            <a href="/register" class="btn btn-outline btn-sm">Registrarse</a>
        <?php endif; ?>
    </div>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success mx-auto max-w-7xl mt-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span><?= htmlspecialchars($_SESSION['success']) ?></span>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-error mx-auto max-w-7xl mt-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span><?= htmlspecialchars($_SESSION['error']) ?></span>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<main class="min-h-screen">