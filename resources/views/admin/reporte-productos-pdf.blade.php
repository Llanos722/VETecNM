<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos — VETecNM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', Arial, sans-serif;
            background: #cbd5e1;
            color: #0f172a;
            font-size: 12px;
            line-height: 1.4;
        }

        /* Barra de Herramientas (Solo en Pantalla, NUNCA en Impresión/PDF) */
        .screen-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            flex-wrap: wrap;
            background: #0f172a;
            padding: 10px 24px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0,0,0,0.25);
        }
        .toolbar-brand {
            font-size: 0.95rem; font-weight: 800; color: #fff;
            display: flex; align-items: center; gap: 8px;
        }
        .toolbar-brand span { color: #38bdf8; }
        .toolbar-right { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
        
        .tb-btn {
            display: inline-flex; align-items: center; gap: 6px;
            border: none; border-radius: 6px; padding: 7px 14px;
            font-size: 0.82rem; font-weight: 600; cursor: pointer;
            text-decoration: none; transition: all 0.18s;
        }
        .tb-btn-pdf {
            background: #059669; color: #fff;
        }
        .tb-btn-pdf:hover { background: #047857; }
        .tb-btn-back {
            background: #334155; color: #e2e8f0;
        }
        .tb-btn-back:hover { background: #475569; color: #fff; }

        .tb-filter-form {
            display: flex; align-items: center; gap: 6px;
        }
        .tb-filter-form label { color: #94a3b8; font-size: 0.78rem; font-weight: 500; }
        .tb-filter-form select {
            padding: 6px 10px; border-radius: 6px;
            border: 1px solid #475569; background: #1e293b;
            color: #f1f5f9; font-size: 0.8rem; outline: none; cursor: pointer;
        }

        /* Hoja de Documento Formal */
        .documento-hoja-wrap {
            max-width: 860px;
            margin: 24px auto 40px;
            padding: 0 16px;
        }
        .documento-hoja {
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0,0,0,0.12);
            padding: 36px 42px;
            border-radius: 4px;
        }

        /* Membrete Oficial */
        .doc-header {
            border-bottom: 2pt solid #1e3a8a;
            padding-bottom: 12px;
            margin-bottom: 16px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
        }
        .doc-inst h1 {
            font-size: 1.15rem;
            font-weight: 800;
            color: #1e3a8a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .doc-inst p {
            font-size: 0.78rem;
            color: #475569;
            margin-top: 2px;
        }
        .doc-meta {
            text-align: right;
            font-size: 0.78rem;
            color: #475569;
        }
        .doc-meta strong { color: #0f172a; }

        /* Título del Reporte */
        .doc-title-block {
            text-align: center;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 10px 14px;
            margin-bottom: 16px;
        }
        .doc-title-block h2 {
            font-size: 1.05rem;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .doc-title-block p {
            font-size: 0.8rem;
            color: #64748b;
            margin-top: 2px;
        }

        /* Métricas de Resumen */
        .summary-strip {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 18px;
        }
        .summary-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 8px 12px;
            text-align: center;
        }
        .summary-card .val {
            font-size: 1.15rem;
            font-weight: 800;
            color: #1e3a8a;
        }
        .summary-card .lbl {
            font-size: 0.72rem;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 600;
        }

        /* Secciones de Categoría */
        .category-block {
            margin-bottom: 22px;
            page-break-inside: avoid;
        }
        .category-header {
            background: #f1f5f9;
            border-left: 4px solid #0284c7;
            padding: 7px 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 0 4px 4px 0;
            margin-bottom: 6px;
        }
        .category-title {
            font-size: 0.92rem;
            font-weight: 700;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .category-count {
            font-size: 0.75rem;
            font-weight: 600;
            color: #475569;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            padding: 2px 8px;
            border-radius: 12px;
        }

        /* Tabla de Productos */
        .report-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.8rem;
        }
        .report-table th {
            background: #f8fafc;
            color: #334155;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 0.4px;
            padding: 6px 10px;
            border-top: 1px solid #cbd5e1;
            border-bottom: 1.5px solid #cbd5e1;
            text-align: left;
        }
        .report-table td {
            padding: 6px 10px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
            color: #1e293b;
        }
        .report-table tbody tr:nth-child(even) {
            background-color: #fafbfc;
        }

        .badge-stock {
            display: inline-block;
            font-weight: 700;
            font-size: 0.72rem;
            padding: 2px 6px;
            border-radius: 4px;
        }
        .stock-in { background: #dcfce7; color: #166534; }
        .stock-low { background: #fef9c3; color: #854d0e; }
        .stock-out { background: #fee2e2; color: #991b1b; }

        /* Pie de Documento */
        .doc-footer {
            margin-top: 24px;
            border-top: 1px solid #cbd5e1;
            padding-top: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.72rem;
            color: #64748b;
        }

        /* ESTILOS DE IMPRESIÓN (PDF) */
        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
                font-size: 11px !important;
            }
            .screen-toolbar {
                display: none !important;
            }
            .documento-hoja-wrap {
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            .documento-hoja {
                box-shadow: none !important;
                padding: 10mm 12mm !important;
                border: none !important;
            }
            @page {
                size: portrait;
                margin: 8mm;
            }
        }
    </style>
</head>
<body>

    <!-- Barra de Herramientas Exclusiva de Pantalla (Oculta en PDF) -->
    <div class="screen-toolbar">
        <div class="toolbar-brand">
            <i class="fa-solid fa-file-pdf"></i>
            <span>VETecNM</span> • Catálogo de Productos
        </div>

        <div class="toolbar-right">
            <!-- Selector de Categoría -->
            <form action="{{ route('admin.productos.pdf') }}" method="GET" class="tb-filter-form">
                <label for="categoria_id"><i class="fa-solid fa-filter"></i> Filtrar Categoría:</label>
                <select name="categoria_id" id="categoria_id" onchange="this.form.submit()">
                    <option value="todas" {{ (!$categoriaId || $categoriaId === 'todas') ? 'selected' : '' }}>
                        -- Todas las Categorías --
                    </option>
                    @foreach ($todasCategorias as $catItem)
                        <option value="{{ $catItem->id_categoria }}" {{ $categoriaId == $catItem->id_categoria ? 'selected' : '' }}>
                            {{ $catItem->nombre }}
                        </option>
                    @endforeach
                </select>
            </form>

            <button type="button" onclick="window.print()" class="tb-btn tb-btn-pdf">
                <i class="fa-solid fa-print"></i> Imprimir / Guardar en PDF
            </button>
            <a href="{{ route('admin.productos.index') }}" class="tb-btn tb-btn-back">
                <i class="fa-solid fa-arrow-left"></i> Volver al Catálogo
            </a>
        </div>
    </div>

    <!-- Hoja de Documento Formal -->
    <div class="documento-hoja-wrap">
        <div class="documento-hoja">
            <!-- Membrete -->
            <div class="doc-header">
                <div class="doc-inst">
                    <h1>Hospital Veterinario VETecNM</h1>
                    <p>Centro Clínico Universitario • Control y Gestión de Inventario</p>
                </div>
                <div class="doc-meta">
                    <div><strong>Fecha de Emisión:</strong> {{ now()->format('d/m/Y H:i') }}</div>
                    <div><strong>Generado por:</strong> {{ session('user_nombre', 'Administrador') }}</div>
                    <div><strong>Reporte:</strong> CAT-PROD-{{ now()->format('Ymd') }}</div>
                </div>
            </div>

            <!-- Título del Documento -->
            <div class="doc-title-block">
                <h2>Catálogo Oficial de Productos y Artículos</h2>
                <p>
                    @if ($categoriaSeleccionada)
                        Clasificación Específica: <strong>{{ $categoriaSeleccionada->nombre }}</strong>
                    @else
                        Reporte General Clasificado por Categorías
                    @endif
                </p>
            </div>

            <!-- Métricas Resumen -->
            <div class="summary-strip">
                <div class="summary-card">
                    <div class="val">{{ $totalProductos }}</div>
                    <div class="lbl">Total Artículos</div>
                </div>
                <div class="summary-card">
                    <div class="val">{{ $totalStock }}</div>
                    <div class="lbl">Unidades en Existencia</div>
                </div>
                <div class="summary-card">
                    <div class="val">${{ number_format($valorTotalInventario, 2) }}</div>
                    <div class="lbl">Valor de Inventario (MXN)</div>
                </div>
            </div>

            <!-- Listas Organizadas por Categoría -->
            @forelse ($categorias as $cat)
                <div class="category-block">
                    <div class="category-header">
                        <div class="category-title">
                            <i class="fa-solid fa-tag" style="color: #0284c7;"></i>
                            {{ $cat->nombre }}
                            @if (!empty($cat->descripcion))
                                <span style="font-size: 0.75rem; font-weight: normal; color: #64748b;">— {{ $cat->descripcion }}</span>
                            @endif
                        </div>
                        <span class="category-count">{{ $cat->total_prods }} artículo(s)</span>
                    </div>

                    <table class="report-table">
                        <thead>
                            <tr>
                                <th style="width: 45px;">ID</th>
                                <th>Artículo / Producto</th>
                                <th>Descripción</th>
                                <th style="text-align: right; width: 90px;">Precio Unit.</th>
                                <th style="text-align: center; width: 75px;">Stock</th>
                                <th style="text-align: center; width: 95px;">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($cat->productos as $p)
                                <tr>
                                    <td><strong>#{{ $p->id_producto }}</strong></td>
                                    <td><strong>{{ $p->nombre }}</strong></td>
                                    <td style="color: #64748b;">{{ $p->descripcion ?: '—' }}</td>
                                    <td style="text-align: right; font-weight: 700; color: #059669;">
                                        ${{ number_format($p->precio, 2) }}
                                    </td>
                                    <td style="text-align: center; font-weight: 600;">
                                        {{ $p->stock }}
                                    </td>
                                    <td style="text-align: center;">
                                        @if ($p->stock > 5)
                                            <span class="badge-stock stock-in">Disponible</span>
                                        @elseif ($p->stock > 0)
                                            <span class="badge-stock stock-low">Stock Bajo</span>
                                        @else
                                            <span class="badge-stock stock-out">Agotado</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; color: #94a3b8; padding: 10px;">
                                        No hay artículos registrados en esta categoría.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @empty
                <div style="text-align: center; padding: 24px; color: #94a3b8;">
                    No se encontraron categorías de productos para mostrar.
                </div>
            @endforelse

            <!-- Productos sin categoría asignada si existen -->
            @if ($productosSinCategoria->isNotEmpty())
                <div class="category-block">
                    <div class="category-header" style="border-left-color: #64748b;">
                        <div class="category-title" style="color: #475569;">
                            <i class="fa-solid fa-folder-open"></i> Sin Categoría Asignada
                        </div>
                        <span class="category-count">{{ $productosSinCategoria->count() }} artículo(s)</span>
                    </div>

                    <table class="report-table">
                        <thead>
                            <tr>
                                <th style="width: 45px;">ID</th>
                                <th>Artículo / Producto</th>
                                <th>Descripción</th>
                                <th style="text-align: right; width: 90px;">Precio Unit.</th>
                                <th style="text-align: center; width: 75px;">Stock</th>
                                <th style="text-align: center; width: 95px;">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productosSinCategoria as $p)
                                <tr>
                                    <td><strong>#{{ $p->id_producto }}</strong></td>
                                    <td><strong>{{ $p->nombre }}</strong></td>
                                    <td style="color: #64748b;">{{ $p->descripcion ?: '—' }}</td>
                                    <td style="text-align: right; font-weight: 700; color: #059669;">
                                        ${{ number_format($p->precio, 2) }}
                                    </td>
                                    <td style="text-align: center; font-weight: 600;">{{ $p->stock }}</td>
                                    <td style="text-align: center;">
                                        @if ($p->stock > 0)
                                            <span class="badge-stock stock-in">Disponible</span>
                                        @else
                                            <span class="badge-stock stock-out">Agotado</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <!-- Pie Formal del Documento -->
            <div class="doc-footer">
                <div>VETecNM • Sistema de Gestión Clínica e Inventario Hospitalario</div>
                <div>Documento Oficial Generado para Uso Interno y de Mostrador</div>
            </div>
        </div>
    </div>

</body>
</html>
