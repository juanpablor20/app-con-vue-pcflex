<?php

namespace App\Http\Controllers;

use App\Models\Services;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ServiceController extends Controller
{
   public function show(string $id)
   {


      $services = Services::with('environment', 'users.contacts', 'users.address', 'equipment', 'librarian')->find($id);

      return Inertia::render('services/Show', [
         'services' => $services,
      ]);
   }
   public function details(string $id)
   {
      $services = Services::with('environment', 'users.contacts', 'users.address', 'equipment', 'librarian', 'librarianreturn')->find($id);

      return Inertia::render('services/details', [
         'services' => $services,
      ]);
   }

   public function historico(Request $request)
   {
       $search = $request->input('search');
       $query = Services::with(['equipment', 'users', 'environment']);
   
       if ($search) {
           $query->whereHas('equipment', function ($q) use ($search) {
               $q->where('serie_equi', 'like', '%' . $search . '%');
           })
           ->orWhereHas('users', function ($q) use ($search) {
               $q->where('number_identification', 'like', '%' . $search . '%');
           })
           ->orWhereHas('environment', function ($q) use ($search) {
               $q->where('names', 'like', '%' . $search . '%');
           });
       }
   
       // Paginar los resultados filtrados
       $services = $query->paginate(10);
   
       return Inertia::render('services/Historico', [
           'services' => $services,
           'search' => $search,
       ]);
   }

   public function pdfhistorico()
   {
      $data = [
         'title' => 'Reporte de historial',

         'services' => Services::with('equipment', 'environment', 'users')->get(),
      ];

      $pdf = Pdf::loadView('report_historico', $data);
      return $pdf->download('reporte_historico.pdf');
   }
}
