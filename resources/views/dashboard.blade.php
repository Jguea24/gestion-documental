<x-app-layout>
    @php
        $topUserMax = max(1, (int) $topUsers->max('documents_count'));
        $topFolderMax = max(1, (int) $topFolders->max('documents_count'));
        $documentStat = collect($stats)->firstWhere('label', __('Documents'));
        $folderStat = collect($stats)->firstWhere('label', __('Folders'));
        $totalDocuments = $documentStat['value'] ?? '0';
        $totalFolders = $folderStat['value'] ?? '0';
        $storageDetail = $documentStat['detail'] ?? '';
        $mainExtension = $extensionStats->first();
        $peakMonth = $monthlyStats->sortByDesc('total')->first();
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
            'translations' => [
                'peakUploadMonth' => __('Peak upload month'),
                'documents' => __('documents'),
                'noData' => __('No data available'),
            ],
        ];
    @endphp

    <style>
        .dm-page {
            min-height: calc(100vh - 4rem);
            background: #f3f6fa;
            color: #0f172a;
            padding: 20px;
        }

        .dm-shell {
            max-width: 1440px;
            margin: 0 auto;
        }

        .dm-hero {
            display: grid;
            grid-template-columns: minmax(0, 1.4fr) minmax(280px, 0.6fr);
            gap: 18px;
            align-items: stretch;
        }

        .dm-hero-main,
        .dm-hero-side,
        .dm-card,
        .dm-panel {
            border: 1px solid #d9e2ef;
            border-radius: 8px;
            background: #ffffff;
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.06);
        }

        .dm-hero-main {
            position: relative;
            overflow: hidden;
            border-color: #173f68;
            background: linear-gradient(135deg, #123b63 0%, #0f2747 58%, #102032 100%);
            color: #ffffff;
            padding: 30px;
        }

        .dm-hero-main::after {
            position: absolute;
            right: 28px;
            bottom: 24px;
            width: 220px;
            height: 130px;
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 8px;
            background:
                linear-gradient(rgba(255, 255, 255, 0.12) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.12) 1px, transparent 1px);
            background-size: 22px 22px;
            content: "";
            opacity: 0.45;
        }

        .dm-eyebrow {
            display: inline-flex;
            width: fit-content;
            align-items: center;
            gap: 8px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
            padding: 7px 12px;
            color: #dbeafe;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .dm-title {
            position: relative;
            z-index: 1;
            max-width: 760px;
            margin: 22px 0 0;
            font-size: clamp(30px, 4vw, 48px);
            font-weight: 900;
            line-height: 1.03;
        }

        .dm-title span {
            color: #8fd3ff;
        }

        .dm-subtitle {
            position: relative;
            z-index: 1;
            max-width: 680px;
            margin-top: 14px;
            color: #c7d8ec;
            font-size: 15px;
            font-weight: 700;
            line-height: 1.65;
        }

        .dm-hero-actions {
            position: relative;
            z-index: 1;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 26px;
        }

        .dm-button {
            display: inline-flex;
            min-height: 42px;
            align-items: center;
            justify-content: center;
            gap: 9px;
            border-radius: 7px;
            padding: 0 16px;
            font-size: 13px;
            font-weight: 900;
            text-decoration: none;
        }

        .dm-button-primary {
            border: 1px solid #ffffff;
            background: #ffffff;
            color: #123b63;
        }

        .dm-button-secondary {
            border: 1px solid rgba(255, 255, 255, 0.32);
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
        }

        .dm-button svg {
            height: 17px;
            width: 17px;
        }

        .dm-hero-side {
            display: grid;
            align-content: space-between;
            gap: 18px;
            padding: 22px;
        }

        .dm-side-label {
            color: #64748b;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .dm-side-value {
            margin-top: 8px;
            color: #0f2747;
            font-size: 34px;
            font-weight: 900;
            line-height: 1;
        }

        .dm-side-note {
            margin-top: 8px;
            color: #56708f;
            font-size: 13px;
            font-weight: 700;
        }

        .dm-health {
            display: grid;
            gap: 10px;
            border-top: 1px solid #d9e2ef;
            padding-top: 18px;
        }

        .dm-health-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            color: #365577;
            font-size: 13px;
            font-weight: 800;
        }

        .dm-status {
            border-radius: 999px;
            background: #dcfce7;
            padding: 5px 10px;
            color: #166534;
            font-size: 12px;
            font-weight: 900;
            white-space: nowrap;
        }

        .dm-kpis {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            margin-top: 18px;
        }

        .dm-card {
            display: grid;
            min-height: 132px;
            gap: 18px;
            padding: 18px;
        }

        .dm-card-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .dm-card-label {
            color: #365577;
            font-size: 13px;
            font-weight: 900;
        }

        .dm-card-icon {
            display: grid;
            height: 40px;
            width: 40px;
            place-items: center;
            border-radius: 8px;
            background: #eef6ff;
            color: #1f4f82;
        }

        .dm-card-icon svg {
            height: 21px;
            width: 21px;
        }

        .dm-card-value {
            color: #061a33;
            font-size: 34px;
            font-weight: 900;
            line-height: 1;
        }

        .dm-card-detail {
            border-top: 1px solid #d9e2ef;
            padding-top: 10px;
            color: #64748b;
            font-size: 12px;
            font-weight: 800;
        }

        .dm-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.55fr) minmax(340px, 0.95fr);
            gap: 18px;
            margin-top: 18px;
        }

        .dm-panel {
            overflow: hidden;
        }

        .dm-panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            border-bottom: 1px solid #d9e2ef;
            padding: 18px 20px;
        }

        .dm-panel-title {
            margin: 0;
            color: #061a33;
            font-size: 16px;
            font-weight: 900;
        }

        .dm-panel-caption {
            margin-top: 4px;
            color: #64748b;
            font-size: 12px;
            font-weight: 800;
        }

        .dm-panel-tag {
            border-radius: 999px;
            background: #f1f5f9;
            padding: 7px 11px;
            color: #365577;
            font-size: 12px;
            font-weight: 900;
            white-space: nowrap;
        }

        .dm-chart-area {
            height: 380px;
            padding: 18px 18px 12px;
        }

        .dm-canvas {
            display: block;
            height: 100%;
            width: 100%;
        }

        .dm-chart-footer {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 18px;
            border-top: 1px solid #d9e2ef;
            padding: 13px 18px 16px;
            color: #56708f;
            font-size: 12px;
            font-weight: 900;
        }

        .dm-dot {
            display: inline-block;
            width: 10px;
            height: 10px;
            margin-right: 7px;
            border-radius: 999px;
            vertical-align: -1px;
        }

        .dm-side-stack {
            display: grid;
            gap: 18px;
        }

        .dm-donut-layout {
            display: grid;
            grid-template-columns: 170px minmax(0, 1fr);
            gap: 18px;
            align-items: center;
            padding: 18px 20px 20px;
        }

        .dm-donut {
            display: block;
            width: 170px;
            height: 170px;
        }

        .dm-list {
            display: grid;
            gap: 12px;
        }

        .dm-list-row {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            align-items: center;
            gap: 12px;
            color: #0f2747;
            font-size: 13px;
            font-weight: 900;
        }

        .dm-list-name {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .dm-list-value {
            color: #56708f;
            font-size: 12px;
            font-weight: 900;
            white-space: nowrap;
        }

        .dm-progress {
            grid-column: 1 / -1;
            height: 8px;
            overflow: hidden;
            border-radius: 999px;
            background: #e2e8f0;
        }

        .dm-progress-fill {
            height: 100%;
            border-radius: inherit;
            background: #1f4f82;
        }

        .dm-progress-fill-alt {
            background: #17a673;
        }

        .dm-progress-fill-warm {
            background: #d97706;
        }

        .dm-lower {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
            margin-top: 18px;
        }

        .dm-recent {
            display: grid;
            gap: 10px;
            padding: 16px 20px 20px;
        }

        .dm-recent-link {
            display: grid;
            grid-template-columns: 42px minmax(0, 1fr) auto;
            align-items: center;
            gap: 12px;
            border: 1px solid #d9e2ef;
            border-radius: 8px;
            padding: 11px 12px;
            color: inherit;
            text-decoration: none;
            transition: border-color 120ms ease, background 120ms ease;
        }

        .dm-recent-link:hover {
            border-color: #a9bfd8;
            background: #f8fbff;
        }

        .dm-file-mark {
            display: grid;
            height: 42px;
            width: 42px;
            place-items: center;
            border-radius: 8px;
            background: #eef6ff;
            color: #1f4f82;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .dm-recent-title {
            overflow: hidden;
            color: #0f2747;
            font-size: 13px;
            font-weight: 900;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .dm-recent-folder {
            margin-top: 4px;
            overflow: hidden;
            color: #64748b;
            font-size: 12px;
            font-weight: 800;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .dm-recent-date {
            color: #56708f;
            font-size: 12px;
            font-weight: 900;
            white-space: nowrap;
        }

        .dm-empty {
            color: #64748b;
            font-size: 13px;
            font-weight: 800;
        }

        @media (max-width: 1180px) {
            .dm-hero,
            .dm-grid,
            .dm-lower {
                grid-template-columns: 1fr;
            }

            .dm-kpis {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 720px) {
            .dm-page {
                padding: 12px;
            }

            .dm-hero-main,
            .dm-hero-side {
                padding: 20px;
            }

            .dm-hero-main::after {
                display: none;
            }

            .dm-kpis,
            .dm-donut-layout {
                grid-template-columns: 1fr;
            }

            .dm-chart-area {
                height: 300px;
            }

            .dm-panel-header,
            .dm-recent-link {
                align-items: flex-start;
                grid-template-columns: 42px minmax(0, 1fr);
            }

            .dm-recent-date {
                grid-column: 2;
            }
        }
    </style>

    <div class="dm-page">
        <div class="dm-shell">
            <section class="dm-hero">
                <div class="dm-hero-main">
                    <div class="dm-eyebrow">{{ __('Institutional archive') }}</div>
                    <h1 class="dm-title">{{ __('Document Management') }} <span>{{ __('Control Center') }}</span></h1>
                    <p class="dm-subtitle">
                        {{ __('Operational view of documents, folders, recent activity, storage volume, and institutional file flow.') }}
                    </p>

                    <div class="dm-hero-actions">
                        <a href="{{ route('explorer.index') }}" class="dm-button dm-button-primary">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 6.5A2.5 2.5 0 0 1 5.5 4H10l2 2h6.5A2.5 2.5 0 0 1 21 8.5v7A2.5 2.5 0 0 1 18.5 18h-13A2.5 2.5 0 0 1 3 15.5z" />
                            </svg>
                            {{ __('Open archive') }}
                        </a>
                        <a href="{{ route('trash.index') }}" class="dm-button dm-button-secondary">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 7h16" />
                                <path d="M10 11v6" />
                                <path d="M14 11v6" />
                                <path d="M6 7l1 14h10l1-14" />
                                <path d="M9 7V4h6v3" />
                            </svg>
                            {{ __('Review trash') }}
                        </a>
                    </div>
                </div>

                <aside class="dm-hero-side">
                    <div>
                        <div class="dm-side-label">{{ __('Total repository') }}</div>
                        <div class="dm-side-value">{{ $totalDocuments }}</div>
                        <div class="dm-side-note">{{ $storageDetail }}</div>
                    </div>

                    <div class="dm-health">
                        <div class="dm-health-row">
                            <span>{{ __('Structure') }}</span>
                            <strong>{{ $totalFolders }} {{ __('Folders') }}</strong>
                        </div>
                        <div class="dm-health-row">
                            <span>{{ __('Main format') }}</span>
                            <strong>{{ $mainExtension['label'] ?? 'N/A' }}</strong>
                        </div>
                        <div class="dm-health-row">
                            <span>{{ __('System status') }}</span>
                            <span class="dm-status">{{ __('Active') }}</span>
                        </div>
                    </div>
                </aside>
            </section>

            <section class="dm-kpis" aria-label="{{ __('Current indicators') }}">
                @foreach ($stats as $index => $stat)
                    <article class="dm-card">
                        <div class="dm-card-top">
                            <div class="dm-card-label">{{ $stat['label'] }}</div>
                            <div class="dm-card-icon">
                                @if ($index === 0)
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M7 3h7l5 5v13H7z" /><path d="M14 3v5h5" /><path d="M10 13h6" /><path d="M10 17h4" /></svg>
                                @elseif ($index === 1)
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7a2 2 0 0 1 2-2h5l2 2h7a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" /></svg>
                                @elseif ($index === 2)
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2" /><circle cx="9.5" cy="7" r="4" /><path d="M22 21v-2a4 4 0 0 0-3-3.87" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /></svg>
                                @else
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7h16" /><path d="M6 7l1 14h10l1-14" /><path d="M9 7V4h6v3" /></svg>
                                @endif
                            </div>
                        </div>
                        <div class="dm-card-value">{{ $stat['value'] }}</div>
                        <div class="dm-card-detail">{{ $stat['detail'] }}</div>
                    </article>
                @endforeach
            </section>

            <section class="dm-grid">
                <article class="dm-panel">
                    <header class="dm-panel-header">
                        <div>
                            <h2 class="dm-panel-title">{{ __('Documents loaded by month') }}</h2>
                            <div class="dm-panel-caption">{{ __('Last 6 months') }}</div>
                        </div>
                        <div class="dm-panel-tag">
                            {{ __('Peak upload month') }}: {{ $peakMonth['label'] ?? 'N/A' }}
                        </div>
                    </header>
                    <div class="dm-chart-area">
                        <canvas id="documentsByMonthChart" class="dm-canvas" aria-label="{{ __('Documents loaded by month') }}"></canvas>
                    </div>
                    <footer class="dm-chart-footer">
                        <span><span class="dm-dot" style="background:#1f4f82"></span>{{ __('Documents') }}</span>
                        <span><span class="dm-dot" style="background:#17a673"></span>{{ __('Storage reference') }}</span>
                    </footer>
                </article>

                <div class="dm-side-stack">
                    <article class="dm-panel">
                        <header class="dm-panel-header">
                            <div>
                                <h2 class="dm-panel-title">{{ __('File types') }}</h2>
                                <div class="dm-panel-caption">{{ __('Top 6') }}</div>
                            </div>
                            <span class="dm-panel-tag">{{ $mainExtension['label'] ?? 'N/A' }}</span>
                        </header>

                        <div class="dm-donut-layout">
                            <canvas id="extensionsDonutChart" class="dm-donut" width="170" height="170" aria-label="{{ __('File types') }}"></canvas>

                            <div class="dm-list">
                                @forelse ($extensionStats as $extension)
                                    <div class="dm-list-row">
                                        <span class="dm-list-name">{{ $extension['label'] }}</span>
                                        <span class="dm-list-value">{{ $extension['total'] }} / {{ $extension['bytes'] }}</span>
                                        <div class="dm-progress">
                                            <div class="dm-progress-fill" style="width: {{ max(4, $extension['percent']) }}%"></div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="dm-empty">{{ __('No documents.') }}</p>
                                @endforelse
                            </div>
                        </div>
                    </article>

                    <article class="dm-panel">
                        <header class="dm-panel-header">
                            <div>
                                <h2 class="dm-panel-title">{{ __('Users with most documents') }}</h2>
                                <div class="dm-panel-caption">{{ __('Activity') }}</div>
                            </div>
                        </header>

                        <div class="dm-recent">
                            @forelse ($topUsers as $user)
                                @php
                                    $percent = $user->documents_count > 0 ? ($user->documents_count / $topUserMax) * 100 : 0;
                                @endphp
                                <div class="dm-list-row">
                                    <span class="dm-list-name">{{ $user->name }}</span>
                                    <span class="dm-list-value">{{ $user->documents_count }}</span>
                                    <div class="dm-progress">
                                        <div class="dm-progress-fill dm-progress-fill-alt" style="width: {{ max(4, $percent) }}%"></div>
                                    </div>
                                </div>
                            @empty
                                <p class="dm-empty">{{ __('No users registered.') }}</p>
                            @endforelse
                        </div>
                    </article>
                </div>
            </section>

            <section class="dm-lower">
                <article class="dm-panel">
                    <header class="dm-panel-header">
                        <div>
                            <h2 class="dm-panel-title">{{ __('Folders with most files') }}</h2>
                            <div class="dm-panel-caption">{{ __('Document concentration by folder') }}</div>
                        </div>
                    </header>

                    <div class="dm-recent">
                        @forelse ($topFolders as $folder)
                            @php
                                $percent = $folder->documents_count > 0 ? ($folder->documents_count / $topFolderMax) * 100 : 0;
                            @endphp
                            <div class="dm-list-row">
                                <span class="dm-list-name">{{ $folder->name }}</span>
                                <span class="dm-list-value">{{ $folder->documents_count }} {{ __('Files') }}</span>
                                <div class="dm-progress">
                                    <div class="dm-progress-fill dm-progress-fill-warm" style="width: {{ max(4, $percent) }}%"></div>
                                </div>
                            </div>
                        @empty
                            <p class="dm-empty">{{ __('No folders registered.') }}</p>
                        @endforelse
                    </div>
                </article>

                <article class="dm-panel">
                    <header class="dm-panel-header">
                        <div>
                            <h2 class="dm-panel-title">{{ __('Latest documents') }}</h2>
                            <div class="dm-panel-caption">{{ __('Recent') }}</div>
                        </div>
                    </header>

                    <div class="dm-recent">
                        @forelse ($recentDocuments as $document)
                            <a href="{{ route('documents.preview', $document) }}" class="dm-recent-link">
                                <span class="dm-file-mark">{{ $document->extension ?: 'DOC' }}</span>
                                <span class="min-w-0">
                                    <span class="dm-recent-title">{{ $document->original_name }}</span>
                                    <span class="dm-recent-folder">{{ $document->folder?->name ?? __('No folder') }}</span>
                                </span>
                                <span class="dm-recent-date">{{ $document->created_at?->format('d/m/Y') }}</span>
                            </a>
                        @empty
                            <p class="dm-empty">{{ __('No recent documents.') }}</p>
                        @endforelse
                    </div>
                </article>
            </section>
        </div>
    </div>

    <script>
        (() => {
            const chartData = @json($dashboardCharts);
            const palette = ['#1f4f82', '#17a673', '#d97706', '#7c3aed', '#0e7490', '#be123c'];

            function setupCanvas(canvas) {
                const ratio = window.devicePixelRatio || 1;
                const rect = canvas.getBoundingClientRect();
                canvas.width = Math.max(1, Math.floor(rect.width * ratio));
                canvas.height = Math.max(1, Math.floor(rect.height * ratio));
                const ctx = canvas.getContext('2d');
                ctx.setTransform(ratio, 0, 0, ratio, 0, 0);
                return { ctx, width: rect.width, height: rect.height };
            }

            function roundedRect(ctx, x, y, width, height, radius, fill) {
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
                const padding = { top: 28, right: 24, bottom: 42, left: 42 };
                const plotWidth = width - padding.left - padding.right;
                const plotHeight = height - padding.top - padding.bottom;
                const step = plotWidth / Math.max(1, data.length);
                const baseY = padding.top + plotHeight;

                ctx.clearRect(0, 0, width, height);

                ctx.font = '800 11px Arial, sans-serif';
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
                    ctx.fillStyle = '#64748b';
                    ctx.fillText(String(value), padding.left - 10, y);
                }

                const points = [];

                data.forEach((item, index) => {
                    const total = Number(item.total) || 0;
                    const barHeight = total > 0 ? Math.max(8, (total / max) * plotHeight) : 3;
                    const center = padding.left + step * index + step / 2;
                    const barWidth = Math.min(44, Math.max(18, step * 0.36));
                    const storageHeight = Math.max(3, barHeight * 0.62);

                    roundedRect(ctx, center - barWidth / 2, baseY - barHeight, barWidth, barHeight, 6, '#1f4f82');
                    roundedRect(ctx, center - barWidth / 2 + barWidth * 0.58, baseY - storageHeight, barWidth * 0.42, storageHeight, 5, '#17a673');

                    points.push({ x: center, y: baseY - barHeight });

                    ctx.fillStyle = '#0f2747';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'bottom';
                    ctx.font = '900 12px Arial, sans-serif';
                    ctx.fillText(String(total), center, baseY - barHeight - 8);

                    ctx.fillStyle = '#56708f';
                    ctx.textBaseline = 'top';
                    ctx.font = '900 12px Arial, sans-serif';
                    ctx.fillText(item.label, center, baseY + 13);
                });

                if (points.length > 1) {
                    ctx.strokeStyle = '#d97706';
                    ctx.lineWidth = 2;
                    ctx.beginPath();
                    points.forEach((point, index) => {
                        if (index === 0) ctx.moveTo(point.x, point.y - 14);
                        else ctx.lineTo(point.x, point.y - 14);
                    });
                    ctx.stroke();

                    points.forEach(point => {
                        ctx.fillStyle = '#ffffff';
                        ctx.strokeStyle = '#d97706';
                        ctx.lineWidth = 2;
                        ctx.beginPath();
                        ctx.arc(point.x, point.y - 14, 4, 0, Math.PI * 2);
                        ctx.fill();
                        ctx.stroke();
                    });
                }
            }

            function drawDonutChart() {
                const canvas = document.getElementById('extensionsDonutChart');
                if (!canvas) return;

                const { ctx, width, height } = setupCanvas(canvas);
                const data = chartData.extensions || [];
                const total = data.reduce((sum, item) => sum + (Number(item.total) || 0), 0);
                const cx = width / 2;
                const cy = height / 2;
                const radius = Math.min(width, height) / 2 - 12;
                const innerRadius = radius * 0.6;

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
                        ctx.lineCap = 'round';
                        ctx.stroke();
                        start += angle;
                    });
                }

                const first = data[0] || { label: 'N/A', total: 0 };
                ctx.fillStyle = '#0f2747';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.font = '900 23px Arial, sans-serif';
                ctx.fillText(first.label, cx, cy - 8);
                ctx.fillStyle = '#64748b';
                ctx.font = '900 11px Arial, sans-serif';
                ctx.fillText(`${first.total || 0} ${chartData.translations.documents}`, cx, cy + 16);
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
