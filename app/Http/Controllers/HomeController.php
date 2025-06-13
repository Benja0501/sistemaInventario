<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\Product;
use App\Models\StockEntry;
use App\Models\StockExit;
use App\Models\DiscrepancyReport;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function dashboard()
    {
        // --- KPIs ---
        $pendingOrders = PurchaseOrder::where('status', 'pending')->count();
        $todayReceptions = StockEntry::whereDate('received_at', today())->count();
        $lowStockProducts = Product::whereColumn('stock', '<=', 'minimum_stock')->count();
        
        // --- AQUÍ ESTÁ LA LÍNEA QUE TE FALTA ---
        $openDiscrepancies = DiscrepancyReport::where('status', 'open')->count();
        
        // --- Tablas de Detalle ---
        $lowStockProductsList = Product::where('status', 'active')
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->orderBy('stock', 'asc')
            ->limit(5)
            ->get();

        $entries = StockEntry::with('product')->latest()->limit(5);
        $exits = StockExit::with('product')->latest()->limit(5);

        $recentMovements = $entries->get()->map(function($entry) {
            $entry->type = 'entry';
            return $entry;
        })->concat($exits->get()->map(function($exit) {
            $exit->type = 'exit';
            $exit->created_at = $exit->exited_at; 
            return $exit;
        }))->sortByDesc('created_at')->take(5);


        // Asegúrate de que todas las variables estén aquí en compact()
        return view('inventory.dashboard', compact(
            'pendingOrders',
            'todayReceptions',
            'lowStockProducts',
            'openDiscrepancies', // <-- La variable debe estar aquí
            'lowStockProductsList',
            'recentMovements'
        ));
    }
}
