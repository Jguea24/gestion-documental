<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\Semestre;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('dashboard', [
            'totalDocumentos' => Documento::count(),
            'totalUsuarios' => User::count(),
            'totalSemestres' => Semestre::count(),
            'ultimosDocumentos' => Documento::with(['semestre', 'carpeta', 'usuario'])
                ->latest('fecha_subida')
                ->limit(8)
                ->get(),
            'documentosPorExtension' => Documento::selectRaw('extension, count(*) as total')
                ->groupBy('extension')
                ->orderByDesc('total')
                ->limit(6)
                ->get(),
        ]);
    }
}
