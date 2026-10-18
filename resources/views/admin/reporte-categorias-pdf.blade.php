<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Categorías — VETecNM</title>
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
            background: #7c3aed; color: #fff;
        }
        .tb-btn-pdf:hover { background: #6d28d9; }
        .tb-btn-back {
            background: #334155; color: #e2e8f0;
        }
        .tb-btn-back:hover { background: #475569; color: #fff; }

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
            color: #7c3aed;
        }
        .summary-card .lbl {
            font-size: 0.72rem;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 600;
        }

        /* Tabla de Categorías */
        .report-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.82rem;
        }
        .report-table th {
            background: #f8fafc;
            color: #334155;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 0.4px;
            padding: 8px 12px;
            border-top: 1px solid #cbd5e1;
            border-bottom: 1.5px solid #cbd5e1;
            text-align: left;
        }
        .report-table td {
            padding: 8px 12px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
            color: #1e293b;
        }
        .report-table tbody tr:nth-child(even) {
            background-color: #fafbfc;
        }

        .badge-cat-count {
            display: inline-block;
            background: #eff6ff;
            color: #1e40af;
            border: 1px solid #bfdbfe;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 700;
        }

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
            <i class="fa-solid fa-tags"></i>
            <span>VETecNM</span> • Estructura de Categorías
        </div>

        <div class="toolbar-right">
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
                    <p>Centro Clínico Universitario • Organización y Clasificación del Catálogo</p>
                </div>
                <div class="doc-meta">
                    <div><strong>Fecha de Emisión:</strong> {{ now()->format('d/m/Y H:i') }}</div>
                    <div><strong>Generado por:</strong> {{ session('user_nombre', 'Administrador') }}</div>
                    <div><strong>Reporte:</strong> CAT-CAT-{{ now()->format('Ymd') }}</div>
                </div>
            </div>

            <!-- Título del Documento -->
            <div class="doc-title-block">
                <h2>Estructura Oficial de Categorías de Productos</h2>
                <p>Listado formal de grupos y divisiones del inventario general</p>
            </div>

            <!-- Métricas Resumen -->
            <div class="summary-strip">
                <div class="summary-card">
                    <div class="val">{{ $totalCategorias }}</div>
                    <div class="lbl">Categorías Activas</div>
                </div>
                <div class="summary-card">
                    <div class="val">{{ $totalProductos }}</div>
                    <div class="lbl">Productos Clasificados</div>
                </div>
                <div class="summary-card">
                    <div class="val">{{ $totalStock }}</div>
                    <div class="lbl">Existencias Globales</div>
                </div>
            </div>

            <!-- Tabla de Categorías -->
            <table class="report-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">ID</th>
                        <th>Nombre de la Categoría</th>
                        <th>Descripción y Alcance</th>
                        <th style="text-align: center; width: 120px;">Productos Asociados</th>
                        <th style="text-align: center; width: 110px;">Stock Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categorias as $c)
                        <tr>
                            <td><strong>#{{ $c->id_categoria }}</strong></td>
                            <td><strong style="color: #1e3a8a;"><i class="fa-solid fa-tag"></i> {{ $c->nombre }}</strong></td>
                            <td style="color: #475569;">{{ $c->descripcion ?: 'Sin descripción detallada' }}</td>
                            <td style="text-align: center;">
                                <span class="badge-cat-count">{{ $c->total_productos }} producto(s)</span>
                            </td>
                            <td style="text-align: center; font-weight: 700; color: #059669;">
                                {{ $c->total_stock }} unidades
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: #94a3b8; padding: 20px;">
                                No hay categorías registradas en el sistema.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pie Formal del Documento -->
            <div class="doc-footer">
                <div>VETecNM • Clasificación y Organización de Inventario</div>
                <div>Documento Oficial Generado para Uso Interno y de Mostrador</div>
            </div>
        </div>
    </div>

</body>
</html>
