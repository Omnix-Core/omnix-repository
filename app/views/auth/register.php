<?php $title = 'Registrarse - Omnix Core'; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="hero min-h-screen bg-base-200">
    <div class="hero-content flex-col">
        <div class="text-center mb-4">
            <h1 class="text-4xl font-bold">Crear Cuenta</h1>
            <p class="py-2">Regístrate en Omnix Core</p>
        </div>
        
        <div class="card shrink-0 w-full max-w-sm shadow-2xl bg-base-100">
            <form method="POST" action="<?= Helpers::url('auth/register') ?>" class="card-body">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Nombre de usuario</span>
                    </label>
                    <input type="text" name="username" placeholder="Introduce tu usuario" class="input input-bordered" required>
                </div>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Email</span>
                    </label>
                    <input type="email" name="email" placeholder="Introduce tu direccion de e-mail" class="input input-bordered" required>
                </div>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Contraseña</span>
                    </label>
                    <input type="password" name="password" placeholder="••••••" class="input input-bordered" required>
                </div>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Confirmar Contraseña</span>
                    </label>
                    <input type="password" name="password_confirm" placeholder="••••••" class="input input-bordered" required>
                </div>
                
                <div class="form-control mt-6">
                    <button type="submit" class="btn btn-primary px-4">Registrarse</button>
                </div>
                
                <div class="text-center mt-4">
                    <p class="text-sm">¿Ya tienes cuenta? <a href="<?= Helpers::url('auth/login') ?>" class="link link-primary">Inicia sesión</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>