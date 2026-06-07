<x-app-layout>
    @php
        $mainExtension = $extensionStats->first();
        $topUserMax = max(1, (int) $topUsers->max('documents_count'));
        $topFolderMax = max(1, (int) $topFolders->max('documents_count'));
        $dashboardCharts = [
            'monthly' => $monthlyStats->map(fn ($month) => [
                'label' => $month['label'],
                'total' => $month['total'],
                'bytes' => $month['bytes'],
            ])->values(),
            'extensions' => $extensionStats->map(fn ($extension) => [
                'label' => $extension['label'],
                'total' => $extension['total'],
                'bytes' => $extension['bytes'],
            ])->values(),
        ];
    @endphp

    <style>
        .gd-page {
            min-height: calc(100vh - 4rem);
            background: #eef2f7;
            color: #0f2747;
            padding: 18px;
        }

        .gd-shell {
            max-width: 1280px;
            margin: 0 auto;
            background: #ffffff;
            border: 1px solid #d9e2ef;
            box-shadow: 0 12px 30px rgba(15, 39, 71, 0.08);
        }

        .gd-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            border-top: 5px solid #1f4f82;
            border-bottom: 1px solid #d9e2ef;
            padding: 18px 22px;
        }

        .gd-title {
            margin: 0;
            color: #061a33;
            font-size: 25px;
            font-weight: 900;
            line-height: 1;
            text-transform: uppercase;
        }

        .gd-title span {
            color: #64748b;
            font-weight: 400;
        }

        .gd-subtitle {
            margin-top: 8px;
            color: #365577;
            font-size: 13px;
            font-weight: 700;
        }

        .gd-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 38px;
            border: 1px solid #b8c7da;
            border-radius: 6px;
            padding: 0 16px;
            color: #1f4f82;
            font-size: 13px;
            font-weight: 800;
            text-decoration: none;
            background: #ffffff;
        }

        .gd-button:hover {
            background: #f5f8fc;
        }

        .gd-top {
            display: grid;
            grid-template-columns: 0.72fr 1.28fr;
            border-bottom: 1px solid #d9e2ef;
        }

        .gd-section {
            padding: 18px;
        }

        .gd-section + .gd-section {
            border-left: 1px solid #d9e2ef;
        }

        .gd-section-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 14px;
            color: #0f2747;
            font-size: 14px;
            font-weight: 900;
        }

        .gd-section-title small {
            color: #7587a0;
            font-size: 11px;
            font-weight: 800;
        }

        .gd-kpis {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .gd-kpi {
            min-height: 112px;
            border: 1px solid #d9e2ef;
            background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
            padding: 15px;
        }

        .gd-kpi-label {
            color: #0f2747;
            font-size: 12px;
            font-weight: 900;
        }

        .gd-kpi-value {
            margin-top: 9px;
            color: #1f4f82;
            font-size: 32px;
            font-weight: 500;
            line-height: 1;
        }

        .gd-kpi-detail {
            margin-top: 14px;
            border-top: 1px solid #d9e2ef;
            padding-top: 9px;
            color: #56708f;
            font-size: 12px;
            font-weight: 700;
        }

        .gd-chart-box {
            position: relative;
            height: 330px;
            border-bottom: 1px solid #cbd8e8;
            padding: 8px 4px 0;
        }

        .gd-canvas {
            display: block;
            width: 100%;
            height: 100%;
        }

        .gd-chart-hint {
            margin-top: 8px;
            min-height: 18px;
            color: #56708f;
            font-size: 12px;
            font-weight: 800;
            text-align: center;
        }

        .gd-legend {
            display: flex;
            justify-content: center;
            gap: 24px;
            margin-top: 12px;
            color: #56708f;
            font-size: 12px;
            font-weight: 800;
        }

        .gd-dot {
            display: inline-block;
            width: 11px;
            height: 11px;
            margin-right: 7px;
            vertical-align: -1px;
        }

        .gd-bottom {
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .gd-panel {
            min-height: 260px;
            border-right: 1px solid #d9e2ef;
            border-bottom: 1px solid #d9e2ef;
            padding: 17px;
        }

        .gd-panel:nth-child(2n) {
            border-right: 0;
        }

        .gd-panel-wide {
            grid-column: 1 / -1;
            border-right: 0;
        }

        .gd-donut-wrap {
            display: grid;
            grid-template-columns: 170px minmax(0, 1fr);
            align-items: center;
            gap: 18px;
        }

        .gd-donut-canvas {
            display: block;
            width: 150px;
            height: 150px;
        }

        .gd-list {
            display: grid;
            gap: 9px;
        }

        .gd-list-row {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            align-items: center;
            gap: 12px;
            color: #0f2747;
            font-size: 12px;
            font-weight: 800;
        }

        .gd-list-name {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .gd-list-value {
            color: #56708f;
            font-weight: 900;
        }

        .gd-progress {
            grid-column: 1 / -1;
            height: 8px;
            overflow: hidden;
            background: #dbe4ee;
        }

        .gd-progress-fill {
            height: 100%;
            background: #1f4f82;
        }

        .gd-progress-fill-pink {
            background: #db2777;
        }

        .gd-recent {
            display: grid;
            gap: 10px;
        }

        .gd-recent-link {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 14px;
            border: 1px solid #d9e2ef;
            padding: 11px 12px;
            color: inherit;
            text-decoration: none;
        }

        .gd-recent-link:hover {
            background: #f8fbff;
        }

        .gd-recent-title {
            overflow: hidden;
            color: #0f2747;
            font-size: 12px;
            font-weight: 900;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .gd-recent-folder {
            margin-top: 4px;
            overflow: hidden;
            color: #56708f;
            font-size: 11px;
            font-weight: 800;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .gd-recent-date {
            align-self: center;
            color: #56708f;
            font-size: 11px;
            font-weight: 900;
            white-space: nowrap;
        }

        @media (max-width: 1100px) {
            .gd-top,
            .gd-bottom {
                grid-template-columns: 1fr;
            }

            .gd-section + .gd-section,
            .gd-panel {
                border-left: 0;
                border-right: 0;
            }
        }

        @media (max-width: 700px) {
            .gd-page {
                padding: 10px;
            }

            .gd-header {
                align-items: stretch;
                flex-direction: column;
            }

            .gd-title {
                font-size: 20px;
            }

            .gd-kpis,
            .gd-donut-wrap {
                grid-template-columns: 1fr;
            }

            .gd-chart-box {
                height: 260px;
            }
        }
    </style>

    <div class="gd-page">
        <div class="gd-shell">
            <header class="gd-header">
                <div>
                    <h1 class="gd-title">Gestion Documental <span>Dashboard</span></h1>
                    <div class="gd-subtitle">Evaluacion general de documentos, carpetas y usuarios</div>
                </div>

                <a href="{{ route('explorer.index') }}" class="gd-button">Explorador</a>
            </header>

            <div class="gd-top">
                <section class="gd-section">
                    <div class="gd-section-title">Indicadores actuales</div>

                    <div class="gd-kpis">
                        @foreach ($stats as $stat)
                            <article class="gd-kpi">
                                <div class="gd-kpi-label">{{ $stat['label'] }}</div>
                                <div class="gd-kpi-value">{{ $stat['value'] }}</div>
                                <div class="gd-kpi-detail">{{ $stat['detail'] }}</div>
                            </article>
                        @endforeach
                    </div>
                </section>

                <section class="gd-section">
                    <div class="gd-section-title">
                        <span>Documentos cargados por mes</span>
                        <small>Ultimos 6 meses</small>
                    </div>

                    <div class="gd-chart-box">
                        <canvas id="documentsByMonthChart" class="gd-canvas" aria-label="Documentos cargados por mes"></canvas>
                    </div>
                    <div id="documentsByMonthHint" class="gd-chart-hint"></div>

                    <div class="gd-legend">
                        <span><span class="gd-dot" style="background:#db2777"></span>Documentos</span>
                        <span><span class="gd-dot" style="background:#1f4f82"></span>Referencia</span>
                    </div>
                </section>
            </div>

            <div class="gd-bottom">
                <section class="gd-panel">
                    <div class="gd-section-title">
                        <span>Tipos de archivo</span>
                        <small>Top 6</small>
                    </div>

                    <div class="gd-donut-wrap">
                        <canvas id="extensionsDonutChart" class="gd-donut-canvas" width="150" height="150" aria-label="Tipos de archivo"></canvas>

                        <div class="gd-list">
                            @forelse ($extensionStats as $extension)
                                <div class="gd-list-row">
                                    <span class="gd-list-name">{{ $extension['label'] }}</span>
                                    <span class="gd-list-value">{{ $extension['bytes'] }}</span>
                                    <div class="gd-progress">
                                        <div class="gd-progress-fill" style="width: {{ max(4, $extension['percent']) }}%"></div>
                                    </div>
                                </div>
                            @empty
                                <p class="gd-list-value">Sin documentos.</p>
                            @endforelse
                        </div>
                    </div>
                </section>

                <section class="gd-panel">
                    <div class="gd-section-title">
                        <span>Carpetas con mas archivos</span>
                        <small>Archivos</small>
                    </div>

                    <div class="gd-list">
                        @forelse ($topFolders as $folder)
                            @php
                                $percent = $folder->documents_count > 0 ? ($folder->documents_count / $topFolderMax) * 100 : 0;
                            @endphp
                            <div class="gd-list-row">
                                <span class="gd-list-name">{{ $folder->name }}</span>
                                <span class="gd-list-value">{{ $folder->documents_count }}</span>
                                <div class="gd-progress">
                                    <div class="gd-progress-fill gd-progress-fill-pink" style="width: {{ max(4, $percent) }}%"></div>
                                </div>
                            </div>
                        @empty
                            <p class="gd-list-value">Sin carpetas registradas.</p>
                        @endforelse
                    </div>
                </section>

                <section class="gd-panel">
                    <div class="gd-section-title">
                        <span>Usuarios con mas documentos</span>
                        <small>Actividad</small>
                    </div>

                    <div class="gd-list">
                        @forelse ($topUsers as $user)
                            @php
                                $percent = $user->documents_count > 0 ? ($user->documents_count / $topUserMax) * 100 : 0;
                            @endphp
                            <div class="gd-list-row">
                                <span class="gd-list-name">{{ $user->name }}</span>
                                <span class="gd-list-value">{{ $user->documents_count }}</span>
                                <div class="gd-progress">
                                    <div class="gd-progress-fill" style="width: {{ max(4, $percent) }}%"></div>
                                </div>
                            </div>
                        @empty
                            <p class="gd-list-value">Sin usuarios registrados.</p>
                        @endforelse
                    </div>
                </section>

                <section class="gd-panel gd-panel-wide">
                    <div class="gd-section-title">
                        <span>Ultimos documentos</span>
                        <small>Recientes</small>
                    </div>

                    <div class="gd-recent">
                        @forelse ($recentDocuments as $document)
                            <a href="{{ route('documents.preview', $document) }}" class="gd-recent-link">
                                <div>
                                    <div class="gd-recent-title">{{ $document->original_name }}</div>
                                    <div class="gd-recent-folder">{{ $document->folder?->name ?? 'Sin carpeta' }}</div>
                                </div>
                                <span class="gd-recent-date">{{ $document->created_at?->format('d/m/Y') }}</span>
                            </a>
                        @empty
                            <p class="gd-list-value">Sin documentos recientes.</p>
                        @endforelse
                    </div>
                </section>
            </div>
        </div>
    </div>

    <script>
        (() => {
            const chartData = @json($dashboardCharts);
            const palette = ['#db2777', '#1f4f82', '#22c55e', '#f59e0b', '#8b5cf6', '#06b6d4'];

            function setupCanvas(canvas) {
                const ratio = window.devicePixelRatio || 1;
                const rect = canvas.getBoundingClientRect();
                canvas.width = Math.max(1, Math.floor(rect.width * ratio));
                canvas.height = Math.max(1, Math.floor(rect.height * ratio));
                const ctx = canvas.getContext('2d');
                ctx.setTransform(ratio, 0, 0, ratio, 0, 0);
                return { ctx, width: rect.width, height: rect.height };
            }

            function drawRoundedBar(ctx, x, y, width, height, radius, fill) {
                const safeHeight = Math.max(height, 2);
                const safeY = y + height - safeHeight;
                const r = Math.min(radius, width / 2, safeHeight / 2);
                ctx.fillStyle = fill;
                ctx.beginPath();
                ctx.moveTo(x, safeY + safeHeight);
                ctx.lineTo(x, safeY + r);
                ctx.quadraticCurveTo(x, safeY, x + r, safeY);
                ctx.lineTo(x + width - r, safeY);
                ctx.quadraticCurveTo(x + width, safeY, x + width, safeY + r);
                ctx.lineTo(x + width, safeY + safeHeight);
                ctx.closePath();
                ctx.fill();
            }

            function drawMonthlyChart() {
                const canvas = document.getElementById('documentsByMonthChart');
                if (!canvas) return;

                const { ctx, width, height } = setupCanvas(canvas);
                const data = chartData.monthly || [];
                const max = Math.max(1, ...data.map(item => Number(item.total) || 0));
                const padding = { top: 28, right: 18, bottom: 34, left: 34 };
                const plotWidth = width - padding.left - padding.right;
                const plotHeight = height - padding.top - padding.bottom;
                const step = plotWidth / Math.max(1, data.length);

                ctx.clearRect(0, 0, width, height);
                ctx.font = '700 11px Arial, sans-serif';
                ctx.textAlign = 'right';
                ctx.textBaseline = 'middle';

                for (let line = 0; line <= 4; line++) {
                    const y = padding.top + (plotHeight / 4) * line;
                    const value = Math.round(max - (max / 4) * line);
                    ctx.strokeStyle = '#dbe4ee';
                    ctx.lineWidth = 1;
                    ctx.beginPath();
                    ctx.moveTo(padding.left, y);
                    ctx.lineTo(width - padding.right, y);
                    ctx.stroke();
                    ctx.fillStyle = '#7587a0';
                    ctx.fillText(String(value), padding.left - 8, y);
                }

                data.forEach((item, index) => {
                    const total = Number(item.total) || 0;
                    const barHeight = total > 0 ? Math.max(8, (total / max) * plotHeight) : 3;
                    const groupCenter = padding.left + step * index + step / 2;
                    const barWidth = Math.min(28, step * 0.28);
                    const baseY = padding.top + plotHeight;

                    drawRoundedBar(ctx, groupCenter - barWidth - 3, baseY - barHeight, barWidth, barHeight, 4, '#db2777');
                    drawRoundedBar(ctx, groupCenter + 3, baseY - Math.max(3, barHeight * 0.78), barWidth, Math.max(3, barHeight * 0.78), 4, '#1f4f82');

                    ctx.fillStyle = '#0f2747';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'bottom';
                    ctx.font = '900 12px Arial, sans-serif';
                    ctx.fillText(String(total), groupCenter, baseY - barHeight - 6);

                    ctx.fillStyle = '#56708f';
                    ctx.textBaseline = 'top';
                    ctx.font = '800 12px Arial, sans-serif';
                    ctx.fillText(item.label, groupCenter, baseY + 10);
                });

                const hint = document.getElementById('documentsByMonthHint');
                const peak = data.reduce((best, item) => (Number(item.total) || 0) > (Number(best.total) || 0) ? item : best, data[0] || { label: 'N/A', total: 0 });
                if (hint) hint.textContent = `Mes con mas carga: ${peak.label} (${peak.total} documentos)`;
            }

            function drawDonutChart() {
                const canvas = document.getElementById('extensionsDonutChart');
                if (!canvas) return;

                const { ctx, width, height } = setupCanvas(canvas);
                const data = chartData.extensions || [];
                const total = data.reduce((sum, item) => sum + (Number(item.total) || 0), 0);
                const cx = width / 2;
                const cy = height / 2;
                const radius = Math.min(width, height) / 2 - 8;
                const innerRadius = radius * 0.58;

                ctx.clearRect(0, 0, width, height);

                if (total === 0) {
                    ctx.beginPath();
                    ctx.arc(cx, cy, radius, 0, Math.PI * 2);
                    ctx.strokeStyle = '#dbe4ee';
                    ctx.lineWidth = radius - innerRadius;
                    ctx.stroke();
                } else {
                    let start = -Math.PI / 2;
                    data.forEach((item, index) => {
                        const value = Number(item.total) || 0;
                        const angle = (value / total) * Math.PI * 2;
                        ctx.beginPath();
                        ctx.arc(cx, cy, (radius + innerRadius) / 2, start, start + angle);
                        ctx.strokeStyle = palette[index % palette.length];
                        ctx.lineWidth = radius - innerRadius;
                        ctx.stroke();
                        start += angle;
                    });
                }

                ctx.fillStyle = '#ffffff';
                ctx.beginPath();
                ctx.arc(cx, cy, innerRadius - 2, 0, Math.PI * 2);
                ctx.fill();

                const first = data[0] || { label: 'N/A', total: 0 };
                ctx.fillStyle = '#0f2747';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.font = '900 20px Arial, sans-serif';
                ctx.fillText(first.label, cx, cy - 8);
                ctx.fillStyle = '#64748b';
                ctx.font = '800 11px Arial, sans-serif';
                ctx.fillText(`${first.total} docs`, cx, cy + 15);
            }

            function drawCharts() {
                drawMonthlyChart();
                drawDonutChart();
            }

            window.addEventListener('resize', drawCharts);
            document.addEventListener('DOMContentLoaded', drawCharts);
            drawCharts();
        })();
    </script>
</x-app-layout>
