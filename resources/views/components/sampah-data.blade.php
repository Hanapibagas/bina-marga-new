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
                        <h4 class="card-title">Daftar Sampah Data Center</h4>
                    </div>
                </div>
                <div class="iq-card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Pengguna</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $filesWithoutFolder = [];
                                $filesWithFolder = [];

                                foreach ($data as $datas) {
                                if (strpos($datas->folder_name, 'folder-file/') === 0) {
                                $filesWithFolder[] = $datas;
                                } else {
                                $filesWithoutFolder[] = $datas;
                                }
                                }
                                @endphp

                                @foreach ($filesWithoutFolder as $key => $datas)
                                @if (!$datas->is_recycle)
                                <tr>
                                    <td>
                                        <a href="{{ route('get.Details', $datas->id) }}">
                                            <i style="font-size: 30px;" class="ri-folders-fill"></i>{{
                                            $datas->folder_name }}
                                        </a>
                                    </td>
                                    <td>{{ $datas->Users->name }}</td>
                                    <td>{{ date('d F Y', strtotime($datas->tanggal)) }}</td>
                                    <td>
                                        <div class="iq-card-header-toolbar d-flex align-items-center">
                                            <div class="dropdown">
                                                <span class="dropdown-toggle text-primary" id="dropdownMenuButton5"
                                                    data-toggle="dropdown">
                                                    <i style="margin-left: 30px;" class="ri-more-2-fill"></i>
                                                </span>
                                                <div class="dropdown-menu dropdown-menu-right"
                                                    aria-labelledby="dropdownMenuButton5">
                                                    <form action="{{ route('put.Pulihkan.Status', $datas->id) }}"
                                                        method="POST">
                                                        @method('PUT')
                                                        @csrf
                                                        <button type="submit" class="dropdown-item"><i
                                                                style="font-size: 25px;"
                                                                class="fa fa-upload mr-2"></i>Pulihkan</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @endforeach

                                @foreach ($filesWithFolder as $key => $datas)
                                @if (!$datas->is_recycle)
                                <tr>
                                    <td>
                                        @if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $datas->folder_name))
                                        <a style="color: #089bab" alt="image" data-toggle="modal"
                                            data-target="#myModal-{{ $datas->id }}">
                                            <i style="font-size: 30px; color: #089bab" class="ri-image-2-fill"></i>
                                            {{ substr($datas->folder_name, 12) }}
                                        </a>
                                        @elseif (preg_match('/\.mp4$/i', $datas->folder_name))
                                        <a target="_blank" href="URL_KE_VIDEO_MP4_DISINI">
                                            <i style="font-size: 30px;" class="ri-video-fill"></i> {{
                                            substr($datas->folder_name, 12) }}
                                        </a>
                                        @else
                                        @php
                                        $extension = pathinfo($datas->folder_name, PATHINFO_EXTENSION);
                                        $iconClass = '';
                                        switch ($extension) {
                                        case 'pdf':
                                        $iconClass = 'ri-file-pdf-fill';
                                        break;
                                        case 'xlsx':
                                        $iconClass = 'ri-file-excel-fill';
                                        break;
                                        case 'docx':
                                        $iconClass = 'ri-file-word-fill';
                                        break;
                                        default:
                                        $iconClass = 'ri-file-fill';
                                        break;
                                        }
                                        @endphp
                                        <a target="_blank"
                                            href="https://docs.google.com/gview?embedded=true&url=https://data-canter.taekwondosulsel.info/storage/{{ $datas->folder_name }}">
                                            <i style="font-size: 30px;" class="{{ $iconClass }}"></i> {{
                                            substr($datas->folder_name, 12) }}
                                        </a>
                                        @endif
                                    </td>
                                    <td>{{ $datas->Users->name }}</td>
                                    <td>{{ date('d F Y', strtotime($datas->tanggal)) }}</td>
                                    <td>
                                        <div class="iq-card-header-toolbar d-flex align-items-center">
                                            <div class="dropdown">
                                                <span class="dropdown-toggle text-primary" id="dropdownMenuButton5"
                                                    data-toggle="dropdown">
                                                    <i style="margin-left: 30px;" class="ri-more-2-fill"></i>
                                                </span>
                                                <div class="dropdown-menu dropdown-menu-right"
                                                    aria-labelledby="dropdownMenuButton5">
                                                    <form action="{{ route('put.Pulihkan.Status', $datas->id) }}"
                                                        method="POST">
                                                        @method('PUT')
                                                        @csrf
                                                        <button type="submit" class="dropdown-item"><i
                                                                style="font-size: 25px;"
                                                                class="fa fa-upload mr-2"></i>Pulihkan</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                                {{-- @foreach ($data as $datas)
                                @if (!$datas->is_recycle)
                                <tr>
                                    <td>
                                        <a href="{{ route('get.Details', $datas->id) }}">
                                            <i style="font-size: 30px;" class="ri-folders-fill"></i> {{
                                            $datas->folder_name }}
                                        </a>
                                    </td>
                                    <td>{{ $datas->Users->name }}</td>
                                    <td>{{ date('d F Y', strtotime($datas->tanggal)) }}</td>
                                    <td>
                                        <div class="iq-card-header-toolbar d-flex align-items-center">
                                            <div class="dropdown">
                                                <span class="dropdown-toggle text-primary" id="dropdownMenuButton5"
                                                    data-toggle="dropdown">
                                                    <i style="margin-left: 30px;" class="ri-more-2-fill"></i>
                                                </span>
                                                <div class="dropdown-menu dropdown-menu-right"
                                                    aria-labelledby="dropdownMenuButton5">
                                                    <form action="{{ route('put.Pulihkan.Status', $datas->id) }}"
                                                        method="POST">
                                                        @method('PUT')
                                                        @csrf
                                                        <button type="submit" class="dropdown-item"><i
                                                                style="font-size: 25px;"
                                                                class="fa fa-upload mr-2"></i>Pulihkan</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
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
</script>
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