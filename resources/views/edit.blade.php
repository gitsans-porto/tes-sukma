<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .edit-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            text-align: center;
        }
        .form-section {
            background-color: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }
        .form-section h5 {
            color: #495057;
            margin-bottom: 1rem;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 0.5rem;
        }
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }
        .form-control, .form-select {
            border: 1px solid #ced4da;
            border-radius: 6px;
            padding: 0.75rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 6px;
            transition: transform 0.2s ease-in-out;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .btn-secondary {
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 6px;
        }
        .alert {
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }
        .required-mark {
            color: #dc3545;
            font-weight: bold;
        }
        .data-preview {
            background-color: #e9ecef;
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1rem;
            border-left: 4px solid #667eea;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="edit-container">
            <div class="form-header">
                <i class="fas fa-edit fa-2x mb-3"></i>
                <h2>Form Edit Data</h2>
                <p class="mb-0">Ubah data sesuai dengan kebutuhan</p>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Terjadi Kesalahan:</h6>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Form Start -->
            <form action="{{ route('penduduk.update', $penduduk->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Data Preview -->
                @if(isset($penduduk))
                    <div class="data-preview">
                        <h6><i class="fas fa-info-circle me-2"></i>Informasi Data Saat Ini:</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <small class="text-muted">NIK:</small> <strong>{{ $penduduk->nik }}</strong>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">Nama:</small> <strong>{{ $penduduk->nama }}</strong>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">No. KK:</small> <strong>{{ $penduduk->kartuKeluarga->no_kk ?? '-' }}</strong>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">Jenis Kelamin:</small> <strong>{{ $penduduk->jenis_kelamin_display }}</strong>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">Pekerjaan:</small> <strong>{{ $penduduk->pekerjaan }}</strong>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">Pendidikan:</small> <strong>{{ $penduduk->tamatan }}</strong>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Basic Information Section -->
                <div class="form-section">
                    <!-- Debug Info -->
                    <div class="alert alert-info" role="alert">
                        <small><strong>DEBUG:</strong></small><br>
                        <small>Jenis Kelamin DB: <strong>{{ $penduduk->jenis_kelamin ?? 'NULL' }}</strong></small><br>
                        <small>Old Value: <strong>{{ old('jenis_kelamin') ?? 'NULL' }}</strong></small><br>
                        <small>Combined: <strong>{{ old('jenis_kelamin', $penduduk->jenis_kelamin ?? '') }}</strong></small>
                    </div>

                    <h5><i class="fas fa-user me-2"></i>Data Identitas Penduduk</h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nik" class="form-label">NIK <span class="required-mark">*</span></label>
                            <input type="text" class="form-control" id="nik" name="nik" maxlength="16"
                                   value="{{ old('nik', $penduduk->nik ?? '') }}" required>
                            <small class="form-text text-muted">16 digit angka</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="nama" class="form-label">Nama Lengkap <span class="required-mark">*</span></label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                   value="{{ old('nama', $penduduk->nama ?? '') }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="required-mark">*</span></label>
                            <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="">-- Pilih --</option>
                                <option value="L" @selected(old('jenis_kelamin', $penduduk->jenis_kelamin ?? '') == 'L')>Laki-laki</option>
                                <option value="P" @selected(old('jenis_kelamin', $penduduk->jenis_kelamin ?? '') == 'P')>Perempuan</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="hubungan_keluarga" class="form-label">Hubungan Keluarga <span class="required-mark">*</span></label>
                            <select class="form-select" id="hubungan_keluarga" name="hubungan_keluarga" required>
                                <option value="">-- Pilih --</option>
                                <option value="Kepala Keluarga" {{ (old('hubungan_keluarga') ?: ($penduduk->hubungan_keluarga == 'Kepala Keluarga')) ? 'selected' : '' }}>Kepala Keluarga</option>
                                <option value="Istri" {{ (old('hubungan_keluarga') ?: ($penduduk->hubungan_keluarga == 'Istri')) ? 'selected' : '' }}>Istri</option>
                                <option value="Anak" {{ (old('hubungan_keluarga') ?: ($penduduk->hubungan_keluarga == 'Anak')) ? 'selected' : '' }}>Anak</option>
                                <option value="Orang Tua" {{ (old('hubungan_keluarga') ?: ($penduduk->hubungan_keluarga == 'Orang Tua')) ? 'selected' : '' }}>Orang Tua</option>
                                <option value="Lainnya" {{ (old('hubungan_keluarga') ?: ($penduduk->hubungan_keluarga == 'Lainnya')) ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="pekerjaan" class="form-label">Pekerjaan <span class="required-mark">*</span></label>
                        <input type="text" class="form-control" id="pekerjaan" name="pekerjaan"
                               value="{{ old('pekerjaan', $penduduk->pekerjaan ?? '') }}" required>
                    </div>
                </div>

                <!-- Birth Information Section -->
                <div class="form-section">
                    <h5><i class="fas fa-calendar me-2"></i>Data Kelahiran</h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tempat_lahir" class="form-label">Tempat Lahir <span class="required-mark">*</span></label>
                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                                   value="{{ old('tempat_lahir', $penduduk->tempat_lahir ?? '') }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tgl_lahir" class="form-label">Tanggal Lahir <span class="required-mark">*</span></label>
                            <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir"
                                   value="{{ old('tgl_lahir', $penduduk->tgl_lahir ? \Carbon\Carbon::parse($penduduk->tgl_lahir)->format('Y-m-d') : '') }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="usia" class="form-label">Usia (tahun)</label>
                            <input type="number" class="form-control" id="usia" name="usia" min="0" max="150"
                                   value="{{ old('usia', $penduduk->usia ?? '') }}" placeholder="Opsional">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tamatan" class="form-label">Pendidikan Terakhir <span class="required-mark">*</span></label>
                            <select class="form-select" id="tamatan" name="tamatan" required">
                                <option value="">-- Pilih --</option>
                                <option value="Tidak Sekolah" {{ (old('tamatan') ?: ($penduduk->tamatan == 'Tidak Sekolah')) ? 'selected' : '' }}>Tidak Sekolah</option>
                                <option value="SD" {{ (old('tamatan') ?: ($penduduk->tamatan == 'SD')) ? 'selected' : '' }}>SD</option>
                                <option value="SMP" {{ (old('tamatan') ?: ($penduduk->tamatan == 'SMP')) ? 'selected' : '' }}>SMP</option>
                                <option value="SMA/SMK" {{ (old('tamatan') ?: ($penduduk->tamatan == 'SMA/SMK')) ? 'selected' : '' }}>SMA/SMK</option>
                                <option value="D1/D2/D3" {{ (old('tamatan') ?: ($penduduk->tamatan == 'D1/D2/D3')) ? 'selected' : '' }}>D1/D2/D3</option>
                                <option value="S1" {{ (old('tamatan') ?: ($penduduk->tamatan == 'S1')) ? 'selected' : '' }}>S1</option>
                                <option value="S2" {{ (old('tamatan') ?: ($penduduk->tamatan == 'S2')) ? 'selected' : '' }}>S2</option>
                                <option value="S3" {{ (old('tamatan') ?: ($penduduk->tamatan == 'S3')) ? 'selected' : '' }}>S3</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="{{ route('penduduk.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>

                    <div>
                        <button type="button" class="btn btn-warning me-2" onclick="confirmReset()">
                            <i class="fas fa-undo me-2"></i>Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Set form values from data on page load
        document.addEventListener('DOMContentLoaded', function() {
            @if(isset($penduduk))
                // Debug: log penduduk data
                console.log('Penduduk Data:', {
                    jenis_kelamin: '{{ $penduduk->jenis_kelamin ?? 'NULL' }}',
                    pekerjaan: '{{ $penduduk->pekerjaan ?? 'NULL' }}',
                    hubungan_keluarga: '{{ $penduduk->hubungan_keluarga ?? 'NULL' }}',
                    tamatan: '{{ $penduduk->tamatan ?? 'NULL' }}'
                });

                // Set specific fields manually
                const pendudukValues = {
                    nik: '{{ $penduduk->nik ?? "" }}',
                    nama: '{{ $penduduk->nama ?? "" }}',
                    tempat_lahir: '{{ $penduduk->tempat_lahir ?? "" }}',
                    tgl_lahir: '{{ $penduduk->tgl_lahir ? \Carbon\Carbon::parse($penduduk->tgl_lahir)->format('Y-m-d') : "" }}',
                    pekerjaan: '{{ $penduduk->pekerjaan ?? "" }}',
                    usia: '{{ $penduduk->usia ?? "" }}'
                };

                Object.keys(pendudukValues).forEach(function(field) {
                    const element = document.getElementById(field);
                    const value = pendudukValues[field];

                    if (element && value) {
                        element.value = value;
                        console.log(`Set ${field}: ${value}`);
                    }
                });

                // Set select fields specifically
                const selectFields = {
                    'jenis_kelamin': '{{ $penduduk->jenis_kelamin ?? "" }}',
                    'hubungan_keluarga': '{{ $penduduk->hubungan_keluarga ?? "" }}',
                    'tamatan': '{{ $penduduk->tamatan ?? "" }}'
                };

                Object.keys(selectFields).forEach(function(key) {
                    const element = document.getElementById(key);
                    const value = selectFields[key];

                    if (element && value) {
                        element.value = value;
                        console.log(`Set select ${key}: ${value}`);

                        // Force trigger change event
                        const event = new Event('change', { bubbles: true });
                        element.dispatchEvent(event);
                    }
                });

            @endif
        });

        // NIK validation - only allow numbers
        document.getElementById('nik').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '');
        });

        // Auto-calculate age based on birth date
        document.getElementById('tgl_lahir').addEventListener('change', function(e) {
            const birthDate = new Date(e.target.value);
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();

            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }

            document.getElementById('usia').value = age;
        });

        // Form reset confirmation
        function confirmReset() {
            if (confirm('Apakah Anda yakin ingin mereset form? Semua perubahan akan hilang.')) {
                document.querySelector('form').reset();
            }
        }

        // Auto-save to localStorage
        const form = document.querySelector('form');
        const inputs = form.querySelectorAll('input, select, textarea');

        // Load saved values on page load
        window.addEventListener('load', function() {
            inputs.forEach(input => {
                const savedValue = localStorage.getItem(input.name);
                if (savedValue && !input.value) {
                    input.value = savedValue;
                }
            });
        });

        // Save values to localStorage on input change
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                localStorage.setItem(input.name, input.value);
            });
        });

        // Clear localStorage on form submit
        form.addEventListener('submit', function() {
            inputs.forEach(input => {
                localStorage.removeItem(input.name);
            });
        });
    </script>
</body>
</html>