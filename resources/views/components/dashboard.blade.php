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
                        <a href="https://docs.google.com/viewer?url=https://data-canter.taekwondosulsel.info/storage/' .
                            $announcement->file . '">
                            ' . $announcement->file . '
                        </a>
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
        <div class="col-lg-8">
            <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title">Grafik Dataset</h4>
                    </div>
                </div>
                <div class="iq-card-body">
                    <canvas id="barChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
        {{-- <div class="col-lg-4">
            @foreach ( $role as $i )
            <div class="iq-card iq-card-block iq-card-stretch">
                <div class="iq-card-body">
                    <div class="user-details-block">
                        <div>
                            <p>Total data dibuat oleh {{ $i->roles_bidang }}</p>
                        </div>
                        <hr>
                        <ul class="doctoe-sedual d-flex align-items-center justify-content-between p-0">
                            <li class="text-center">
                                <h3 class="counter">{{ $totalFolderBidangUpt }}</h3>
                                <span>Folder</span>
                            </li>
                            <li class="text-center">
                                <h3 class="counter">{{ $totalFilerBidangUpt }}</h3>
                                <span>File</span>
                            </li>
                        </ul>
                        <div>
                            <p>Selengkapnya ...</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="iq-card iq-card-block iq-card-stretch">
                <div class="iq-card-body">
                    <div class="user-details-block">
                        <div>
                            <p>Total data yang dibuat oleh staff</p>
                        </div>
                        <hr>
                        <ul class="doctoe-sedual d-flex align-items-center justify-content-between p-0">
                            <li class="text-center">
                                <h3 class="counter">{{ $totalFolderSeksi }}</h3>
                                <span>Folder</span>
                            </li>
                            <li class="text-center">
                                <h3 class="counter">{{ $totalFilerSeksi }}</h3>
                                <span>File</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="iq-card iq-card-block iq-card-stretch">
                <div class="iq-card-body">
                    <div class="user-details-block">
                        <div>
                            <p>Total data yang dibuat oleh seksi</p>
                        </div>
                        <hr>
                        <ul class="doctoe-sedual d-flex align-items-center justify-content-between p-0">
                            <li class="text-center">
                                <h3 class="counter">{{ $totalFolderStaff }}</h3>
                                <span>Folder</span>
                            </li>
                            <li class="text-center">
                                <h3 class="counter">{{ $totalFilerStaff }}</h3>
                                <span>File</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    var datacenterFileData = @json($datacenterFile);
    var datacenterNonFileData = @json($datacenterNonFile);

    var ctx = document.getElementById('barChart').getContext('2d');

    var barChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: datacenterFileData.map(data => data.month_year),
            datasets: [
                {
                    label: 'Jumlah File Yang Diapload',
                    data: datacenterFileData.map(data => data.count),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Jumlah Folder Yang Dibuat',
                    data: datacenterNonFileData.map(data => data.count),
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
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