<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function __construct()
    {
        // No necesitamos middleware aquí ya que lo manejamos manualmente
    }

    /**
     * Display the admin dashboard.
     */
    public function dashboard(): View
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        // Contar subastas activas
        $activeAuctions = \App\Models\Auction::where('status', 'active')
            ->whereNotNull('end_date')
            ->where('end_date', '>', now())
            ->get();

        // Verificar cada subasta
        foreach ($activeAuctions as $auction) {
            Log::info('Subasta en dashboard:', [
                'id' => $auction->id,
                'title' => $auction->title,
                'status' => $auction->status,
                'end_date' => $auction->end_date->format('Y-m-d H:i:s'),
                'is_active' => $auction->isActive()
            ]);
        }

        return view('admin.dashboard', [
            'totalUsers' => User::count(),
            'activeAuctions' => $activeAuctions->count(),
            'totalBids' => Bid::count(),
            'finishedAuctions' => \App\Models\Auction::finished()->count(),
            'latestAuctions' => \App\Models\Auction::latest()->take(5)->get(),
            'latestBids' => Bid::with(['user', 'auction'])->latest()->take(5)->get(),
        ]);
    }

    /**
     * Display the admin dashboard for mobile.
     */
    public function mobileDashboard(): View
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $activeAuctions = \App\Models\Auction::where('status', 'active')
            ->whereNotNull('end_date')
            ->where('end_date', '>', now())
            ->get();

        // Calcular ingresos totales
        $totalRevenue = \App\Models\Bid::sum('amount');

        return view('admin.mobile.dashboard', [
            'totalUsers' => User::count(),
            'activeAuctions' => $activeAuctions->count(),
            'totalBids' => Bid::count(),
            'totalRevenue' => $totalRevenue,
            'latestAuctions' => \App\Models\Auction::latest()->take(5)->get(),
            'latestBids' => Bid::with(['user', 'auction'])->latest()->take(5)->get(),
        ]);
    }

    /**
     * Display the user management page.
     */
    public function users(): View
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $users = User::with('roles')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for editing a user.
     */
    public function editUser(User $user): View
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $roles = \Spatie\Permission\Models\Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user.
     */
    public function updateUser(Request $request, User $user)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'roles' => 'array',
            'roles.*' => 'exists:roles,name'
        ]);

        $user->update($request->only(['name', 'email']));
        $user->syncRoles($request->roles);

        return redirect()->route('admin.users')
            ->with('success', 'Usuario actualizado correctamente');
    }

    /**
     * Delete a user (admin only)
     */
    public function deleteUser(Request $request, User $user)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'No puedes eliminar tu propio usuario.');
        }
        $user->delete();
        // Redirección según origen explícito
        if ($request->input('origin') === 'mobile') {
            return redirect()->route('admin.mobile.users')->with('success', 'Usuario eliminado correctamente.');
        }
        return redirect()->route('admin.users')->with('success', 'Usuario eliminado correctamente.');
    }

    /**
     * Display the auction management page.
     */
    public function auctions(): View
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $auctions = \App\Models\Auction::with(['user', 'bids'])
            ->orderBy('end_date', 'desc')
            ->paginate(15);

        return view('admin.auctions.index', compact('auctions'));
    }

    /**
     * Show the form for editing an auction.
     */
    public function editAuction(\App\Models\Auction $auction): View
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        return view('admin.auctions.edit', compact('auction'));
    }

    /**
     * Update the specified auction.
     */
    public function updateAuction(Request $request, \App\Models\Auction $auction)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'starting_price' => 'required|numeric|min:0',
            'status' => 'required|in:active,pending,finished,cancelled',
            'ends_at' => 'required|date|after:now'
        ]);

        $auction->update($request->all());

        return redirect()->route('admin.auctions')
            ->with('success', 'Subasta actualizada correctamente');
    }

    /**
     * Vista móvil para gestionar subastas
     */
    public function mobileAuctions(): View
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $auctions = \App\Models\Auction::latest()->paginate(10);
        return view('admin.mobile.auctions', compact('auctions'));
    }

    /**
     * Vista móvil para gestionar usuarios
     */
    public function mobileUsers(): View
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $users = \App\Models\User::with('roles')->paginate(10);
        return view('admin.mobile.users', compact('users'));
    }

    /**
     * Editar usuario (formulario móvil)
     */
    public function editMobileUser(User $user)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $roles = \Spatie\Permission\Models\Role::all();
        return view('admin.mobile.edit-user', compact('user', 'roles'));
    }

    /**
     * Actualizar usuario (móvil)
     */
    public function updateMobileUser(Request $request, User $user)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'roles' => 'array',
            'roles.*' => 'exists:roles,name'
        ]);
        $user->update($request->only(['name', 'email']));
        $user->syncRoles($request->roles);
        return redirect()->route('admin.mobile.users.edit', $user->id)
            ->with('success', 'Usuario actualizado correctamente');
    }

    /**
     * Display the reports page.
     */
    public function reports(): View
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        // Reporte de ingresos
        $revenue = DB::table('auctions')
            ->join('bids', 'auctions.id', '=', 'bids.auction_id')
            ->where('auctions.status', 'finished')
            ->select(
                DB::raw('DATE(auctions.created_at) as date'),
                DB::raw('SUM(bids.amount) as total_revenue')
            )
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();

        // Reporte de subastas por estado
        $auctionsByStatus = \App\Models\Auction::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        return view('admin.reports.index', compact('revenue', 'auctionsByStatus'));
    }

    /**
     * Vista móvil para reportes
     */
    public function mobileReports(): View
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $revenue = \DB::table('auctions')
            ->join('bids', 'auctions.id', '=', 'bids.auction_id')
            ->where('auctions.status', 'finished')
            ->select(
                \DB::raw('DATE(auctions.created_at) as date'),
                \DB::raw('SUM(bids.amount) as total_revenue')
            )
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();
        $auctionsByStatus = \App\Models\Auction::select('status', \DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();
        return view('admin.mobile.reports', compact('revenue', 'auctionsByStatus'));
    }
}
