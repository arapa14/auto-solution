@extends('layouts.app')

@section('title', 'Pesan Service - ' . $service->name)

@section('content')
    <section class="container mx-auto py-10 px-4">
        <div class="bg-white rounded-lg shadow p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $service->name }}</h1>
            <p class="text-gray-600 mb-4">{{ $service->description }}</p>
            <p class="text-lg font-bold text-blue-600 mb-4">Rp. {{ number_format($service->price, 0, ',', '.') }}</p>
            <p class="text-sm text-gray-500 mb-2">Duration: {{ $service->duration }} menit</p>
            <form action="{{ route('service.order', $service->id) }}" method="POST">
                @csrf
                <!-- Jika ada field tambahan, tambahkan di sini -->
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Pesan Service
                </button>
            </form>
        </div>
    </section>
@endsection

@section('scripts')
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Pemesanan Berhasil',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Pemesanan Gagal',
                text: "{{ session('error') }}",
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif
@endsection