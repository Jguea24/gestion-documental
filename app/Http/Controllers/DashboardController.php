<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('dashboard', Cache::remember('dashboard.metrics', now()->addMinutes(5), fn () => $this->dashboardData()));
    }

    private function dashboardData(): array
    {
        $documentCount = Document::count();
        $folderCount = Folder::count();
        $userCount = User::count();
        $deletedDocumentCount = Document::onlyTrashed()->count();
        $deletedFolderCount = Folder::onlyTrashed()->count();
        $storageBytes = (int) Document::sum('size');

        $extensionRows = Document::query()
            ->selectRaw('LOWER(extension) as extension, COUNT(*) as total, SUM(size) as bytes')
            ->groupBy('extension')
            ->orderByDesc('total')
            ->limit(6)
            ->get();

        $maxExtensionTotal = max(1, (int) $extensionRows->max('total'));
        $extensionStats = $extensionRows->map(fn ($row) => [
            'label' => strtoupper($row->extension ?: 'N/A'),
            'total' => (int) $row->total,
            'bytes' => $this->humanFileSize((int) $row->bytes),
            'percent' => round(((int) $row->total / $maxExtensionTotal) * 100, 1),
        ]);

        $monthlyRows = Document::query()
            ->where('created_at', '>=', now()->startOfMonth()->subMonths(5))
            ->get(['created_at', 'size']);

        $monthLabels = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        $monthlyStats = collect();

        for ($monthOffset = 5; $monthOffset >= 0; $monthOffset--) {
            $month = now()->startOfMonth()->subMonths($monthOffset);
            $key = $month->format('Y-m');
            $documents = $monthlyRows->filter(fn (Document $document) => $document->created_at?->format('Y-m') === $key);

            $monthlyStats->push([
                'label' => $monthLabels[(int) $month->format('n') - 1],
                'total' => $documents->count(),
                'bytes' => $this->humanFileSize((int) $documents->sum('size')),
            ]);
        }

        $maxMonthlyTotal = max(1, (int) $monthlyStats->max('total'));
        $monthlyStats = $monthlyStats->map(fn (array $item) => $item + [
            'percent' => round(($item['total'] / $maxMonthlyTotal) * 100, 1),
        ]);

        return [
            'stats' => [
                ['label' => 'Documentos', 'value' => number_format($documentCount), 'detail' => $this->humanFileSize($storageBytes).' almacenados'],
                ['label' => 'Carpetas', 'value' => number_format($folderCount), 'detail' => 'Estructura activa'],
                ['label' => 'Usuarios', 'value' => number_format($userCount), 'detail' => 'Cuentas registradas'],
                ['label' => 'Papelera', 'value' => number_format($deletedDocumentCount + $deletedFolderCount), 'detail' => $deletedDocumentCount.' archivos, '.$deletedFolderCount.' carpetas'],
            ],
            'extensionStats' => $extensionStats,
            'monthlyStats' => $monthlyStats,
            'topUsers' => User::withCount('documents')->orderByDesc('documents_count')->limit(5)->get(['id', 'name']),
            'topFolders' => Folder::withCount('documents')->orderByDesc('documents_count')->limit(5)->get(['id', 'name']),
            'recentDocuments' => Document::with(['user', 'folder'])->latest()->limit(6)->get(),
        ];
    }

    private function humanFileSize(int $bytes): string
    {
        if ($bytes < 1024) {
            return $bytes.' B';
        }

        $units = ['KB', 'MB', 'GB', 'TB'];
        $size = $bytes / 1024;

        foreach ($units as $unit) {
            if ($size < 1024 || $unit === 'TB') {
                return number_format($size, $size >= 10 ? 1 : 2).' '.$unit;
            }

            $size /= 1024;
        }

        return number_format($size, 1).' TB';
    }
}
