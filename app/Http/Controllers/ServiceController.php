<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_Service;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    /**
     * Menampilkan daftar service.
     */
    public function index()
    {
        try {
            $services = Service::all();
            return view('admin.service', compact('services'));
        } catch (\Exception $e) {
            \Log::error("Error in ServiceController@index: " . $e->getMessage());
            return back()->with('error', 'Failed to fetch services.');
        }
    }

    /**
     * Menyimpan service baru.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|string|max:255',
            'duration'    => 'required|integer|min:1', // Validasi sebagai integer minimal 1
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ]);
        }

        try {
            $service = Service::create([
                'name'        => $request->name,
                'description' => $request->description,
                'price'       => $request->price,
                'duration'    => $request->duration,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Service added successfully!',
                'service' => $service,
            ]);
        } catch (\Exception $e) {
            \Log::error("Error in ServiceController@store: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to add service.',
            ]);
        }
    }



    /**
     * Memperbarui data service.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|string|max:255',
            'duration'    => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ]);
        }

        try {
            $service = Service::findOrFail($id);
            $service->update([
                'name'        => $request->name,
                'description' => $request->description,
                'price'       => $request->price,
                'duration'    => $request->duration,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Service updated successfully!',
                'service' => $service,
            ]);
        } catch (\Exception $e) {
            \Log::error("Error in ServiceController@update: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update service.',
            ]);
        }
    }

    /**
     * Menghapus service.
     */
    public function destroy($id)
    {
        try {
            $service = Service::findOrFail($id);
            $service->delete();

            return response()->json([
                'success' => true,
                'message' => 'Service deleted successfully!',
            ]);
        } catch (\Exception $e) {
            \Log::error("Error in ServiceController@destroy: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete service.',
            ]);
        }
    }


    public function show($id)
    {
        $service = Service::findOrFail($id);
        return view('service_order', compact('service'));
    }

    public function order(Request $request, $id)
    {

        $service = Service::findOrFail($id);

        try {
            DB::transaction(function () use ($request, $service) {
                // Buat record Order (misalnya, tipe order 'service')
                $order = Order::create([
                    'user_id'     => auth()->id(),
                    'type'        => 'service',
                    'status'      => 'pending', // Status awal, misalnya pending
                    'total_price' => $service->price, // Sesuaikan jika ada perhitungan tambahan
                    'description' => 'Pemesanan service: ' . $service->name,
                ]);

                // Buat record pivot yang mengaitkan order dengan service
                Order_Service::create([
                    'order_id'    => $order->id,
                    'service_id'  => $service->id,
                    'duration' => $service->duration,
                    'price_unit'  => $service->price,
                    'total_price' => $service->price,
                ]);
            });

            return redirect()->route('service')->with('success', 'Service berhasil dipesan!');
        } catch (\Exception $e) {
            \Log::error("Error in ServiceController@order: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memesan service.');
        }
    }
}
