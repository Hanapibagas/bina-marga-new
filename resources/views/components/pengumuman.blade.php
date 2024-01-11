@extends('layouts.app')

@section('content')

@if (session('status'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Sukses!',
        text : "{{ session('status') }}",
    });
</script>
@endif

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title">Daftar Pengumuman Data Center</h4>
                    </div>
                    <div class="iq-card-header-toolbar d-flex align-items-center">
                        <div class="dropdown">
                            <span class="dropdown-toggle text-primary" id="dropdownMenuButton5" data-toggle="dropdown">
                                <i style="font-size: 30px; margin-right: 30px; cursor: pointer;"
                                    class="ri-add-line"></i>
                            </span>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton5">
                                <a style="margin-top: 10px; margin-bottom: 10px; cursor: pointer;" class="dropdown-item"
                                    data-toggle="modal" data-target="#exampleModalCenter">
                                    <i style="font-size: 25px; " class="ri-mail-open-fill"></i> Tambah Pengumuman
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="iq-card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Judul</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">File</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengumuman as $key => $datas)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $datas->judul }}</td>
                                    <td>{{ date('d F Y', strtotime($datas->tannggal)) }}</td>
                                    <td>
                                        @php
                                        $extension = pathinfo($datas->file, PATHINFO_EXTENSION);
                                        $iconClass = '';
                                        switch ($extension) {
                                        case 'pdf':
                                        $iconClass = 'ri-file-pdf-fill';
                                        break;
                                        case 'docs':
                                        $iconClass = 'ri-file-word-fill';
                                        break;
                                        default:
                                        $iconClass = 'ri-file-fill';
                                        break;
                                        }
                                        @endphp
                                        <a
                                            href="https://docs.google.com/gview?embedded=true&url=https://data-canter.taekwondosulsel.info/storage/{{ $datas->file }}">
                                            <i style="font-size: 30px;" class="{{ $iconClass }}"></i>
                                            {{ $datas->file }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="iq-card-header-toolbar d-flex align-items-center">
                                            <div class="dropdown">
                                                <span class="dropdown-toggle text-primary" id="dropdownMenuButton5"
                                                    data-toggle="dropdown">
                                                    <i style="margin-left: 30px;" class="ri-more-2-fill"></i>
                                                </span>
                                                <div class="dropdown-menu dropdown-menu-right"
                                                    aria-labelledby="dropdownMenuButton5">
                                                    <a class="dropdown-item" data-toggle="modal"
                                                        data-target="#editModal{{ $datas->id }}"><i
                                                            style="font-size: 25px;"
                                                            class="ri-pencil-fill mr-2"></i>Edit</a>
                                                    <hr>
                                                    <form action="{{ route('delete.Pengumuman', $datas->id) }}"
                                                        method="POST" id="delete-form">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="button" class="dropdown-item delete-button">
                                                            <i style="font-size: 25px;"
                                                                class="ri-delete-bin-6-fill mr-2"></i>Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach ( $pengumuman as $item )
<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Pengumuman Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('put.Pengmumuman', $item->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="folder-name" class="col-form-label">Judul</label>
                        <input type="text" name="judul" class="form-control" id="folder-name"
                            aria-describedby="emailHelp" value="{{ $item->judul }}" placeholder="Silahkan buat judul">
                    </div>
                    <div class="form-group">
                        <label for="tanggal" class="col-form-label">Tanggal</label>
                        <input type="date" name="tannggal" class="form-control" id="tanggal"
                            aria-describedby="emailHelp" value="{{ $item->tannggal }}"
                            placeholder="Silahkan buat folder">
                    </div>
                    <div class="form-group">
                        <label for="file" class="col-form-label">File</label>
                        <input type="file" name="file" accept=".pdf,.doc,.docx" class="form-control" id="file"
                            aria-describedby="emailHelp" placeholder="Silahkan buat folder">
                        {{-- <div id="file-preview" style="display: none;">
                        </div> --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btn-buat">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Pengumuman Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('post.Pengumuman') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="folder-name" class="col-form-label">Judul</label>
                        <input type="text" name="judul" class="form-control" id="folder-name"
                            aria-describedby="emailHelp" placeholder="Silahkan buat judul">
                    </div>
                    <div class="form-group">
                        <label for="tanggal" class="col-form-label">Tanggal</label>
                        <input type="date" name="tannggal" class="form-control" id="tannggal"
                            aria-describedby="emailHelp" placeholder="Silahkan buat folder">
                    </div>
                    <div class="form-group">
                        <label for="file" class="col-form-label">File</label>
                        <input type="file" name="file" accept=".pdf,.doc,.docx" class="form-control" id="file"
                            aria-describedby="emailHelp" placeholder="Silahkan buat folder">
                        {{-- <div id="file-preview" style="display: none;">
                        </div> --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btn-buat">Buat</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('js')
{{-- <script>
    document.getElementById('file').addEventListener('change', function (event) {
        const fileInput = event.target;
        const file = fileInput.files[0];

        if (file) {
            const fileType = file.name.split('.').pop().toLowerCase();
            if (fileType === 'pdf' || fileType === 'doc' || fileType === 'docx') {
                const filePreview = document.getElementById('file-preview');
                filePreview.innerHTML = `File terpilih: ${file.name}`;
                filePreview.style.display = 'block';
            } else {
                document.getElementById('file-preview').style.display = 'none';
            }
        }
    });
</script> --}}
<script>
    $(document).ready(function () {
        $('.delete-button').click(function () {
            Swal.fire({
                title: 'Konfirmasi Hapus Data',
                text: 'Anda yakin ingin menghapus data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#delete-form').submit();
                }
            });
        });
    });
</script>
{{-- <script>
    $(document).ready(function () {
        $('#exampleModalCenter form').submit(function (event) {
            event.preventDefault();

            var folderName = $('#folder-name').val();
            var tanggal = $('#tanggal').val();
            var keterangan = $('#alamat_pelapor').val();

            if (folderName.trim() === '') {
                swal('Error', 'Judul tidak boleh kosong', 'error');
                return;
            }

            if (tanggal.trim() === '') {
                swal('Error', 'Tanggal tidak boleh kosong', 'error');
                return;
            }

            if (keterangan.trim() === '') {
                swal('Error', 'Keterangan tidak boleh kosong', 'error');
                return;
            }

            $('#exampleModalCenter form').unbind('submit').submit();
        });
    });
</script> --}}
<script>
    const chatIcon = document.getElementById('chat-icon');
    const notificationsDropdown = document.getElementById('notifications-dropdown');

    chatIcon.addEventListener('click', () => {
        notificationsDropdown.classList.toggle('show-dropdown');
    });
</script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script>
@endpush