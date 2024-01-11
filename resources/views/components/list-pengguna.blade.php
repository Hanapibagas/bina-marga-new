@extends('layouts.app')

@section('content')

@if (session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: "{{ session('error') }}",
    })
</script>
@endif

@if (session('status'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Sukses!',
        text : "{{ session('status') }}",
    });
</script>
@endif

<style>
    .image-container {
        position: relative;
    }

    .image-container img {
        transition: transform 0.3s;
    }

    .image-container:hover img {
        transform: scale(1.3);
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title">Daftar Pengguna</h4>
                    </div>
                    <div class="iq-card-header-toolbar d-flex align-items-center">
                        <div class="dropdown">
                            <span class="dropdown-toggle text-primary" id="dropdownMenuButton5" data-toggle="dropdown">
                                <i style="font-size: 30px; margin-right: 30px; cursor: pointer;"
                                    class="ri-add-line"></i>
                            </span>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton5">
                                <a style="margin-bottom: 10px; margin-top: 10px; cursor: pointer;" class="dropdown-item"
                                    data-toggle="modal" data-target="#exampleModalCenterUser"><i
                                        style="font-size: 25px;" class="ri-user-fill"></i>Pengguna Baru +</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="iq-card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>NIP Operator</th>
                                    <th>Nama Penanggung Jawab</th>
                                    <th>Nama Bidang</th>
                                    <th>Email</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $pengguna as $key => $penggunas )
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        @if (Auth::check() && Auth::user()->picture)
                                        <div class="image-container">
                                            <img style="margin-right: 10px;" src="{{ Storage::url($user->picture) }}"
                                                width="40" class="rounded-circle" onmouseover="zoomIn(this)"
                                                onmouseout="zoomOut(this)">
                                        </div>
                                        @else
                                        <div class="image-container">
                                            <img style="margin-right: 10px;"
                                                src="https://ui-avatars.com/api/?name={{ Auth::user()->nama_penanggung_jawab }}"
                                                width="40" class="rounded-circle" onmouseover="zoomIn(this)"
                                                onmouseout="zoomOut(this)">
                                        </div>
                                        @endif
                                    </td>
                                    <td>{{ $penggunas->nip_oprator }}</td>
                                    <td>{{ $penggunas->name }}</td>
                                    <td>
                                        @if($penggunas->roles_bidang_id && !$penggunas->roles_seksi_id)
                                        {{ $penggunas->RolesBidang->name }}
                                        @elseif($penggunas->roles_seksi_id)
                                        {{ $penggunas->RolesSeksi->nama }} bagian {{ $penggunas->RolesBidang->name }}
                                        @endif
                                    </td>
                                    <td>{{ $penggunas->email }}</td>
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
                                                        data-target="#exampleModalCenterUser{{ $penggunas->id }}"><i
                                                            style="font-size: 25px;"
                                                            class="ri-pencil-fill mr-2"></i>Edit</a>
                                                    <hr>
                                                    <form action="{{ route('put.Update.Status', $penggunas->id) }}"
                                                        method="POST">
                                                        @method('PUT')
                                                        @csrf
                                                        <button type="submit" class="dropdown-item"><i
                                                                style="font-size: 25px;"
                                                                class="ri-delete-bin-6-fill mr-2"></i>Hapus</button>
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

<div class="modal fade" id="exampleModalCenterUser" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Tambah Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('get.Tambah.Pengguna') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Pengguna">Bagian</label>
                        <select id="userRole" name="roles_bidang_id" class="form-control">
                            <option value="-- Silahkan Pilih --">-- Silahkan Pilih --</option>
                            @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Pengguna">SubBagian <span><i>(jika tidak memiliki subBagian kosongkan
                                    saja)</i></span></label>
                        <select id="userRole" name="roles_seksi_id" class="form-control">
                            <option value="-- Silahkan Pilih --">-- Silahkan Pilih --</option>
                            @foreach ($subBagian as $subBagians)
                            <option value="{{ $subBagians->id }}">{{ $subBagians->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Pengguna">Nama Penanggung Jawab</label>
                        <input type="text" name="name" class="form-control" id="folder-name"
                            placeholder="Silahkan diisi...">
                    </div>
                    <div class="form-group">
                        <label for="Pengguna">Email Penanggung Jawab</label>
                        <input type="text" name="email" class="form-control" id="folder-name"
                            placeholder="Silahkan diisi...">
                    </div>
                    <div class="form-group">
                        <label for="Pengguna">NIP Penanggung Jawab</label>
                        <input type="text" name="nip_oprator" class="form-control" id="folder-name"
                            placeholder="Silahkan diisi...">
                    </div>
                    <div class="form-group">
                        <label for="Pengguna">Pangkat Penanggung Jawab</label>
                        <input type="text" name="pangakat" class="form-control" id="folder-name"
                            placeholder="Silahkan diisi...">
                    </div>
                    <div class="form-group">
                        <label>Tugas Oprator</label>
                        <p class="fw-bold">Edit</p>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" value="1" name="permission_edit"
                                id="radioExample1" />
                            <label class="form-check-label" for="radioExample1">
                                Ya
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" value="0" name="permission_edit"
                                id="radioExample2" />
                            <label class="form-check-label" for="radioExample2">
                                Tidak
                            </label>
                        </div>
                        <p class="fw-bold">Hapus</p>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" value="1" name="permission_delete"
                                id="radioExample1" />
                            <label class="form-check-label" for="radioExample1">
                                Ya
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" value="0" name="permission_delete"
                                id="radioExample2" />
                            <label class="form-check-label" for="radioExample2">
                                Tidak
                            </label>
                        </div>
                        <p class="fw-bold">Upload</p>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" value="1" name="permission_upload"
                                id="radioExample1" />
                            <label class="form-check-label" for="radioExample1">
                                Ya
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" value="0" name="permission_upload"
                                id="radioExample2" />
                            <label class="form-check-label" for="radioExample2">
                                Tidak
                            </label>
                        </div>
                        <p class="fw-bold">Update</p>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" value="1" name="permission_create"
                                id="radioExample1" />
                            <label class="form-check-label" for="radioExample1">
                                Ya
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" value="0" name="permission_create"
                                id="radioExample1" />
                            <label class="form-check-label" for="radioExample1">
                                Tidak
                            </label>
                        </div>
                        <p class="fw-bold">Download</p>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" value="1" name="permission_download"
                                id="radioExample1" />
                            <label class="form-check-label" for="radioExample1">
                                Ya
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" value="0" name="permission_download"
                                id="radioExample2" />
                            <label class="form-check-label" for="radioExample2">
                                Tidak
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambahkan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach ( $pengguna as $value )
<div class="modal fade" id="exampleModalCenterUser{{ $value->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Tugas Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('putUpdatepengguna', $value->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tugas Oprator {{ $value->nama_penanggung_jawab }}</label>
                        <p class="fw-bold">
                            User ini {{ $value->permission_edit == 1 ? 'memiliki akses edit' : 'tidak memiliki akses
                            edit ' }}<br>
                            Apakah anda ingin mengubahnya ?
                        </p>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" value="1" name="permission_edit"
                                id="radioExample1" />
                            <label class="form-check-label" for="radioExample1">
                                Ya
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" value="0" name="permission_edit"
                                id="radioExample2" />
                            <label class="form-check-label" for="radioExample2">
                                Tidak
                            </label>
                        </div>
                        <p class="fw-bold">
                            User ini {{ $value->permission_delete == 1 ? 'memiliki akses delete' : 'tidak memiliki akses
                            delete ' }} <br>
                            Apakah anda ingin mengubahnya ?
                        </p>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" value="1" name="permission_delete"
                                id="radioExample1" />
                            <label class="form-check-label" for="radioExample1">
                                Ya
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" value="0" name="permission_delete"
                                id="radioExample2" />
                            <label class="form-check-label" for="radioExample2">
                                Tidak
                            </label>
                        </div>
                        <p class="fw-bold">
                            User ini {{ $value->permission_upload == 1 ? 'memiliki akses upload' : 'tidak memiliki akses
                            upload ' }} <br>
                            Apakah anda ingin mengubahnya ?
                        </p>>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" value="1" name="permission_upload"
                                id="radioExample1" />
                            <label class="form-check-label" for="radioExample1">
                                Ya
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" value="0" name="permission_upload"
                                id="radioExample2" />
                            <label class="form-check-label" for="radioExample2">
                                Tidak
                            </label>
                        </div>
                        <p class="fw-bold">
                            User ini {{ $value->permission_create == 1 ? 'memiliki akses create' : 'tidak memiliki akses
                            create ' }} <br>
                            Apakah anda ingin mengubahnya ?
                        </p>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" value="1" name="permission_create"
                                id="radioExample1" />
                            <label class="form-check-label" for="radioExample1">
                                Ya
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" value="0" name="permission_create"
                                id="radioExample1" />
                            <label class="form-check-label" for="radioExample1">
                                Tidak
                            </label>
                        </div>
                        <p class="fw-bold">
                            User ini {{ $value->permission_download == 1 ? 'memiliki akses download' : 'tidak memiliki
                            akses
                            download ' }} <br>
                            Apakah anda ingin mengubahnya ?
                        </p>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" value="1" name="permission_download"
                                id="radioExample1" />
                            <label class="form-check-label" for="radioExample1">
                                Ya
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" value="0" name="permission_download"
                                id="radioExample2" />
                            <label class="form-check-label" for="radioExample2">
                                Tidak
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection

@push('js')
<script>
    function zoomIn(image) {
        image.style.transform = "scale(1.3)";
    }

    function zoomOut(image) {
        image.style.transform = "scale(1)";
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var userRoleSelect = document.getElementById('userRole');
        var userRolesInput = document.getElementById('userRoles');

        userRoleSelect.addEventListener('change', function () {
            var selectedOption = userRoleSelect.options[userRoleSelect.selectedIndex];
            var selectedValue = selectedOption.value;
            var selectedText = selectedOption.text;

            if (selectedValue === 'Admin bidang/upt') {
                userRolesInput.value = 'bidang_upt';
            } else if (selectedValue === 'Admin seksi') {
                userRolesInput.value = 'seksi';
            } else if (selectedValue === 'Admin staff') {
                userRolesInput.value = 'staff';
            } else {
                userRolesInput.value = '';
            }
        });
    });
</script>
{{-- <script>
    const userRoleSelect = document.getElementById('userRole');
    const additionalFieldsDiv = document.getElementById('additionalFields');
    const userEmailInput = document.getElementById('userEmail');
    const userRolesInput = document.getElementById('userRoles');
    const userPasswordInput = document.getElementById('userPassword');

    userRoleSelect.addEventListener('change', function() {
        if (userRoleSelect.value === 'Admin bidang/upt') {
            additionalFieldsDiv.style.display = 'block';
            userEmailInput.value = 'bidang/upt@gmail.com';
            userRolesInput.value = 'bidang_upt';
            userPasswordInput.value = '12345678';
        } else if (userRoleSelect.value === 'Admin seksi') {
            additionalFieldsDiv.style.display = 'block';
            userEmailInput.value = 'seksi@gmail.com';
            userRolesInput.value = 'seksi';
            userPasswordInput.value = '12345678';
        } else if (userRoleSelect.value === 'Admin staff') {
            additionalFieldsDiv.style.display = 'block';
            userEmailInput.value = 'staff@gmail.com';
            userRolesInput.value = 'staff';
            userPasswordInput.value = '12345678';
        } else {
            additionalFieldsDiv.style.display = 'none';
        }
    });
</script> --}}
<script>
    const fileInput = document.getElementById('fileInput');
    const previewContainer = document.getElementById('previewContainer');

    fileInput.addEventListener('change', function() {
        previewContainer.innerHTML = '';

        const files = fileInput.files;

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();

            reader.onload = function(e) {
                const preview = document.createElement('img');
                preview.src = e.target.result;
                preview.style.maxWidth = '100%';
                preview.style.height = 'auto';
                previewContainer.appendChild(preview);
            }

            reader.readAsDataURL(file);
        }
    });
</script>
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