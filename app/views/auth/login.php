<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Omnix Core</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-base-200">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-primary">Omnix Core</h1>
                <p class="text-base-content/70 mt-2">Inicia sesión en tu cuenta</p>
            </div>

            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-error mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span><?= htmlspecialchars($_SESSION['error']) ?></span>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span><?= htmlspecialchars($_SESSION['success']) ?></span>
                        </div>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>

                    <form action="/login" method="POST" class="space-y-4">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Email</span>
                            </label>
                            <input 
                                type="email" 
                                name="email" 
                                placeholder="tu@email.com" 
                                class="input input-bordered w-full" 
                                required 
                                autofocus
                            />
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Contraseña</span>
                            </label>
                            <input 
                                type="password" 
                                name="password" 
                                placeholder="••••••••" 
                                class="input input-bordered w-full" 
                                required 
                            />
                            <label class="label">
                                <a href="#" class="label-text-alt link link-hover">¿Olvidaste tu contraseña?</a>
                            </label>
                        </div>

                        <div class="form-control mt-6">
                            <button type="submit" class="btn btn-primary w-full">
                                Iniciar Sesión
                            </button>
                        </div>
                    </form>

                    <div class="divider">O</div>

                    <div class="text-center">
                        <p class="text-sm">
                            ¿No tienes cuenta? 
                            <a href="/register" class="link link-primary">Regístrate</a>
                        </p>
                    </div>

                    <div class="text-center mt-4">
                        <a href="/" class="btn btn-ghost btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Volver a la tienda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>