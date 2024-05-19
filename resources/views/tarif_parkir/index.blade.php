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
                            <th>Lama Parkir</th>
                            <th>Tarif</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tarif_parkir as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->lama_parkir == 1 ? '1 (satu) Jam pertama' : 'Setiap Jam Berikutnya' }} </td>
                                <td>Rp{{ $data->tarif }}</td>

                                <td>
                                    <button class="ms-auto btn btn-sm btn-danger delete-btn" data-id="{{ $data->id }}">
                                        <i class="feather-lg" data-feather="trash-2"></i>
                                    </button>
                                    <!-- Tombol Edit -->
                                    <!-- Tombol Edit -->
                                    <button class="ms-auto btn btn-sm btn-info edit-btn" data-id="{{ $data->id }}"><i
                                            class="feather-lg" data-feather="edit-3"></i></button>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Lama Parkir dan Tarif</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="edit-id">
                        <div class="mb-3">
                            <label for="edit-lama-parkir" class="col-form-label">Lama Parkir</label>
                            <select class="form-select mb-3" id="edit-lama-parkir">
                                <option selected disabled>- Pilih Tarif Per Jam -</option>
                                <option value="1">1 Jam pertama</option>
                                <option value="2">Setiap jam berikutnya</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit-tarif" class="col-form-label">Tarif</label>
                            <input type="number" class="form-control" id="edit-tarif">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save-edit-btn">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add data -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Input Tarif Parkir</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="tarif-parkir-form">
                        <div class="mb-3">
                            <label for="lama-parkir" class="col-form-label">Lama Parkir / Jam</label>
                            <select class="form-select mb-3" id="lama-parkir-select">
                                <option selected disabled>- Pilih Tarif Per Jam -</option>
                                <option value="1">1 Jam pertama</option>
                                <option value="2">Setiap jam berikutnya</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tarif" class="col-form-label">Tarif</label>
                            <input type="number" class="form-control" id="tarif">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save-tarif-btn">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    @push('footer_comp')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('save-tarif-btn').addEventListener('click', function() {
                    const lamaParkirSelect = document.getElementById('lama-parkir-select');
                    const tarifInput = document.getElementById('tarif');

                    const lamaParkir = lamaParkirSelect.value;
                    const tarif = tarifInput.value;

                    if (!lamaParkir || !tarif) {
                        alert('Harap isi semua field!');
                        return;
                    }

                    const data = {
                        lama_parkir: lamaParkir,
                        tarif: tarif
                    };

                    fetch('/tarif-parkir/store', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute(
                                        'content')
                            },
                            body: JSON.stringify(data)
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Data berhasil disimpan!');
                                window.location.reload();
                            } else if (data.errors) {
                                let errorMessage = '';
                                for (const [field, messages] of Object.entries(data.errors)) {
                                    errorMessage = `${messages.join(', ')}\n`;
                                }
                                alert(errorMessage);
                            } else {
                                alert('Gagal menyimpan data.');
                            }
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                        });
                });

                document.querySelectorAll('.delete-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');

                        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                            fetch(`/tarif-parkir/delete/${id}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector(
                                                'meta[name="csrf-token"]')
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


                document.querySelectorAll('.edit-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        const modal = new bootstrap.Modal(document.getElementById(
                            'editModal'));
                        fetch(`/tarif-parkir/${id}/edit`)
                            .then(response => response.json())
                            .then(data => {
                                document.getElementById('edit-id').value = data.id;
                                document.getElementById('edit-lama-parkir').value = data
                                    .lama_parkir;
                                document.getElementById('edit-tarif').value = data.tarif;

                                modal.show();
                            });
                    });
                });

                document.getElementById('save-edit-btn').addEventListener('click', function() {
                    const id = document.getElementById('edit-id').value;
                    const lamaParkir = document.getElementById('edit-lama-parkir').value;
                    const tarif = document.getElementById('edit-tarif').value;
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editModal'));

                    fetch(`/tarif-parkir/${id}/update`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            },
                            body: JSON.stringify({
                                lama_parkir: lamaParkir,
                                tarif: tarif
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                modal.hide();
                                location.reload();
                            } else {
                                alert('Gagal memperbarui data: ' + data.message);
                            }
                        });
                });
            });
        </script>
    @endpush
@endsection
