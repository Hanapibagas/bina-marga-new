@extends('layouts.app')

@section('content')

@push('css')
<style>
    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        z-index: 999;
        width: 100vw;
        height: 100vh;
        background-color: #000;
        opacity: 0.5;
    }

    .announcement {
        position: absolute;
        top: 50%;
        /* Pusatkan vertikal */
        left: 50%;
        /* Pusatkan horizontal */
        transform: translate(-50%, -50%);
        /* Pusatkan elemen ke tengah */
        z-index: 1000;
        /* Beri z-index yang lebih tinggi dari overlay jika perlu */
        width: 60vw;
        height: max-content;
        padding: 10px;
        border-radius: 10px
    }

    .announcement .title {
        font-size: 30px;
    }

    .announcement .badge {
        font-size: 12px;
    }

    .announcement .card-body {
        position: relative;
        height: fit-content;
    }

    .owl-stage-outer {
        height: fit-content;
        overflow: hidden;
    }

    .owl-stage {
        display: flex;
        flex-direction: row;
        overflow: hidden;
    }

    .owl-nav {
        display: none
    }

    .close {
        position: absolute;
        top: 10px;
        right: 10px;
    }
</style>
@endpush

@if (session('status'))
<script>
    Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: "{{ session('status') }}",
            });
</script>
@endif

@php
if (!session('announcement')) {
$twoDaysAgo = now()->subDays(2);
$pengumuman = \App\Models\Pengumuman::where('created_at', '>=', $twoDaysAgo)
->orderBy('created_at', 'desc')
->get();
echo '<div class="overlay">
    <div class="announcement card">
        <div class="card-body">
            <button class="close">X</button>
            <div class="owl-carouselss owl-theme">';
                foreach ($pengumuman as $announcement) {
                echo'<div class="item">
                    <div class="title">'. $announcement->judul . '</div>
                    <span class="badge badge-secondary">' .
                        date('d F Y', strtotime($announcement->tannggal)) . '</span> Diposting oleh : <i
                        style="font-size: 15px;">'. $announcement->Users->name .'</i>
                    <div class="desc">
                        ' . $announcement->keterangan . '
                    </div>
                </div>';
                }
                echo'</div>
        </div>
    </div>
</div>';
session(['announcement' => true]);
}
@endphp

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title">Daftar Data Center</h4>
                    </div>
                    <div class="iq-card-header-toolbar d-flex align-items-center">
                        <div class="dropdown">
                            <span class="dropdown-toggle text-primary" id="dropdownMenuButton5" data-toggle="dropdown">
                                <i style="font-size: 30px; margin-right: 30px;" class="ri-add-line"></i>
                            </span>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton5">
                                @if (Auth::check() && Auth::user()->RolesBidang->name == 'super admin')
                                <a style="margin-top: 10px;" class="dropdown-item" data-toggle="modal"
                                    data-target="#exampleModalCenter">
                                    <i style="font-size: 25px; " class="ri-folder-fill"></i> Folder
                                    Baru +
                                </a>
                                <hr>
                                <a style="margin-bottom: 10px;" class="dropdown-item" data-toggle="modal"
                                    data-target="#exampleModalCenterFile"><i style="font-size: 25px;"
                                        class="ri-file-fill"></i>File Baru +</a>
                                @elseif (Auth::user()->permission_create)
                                <a style="margin-top: 10px;" class="dropdown-item" data-toggle="modal"
                                    data-target="#exampleModalCenter">
                                    <i style="font-size: 25px; " class="ri-folder-fill"></i> Folder
                                    Baru +
                                </a>
                                <hr>
                                <a style="margin-bottom: 10px;" class="dropdown-item" data-toggle="modal"
                                    data-target="#exampleModalCenterFile"><i style="font-size: 25px;"
                                        class="ri-file-fill"></i> File Baru +</a>
                                @else
                                <p style="margin-left: 10px; font-size: 15px; margin-right: 10px;">Anda Tidak Memiliki
                                    Akses</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="iq-card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Nama</th>
                                    @if (Auth::check() && Auth::user()->RolesBidang->name == 'super admin')
                                    <th scope="col">Nama Penanggung Jawab</th>
                                    @endif
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
                                <tr>
                                    <td>
                                        <a href="{{ route('get.Details', $datas->id) }}">
                                            <i style="font-size: 30px;" class="ri-folder-fill"></i>{{
                                            $datas->folder_name }}
                                        </a>
                                    </td>
                                    @if (Auth::check() && Auth::user()->RolesBidang->name == 'super admin')
                                    <td>{{ $datas->Users->nama_penanggung_jawab }}</td>
                                    @endif
                                    <td>
                                        {{ date('d F Y', strtotime($datas->tanggal)) }},
                                        <i>{{ $datas->created_at->diffForHumans() }}</i>
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
                                                    @if (Auth::check() && Auth::user()->RolesBidang->name ==
                                                    'super admin')
                                                    <a class="dropdown-item" data-toggle="modal"
                                                        data-target="#editModal{{ $datas->id }}"><i
                                                            style="font-size: 25px;"
                                                            class="ri-pencil-fill mr-2"></i>Edit</a>
                                                    <hr>
                                                    <a class="dropdown-item" data-toggle="modal"
                                                        data-target="#logModalEdit{{ $datas->id }}"><i
                                                            style=" font-size: 25px;"
                                                            class="ri-file-list-2-fill mr-2"></i>Log Data</a>
                                                    <hr>
                                                    <form action="{{ route('put.Update.Status', $datas->id) }}"
                                                        method="POST">
                                                        @method('PUT')
                                                        @csrf
                                                        <button type="submit" class="dropdown-item"><i
                                                                style="font-size: 25px;"
                                                                class="ri-delete-bin-6-fill mr-2"></i>Pindahkan ke
                                                            sampah</button>
                                                    </form>
                                                    @elseif (Auth::user()->permission_edit &&
                                                    Auth::user()->permission_delete)
                                                    <a class="dropdown-item" data-toggle="modal"
                                                        data-target="#editModal{{ $datas->id }}"><i
                                                            style="font-size: 25px;"
                                                            class="ri-pencil-fill mr-2"></i>Edit</a>
                                                    <hr>
                                                    <form action="{{ route('put.Update.Status', $datas->id) }}"
                                                        method="POST">
                                                        @method('PUT')
                                                        @csrf
                                                        <button type="submit" class="dropdown-item"><i
                                                                style="font-size: 25px;"
                                                                class="ri-delete-bin-6-fill mr-2"></i>Pindahkan ke
                                                            sampah</button>
                                                    </form>
                                                    @elseif (Auth::user()->permission_edit)
                                                    <a class="dropdown-item" data-toggle="modal"
                                                        data-target="#editModal{{ $datas->id }}"><i
                                                            style="font-size: 25px;"
                                                            class="ri-pencil-fill mr-2"></i>Edit</a>
                                                    @elseif (Auth::user()->permission_delete)
                                                    <form action="{{ route('put.Update.Status', $datas->id) }}"
                                                        method="POST">
                                                        @method('PUT')
                                                        @csrf
                                                        <button type="submit" class="dropdown-item"><i
                                                                style="font-size: 25px;"
                                                                class="ri-delete-bin-6-fill mr-2"></i>Pindahkan ke
                                                            sampah</button>
                                                    </form>
                                                    @else
                                                    <p style="margin-left: 10px;">Anda Tidak
                                                        Memiliki Akses</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <div class="modal fade" id="editModal{{ $datas->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Edit Nama Folder
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('put.Nama.Folder', $datas->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <input type="text" name="folder_name" class="form-control"
                                                            value="{{ $datas->folder_name }}">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Ubah
                                                        Nama</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                @php
                                $fileId = $datas->id;
                                $log = App\Models\Ativitas::where('file_id', $fileId)->get();
                                $download = App\Models\LogEdit::where('file_id', $fileId)->get();
                                @endphp
                                <div class="modal fade" id="logModalEdit{{ $datas->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Daftar Aktivitas Data
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="">Nama yang Buat Folder</label>
                                                    @foreach ( $log as $logs )
                                                    <h5>{{ $logs->Users->nama_penanggung_jawab }} dengan nip user {{
                                                        $logs->Users->nip_oprator }}</h5>
                                                    @endforeach
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Nama yang Edit Folder</label>
                                                    @foreach ($download as $downloadLog)
                                                    <h4>{{ $downloadLog->Users->nama_penanggung_jawab }} dengan nip user
                                                        {{
                                                        $logs->Users->nip_oprator }}</h4>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                                @foreach ($filesWithFolder as $key => $datas)
                                <tr>
                                    <td>
                                        @if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $datas->folder_name))
                                        <a style="color: #089bab" alt="image" data-toggle="modal"
                                            data-target="#myModal-{{ $datas->id }}">
                                            <i style="font-size: 30px; color: #089bab" class="ri-image-2-fill"></i>
                                            {{ substr($datas->folder_name, 12) }}
                                        </a>
                                        <div class="modal fade" id="myModal-{{ $datas->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="modalLabel-{{ $datas->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">{{ substr($datas->folder_name, 12) }}
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Tutup">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <img style="width: 100%;"
                                                            src="{{ Storage::url($datas->folder_name) }}"
                                                            alt="Gambar Modal">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @elseif (preg_match('/\.mp3$/i', $datas->folder_name))
                                        <a style="color: #089bab" alt="audio" data-toggle="modal"
                                            data-target="#myModal-{{ $datas->id }}">
                                            <i style="font-size: 30px;" class="ri-music-fill"></i>
                                            {{ substr($datas->folder_name, 12) }}
                                        </a>
                                        <div class="modal fade" id="myModal-{{ $datas->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="modalLabel-{{ $datas->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">{{ substr($datas->folder_name, 12) }}
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Tutup">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <audio controls>
                                                            <source src="{{ asset('storage/'.$datas->folder_name) }}"
                                                                type="audio/mpeg">
                                                            Browser Anda tidak mendukung pemutaran audio.
                                                        </audio>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @elseif (preg_match('/\.mp4$/i', $datas->folder_name))
                                        <a style="color: #089bab" alt="video" data-toggle="modal"
                                            data-target="#myModal-{{ $datas->id }}">
                                            <i style="font-size: 30px;" class="ri-video-fill"></i>
                                            {{ substr($datas->folder_name, 12) }}
                                        </a>

                                        <div class="modal fade" id="myModal-{{ $datas->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="modalLabel-{{ $datas->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            {{substr($datas->folder_name, 12) }}
                                                            Modal</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Tutup">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <video style="width: 50%" controls autoplay>
                                                            <source src="{{ asset('storage/'.$datas->folder_name) }}"
                                                                type="video/mp4">
                                                            Browser Anda tidak mendukung pemutaran video.
                                                        </video>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                        case 'pptx':
                                        $iconClass = 'ri-file-ppt-fill';
                                        break;
                                        default:
                                        $iconClass = 'ri-file-fill';
                                        break;
                                        }
                                        @endphp
                                        <a target="_blank"
                                            href="https://docs.google.com/viewer?url=https://data-canter.taekwondosulsel.info/storage/{{    ($datas->folder_name) }}">
                                            <i style="font-size: 30px;" class="{{ $iconClass }}"></i> {{
                                            substr($datas->folder_name, 12) }}
                                        </a>
                                        @endif
                                    </td>
                                    @if (Auth::check() && Auth::user()->RolesBidang->name == 'super admin')
                                    <td>{{ $datas->Users->nama_penanggung_jawab }}</td>
                                    @endif
                                    <td>
                                        {{ $datas->created_at->format('d F Y') }},
                                        <i>{{ $datas->created_at->diffForHumans() }}</i>
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
                                                    @if (Auth::check() && Auth::user()->RolesBidang->name ==
                                                    'super admin')
                                                    <a class="dropdown-item"
                                                        href="{{ route('recordActivity', $datas->id) }}"><i
                                                            style="font-size: 25px;"
                                                            class="ri-file-download-fill mr-2"></i>Download</a>
                                                    <hr>
                                                    <a class="dropdown-item" data-toggle="modal"
                                                        data-target="#logModal{{ $datas->id }}"><i
                                                            style=" font-size: 25px;"
                                                            class="ri-file-list-2-fill mr-2"></i>Log Data</a>
                                                    <hr>
                                                    <form action="{{ route('put.Update.Status', $datas->id) }}"
                                                        method="POST">
                                                        @method('PUT')
                                                        @csrf
                                                        <button type="submit" class="dropdown-item"><i
                                                                style="font-size: 25px;"
                                                                class="ri-delete-bin-6-fill mr-2"></i>Pindahkan ke
                                                            sampah</button>
                                                    </form>
                                                    @elseif (Auth::user()->permission_download &&
                                                    Auth::user()->permission_delete)
                                                    <a class="dropdown-item"
                                                        href="{{ route('recordActivity', $datas->id) }}"><i
                                                            style="font-size: 25px;"
                                                            class="ri-file-download-fill mr-2"></i>Download</a>
                                                    <hr>
                                                    <form action="{{ route('put.Update.Status', $datas->id) }}"
                                                        method="POST">
                                                        @method('PUT')
                                                        @csrf
                                                        <button type="submit" class="dropdown-item"><i
                                                                style="font-size: 25px;"
                                                                class="ri-delete-bin-6-fill mr-2"></i>Pindahkan ke
                                                            sampah</button>
                                                    </form>
                                                    @elseif (Auth::user()->permission_download)
                                                    <a class="dropdown-item"
                                                        href="{{ route('recordActivity', $datas->id) }}">
                                                        <i style="font-size: 25px;"
                                                            class="ri-file-download-fill mr-2"></i>Download</a>
                                                    @elseif (Auth::user()->permission_delete)
                                                    <form action="{{ route('put.Update.Status', $datas->id) }}"
                                                        method="POST">
                                                        @method('PUT')
                                                        @csrf
                                                        <button type="submit" class="dropdown-item"><i
                                                                style="font-size: 25px;"
                                                                class="ri-delete-bin-6-fill mr-2"></i>Pindahkan ke
                                                            sampah</button>
                                                    </form>
                                                    @else
                                                    <p style="margin-left: 10px;">Anda Tidak
                                                        Memiliki Akses</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                @php
                                $fileId = $datas->id;
                                $log = App\Models\Ativitas::where('file_id', $fileId)->get();
                                $download = App\Models\DownloadLog::where('file_id', $fileId)->get();
                                @endphp
                                <div class="modal fade" id="logModal{{ $datas->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Daftar Aktivitas Data
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="">Nama yang Buat Folder</label>
                                                    @foreach ( $log as $logs )
                                                    <h5>{{ $logs->Users->nama_penanggung_jawab }} dengan nip user {{
                                                        $logs->Users->nip_oprator }}</h5>
                                                    @endforeach
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Nama yang Edit Folder</label>
                                                    @foreach ($download as $downloadLog)
                                                    <h4>{{ $downloadLog->Users->nama_penanggung_jawab }} dengan nip user
                                                        {{
                                                        $logs->Users->nip_oprator }}</h4>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Folder Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('post.Folder') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" name="folder_name" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp" placeholder="Silahkan buat folder">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Buat</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModalCenterFile" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Upload File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('post.File') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <input type="file" name="folder_name" class="form-control-file" id="fileInput"
                            aria-describedby="fileHelp"><br>
                        <div id="previewContainer"></div>
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
                        <label for="Pengguna">Pengguna</label>
                        <select id="userRole" name="name" class="form-control" required>
                            <option value="-- Silahkan Pilih --">-- Silahkan Pilih --</option>
                            <option value="Admin bidang/upt">Admin bidang/upt</option>
                            <option value="Admin seksi">Admin seksi</option>
                            <option value="Admin staff">Admin staff</option>
                        </select>
                    </div>
                    <div id="additionalFields" style="display: none;">
                        <div class="form-group">
                            <label for="Email">Email</label>
                            <input type="email" name="email" id="userEmail" class="form-control" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="Email">Jabatan</label>
                            <input type="text" name="roles" id="userRoles" class="form-control" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="Password">Password</label>
                            <input name="password" id="userPassword" class="form-control" value="12345678" readonly>
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
<script>
    document.addEventListener("DOMContentLoaded", function() {
            let announcement = document.querySelector(".announcement");
            let overlay = document.querySelector(".overlay");
            let closeButton = document.querySelector(".close");

            if (announcement) {
                document.body.appendChild(overlay);
                document.body.appendChild(announcement);
            }

            closeButton.addEventListener('click', function() {
                overlay.remove();
                announcement.remove();
            })
        });

        // Mengecek apakah overlay pernah ditampilkan sebelumnya
        if (!localStorage.getItem('overlayShown')) {
            // Jika belum pernah ditampilkan, maka tampilkan overlay
            $(".overlay").show();

            // Menandai bahwa overlay sudah ditampilkan
            localStorage.setItem('overlayShown', 'true');
        }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
    integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $('.owl-carouselss').owlCarousel({
            loop: true,
            margin: 10,
            dots: false,
            nav: false,
            autoplay: true,
            autoplayTimeout: 7000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }
        })
</script>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script>
@endpush