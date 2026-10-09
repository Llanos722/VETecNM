@extends('layouts.admin')

@section('title', 'VETecNM - Gestión de Productos & Categorías')
@section('header_title', 'Catálogo de Productos y Categorías')

@section('content')
<!-- Categorías -->
<div class="card-custom">
    <div class="card-header-flex">
        <div>
            <h3><i class="fa-solid fa-tags" style="color: #7c3aed;"></i> Categorías de Productos</h3>
            <span style="font-size: 0.85rem; color: #64748b;">Organización y clasificación del catálogo general.</span>
        </div>
        <button class="btn-action btn-add" style="background: #7c3aed;" onclick="openCreateCategoriaModal()">
            <i class="fa-solid fa-plus"></i> Nueva Categoría
        </button>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre Categoría</th>
                    <th>Descripción</th>
                    <th>Productos Asociados</th>
                    <th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categorias as $cat)
                    <tr>
                        <td><strong>#{{ $cat->id_categoria }}</strong></td>
                        <td><strong style="color: #0f172a;"><i class="fa-solid fa-tag"></i> {{ $cat->nombre }}</strong></td>
                        <td>{{ $cat->descripcion ?? 'Sin descripción' }}</td>
                        <td><span class="status-badge status-Finalizada">{{ $cat->total_productos }} producto(s)</span></td>
                        <td style="text-align: right; white-space: nowrap;">
                            <button class="btn-action btn-edit" onclick='openEditCategoriaModal(@json($cat))' title="Editar Categoría">
                                <i class="fa-solid fa-pen"></i> Editar
                            </button>

                            <form action="{{ route('admin.categorias.destroy', $cat->id_categoria) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Eliminar esta categoría?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="Eliminar Categoría">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #94a3b8; padding: 2rem;">No hay categorías registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Productos -->
<div class="card-custom">
    <div class="card-header-flex">
        <div>
            <h3><i class="fa-solid fa-boxes-packing" style="color: #2563eb;"></i> Productos y Artículos</h3>
            <span style="font-size: 0.85rem; color: #64748b;">Inventario de alimentos, accesorios y productos veterinarios.</span>
        </div>
        <button class="btn-action btn-add" onclick="openCreateProductoModal()">
            <i class="fa-solid fa-plus"></i> Agregar Producto
        </button>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Producto</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Descripción</th>
                    <th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($productos as $p)
                    <tr>
                        <td><strong>#{{ $p->id_producto }}</strong></td>
                        <td><strong style="color: #0f172a;"><i class="fa-solid fa-box"></i> {{ $p->nombre }}</strong></td>
                        <td>{{ $p->categoria_nombre ?? 'Sin Categoría' }}</td>
                        <td><strong style="color: #059669;">${{ number_format($p->precio, 2) }}</strong></td>
                        <td>
                            @if($p->stock > 5)
                                <span class="status-badge status-Confirmada">{{ $p->stock }} unidades</span>
                            @elseif($p->stock > 0)
                                <span class="status-badge status-Pendiente">{{ $p->stock }} unidades (Bajo)</span>
                            @else
                                <span class="status-badge status-Cancelada">Agotado (0)</span>
                            @endif
                        </td>
                        <td>{{ $p->descripcion ?? 'N/A' }}</td>
                        <td style="text-align: right; white-space: nowrap;">
                            <button class="btn-action btn-edit" onclick='openEditProductoModal(@json($p))' title="Editar Producto">
                                <i class="fa-solid fa-pen"></i> Editar
                            </button>

                            <form action="{{ route('admin.productos.destroy', $p->id_producto) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Eliminar producto?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="Eliminar Producto">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: #94a3b8; padding: 2.5rem;">No hay productos en el inventario.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Crear Categoría -->
<div id="modalCreateCat" class="modal-backdrop">
    <div class="modal-container">
        <div class="modal-header">
            <h4><i class="fa-solid fa-tag" style="color: #7c3aed;"></i> Crear Categoría</h4>
            <button class="modal-close" onclick="closeModal('modalCreateCat')">&times;</button>
        </div>
        <form action="{{ route('admin.categorias.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="cat_nombre">Nombre de Categoría *</label>
                <input type="text" name="nombre" id="cat_nombre" placeholder="Ej: Alimentos, Medicamentos..." required>
            </div>
            <div class="form-group">
                <label for="cat_descripcion">Descripción</label>
                <textarea name="descripcion" id="cat_descripcion" rows="3" placeholder="Detalles de la categoría..."></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-action" style="background:#cbd5e1; color:#334155;" onclick="closeModal('modalCreateCat')">Cancelar</button>
                <button type="submit" class="btn-action btn-add" style="background:#7c3aed;">Guardar Categoría</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Editar Categoría -->
<div id="modalEditCat" class="modal-backdrop">
    <div class="modal-container">
        <div class="modal-header">
            <h4><i class="fa-solid fa-pen-to-square" style="color: #f59e0b;"></i> Editar Categoría</h4>
            <button class="modal-close" onclick="closeModal('modalEditCat')">&times;</button>
        </div>
        <form id="formEditCat" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit_cat_nombre">Nombre *</label>
                <input type="text" name="nombre" id="edit_cat_nombre" required>
            </div>
            <div class="form-group">
                <label for="edit_cat_descripcion">Descripción</label>
                <textarea name="descripcion" id="edit_cat_descripcion" rows="3"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-action" style="background:#cbd5e1; color:#334155;" onclick="closeModal('modalEditCat')">Cancelar</button>
                <button type="submit" class="btn-action btn-add">Actualizar Categoría</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Crear Producto -->
<div id="modalCreateProd" class="modal-backdrop">
    <div class="modal-container">
        <div class="modal-header">
            <h4><i class="fa-solid fa-box" style="color: #2563eb;"></i> Agregar Producto</h4>
            <button class="modal-close" onclick="closeModal('modalCreateProd')">&times;</button>
        </div>
        <form action="{{ route('admin.productos.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="prod_nombre">Nombre del Producto *</label>
                <input type="text" name="nombre" id="prod_nombre" placeholder="Ej: Champú Antipulgas 500ml" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="id_categoria">Categoría</label>
                    <select name="id_categoria" id="id_categoria">
                        <option value="">-- Ninguna --</option>
                        @foreach($categorias as $c)
                            <option value="{{ $c->id_categoria }}">{{ $c->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="precio">Precio ($) *</label>
                    <input type="number" step="0.01" name="precio" id="precio" placeholder="150.00" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="stock">Stock *</label>
                    <input type="number" name="stock" id="stock" value="10" min="0" required>
                </div>
                <div class="form-group">
                    <label for="imagen_url">URL Imagen (Opcional)</label>
                    <input type="text" name="imagen_url" id="imagen_url" placeholder="https://ejemplo.com/imagen.jpg">
                </div>
            </div>
            <div class="form-group">
                <label for="prod_descripcion">Descripción</label>
                <textarea name="descripcion" id="prod_descripcion" rows="3" placeholder="Detalles del producto..."></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-action" style="background:#cbd5e1; color:#334155;" onclick="closeModal('modalCreateProd')">Cancelar</button>
                <button type="submit" class="btn-action btn-add">Guardar Producto</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Editar Producto -->
<div id="modalEditProd" class="modal-backdrop">
    <div class="modal-container">
        <div class="modal-header">
            <h4><i class="fa-solid fa-pen-to-square" style="color: #f59e0b;"></i> Editar Producto</h4>
            <button class="modal-close" onclick="closeModal('modalEditProd')">&times;</button>
        </div>
        <form id="formEditProd" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit_prod_nombre">Nombre *</label>
                <input type="text" name="nombre" id="edit_prod_nombre" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="edit_id_categoria">Categoría</label>
                    <select name="id_categoria" id="edit_id_categoria">
                        <option value="">-- Ninguna --</option>
                        @foreach($categorias as $c)
                            <option value="{{ $c->id_categoria }}">{{ $c->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit_precio">Precio ($) *</label>
                    <input type="number" step="0.01" name="precio" id="edit_precio" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="edit_stock">Stock *</label>
                    <input type="number" name="stock" id="edit_stock" min="0" required>
                </div>
                <div class="form-group">
                    <label for="edit_imagen_url">URL Imagen</label>
                    <input type="text" name="imagen_url" id="edit_imagen_url">
                </div>
            </div>
            <div class="form-group">
                <label for="edit_prod_descripcion">Descripción</label>
                <textarea name="descripcion" id="edit_prod_descripcion" rows="3"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-action" style="background:#cbd5e1; color:#334155;" onclick="closeModal('modalEditProd')">Cancelar</button>
                <button type="submit" class="btn-action btn-add">Actualizar Producto</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openCreateCategoriaModal() { document.getElementById('modalCreateCat').classList.add('active'); }
    function openCreateProductoModal() { document.getElementById('modalCreateProd').classList.add('active'); }
    function closeModal(id) { document.getElementById(id).classList.remove('active'); }

    function openEditCategoriaModal(cat) {
        document.getElementById('formEditCat').action = "/admin/categorias/" + cat.id_categoria;
        document.getElementById('edit_cat_nombre').value = cat.nombre;
        document.getElementById('edit_cat_descripcion').value = cat.descripcion || '';
        document.getElementById('modalEditCat').classList.add('active');
    }

    function openEditProductoModal(prod) {
        document.getElementById('formEditProd').action = "/admin/productos/" + prod.id_producto;
        document.getElementById('edit_prod_nombre').value = prod.nombre;
        document.getElementById('edit_id_categoria').value = prod.id_categoria || '';
        document.getElementById('edit_precio').value = prod.precio;
        document.getElementById('edit_stock').value = prod.stock;
        document.getElementById('edit_imagen_url').value = prod.imagen_url || '';
        document.getElementById('edit_prod_descripcion').value = prod.descripcion || '';
        document.getElementById('modalEditProd').classList.add('active');
    }
</script>
@endsection
