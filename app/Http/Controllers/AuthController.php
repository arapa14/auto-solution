<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Fungsi untuk melakukan registrasi user baru.
     */
    public function register(Request $request)
    {
        // Validasi input registrasi
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone'    => 'required|string',
            'address'  => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('landing')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => bcrypt($request->password),
                'phone'    => $request->phone,
                'address'  => $request->address,
            ]);

            Auth::login($user);
            // Tambahkan flash message untuk pendaftaran
            session()->flash('success_register', 'Pendaftaran berhasil! Selamat datang, ' . $user->name);
            return $this->redirectBasedOnRole($user);
        } catch (\Exception $e) {
            return redirect()->route('landing')
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }


    /**
     * Fungsi untuk melakukan proses login.
     */
    public function login(Request $request)
    {
        // Validasi input login
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('landing')
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // Gunakan key flash yang konsisten, misalnya 'success_login'
            session()->flash('success_login', 'Login berhasil! Selamat datang, ' . $user->name);
            return $this->redirectBasedOnRole($user);
        }

        // Jika kredensial tidak valid
        return redirect()->route('landing')
            ->withErrors(['error' => 'Email atau password tidak valid.'])
            ->withInput();
    }


    /**
     * Fungsi untuk logout user.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Tambahkan flash message logout
        session()->flash('success_logout', 'Logout berhasil! Sampai jumpa lagi.');

        return redirect()->route('landing');
    }


    /**
     * Fungsi pembantu untuk mengarahkan user berdasarkan role-nya.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    private function redirectBasedOnRole($user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->back();
    }

    public function admin()
    {
        // Statistik Utama
        $totalProducts  = Product::count();
        $totalServices  = Service::count();
        $totalUsers     = User::where('role', 'user')->count();
        $totalComplete  = Order::where('status', 'completed')->count();
        $pendingOrders  = Order::where('status', 'pending')->count();
        $totalSales     = Order::where('status', 'completed')->sum('total_price');
        $recentOrders   = Order::with('user')->orderBy('created_at', 'desc')->limit(5)->get();

        // Data untuk Sales Overview Chart (6 bulan terakhir)
        $salesData = Order::selectRaw("DATE_FORMAT(created_at, '%M') as month, SUM(total_price) as total")
            ->where('status', 'completed')
            ->groupBy('month')
            ->orderByRaw("MIN(created_at) ASC")
            ->limit(6)
            ->get();

        $salesChartLabels = $salesData->pluck('month');
        $salesChartData   = $salesData->pluck('total');

        /*
     * Data Laporan Penjualan Berdasarkan Periode
     */

        // 1. Laporan Harian (misal: 7 hari terakhir)
        $dailySalesData = Order::selectRaw("DATE_FORMAT(created_at, '%d %b') as day, SUM(total_price) as total")
            ->where('status', 'completed')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('day')
            ->orderByRaw("MIN(created_at) ASC")
            ->get();

        $dailySalesChartLabels = $dailySalesData->pluck('day');
        $dailySalesChartData   = $dailySalesData->pluck('total');

        // 2. Laporan Mingguan (misal: 4 minggu terakhir)
        // Menggunakan YEARWEEK() untuk mengelompokkan data berdasarkan minggu
        $weeklySalesData = Order::selectRaw("YEARWEEK(created_at, 1) as week, SUM(total_price) as total")
            ->where('status', 'completed')
            ->where('created_at', '>=', now()->subWeeks(4))
            ->groupBy('week')
            ->orderByRaw("MIN(created_at) ASC")
            ->get();

        $weeklySalesChartLabels = $weeklySalesData->pluck('week');
        $weeklySalesChartData   = $weeklySalesData->pluck('total');

        // 3. Laporan Bulanan (misal: 12 bulan terakhir)
        $monthlySalesData = Order::selectRaw("DATE_FORMAT(created_at, '%M %Y') as month, SUM(total_price) as total")
            ->where('status', 'completed')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderByRaw("MIN(created_at) ASC")
            ->get();

        $monthlySalesChartLabels = $monthlySalesData->pluck('month');
        $monthlySalesChartData   = $monthlySalesData->pluck('total');

        // 4. Laporan Tahunan (seluruh tahun yang ada pada data)
        $yearlySalesData = Order::selectRaw("YEAR(created_at) as year, SUM(total_price) as total")
            ->where('status', 'completed')
            ->groupBy('year')
            ->orderByRaw("MIN(created_at) ASC")
            ->get();

        $yearlySalesChartLabels = $yearlySalesData->pluck('year');
        $yearlySalesChartData   = $yearlySalesData->pluck('total');

        // Flash message jika diperlukan
        session()->flash('success_login', 'Selamat datang, Admin!');

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalServices',
            'totalUsers',
            'totalComplete',
            'pendingOrders',
            'totalSales',
            'recentOrders',
            'salesChartLabels',
            'salesChartData',
            'dailySalesChartLabels',
            'dailySalesChartData',
            'weeklySalesChartLabels',
            'weeklySalesChartData',
            'monthlySalesChartLabels',
            'monthlySalesChartData',
            'yearlySalesChartLabels',
            'yearlySalesChartData'
        ));
    }




    public function switchAccount(Request $request, $id)
    {
        try {
            $user = Auth::user();
            $role = Auth::user()->role;
            if ($user && $role == 'admin') {
                // simpan id pengguna asli di session sebelum switch
                session(['original_user_id' => $user->id]);

                // login sebagai user lain dengan id yang dimasukkan
                auth()->guard('web')->loginUsingId($id);

                // redirect ke halaman landing atau halaman lainnya
                return redirect()->route('landing');
            }
        } catch (\Exception $e) {
            // jika bukan admin, tampilkan error 403
            abort(403);
        }
    }

    public function switchBack()
    {
        if (session()->has('original_user_id')) {
            // ambil id user asli dan login kembali sebagai admin
            $originalUserId = session('original_user_id');
            auth()->guard('web')->loginUsingId($originalUserId);

            // hapus id user asli dari session
            session()->forget('original_user_id');

            // redirect kembali ke halaman dashboard
            return redirect()->route('admin.dashboard');
        }

        // jika tidak ada id asli di session, tampilkan erro 403
        abort(403);
    }
}
