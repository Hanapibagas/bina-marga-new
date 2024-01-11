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
        <div class="col-lg-12">
            <div class="iq-edit-list-data">
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="personal-information" role="tabpanel">
                        <div class="iq-card">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                    <h4 class="card-title">Personal Information</h4>
                                </div>
                            </div>
                            <div class="iq-card-body">
                                <form action="{{ route('put.Password.User', $user->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group row align-items-center">
                                        <div class="col-md-12">
                                            <div class="profile-img-edit">
                                                @if (Auth::check() && Auth::user()->picture)
                                                <img width="100%" src="{{ Storage::url($user->picture) }}"
                                                    class="profile-pic" alt="profile-pic">
                                                @else
                                                <img width="100%"
                                                    src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}"
                                                    class="profile-pic" alt="profile-pic" />
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" row align-items-center">
                                        <div class="form-group col-sm-6">
                                            <label for="fname">Nama Pengguna</label>
                                            <input type="text" class="form-control" id="fname" value="{{ $user->name }}"
                                                readonly>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="lname">Email Pengguna</label>
                                            <input type="text" class="form-control" id="lname"
                                                value="{{ $user->email }}" readonly>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="uname">Role Pengguna</label>
                                            <input type="text" class="form-control" id="uname"
                                                value="{{ $user->RolesBidang->roles_bidang }}" readonly>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="fname">Nama Penanggung Jawab</label>
                                            <input type="text" name="nama_penanggung_jawab" class="form-control"
                                                id="fname" value="{{ $user->nama_penanggung_jawab }}">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="fname">NIP Oprator</label>
                                            <input type="text" name="nip_oprator" class="form-control" id="fname"
                                                value="{{ $user->nip_oprator }}">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="cname">Password</label>
                                            <input type="text" class="form-control" name="password" id="cname">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary mr-2">Kirim perubahan</button>
                                    <button type="reset" class="btn iq-bg-danger">cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection