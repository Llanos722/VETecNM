@extends('layouts.admin')

@section('title', 'VETecNM - Gestión de Productos & Categorías')
@section('header_title', 'Catálogo de Productos y Categorías')

@section('content')
<!-- Selector de Pestañas Superiores (Productos como vista principal) -->
<!-- Selector de Pestañas Superiores (Plantilla Flowbite) -->
<div class="border-b border-default" style="border-bottom: 1px solid #e2e8f0; margin-bottom: 1.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-body" style="display: flex; flex-wrap: wrap; margin-bottom: -1px; list-style: none; padding: 0;">
            <li class="me-2" style="margin-right: 0.5rem;">
                <a href="javascript:void(0)" id="tabBtnProductos" onclick="switchAdminCatalogTab('productos')"
                   class="inline-flex items-center justify-center p-4 text-fg-brand border-b border-brand rounded-t-base active group"
                   style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center; padding: 0.9rem 1.25rem; border-bottom: 2px solid #2563eb; color: #2563eb; font-weight: 600; font-size: 0.95rem; border-top-left-radius: 0.6rem; border-top-right-radius: 0.6rem; transition: all 0.2s;"
                   aria-current="page">
                    <svg class="w-4 h-4 me-2 text-fg-brand" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" style="width: 1.15rem; height: 1.15rem; margin-right: 0.5rem; color: #2563eb;">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.143 4H4.857A.857.857 0 0 0 4 4.857v4.286c0 .473.384.857.857.857h4.286A.857.857 0 0 0 10 9.143V4.857A.857.857 0 0 0 9.143 4Zm10 0h-4.286a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286A.857.857 0 0 0 20 9.143V4.857A.857.857 0 0 0 19.143 4Zm-10 10H4.857a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286a.857.857 0 0 0 .857-.857v-4.286A.857.857 0 0 0 9.143 14Zm10 0h-4.286a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286a.857.857 0 0 0 .857-.857v-4.286a.857.857 0 0 0-.857-.857Z"/>
                    </svg>
                    <span>Productos y Artículos</span>
                    <span id="tabBadgeProductos" style="margin-left: 0.5rem; background: #2563eb; color: #ffffff; padding: 2px 8px; border-radius: 9999px; font-size: 0.75rem; font-weight: 700;">{{ $productos->count() }}</span>
                </a>
            </li>
            <li class="me-2" style="margin-right: 0.5rem;">
                <a href="javascript:void(0)" id="tabBtnCategorias" onclick="switchAdminCatalogTab('categorias')"
                   class="inline-flex items-center justify-center p-4 border-b border-transparent rounded-t-base hover:text-fg-brand hover:border-brand group"
                   style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center; padding: 0.9rem 1.25rem; border-bottom: 2px solid transparent; color: #64748b; font-weight: 500; font-size: 0.95rem; border-top-left-radius: 0.6rem; border-top-right-radius: 0.6rem; transition: all 0.2s;">
                    <svg class="w-4 h-4 me-2 text-body group-hover:text-fg-brand" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" style="width: 1.15rem; height: 1.15rem; margin-right: 0.5rem; color: #64748b;">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.586 3H8.414a2 2 0 0 0-1.414.586L2.586 8a2 2 0 0 0 0 2.828l9.586 9.586a2 2 0 0 0 2.828 0l4.414-4.414a2 2 0 0 0 .586-1.414V7.414A2 2 0 0 0 18.586 5l-3-2ZM8 8h.01"/>
                    </svg>
                    <span>Categorías del Catálogo</span>
                    <span id="tabBadgeCategorias" style="margin-left: 0.5rem; background: #f1f5f9; color: #475569; padding: 2px 8px; border-radius: 9999px; font-size: 0.75rem; font-weight: 700;">{{ $categorias->count() }}</span>
                </a>
            </li>
        </ul>
        <div style="padding-bottom: 0.5rem;">
            <span style="font-size: 0.82rem; color: #64748b;">
                <i class="fa-solid fa-circle-info" style="color: #3b82f6;"></i> Cambia de pestaña para gestionar inventario o categorías
            </span>
        </div>
    </div>
</div>

<!-- =========================================================================
     PESTAÑA 1: PRODUCTOS Y ARTÍCULOS (VISTA PRINCIPAL POR DEFECTO)
     ========================================================================= -->
<div id="panelProductos" class="catalog-tab-panel">
    <div class="card-custom">
        <div class="card-header-flex">
            <div>
                <h3><i class="fa-solid fa-boxes-packing" style="color: #2563eb;"></i> Productos y Artículos en Inventario</h3>
                <span style="font-size: 0.85rem; color: #64748b;">Inventario de alimentos, accesorios y productos veterinarios.</span>
            </div>
            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                <a href="{{ route('admin.productos.pdf') }}" target="_blank" class="btn-action" style="background: #059669; color: white;" title="Descargar Catálogo Completo separado por Categorías en PDF">
                    <i class="fa-solid fa-file-pdf"></i> Descargar Catálogo (PDF)
                </a>
                <button class="btn-action btn-add" onclick="openCreateProductoModal()">
                    <i class="fa-solid fa-plus"></i> Agregar Producto
                </button>
            </div>
        </div>

        <!-- Barra de Búsqueda y Filtros en Tiempo Real -->
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.85rem 1rem; margin-bottom: 1.25rem; display: flex; gap: 12px; flex-wrap: wrap; align-items: center; justify-content: space-between;">
            <div style="display: flex; gap: 10px; flex: 1; min-width: 280px; flex-wrap: wrap;">
                <div style="flex: 2; min-width: 200px; position: relative;">
                    <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.85rem;"></i>
                    <input type="text" id="filtro_busqueda_prod" placeholder="Buscar por nombre, código o descripción..." oninput="filtrarTablaProductos()"
                        style="width: 100%; padding: 8px 10px 8px 32px; border-radius: 6px; border: 1px solid #cbd5e1; font-size: 0.88rem; outline: none;">
                </div>
                <div style="flex: 1; min-width: 160px;">
                    <select id="filtro_categoria_prod" onchange="filtrarTablaProductos()"
                        style="width: 100%; padding: 8px 10px; border-radius: 6px; border: 1px solid #cbd5e1; font-size: 0.88rem; outline: none; background: white;">
                        <option value="">-- Todas las Categorías --</option>
                        @foreach($categorias as $c)
                            <option value="{{ strtolower($c->nombre) }}">{{ $c->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="flex: 1; min-width: 150px;">
                    <select id="filtro_stock_prod" onchange="filtrarTablaProductos()"
                        style="width: 100%; padding: 8px 10px; border-radius: 6px; border: 1px solid #cbd5e1; font-size: 0.88rem; outline: none; background: white;">
                        <option value="">-- Todos los Stocks --</option>
                        <option value="con_stock">En Stock (> 5)</option>
                        <option value="bajo_stock">Stock Bajo (1 a 5)</option>
                        <option value="agotado">Agotados (0)</option>
                    </select>
                </div>
            </div>
            <div>
                <span id="contador_prods_visibles" style="font-size: 0.85rem; color: #475569; font-weight: 600;">
                    Mostrando {{ $productos->count() }} producto(s)
                </span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="admin-table" id="tabla_productos_admin">
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
                        <tr class="row-producto-item"
                            data-nombre="{{ strtolower($p->nombre) }}"
                            data-cat="{{ strtolower($p->categoria_nombre ?? '') }}"
                            data-desc="{{ strtolower($p->descripcion ?? '') }}"
                            data-stock="{{ $p->stock }}">
                            <td><strong>#{{ $p->id_producto }}</strong></td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div style="width: 32px; height: 32px; border-radius: 6px; background: #eff6ff; display: flex; align-items: center; justify-content: center; color: #2563eb; font-size: 0.95rem;">
                                        <i class="fa-solid fa-box"></i>
                                    </div>
                                    <strong style="color: #0f172a;">{{ $p->nombre }}</strong>
                                </div>
                            </td>
                            <td>
                                @if($p->categoria_nombre)
                                    <span class="status-badge" style="background: #f3e8ff; color: #7c3aed; border: 1px solid #d8b4fe;">
                                        <i class="fa-solid fa-tag"></i> {{ $p->categoria_nombre }}
                                    </span>
                                @else
                                    <span style="color: #94a3b8; font-style: italic;">Sin Categoría</span>
                                @endif
                            </td>
                            <td><strong style="color: #059669; font-size: 0.95rem;">${{ number_format($p->precio, 2) }} MXN</strong></td>
                            <td>
                                @if($p->stock > 5)
                                    <span class="status-badge status-Confirmada">{{ $p->stock }} unidades</span>
                                @elseif($p->stock > 0)
                                    <span class="status-badge status-Pendiente">{{ $p->stock }} unidades (Bajo)</span>
                                @else
                                    <span class="status-badge status-Cancelada">Agotado (0)</span>
                                @endif
                            </td>
                            <td style="max-width: 240px; white-space: normal; color: #475569; font-size: 0.85rem;">
                                {{ $p->descripcion ? Str::limit($p->descripcion, 70) : 'Sin detalles adicionales' }}
                            </td>
                            <td style="text-align: right; white-space: nowrap;">
                                <button class="btn-action btn-edit" onclick='openEditProductoModal(@json($p))' title="Editar Producto">
                                    <i class="fa-solid fa-pen"></i> Editar
                                </button>

                                <form action="{{ route('admin.productos.destroy', $p->id_producto) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Eliminar producto {{ $p->nombre }}?');">
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
                            <td colspan="7" style="text-align: center; color: #94a3b8; padding: 2.5rem;">
                                <i class="fa-solid fa-boxes-packing" style="font-size: 2rem; display: block; margin-bottom: 0.5rem; color: #cbd5e1;"></i>
                                No hay productos en el inventario. Haz clic en "Agregar Producto" para registrar el primero.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- =========================================================================
     PESTAÑA 2: CATEGORÍAS DEL CATÁLOGO
     ========================================================================= -->
<div id="panelCategorias" class="catalog-tab-panel" style="display: none;">
    <div class="card-custom">
        <div class="card-header-flex">
            <div>
                <h3><i class="fa-solid fa-tags" style="color: #7c3aed;"></i> Categorías de Productos</h3>
                <span style="font-size: 0.85rem; color: #64748b;">Organización y clasificación del catálogo general.</span>
            </div>
            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                <a href="{{ route('admin.categorias.pdf') }}" target="_blank" class="btn-action" style="background: #7c3aed; color: white;" title="Descargar Reporte Formal de Categorías en PDF">
                    <i class="fa-solid fa-file-pdf"></i> Descargar Categorías (PDF)
                </a>
                <button class="btn-action btn-add" style="background: #4f46e5;" onclick="openCreateCategoriaModal()">
                    <i class="fa-solid fa-plus"></i> Nueva Categoría
                </button>
            </div>
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
                                <a href="{{ route('admin.productos.pdf', ['categoria_id' => $cat->id_categoria]) }}" target="_blank" class="btn-action" style="background: #0284c7; color: white; padding: 5px 9px; font-size: 0.8rem; text-decoration: none;" title="Descargar catálogo de esta categoría en PDF">
                                    <i class="fa-solid fa-file-pdf"></i> PDF
                                </a>

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
    function switchAdminCatalogTab(tab) {
        const btnProds = document.getElementById('tabBtnProductos');
        const btnCats = document.getElementById('tabBtnCategorias');
        const badgeProds = document.getElementById('tabBadgeProductos');
        const badgeCats = document.getElementById('tabBadgeCategorias');
        const panelProds = document.getElementById('panelProductos');
        const panelCats = document.getElementById('panelCategorias');

        if (!btnProds || !btnCats || !panelProds || !panelCats) return;

        const svgProds = btnProds.querySelector('svg');
        const svgCats = btnCats.querySelector('svg');

        if (tab === 'categorias') {
            panelProds.style.display = 'none';
            panelCats.style.display = 'block';

            btnCats.style.borderColor = '#2563eb';
            btnCats.style.color = '#2563eb';
            btnCats.style.fontWeight = '600';
            btnCats.setAttribute('aria-current', 'page');
            if (svgCats) svgCats.style.color = '#2563eb';
            if (badgeCats) {
                badgeCats.style.background = '#2563eb';
                badgeCats.style.color = '#ffffff';
            }

            btnProds.style.borderColor = 'transparent';
            btnProds.style.color = '#64748b';
            btnProds.style.fontWeight = '500';
            btnProds.removeAttribute('aria-current');
            if (svgProds) svgProds.style.color = '#64748b';
            if (badgeProds) {
                badgeProds.style.background = '#f1f5f9';
                badgeProds.style.color = '#475569';
            }

            window.location.hash = 'categorias';
        } else {
            panelProds.style.display = 'block';
            panelCats.style.display = 'none';

            btnProds.style.borderColor = '#2563eb';
            btnProds.style.color = '#2563eb';
            btnProds.style.fontWeight = '600';
            btnProds.setAttribute('aria-current', 'page');
            if (svgProds) svgProds.style.color = '#2563eb';
            if (badgeProds) {
                badgeProds.style.background = '#2563eb';
                badgeProds.style.color = '#ffffff';
            }

            btnCats.style.borderColor = 'transparent';
            btnCats.style.color = '#64748b';
            btnCats.style.fontWeight = '500';
            btnCats.removeAttribute('aria-current');
            if (svgCats) svgCats.style.color = '#64748b';
            if (badgeCats) {
                badgeCats.style.background = '#f1f5f9';
                badgeCats.style.color = '#475569';
            }

            window.location.hash = 'productos';
        }
    }

    function filtrarTablaProductos() {
        const query = (document.getElementById('filtro_busqueda_prod')?.value || '').toLowerCase().trim();
        const catFilter = (document.getElementById('filtro_categoria_prod')?.value || '').toLowerCase().trim();
        const stockFilter = document.getElementById('filtro_stock_prod')?.value || '';
        const rows = document.querySelectorAll('#tabla_productos_admin tbody .row-producto-item');
        const contador = document.getElementById('contador_prods_visibles');

        let visibles = 0;

        rows.forEach(row => {
            const nombre = row.getAttribute('data-nombre') || '';
            const cat = row.getAttribute('data-cat') || '';
            const desc = row.getAttribute('data-desc') || '';
            const stock = parseInt(row.getAttribute('data-stock') || '0', 10);

            const matchQuery = !query || nombre.includes(query) || cat.includes(query) || desc.includes(query);
            const matchCat = !catFilter || cat === catFilter;

            let matchStock = true;
            if (stockFilter === 'con_stock') matchStock = stock > 5;
            else if (stockFilter === 'bajo_stock') matchStock = stock > 0 && stock <= 5;
            else if (stockFilter === 'agotado') matchStock = stock === 0;

            if (matchQuery && matchCat && matchStock) {
                row.style.display = '';
                visibles++;
            } else {
                row.style.display = 'none';
            }
        });

        if (contador) {
            contador.textContent = `Mostrando ${visibles} producto(s)`;
        }
    }

    window.addEventListener('DOMContentLoaded', function() {
        if (window.location.hash === '#categorias') {
            switchAdminCatalogTab('categorias');
        } else {
            switchAdminCatalogTab('productos');
        }
    });

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
