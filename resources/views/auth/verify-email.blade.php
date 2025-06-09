@extends('layouts.guest')
@section('title', 'Verify Email')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-header text-center">
                        <h4>Verifikasi Email</h4>
                    </div>
                    <div class="card-body">
                        <p>Terima kasih telah mendaftar! Sebelum memulai, harap verifikasi alamat email Anda dengan mengklik tautan yang telah kami kirimkan ke email Anda.</p>
                        <p>Jika Anda tidak menerima email, kami akan dengan senang hati mengirimkan ulang.</p>

                        @if (session('status') == 'verification-link-sent')
                            <div class="alert alert-success">
                                Tautan verifikasi baru telah dikirim ke alamat email Anda.
                            </div>
                        @endif

                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary">Kirim Ulang Email Verifikasi</button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}" class="mt-3">
                            @csrf
                            <button type="submit" class="btn btn-secondary">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection@extends('layouts.guest')
@section('title', 'Verify Email')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-header text-center">
                        <h4>Verifikasi Email</h4>
                    </div>
                    <div class="card-body">
                        <p>Terima kasih telah mendaftar! Sebelum memulai, harap verifikasi alamat email Anda dengan mengklik tautan yang telah kami kirimkan ke email Anda.</p>
                        <p>Jika Anda tidak menerima email, kami akan dengan senang hati mengirimkan ulang.</p>

                        @if (session('status') == 'verification-link-sent')
                            <div class="alert alert-success">
                                Tautan verifikasi baru telah dikirim ke alamat email Anda.
                            </div>
                        @endif

                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary">Kirim Ulang Email Verifikasi</button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}" class="mt-3">
                            @csrf
                            <button type="submit" class="btn btn-secondary">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection