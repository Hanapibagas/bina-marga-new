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
                        <h4 class="card-title">Daftar Nama Seksi</h4>
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
                                        style="font-size: 25px;" class="ri-user-fill"></i>Data Seksi +</a>
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
                                    {{-- <th>Nama User</th> --}}
                                    <th>Nama Bidang</th>
                                    <th>Nama Seksi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $rolesSeksi as $key => $rolesS )
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    {{-- <td>{{ $rolesS->email }}</td> --}}
                                    <td>{{ $rolesS->name_bidang }}</td>
                                    <td>{{ $rolesS->name_seksi }}</td>
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
                                                        data-target="#exampleModalCenterUserUpdate{{ $rolesS->id }}"><i
                                                            style="font-size: 25px;"
                                                            class="ri-pencil-fill mr-2"></i>Edit</a>
                                                    <hr>
                                                    <a class="dropdown-item" data-toggle="modal"
                                                        data-target="#exampleModalCenterUserDelete{{ $rolesS->id }}"><i
                                                            style="font-size: 25px;"
                                                            class="ri-delete-bin-6-fill mr-2"></i>Delete</a>
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

@foreach ( $rolesSeksi as $value )
<div class="modal fade" id="exampleModalCenterUserDelete{{ $value->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Delete Nama Bidang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('deleteNameSeksi', $value->name_seksi) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $value->id }}">
                <div class="modal-body">
                    <p>Apakah anda ingin menngahapus data ini ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@foreach ( $rolesSeksi as $value )
<div class="modal fade" id="exampleModalCenterUserUpdate{{ $value->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Nama Bidang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('updateNameSeksi', $value->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $value->id }}">
                <div class="modal-body">
                    {{-- <div class="form-group">
                        <label for="Pengguna">Nama User</label><br>
                        <select name="users_id" class="form-control" required>
                            @foreach ( $user as $v )
                            <option value="{{ $v->id }}">{{ $v->email }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                    <div class="form-group">
                        <label for="Pengguna">Nama User</label><br>
                        <select name="roles_bidang_id" class="form-control" required>
                            @foreach ( $roles as $v )
                            <option value="{{ $v->id }}">{{ $v->name_bidang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Pengguna">Nama Seksi</label><br>
                        <input type="text" name="name_seksi" class="form-control" id="folder-name"
                            placeholder="Silahkan buat judul" value="{{ $value->name_seksi }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<div class="modal fade" id="exampleModalCenterUser" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Tambah Struktur Organisasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('postSeksi') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    {{-- <div class="form-group">
                        <label for="Pengguna">Nama User</label><br>
                        <select name="users_id" class="form-control">
                            @foreach ( $user as $v )
                            <option value="{{ $v->id }}">{{ $v->email }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                    <div class="form-group">
                        <label for="Pengguna">Nama Bidang</label><br>
                        <select name="roles_bidang_id" class="form-control">
                            @foreach ( $roles as $v )
                            <option value="{{ $v->id }}">{{ $v->name_bidang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Pengguna">Nama Bagian</label><br>
                        <input type="text" name="name_seksi" class="form-control" id="folder-name"
                            placeholder="Silahkan buat judul">
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

@endsection

@push('js')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // Add new form group for "Nama SubBagian"
        $("#addSubBagian").click(function () {
            var newFormGroup = '<div class="form-group">' +
                '<label for="Pengguna">Nama SubBagian</label><br>' +
                '<input type="text" name="name[]" class="form-control" placeholder="Silahkan buat judul">' +
                '</div>';

            $(".modal-body").append(newFormGroup);
        });
    });
</script>
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
