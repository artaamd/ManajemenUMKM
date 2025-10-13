@extends('layouts.app')
@section('title', 'Penilaian Tingkat Interaksi')
@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Menggabungkan Judul dan Form Pencarian dalam satu baris --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div class="w-50">
            <form action="{{ route('analitik.index') }}" method="GET" id="searchForm">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" id="searchInput" placeholder="Cari konten berdasarkan judul..." value="{{ $searchTerm ?? '' }}">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            @if($analitiks->isEmpty())
                <div class="alert alert-info text-center m-4" role="alert">
                    @if(isset($searchTerm) && $searchTerm)
                        <i class="bi bi-search me-2"></i>Tidak ada data analitik yang cocok dengan pencarian "{{ $searchTerm }}".
                    @else
                        <i class="bi bi-info-circle me-2"></i>Belum ada data interaksi. Unggah konten dan isi engagement rate setelah 7 hari untuk melihat hasilnya di sini.
                    @endif
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle m-0">
                        <thead class="table-primary">
                            <tr>
                                <th style="width: 25%;">Konten</th>
                                <th style="width: 8%;" class="text-center">Likes</th>
                                <th style="width: 8%;" class="text-center">Comments</th>
                                <th style="width: 8%;" class="text-center">Shares</th>
                                <th style="width: 12%;" class="text-center">Rate (%)</th>
                                <th style="width: 15%;" class="text-center">Grade</th>
                                <th style="width: 12%;" class="text-center">Screenshot</th>
                                <th style="width: 12%;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($analitiks as $analitik)
                                <tr>
                                    <td>{{ $analitik->konten->judul ?? 'Konten tidak ditemukan' }}</td>
                                    <td class="text-center">{{ $analitik->likes ?? '-' }}</td>
                                    <td class="text-center">{{ $analitik->comments ?? '-' }}</td>
                                    <td class="text-center">{{ $analitik->shares ?? '-' }}</td>
                                    <td class="text-center">{{ $analitik->engagement_rate ? number_format($analitik->engagement_rate, 2) . '%' : '-' }}</td>
                                    <td class="text-center">
                                        @if($analitik->grade)
                                            <button type="button" class="btn btn-sm grade-button-custom {{ $analitik->grade == 'A' ? 'btn-success' : ($analitik->grade == 'B' ? 'btn-info' : ($analitik->grade == 'C' ? 'btn-warning' : 'btn-danger')) }}" data-bs-toggle="modal" data-bs-target="#gradeModal" data-grade="{{ $analitik->grade }}">
                                                <i class="bi bi-info-circle-fill me-2"></i> 
                                                <span>Grade {{ $analitik->grade }}</span>
                                            </button>
                                        @else
                                            <span>-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($analitik->screenshot)
                                            <a href="{{ Storage::url($analitik->screenshot) }}" target="_blank">
                                                <img src="{{ Storage::url($analitik->screenshot) }}" alt="Screenshot" class="screenshot-img rounded shadow-sm">
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $sevenDaysPassed = $analitik->konten->created_at->addDays(7)->lte(now());
                                            $isFilled = $analitik->engagement_filled_at !== null;
                                        @endphp
                                        @if ($sevenDaysPassed && !$isFilled)
                                            <a href="{{ route('analitik.edit', $analitik->konten->id) }}" class="btn btn-primary btn-sm">
                                                <i class="bi bi-pencil me-1"></i>Isi Engangement
                                            </a>
                                        @elseif ($isFilled)
                                            <span class="badge bg-success">Sudah Diisi</span>
                                        @else
                                            <span class="badge bg-secondary">Tunggu 7 Hari</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection

<!-- Modal untuk Tindak Lanjut Grade -->
<div class="modal fade" id="gradeModal" tabindex="-1" aria-labelledby="gradeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gradeModalLabel">Tindak Lanjut untuk Grade <span id="gradeValue" class="fw-bold"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="gradeModalBody"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .table { table-layout: fixed; width: 100%; }
        .table th, .table td { vertical-align: middle; white-space: normal; overflow-wrap: break-word; }
        .table-primary th { background-color: #007bff; color: white; font-weight: 600; }
        .screenshot-img { width: 80px; height: 80px; object-fit: cover; transition: transform 0.2s ease; }
        .screenshot-img:hover { transform: scale(1.1); }
        .badge { font-size: 0.8rem; padding: 0.4em 0.7em; }
        .card { border-radius: 0.75rem; overflow: hidden; }
        .grade-button-custom { display: inline-flex; align-items: center; justify-content: center; font-weight: 600; border-radius: 0.5rem; border: none; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15); transition: all 0.2s ease-in-out; }
        .grade-button-custom:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Skrip untuk modal grade
            const gradeModal = document.getElementById('gradeModal');
            if (gradeModal) {
                gradeModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const grade = button.getAttribute('data-grade');
                    const modalTitle = document.getElementById('gradeValue');
                    const modalBody = document.getElementById('gradeModalBody');
                    let bodyContent = '';

                    switch (grade) {
                        case 'A':
                            bodyContent = `
                                <h6 class="fw-bold text-success">Analisis</h6>
                                <p>Anda mendapatkan grade ini karena tingkat interaksi konten sangat tinggi, menandakan konten Anda sangat disukai dan relevan bagi audiens.</p>
                                
                                <h6 class="fw-bold text-success mt-3">Solusi & Saran</h6>
                                <ul>
                                    <li><strong>Analisis Keberhasilan:</strong> Pelajari elemen kunci (visual, caption, waktu posting) dari konten ini dan terapkan pada ide selanjutnya.</li>
                                    <li><strong>Bangun Komunitas:</strong> Manfaatkan interaksi yang tinggi dengan membalas setiap komentar untuk membangun koneksi yang lebih kuat.</li>
                                </ul>

                                <p class="fst-italic">Kerja luar biasa! Anda tidak hanya menjual produk, tetapi juga membangun koneksi. Teruslah menjadi inspirasi di pasar Anda!</p>
                            `;
                            break;
                        case 'B':
                            bodyContent = `
                                <h6 class="fw-bold text-info">Analisis</h6>
                                <p>Anda mendapatkan grade ini karena tingkat interaksi konten Anda bagus dan berada di atas rata-rata. Audiens menunjukkan ketertarikan yang kuat.</p>
                                
                                <h6 class="fw-bold text-info mt-3">Solusi & Saran</h6>
                                <ul>
                                    <li><strong>Perkuat CTA:</strong> Ajak audiens secara eksplisit untuk menyimpan post, berkomentar, atau mengunjungi link di bio Anda.</li>
                                    <li><strong>Optimalkan Hashtag:</strong> Gunakan kombinasi hashtag yang lebih spesifik dan relevan untuk menjangkau audiens baru yang tepat sasaran.</li>
                                </ul>

                                <p class="fst-italic">Anda sudah di jalur yang benar! Hanya sedikit polesan lagi untuk menjadi yang terdepan. Terus bergerak maju!</p>
                            `;
                            break;
                        case 'C':
                            bodyContent = `
                                <h6 class="fw-bold text-warning">Analisis</h6>
                                <p>Anda mendapatkan grade ini karena tingkat interaksi konten berada di level rata-rata. Ini adalah fondasi yang baik, namun masih ada ruang besar untuk berkembang.</p>
                                
                                <h6 class="fw-bold text-warning mt-3">Solusi & Saran</h6>
                                <ul>
                                    <li><strong>Tingkatkan Kualitas Visual:</strong> Pastikan foto atau video Anda memiliki pencahayaan yang baik, resolusi tinggi, dan komposisi yang menarik.</li>
                                    <li><strong>Buat Caption Bercerita:</strong> Gunakan kalimat pembuka yang memancing rasa penasaran dan ajukan pertanyaan di akhir caption untuk memancing diskusi.</li>
                                </ul>

                                <p class="fst-italic">Setiap langkah adalah proses belajar. Dengan sedikit penyesuaian, usaha Anda akan memberikan hasil yang jauh lebih besar. Semangat!</p>
                            `;
                            break;
                        case 'D':
                            bodyContent = `
                                <h6 class="fw-bold text-danger">Analisis</h6>
                                <p>Anda mendapatkan grade ini karena tingkat interaksi pada konten ini masih rendah, yang berarti audiens belum merasa terhubung dengan pesan yang disampaikan.</p>
                                
                                <h6 class="fw-bold text-danger mt-3">Solusi & Saran</h6>
                                <ul>
                                    <li><strong>Evaluasi Ulang Topik:</strong> Apakah topik konten ini sudah benar-benar sesuai dengan minat dan kebutuhan target pasar Anda?</li>
                                    <li><strong>Minta Umpan Balik:</strong> Jangan ragu menggunakan fitur polling atau stiker pertanyaan di Story untuk bertanya langsung kepada audiens.</li>
                                </ul>
                            
                                <p class="fst-italic">Jangan berkecil hati! Anggap ini sebagai data berharga untuk tumbuh. Kegagalan hari ini adalah resep kesuksesan di masa depan. Coba lagi!</p>
                            `;
                            break;
                        default:
                            bodyContent = '<p>Grade tidak dikenali.</p>';
                    }

                    modalTitle.textContent = grade;
                    modalBody.innerHTML = bodyContent;
                });
            }

            // Skrip baru untuk search bar
            const searchForm = document.getElementById('searchForm');
            const searchInput = document.getElementById('searchInput');
            let debounceTimeout;

            if (searchInput) {
                 searchInput.addEventListener('input', function() {
                    clearTimeout(debounceTimeout);
                    debounceTimeout = setTimeout(() => {
                        searchForm.submit();
                    }, 500); // Kirim form setelah 0.5 detik berhenti mengetik
                });
            }
        });
    </script>
@endpush

