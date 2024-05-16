@extends('layouts.master')
@push('head_comp')
@endpush
@section('bar_title')
    Data Parkir
@endsection
@section('content')
    <div class="col-12 col-lg-12 col-xxl-12 d-flex">
        <div class="card flex-fill">
            <div class="card-header d-flex">
                <h5 class="card-title m-2">Data Parkir</h5>
                <button type="button" class="ms-auto btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Add
                </button>
            </div>
            <div class="card-body">
                <table class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Parkir</th>
                            <th>Kendaraan</th>
                            <th class="d-none d-xl-table-cell">Tanggal</th>
                            <th class="d-none d-xl-table-cell">Jam Masuk</th>
                            <th class="d-none d-xl-table-cell">Lama Parkir</th>
                            <th class="d-none d-xl-table-cell">Total Tagihan</th>
                            <th>Ket</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_parkir as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->no_parkir }}</td>
                                <td>{{ $data->jenis_kendaraan }}</td>
                                <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d-m-Y') }} </td>
                                <td>{{ $data->jam_masuk }}</td>
                                <td>{{ $data->lama_parkir }}</td>
                                <td>Rp{{ $data->total_tagihan }}</td>
                                {{-- <td>{{ $data->keterangan }}</td> --}}
                                <td>Selesai</td>
                                <td>
                                    <button class="ms-auto btn btn-sm btn-danger delete-btn" data-id="{{ $data->id }}">
                                        <i class="feather-lg" data-feather="trash-2"></i>
                                    </button>
                                    <button class="ms-auto btn btn-sm btn-info"><i class="feather-lg"
                                            data-feather="info"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Recipient:</label>
                            <input type="text" class="form-control" id="recipient-name">
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Message:</label>
                            <textarea class="form-control" id="message-text"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    @push('footer_comp')
        <script>
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');

                    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                        fetch(`/data-parkir/delete/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    this.closest('tr').remove();
                                    alert('Data berhasil dihapus!');
                                } else {
                                    alert(data.message);
                                }
                            })
                            .catch((error) => {
                                console.error('Error:', error);
                            });
                    }
                });
            });
        </script>
    @endpush
@endsection
