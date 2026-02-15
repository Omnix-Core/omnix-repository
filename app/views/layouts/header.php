<?php require_once __DIR__ . '/../../libs/Auth.php'; ?>
<?php require_once __DIR__ . '/../../libs/Helpers.php'; ?>
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
                <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-1 p-2 shadow bg-base-100 rounded-box w-52">
                    <li><a href="<?= Helpers::url('home/index') ?>">Inicio</a></li>
                    <li><a href="<?= Helpers::url('product/index') ?>">Productos</a></li>
                    <?php if (Auth::check() && Auth::isAdmin()): ?>
                        <li><a href="<?= Helpers::url('admin/index') ?>">Admin</a></li>
                    <?php endif; ?>
                </ul>
            </div>
            <a href="<?= Helpers::url('home/index') ?>" class="btn btn-ghost normal-case">
                <img src="/assets/images/other/logo.png" class="h-20 w-auto object-contain" alt="Omnix Core Logo">
            </a>
        </div>

        <div class="navbar-center hidden lg:flex gap-4">
            <ul class="menu menu-horizontal px-1">
                <li><a href="<?= Helpers::url('home/index') ?>">Inicio</a></li>
                <li><a href="<?= Helpers::url('product/index') ?>">Productos</a></li>
                <?php if (Auth::check() && Auth::isAdmin()): ?>
                    <li><a href="<?= Helpers::url('admin/index') ?>" class="text-primary">Panel Admin</a></li>
                <?php endif; ?>
            </ul>

            <!-- Barra de búsqueda en el header (solo desktop) -->
            <form method="GET" action="<?= Helpers::url('product/index') ?>" class="form-control">
                <div class="input-group input-group-sm">
                    <input type="text"
                        name="search"
                        placeholder="Buscar productos..."
                        class="input input-bordered input-sm w-48 xl:w-64"
                        value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                    <button type="submit" class="btn btn-sm btn-primary pl-4 pr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <div class="navbar-end gap-2">
            <!-- Botón de Tema Oscuro/Claro -->
            <label class="swap swap-rotate btn btn-ghost btn-circle">
                <input type="checkbox" id="theme-toggle" />

                <!-- Icono de Sol (Modo Claro) -->
                <svg class="swap-off fill-current w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z" />
                </svg>

                <!-- Icono de Luna (Modo Oscuro) -->
                <svg class="swap-on fill-current w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z" />
                </svg>
            </label>

            <?php if (Auth::check()): ?>
                <a href="<?= Helpers::url('cart/index') ?>" class="btn btn-ghost btn-circle relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span id="cart-count" class="badge badge-sm badge-primary absolute -top-1 -right-1">0</span>
                </a>

                <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-ghost btn-circle avatar placeholder">
                        <div class="bg-neutral-focus text-neutral-content rounded-full w-10 flex items-center justify-center">
                            <span><?= strtoupper(substr(Auth::user()->username, 0, 1)) ?></span>
                        </div>
                    </label>
                    <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-1 p-2 shadow bg-base-100 rounded-box w-52">
                        <li class="menu-title"><span><?= htmlspecialchars(Auth::user()->username) ?></span></li>
                        <li><a href="<?= Helpers::url('order/index') ?>">Mis Pedidos</a></li>
                        <li><a href="<?= Helpers::url('cart/index') ?>">Mi Carrito</a></li>
                        <li><a href="<?= Helpers::url('auth/logout') ?>">Cerrar Sesión</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <a href="<?= Helpers::url('auth/login') ?>" class="btn btn-primary btn-sm">Iniciar Sesión</a>
                <a href="<?= Helpers::url('auth/register') ?>" class="btn btn-outline btn-sm">Registrarse</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Barra de búsqueda móvil (debajo del navbar) -->
    <div class="lg:hidden bg-base-200 p-3">
        <form method="GET" action="<?= Helpers::url('product/index') ?>" class="form-control">
            <div class="input-group input-group-sm w-full">
                <input type="text"
                    name="search"
                    placeholder="Buscar productos..."
                    class="input input-bordered input-sm flex-1"
                    value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                <button type="submit" class="btn btn-sm btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
        </form>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success mx-auto max-w-7xl mt-4 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span><?= htmlspecialchars($_SESSION['success']) ?></span>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error mx-auto max-w-7xl mt-4 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span><?= htmlspecialchars($_SESSION['error']) ?></span>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <main class="min-h-screen">

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const toggle = document.getElementById('theme-toggle');
                const html = document.documentElement;

                const savedTheme = localStorage.getItem('theme') || 'light';
                html.setAttribute('data-theme', savedTheme);
                toggle.checked = savedTheme === 'dark';

                toggle.addEventListener('change', function() {
                    const newTheme = this.checked ? 'dark' : 'light';
                    html.setAttribute('data-theme', newTheme);
                    localStorage.setItem('theme', newTheme);
                });
            });
        </script>