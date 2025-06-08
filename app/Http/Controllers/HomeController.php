<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\Reception;
use App\Models\Discrepancy; 
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard()
    {
        // Ejemplo de datos que podrías mostrar
        $pendingOrders      = PurchaseOrder::where('status','pending')->count();
        $todayReceptions    = Reception::whereDate('received_at', now())->count();
        $openDiscrepancies  = Discrepancy::where('status','pending')->count();

        return view('inventory.dashboard', compact(
            'pendingOrders','todayReceptions','openDiscrepancies'
        ));
    }
}
