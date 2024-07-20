<?php

namespace App\Http\Controllers;

use App\Models\Programs;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Realiza la búsqueda en tu base de datos o en la lógica que necesites
        $results = Programs::where('names_pro', 'like', '%' . $query . '%')->get();

        // Retorna los resultados como props de Inertia
        return Inertia::render('SearchResults', [
            'results' => $results,
        ]);
    }
}
