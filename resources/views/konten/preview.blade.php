@extends('layouts.app')
@section('title', 'Preview Tampilan Konten')
@section('content')
    <div class="">
        <div class="row m-0">
            <div class="col-15 p-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="bi bi-eye-fill me-2"></i>Preview Tampilan Konten</h4>
                    </div>
                    <div class="card-body p-8">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @forelse($kontens as $konten)
                            <div class="post-container mb-4 {{ $konten->platform == 'instagram' ? 'instagram-post' : 'facebook-post' }} border rounded-lg shadow-sm bg-white">
                                <!-- Header Postingan -->
                                <div class="d-flex align-items-center justify-content-between p-2 border-bottom">
                                    <div class="d-flex align-items-center">
                                        @if ($konten->user->profile_image)
                                            <div class="profile-pic-wrapper">
                                                <img src="{{ asset('storage/' . $konten->user->profile_image) }}" alt="Profile" class="rounded-circle me-2 profile-pic" style="width: 32px; height: 32px; object-fit: cover;">
                                            </div>
                                        @else
                                            <div class="profile-pic-wrapper">
                                                <img src="https://via.placeholder.com/32" alt="Profile" class="rounded-circle me-2 profile-pic" style="width: 32px; height: 32px;">
                                            </div>
                                        @endif
                                        <div>
                                            <div class="d-flex align-items-center">
                                                <strong class="username">{{ $konten->user->name ?? 'Nama Tidak Diketahui' }}</strong>
                                                @if ($konten->platform == 'facebook')
                                                    <small class="text-muted ms-2 time-posted">{{ $konten->tanggal_publish ? \Carbon\Carbon::parse($konten->tanggal_publish)->format('d M') : 'Baru Saja' }} · <i class="bi bi-globe2"></i></small>
                                                @endif
                                            </div>
                                            @if ($konten->platform == 'instagram')
                                                <small class="text-muted time-posted">{{ $konten->tanggal_publish ? \Carbon\Carbon::parse($konten->tanggal_publish)->diffForHumans() : 'Baru Saja' }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-link text-dark p-0 more-options" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Edit</a></li>
                                            <li><a class="dropdown-item text-danger" href="#">Hapus</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Gambar Postingan -->
                                <div class="post-image-container">
                                    @if ($konten->image)
                                        <img src="{{ asset('storage/' . $konten->image) }}" alt="Post Image" class="img-fluid w-100 post-image" data-platform="{{ $konten->platform }}">
                                    @else
                                        <img src="https://via.placeholder.com/{{ $konten->platform == 'instagram' ? '1080x1080' : '1080x608' }}" alt="Post Image" class="img-fluid w-100 post-image" data-platform="{{ $konten->platform }}">
                                    @endif
                                    <div class="double-tap-heart" style="display: none;">
                                        <svg class="heart-icon" viewBox="0 0 48 48" fill="white">
                                            <path d="M34.6 3.6c-4.5 0-8.2 3.7-9.6 7.8-1.4-4.1-5.1-7.8-9.6-7.8C8.8 3.6 4 8.4 4 14.9c0 8.2 9.5 15.2 19.5 25.1l1.5 1.4 1.5-1.4C36.5 30.1 46 23.1 46 14.9c0-6.5-4.8-11.3-11.4-11.3z"/>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Interaksi -->
                                <div class="post-footer p-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <button class="btn btn-link p-0 me-3 like-btn" data-post-id="{{ $konten->id }}" data-platform="{{ $konten->platform }}">
                                            <i class="bi bi-heart {{ $konten->platform == 'instagram' ? 'text-instagram' : 'text-facebook' }}" style="font-size: 1.5rem;"></i>
                                        </button>
                                        <button class="btn btn-link p-0 me-3 comment-btn" data-post-id="{{ $konten->id }}">
                                            <i class="bi bi-chat-dots {{ $konten->platform == 'instagram' ? 'text-instagram' : 'text-facebook' }}" style="font-size: 1.5rem;"></i>
                                        </button>
                                        <button class="btn btn-link p-0 share-btn" data-post-id="{{ $konten->id }}">
                                            <i class="bi {{ $konten->platform == 'instagram' ? 'bi-send text-instagram' : 'bi-share-fill text-facebook' }}" style="font-size: 1.5rem;"></i>
                                        </button>
                                    </div>
                                    <div class="like-count-text mb-1">
                                        <span class="like-count">123</span> likes
                                    </div>
                                    <div class="caption mb-2">
                                        <strong class="username">{{ $konten->user->name ?? 'Nama Tidak Diketahui' }}</strong>
                                        <span class="caption-text">{{ $konten->judul }} {{ $konten->deskripsi }}</span>
                                    </div>
                                    <a href="#" class="text-muted d-block mb-2 view-comments">View all 0 comments</a>
                                    <div class="comment-list mb-2">
                                        <!-- Simulasi Komentar -->
                                    </div>
                                    <div class="add-comment d-flex align-items-center">
                                        <img src="https://via.placeholder.com/24" alt="User" class="rounded-circle me-2" style="width: 24px; height: 24px;">
                                        <input type="text" class="form-control border-0 bg-light" placeholder="Add a comment..." data-post-id="{{ $konten->id }}">
                                        <button class="btn btn-link text-primary p-0 ms-2 post-comment-btn">Post</button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center p-4 text-muted">
                                <i class="bi bi-image fs-1 mb-3"></i>
                                <p>Belum ada konten untuk ditampilkan.</p>
                            </div>
                        @endforelse

                        <a href="{{ route('konten.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;600&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
        <style>
            /* Font dan Warna */
            .instagram-post {
                font-family: 'Roboto', sans-serif;
            }
            .facebook-post {
                font-family: 'Open Sans', sans-serif;
            }
            .bg-primary {
                background: linear-gradient(90deg, #007bff, #0056b3);
            }
            .text-instagram {
                color: #E1306C !important;
            }
            .text-facebook {
                color: #1877F2 !important;
            }
            .post-container {
                max-width: 614px;
                margin: 0 auto;
                border: 1px solid #dbdbdb;
                border-radius: 3px;
                background: #fff;
            }
            .instagram-post .post-image {
                aspect-ratio: 1/1;
                background: linear-gradient(45deg, #405de6, #5851db, #833ab4, #c13584, #e1306c, #fd1d1d);
            }
            .facebook-post .post-image {
                aspect-ratio: 16/9;
                background: #1877f2;
            }
            .post-image-container {
                position: relative;
            }
            .post-image {
                object-fit: cover;
                max-height: 614px;
            }
            .profile-pic-wrapper {
                position: relative;
            }
            .instagram-post .profile-pic-wrapper::before {
                content: '';
                position: absolute;
                top: -2px;
                left: -2px;
                right: -2px;
                bottom: -2px;
                background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
                border-radius: 50%;
                z-index: -1;
            }
            .profile-pic {
                border: 2px solid #fff;
            }
            .username {
                font-size: 14px;
                font-weight: 600;
                color: #262626;
            }
            .time-posted {
                font-size: 10px;
                color: #8e8e8e;
                line-height: 1;
            }
            .time-posted .bi-globe2 {
                font-size: 10px;
            }
            .more-options i {
                font-size: 20px;
                color: #262626;
            }
            .like-btn, .comment-btn, .share-btn {
                margin-right: 16px !important;
            }
            .like-btn i, .comment-btn i, .share-btn i {
                font-size: 24px !important;
            }
            .like-count-text {
                font-size: 14px;
                font-weight: 600;
                color: #262626;
            }
            .caption {
                font-size: 14px;
                color: #262626;
                line-height: 1.5;
            }
            .caption-text {
                margin-left: 4px;
            }
            .view-comments {
                font-size: 14px;
                color: #8e8e8e !important;
                line-height: 1.5;
            }
            .add-comment input {
                font-size: 14px;
                color: #262626;
                background: #fafafa;
                border-radius: 20px;
                padding: 8px 12px;
                height: 36px;
            }
            .add-comment .post-comment-btn {
                font-size: 14px;
                font-weight: 600;
                color: #0095f6 !important;
                opacity: 0.5;
            }
            .add-comment input:focus + .post-comment-btn {
                opacity: 1;
            }
            .comment-list .comment {
                font-size: 14px;
                color: #262626;
                margin-bottom: 8px;
                line-height: 1.5;
            }
            .double-tap-heart {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                opacity: 0;
            }
            .heart-icon {
                width: 100px;
                height: 100px;
                fill: white;
                stroke: rgba(0, 0, 0, 0.2);
                stroke-width: 2;
            }
            .heart-animate {
                animation: heartFade 0.5s ease forwards;
            }
            @keyframes heartFade {
                0% { opacity: 0; transform: translate(-50%, -50%) scale(0); }
                50% { opacity: 1; transform: translate(-50%, -50%) scale(1); }
                100% { opacity: 0; transform: translate(-50%, -50%) scale(1.2); }
            }
            .like-btn.active .bi-heart {
                color: #E1306C !important;
                animation: heartPulse 0.3s ease;
            }
            @keyframes heartPulse {
                0% { transform: scale(1); }
                50% { transform: scale(1.2); }
                100% { transform: scale(1); }
            }
            .shadow-sm {
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
            }
            .card {
                border-radius: 0.75rem;
            }
            .card-header {
                padding: 1rem 1.5rem;
            }
            @media (max-width: 768px) {
                .post-container {
                    max-width: 100%;
                    border: none;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Tooltip
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });

                // Simulasi interaksi suka
                document.querySelectorAll('.like-btn').forEach(btn => {
                    btn.addEventListener('click', function () {
                        const count = this.closest('.post-footer').querySelector('.like-count');
                        let likes = parseInt(count.textContent) || 0;
                        if (!this.classList.contains('active')) {
                            likes += 1;
                            this.classList.add('active');
                        } else {
                            likes -= 1;
                            this.classList.remove('active');
                        }
                        count.textContent = likes;
                    });
                });

                // Double-tap untuk suka (Instagram)
                document.querySelectorAll('.post-image').forEach(img => {
                    let lastTap = 0;
                    img.addEventListener('touchend', function (e) {
                        const currentTime = new Date().getTime();
                        const tapLength = currentTime - lastTap;
                        if (tapLength < 300 && tapLength > 0 && this.getAttribute('data-platform') === 'instagram') {
                            const heart = this.parentElement.querySelector('.double-tap-heart');
                            heart.style.display = 'block';
                            heart.classList.remove('heart-animate');
                            void heart.offsetWidth; // Reset animasi
                            heart.classList.add('heart-animate');
                            const likeBtn = this.closest('.post-container').querySelector('.like-btn');
                            if (!likeBtn.classList.contains('active')) {
                                likeBtn.click();
                            }
                        }
                        lastTap = currentTime;
                    });
                });

                // Simulasi komentar
                document.querySelectorAll('.comment-btn').forEach(btn => {
                    btn.addEventListener('click', function () {
                        const postId = this.getAttribute('data-post-id');
                        const commentList = this.closest('.post-footer').querySelector('.comment-list');
                        const viewComments = this.closest('.post-footer').querySelector('.view-comments');
                        if (commentList.children.length === 0) {
                            const comment = document.createElement('div');
                            comment.className = 'comment';
                            comment.innerHTML = '<strong class="username">user.example</strong> Keren sekali! ❤️';
                            commentList.appendChild(comment);
                            viewComments.textContent = 'View all 1 comments';
                        }
                    });
                });

                // Simulasi tambah komentar
                document.querySelectorAll('.post-comment-btn').forEach(btn => {
                    btn.addEventListener('click', function () {
                        const input = this.previousElementSibling;
                        const commentList = this.closest('.post-footer').querySelector('.comment-list');
                        const viewComments = this.closest('.post-footer').querySelector('.view-comments');
                        if (input.value.trim()) {
                            const comment = document.createElement('div');
                            comment.className = 'comment';
                            comment.innerHTML = `<strong class="username">{{ auth()->user()->name ?? 'Pengguna' }}</strong> ${input.value}`;
                            commentList.appendChild(comment);
                            const commentCount = commentList.children.length;
                            viewComments.textContent = `View all ${commentCount} comments`;
                            input.value = '';
                        }
                    });
                });

                // Simulasi share
                document.querySelectorAll('.share-btn').forEach(btn => {
                    btn.addEventListener('click', function () {
                        alert('Konten dibagikan!');
                    });
                });

                // Aktifkan tombol "Post" saat input komentar diisi
                document.querySelectorAll('.add-comment input').forEach(input => {
                    input.addEventListener('input', function () {
                        const postBtn = this.nextElementSibling;
                        postBtn.style.opacity = this.value.trim() ? '1' : '0.5';
                    });
                });
            });
        </script>
    @endpush
@endsection