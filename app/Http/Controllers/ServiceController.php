<?php

namespace App\Http\Controllers;

use App\Models\Services;
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

   public function historico()
   {
      $services = Services::with('equipment', 'users')->paginate(10);

      return Inertia::render('services/Historico', [
         'services' => $services,
      ]);
    
   }
}
