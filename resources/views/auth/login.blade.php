<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <meta name="description"
        content="today we are going to learn How to Create a Responsive Login and Registration Form Template in HTML and CSS" />
    <meta name="keywords"
        content="Animated Login & Registration Form,css form,Form Design,free form design,HTML and CSS,HTML CSS JavaScript,HTML Form,Login Form Design,responsive login form,HTML,CSS,JavaScript,Tailwind,Bootstrap" />
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('assets/login/style.css') }}" />

    <link rel="stylesheet"
        href="{{ asset('assets/login/cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="{{ asset('assets/login/custom-scripts.js') }}"></script>
</head>

<body>
    <div class="container d-flex flex-row">
        <div class="cover">
            {{-- <div class=""> --}}
                {{-- <dotlottie-player src="https://lottie.host/1e57f55b-72be-461d-922c-a475cc80b161/vVGvSKgX4T.json"
                    background="transparent" speed="1" style="width: 300px; height: 300px;" loop autoplay>
                </dotlottie-player> --}}
                <img style="" id="animatedGif" src="{{ asset('assets/Bina_Marga.gif') }}" alt="">
                {{--
            </div> --}}
            {{-- <img src="{{ asset('assets/login/images/frontImg.jpg') }}" alt="" /> --}}
        </div>
        <div class="forms">
            <div class="form-content">
                <div class="login-form">
                    <div class="title">Selamat Datang di Sisfo Datacenter Bina Marga</div>
                    <p>Portal Informasi Datacenter Bina Marga yang Terpercaya</p>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="input-boxes">
                            <div class="input-box">
                                <i class="fas fa-envelope"></i>
                                <input type="email" name="email" required placeholder="Enter your email" />
                            </div>
                            <div class="input-box">
                                <i class="fas fa-lock"></i>
                                <input type="password" name="password" required placeholder="Enter your password" />
                            </div>
                            <div class="button input-box">
                                <input type="submit" value="Login" />
                            </div>
                            {{-- <style>
                                .google-login {
                                    margin-top: 20px;
                                    margin-left: 90px;
                                }

                                .google-btn {
                                    background-color: #fff;
                                    border: 1px solid #ccc;
                                    border-radius: 4px;
                                    padding: 8px 16px;
                                    font-size: 14px;
                                    cursor: pointer;
                                }

                                .google-btn i {
                                    margin-right: 10px;
                                }
                            </style> --}}
                            {{-- <div class="google-login">
                                <a href="{{ route('get.Auth.Google') }}" style="text-decoration: #fff;color: black"
                                    class="google-btn">
                                    <i class="fab fa-google"></i> Login with Google
                                </a>
                            </div> --}}
                            {{-- <div class="text sign-up-text">Apakah anda belum mempunyai akun? <label
                                    for="flip">Daftar</label>
                            </div> --}}
                        </div>
                    </form>
                    <div class="playstore-download">
                        <p><a style="text-decoration: none" href="">Unduh Aplikasi Kami di Play Store</a></p>
                        {{-- <a href="link_ke_aplikasi_di_Play_Store" target="_blank">
                            <img style="width: 35px;" src="{{ asset('assets/login/game.png') }}" alt="Play Store" />
                        </a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mengakses elemen gambar GIF
        var animatedGif = document.getElementById('animatedGif');

        // Memastikan bahwa gambar GIF telah dimuat sebelum memulai pemutaran
        animatedGif.addEventListener('load', function() {
          animatedGif.play();
        });
    </script>

    {{-- <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module">
    </script> --}}
</body>

</html>