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
                <div class="card-body">
                    <label for="exampleInputEmail1" class="form-label">Total Bayar</label>
                    <H2 id="total_bayar">Rp.0</H3>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <label for="exampleInputEmail1" class="form-label">Bayar</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="jumlah_uang">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <label for="exampleInputEmail1" class="form-label">Kembali</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control" readonly id="kembali">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Data Kendaraan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <p class="h5 mb-1">No. Parkir </p>
                            <p class="mb-1">Kendaraan </p>
                            <p class="mb-1">Tanggal Masuk </p>
                            <p class="mb-1">Jam Masuk </p>
                            <p class="mb-1">Durasi Parkir </p>
                            <p class="mb-1">Total Tagihan </p>
                        </div>
                        <div class="col-12 col-lg-6">
                            <p class="h5 mb-1" id="no_parkir"></p>
                            <p class="mb-1" id="jenis_kendaraan"></p>
                            <p class="mb-1" id="tanggal"></p>
                            <p class="mb-1" id="jam_masuk"></p>
                            <p class="mb-1 fw-bold" id="lama_parkir"></p>
                            <p class="mb-1 fw-bold" id="total_tagihan"></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <button id="bukaPalangBtn" class="btn btn-success btn-lg">Selesai - Buka
                                Palang</button>

                            <button id="tutupPalangBtn" class="btn btn-danger  btn-lg">Tutup
                                Palang</button>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <a class="btn btn-danger" href="#" role="button" id="TutupPalangBtn">Tutup</a>
                        </div>
                    </div>
                </div> --}}
            </div>

        </div>
    </div>

    @push('footer_comp')
        <script>
            let inputTimeout;

            document.getElementById('jumlah_uang').addEventListener('input', function() {
                // Get the values and convert them to numbers
                var jumlah_uang = parseFloat(document.getElementById('jumlah_uang').value) || 0;
                var total_tagihan = parseFloat(document.getElementById('total_tagihan').textContent) || 0;

                // Calculate the change (kembali)
                var kembali = jumlah_uang - total_tagihan;

                // Update the kembali field
                document.getElementById('kembali').value = kembali.toFixed(0); // Ensures two decimal places
            });


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
                            document.getElementById('total_tagihan').textContent = parkirData.total_tagihan;
                            document.getElementById('total_bayar').textContent =
                                `Rp${parkirData.total_tagihan}`;
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


            document.getElementById('bukaPalangBtn').addEventListener('click', function(event) {
                event.preventDefault();
                const no_parkir = document.getElementById('no_parkir').textContent;
                const status = 1
                updatePalang('buka');
                updateDataParkir(status, no_parkir);
            });

            document.getElementById('tutupPalangBtn').addEventListener('click', function(event) {
                event.preventDefault();
                updatePalang('tutup');
            });

            async function updatePalang(status) {
                try {
                    const response = await fetch('/status-palang/update', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            status: status
                        })
                    });

                    const data = await response.json();
                    // alert(data.message);
                    // location.reload(); // Refresh halaman untuk memperbarui tampilan
                } catch (error) {
                    console.error('Terjadi kesalahan:', error);
                }
            }

            async function updateDataParkir(status, no_parkir) {
                try {
                    const response = await fetch('/parkir/update-data-parkir', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            status: status,
                            no_parkir: no_parkir
                        })
                    });

                    const data = await response.json();
                    alert(data.message);
                    // location.reload(); // Refresh halaman untuk memperbarui tampilan
                } catch (error) {
                    console.error('Terjadi kesalahan:', error);
                }
            }
        </script>
    @endpush
@endsection
