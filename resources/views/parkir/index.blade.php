@extends('layouts.master')

@section('bar_title')
    Parkir
@endsection
@section('content')
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Scan / Masukkan Kode Parkir</h5>
                </div>
                <div class="card-body">
                    <div class="input-group m-2">
                        <input type="text" class="form-control" placeholder="Masukkan kode parkir" id="kodeParkirInput"
                            aria-label="Masukkan kode parkir" autofocus>
                        <button class="btn btn-primary" type="button" id="kode_parkir">Cari</button>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Textarea</h5>
                </div>
                <div class="card-body">
                    <textarea class="form-control" rows="2" placeholder="Textarea"></textarea>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Data Kendaraan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <p class="h5 mb-1">Kode </p>
                            <p class="mb-1">Kendaraan </p>
                            <p class="mb-1">Tanggal Masuk </p>
                            <p class="mb-1">Jam Masuk </p>
                            <p class="mb-3">Durasi Parkir </p>
                            <p class="h4 mb-1">Total Tagihan </p>
                        </div>
                        <div class="col-12 col-lg-6">
                            <p class="h5 mb-1" id="no_parkir"></p>
                            <p class="mb-1" id="jenis_kendaraan"></p>
                            <p class="mb-1" id="tanggal"></p>
                            <p class="mb-1" id="jam_masuk"></p>
                            <p class="mb-3" id="lama_parkir"></p>
                            <p class="h4 mb-1" id="total_tagihan"></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <a class="btn btn-success" href="#" role="button">Selesai dan Buka Palang</a>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <a class="btn btn-success" href="#" role="button">Selesai dan Buka Palang</a>
                        </div>
                    </div>
                </div> --}}
            </div>

        </div>
    </div>

    @push('footer_comp')
        <script>
            let inputTimeout;

            document.getElementById('kodeParkirInput').addEventListener('input', function() {
                clearTimeout(inputTimeout);

                inputTimeout = setTimeout(function() {
                    var inputField = document.getElementById('kodeParkirInput');
                    var kodeParkir = inputField.value;

                    // If the input field has a value, fetch data
                    if (kodeParkir) {
                        fetchData(kodeParkir, inputField);
                    }
                }, 300); // Adjust the timeout duration as needed
            });

            function fetchData(kodeParkir, inputField) {
                var apiEndpoint = '/parkir/' + kodeParkir;
                fetch(apiEndpoint)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log(data);
                        if (data.success) {
                            inputField.value = '';
                            const parkirData = data.data;

                            document.getElementById('no_parkir').textContent = parkirData.no_parkir
                            document.getElementById('jenis_kendaraan').textContent = parkirData.jenis_kendaraan

                            const tanggal = new Date(parkirData.tanggal);

                            document.getElementById('tanggal').textContent = tanggal.toLocaleDateString("en-GB")
                            document.getElementById('jam_masuk').textContent = parkirData.jam_masuk
                            document.getElementById('lama_parkir').textContent = parkirData.lama_parkir
                            document.getElementById('total_tagihan').textContent = `Rp${parkirData.total_tagihan}`;
                        } else {
                            inputField.value = '';
                            document.getElementById('no_parkir').textContent = kodeParkir
                            document.getElementById('jenis_kendaraan').textContent = '-'
                            document.getElementById('tanggal').textContent = '-'
                            document.getElementById('jam_masuk').textContent = '-'
                            document.getElementById('lama_parkir').textContent = '-'
                            document.getElementById('total_tagihan').textContent = '-'
                        }
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                    });
            }
        </script>
    @endpush
@endsection
