<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Gestión de Categorías</h1>
            <button onclick="openCreateModal()" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nueva Categoría
            </button>
        </div>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><?= $category->id ?></td>
                                <td class="font-semibold"><?= htmlspecialchars($category->name) ?></td>
                                <td>
                                    <div class="flex gap-2">
                                        <button onclick='editCategory(<?= json_encode($category) ?>)' class="btn btn-sm btn-info">
                                            Editar
                                        </button>
                                        <button onclick="deleteCategory(<?= $category->id ?>)" class="btn btn-sm btn-error">
                                            Eliminar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<dialog id="category_modal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4" id="modal_title">Nueva Categoría</h3>
        <form id="category_form" class="space-y-4">
            <input type="hidden" id="category_id" name="id">
            
            <div class="form-control">
                <label class="label"><span class="label-text">Nombre *</span></label>
                <input type="text" id="category_name" name="name" class="input input-bordered" required />
            </div>

            <div class="modal-action">
                <button type="button" onclick="closeModal()" class="btn">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</dialog>

<script>
let isEditing = false;

function openCreateModal() {
    isEditing = false;
    document.getElementById('modal_title').textContent = 'Nueva Categoría';
    document.getElementById('category_form').reset();
    document.getElementById('category_modal').showModal();
}

function editCategory(category) {
    isEditing = true;
    document.getElementById('modal_title').textContent = 'Editar Categoría';
    document.getElementById('category_id').value = category.id;
    document.getElementById('category_name').value = category.name;
    document.getElementById('category_modal').showModal();
}

function closeModal() {
    document.getElementById('category_modal').close();
}

document.getElementById('category_form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const url = isEditing ? '/admin/updateCategory' : '/admin/createCategory';
    
    fetch(url, {
        method: 'POST',
        body: new URLSearchParams(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al guardar la categoría');
    });
});

function deleteCategory(id) {
    if (!confirm('¿Estás seguro de eliminar esta categoría?')) return;
    
    fetch('/admin/deleteCategory', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `id=${id}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    });
}
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>