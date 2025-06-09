@extends('layouts.app')
   @section('title', 'Register')
   @section('content')
   <h1>DEBUG: Ini adalah register.blade.php yang benar</h1>
       <div class="container-fluid p-0 m-0">
           <div class="row m-0">
               <div class="col-12 p-3">
                   <h2 class="mb-4">Registrasi UMKM</h2>
                   <div class="card shadow-sm">
                       <div class="card-header bg-primary text-white">
                           <h5 class="mb-0">Form Registrasi</h5>
                       </div>
                       <div class="card-body">
                           @if ($errors->any())
                               <div class="alert alert-danger">
                                   <ul class="mb-0">
                                       @foreach ($errors->all() as $error)
                                           <li>{{ $error }}</li>
                                       @endforeach
                                   </ul>
                               </div>
                           @endif

                           <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate>
                               @csrf
                               <div class="row g-3">
                                   <div class="col-12 col-md-4 mb-3">
                                       <label for="name" class="form-label">Nama UMKM</label>
                                       <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                                       <div class="invalid-feedback">Nama UMKM wajib diisi.</div>
                                   </div>
                                   <div class="col-12 col-md-4 mb-3">
                                       <label for="email" class="form-label">Email</label>
                                       <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                                       <div class="invalid-feedback">Email wajib diisi dan valid.</div>
                                   </div>
                                   <div class="col-12 col-md-4 mb-3">
                                       <label for="password" class="form-label">Password</label>
                                       <input type="password" class="form-control" id="password" name="password" required>
                                       <div class="invalid-feedback">Password wajib diisi.</div>
                                   </div>
                                   <div class="col-12 col-md-4 mb-3">
                                       <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                       <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                       <div class="invalid-feedback">Konfirmasi password wajib diisi.</div>
                                   </div>
                                   <div class="col-12 col-md-4 mb-3">
                                       <label for="lokasi" class="form-label">Lokasi</label>
                                       <input type="text" class="form-control" id="lokasi" name="lokasi" value="{{ old('lokasi') }}">
                                   </div>
                                   <div class="col-12 col-md-4 mb-3">
                                       <label class="form-label">Apakah Anda memiliki NIB?</label>
                                       <div class="form-check mb-2">
                                           <input class="form-check-input" type="radio" name="has_nib" id="has_nib_yes" value="yes" {{ old('has_nib') == 'yes' ? 'checked' : '' }} required>
                                           <label class="form-check-label" for="has_nib_yes">Ya</label>
                                       </div>
                                       <div class="form-check">
                                           <input class="form-check-input" type="radio" name="has_nib" id="has_nib_no" value="no" {{ old('has_nib', 'no') == 'no' ? 'checked' : '' }} required>
                                           <label class="form-check-label" for="has_nib_no">Belum ada NIB</label>
                                       </div>
                                       <div class="invalid-feedback">Pilih opsi NIB.</div>
                                   </div>
                                   <div class="col-12 col-md-4 mb-3" id="nib_field" style="display: none;">
                                       <label for="nib" class="form-label">Nomor Induk Berusaha (NIB)</label>
                                       <input type="text" class="form-control" id="nib" name="nib" value="{{ old('nib') }}" maxlength="13" {{ old('has_nib') == 'yes' ? 'required' : '' }}>
                                       <div class="invalid-feedback">NIB wajib diisi jika memilih "Ya".</div>
                                   </div>
                                   <div class="col-12 col-md-4 mb-3">
                                       <label for="akun_facebook" class="form-label">Akun Facebook (URL)</label>
                                       <input type="url" class="form-control" id="akun_facebook" name="akun_facebook" value="{{ old('akun_facebook') }}">
                                   </div>
                                   <div class="col-12 col-md-4 mb-3">
                                       <label for="akun_instagram" class="form-label">Akun Instagram (URL)</label>
                                       <input type="url" class="form-control" id="akun_instagram" name="akun_instagram" value="{{ old('akun_instagram') }}">
                                   </div>
                                   <div class="col-12 col-md-4 mb-3">
                                       <label for="total_pengikut_facebook" class="form-label">Total Pengikut Facebook</label>
                                       <input type="number" class="form-control" id="total_pengikut_facebook" name="total_pengikut_facebook" value="{{ old('total_pengikut_facebook', 0) }}" min="0">
                                   </div>
                                   <div class="col-12 col-md-4 mb-3">
                                       <label for="total_pengikut_instagram" class="form-label">Total Pengikut Instagram</label>
                                       <input type="number" class="form-control" id="total_pengikut_instagram" name="total_pengikut_instagram" value="{{ old('total_pengikut_instagram', 0) }}" min="0">
                                   </div>
                               </div>
                               <button type="submit" class="btn btn-primary w-100 mt-3">Daftar</button>
                           </form>
                       </div>
                   </div>
               </div>
           </div>
       </div>

       @push('scripts')
           <script>
               // Bootstrap validation
               (function () {
                   'use strict';
                   var forms = document.querySelectorAll('.needs-validation');
                   Array.prototype.slice.call(forms).forEach(function (form) {
                       form.addEventListener('submit', function (event) {
                           if (!form.checkValidity()) {
                               event.preventDefault();
                               event.stopPropagation();
                           }
                           form.classList.add('was-validated');
                       }, false);
                   });
               })();

               // Toggle NIB field
               document.querySelectorAll('input[name="has_nib"]').forEach(function(radio) {
                   radio.addEventListener('change', function() {
                       const nibField = document.getElementById('nib_field');
                       const nibInput = document.getElementById('nib');
                       if (this.value === 'yes') {
                           nibField.style.display = 'block';
                           nibInput.setAttribute('required', 'required');
                       } else {
                           nibField.style.display = 'none';
                           nibInput.removeAttribute('required');
                       }
                   });
               });

               // Set initial state for NIB field based on old value
               document.addEventListener('DOMContentLoaded', function() {
                   const hasNibYes = document.getElementById('has_nib_yes');
                   const hasNibNo = document.getElementById('has_nib_no');
                   const nibField = document.getElementById('nib_field');
                   const nibInput = document.getElementById('nib');
                   if (hasNibYes && hasNibNo) {
                       if ('{{ old('has_nib') }}' === 'yes') {
                           nibField.style.display = 'block';
                           nibInput.setAttribute('required', 'required');
                           hasNibYes.checked = true;
                       } else {
                           nibField.style.display = 'none';
                           nibInput.removeAttribute('required');
                           hasNibNo.checked = true;
                       }
                   }
               });
           </script>
       @endpush
   @endsection