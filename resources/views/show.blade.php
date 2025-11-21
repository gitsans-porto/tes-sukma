<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Data Penduduk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .show-container {
            max-width: 900px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            text-align: center;
        }
        .data-section {
            background-color: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            border-left: 4px solid #667eea;
        }
        .data-section h5 {
            color: #495057;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .data-label {
            font-weight: 600;
            color: #6c757d;
            min-width: 180px;
        }
        .data-value {
            color: #212529;
            font-weight: 500;
        }
        .badge-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
        }
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
        }
        .status-l {
            background-color: #d4edda;
            color: #155724;
        }
        .status-p {
            background-color: #f8d7da;
            color: #721c24;
        }
        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #e9ecef;
        }
        .btn-custom {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        .btn-primary-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
        }
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            color: white;
        }
        .card-custom {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
        }
        .photo-section {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .photo-placeholder {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: #6c757d;
            margin-bottom: 1rem;
        }
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        @media (max-width: 768px) {
            .grid-2 {
                grid-template-columns: 1fr;
            }
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="show-container">
            <!-- Header Section -->
            <div class="header-section">
                <i class="fas fa-user-circle fa-3x mb-3"></i>
                <h2>Detail Data Penduduk</h2>
                <p class="mb-0">Informasi lengkap data penduduk</p>
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

            <!-- Photo Section -->
            <div class="photo-section">
                @if(isset($penduduk->foto) && $penduduk->foto)
                    <img src="{{ asset('storage/'.$penduduk->foto) }}" alt="Foto Penduduk"
                         class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                @else
                    <div class="photo-placeholder">
                        <i class="fas fa-user"></i>
                    </div>
                @endif
                <h4 class="mt-3 mb-1">{{ $penduduk->nama }}</h4>
                <span class="status-badge {{ $penduduk->jenis_kelamin == 'L' ? 'status-l' : 'status-p' }}">
                    {{ $penduduk->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                </span>
            </div>

            <!-- Kartu Keluarga Information -->
            <div class="data-section">
                <h5><i class="fas fa-id-card me-2"></i>Data Kartu Keluarga</h5>
                <div class="grid-2">
                    <div class="mb-3">
                        <span class="data-label">Nomor KK:</span>
                        <span class="data-value">{{ $penduduk->kartuKeluarga->no_kk ?? '-' }}</span>
                    </div>
                    <div class="mb-3">
                        <span class="data-label">Hubungan Keluarga:</span>
                        <span class="data-value badge-custom">{{ $penduduk->hubungan_keluarga }}</span>
                    </div>
                </div>
                @if($penduduk->kartuKeluarga)
                    <div class="grid-2">
                        <div class="mb-3">
                            <span class="data-label">Kategori Sejahtera:</span>
                            <span class="data-value">{{ $penduduk->kartuKeluarga->kategori_sejahtera ?? '-' }}</span>
                        </div>
                        <div class="mb-3">
                            <span class="data-label">Jenis Bangunan:</span>
                            <span class="data-value">{{ $penduduk->kartuKeluarga->jenis_bangunan ?? '-' }}</span>
                        </div>
                        <div class="mb-3">
                            <span class="data-label">Pemakaian Air:</span>
                            <span class="data-value">{{ $penduduk->kartuKeluarga->pemakaian_air ?? '-' }}</span>
                        </div>
                        <div class="mb-3">
                            <span class="data-label">Jenis Bantuan:</span>
                            <span class="data-value">{{ $penduduk->kartuKeluarga->jenis_bantuan ?? '-' }}</span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Personal Information -->
            <div class="data-section">
                <h5><i class="fas fa-user me-2"></i>Data Identitas</h5>
                <div class="grid-2">
                    <div class="mb-3">
                        <span class="data-label">NIK:</span>
                        <span class="data-value">{{ $penduduk->nik }}</span>
                    </div>
                    <div class="mb-3">
                        <span class="data-label">Nama Lengkap:</span>
                        <span class="data-value">{{ $penduduk->nama }}</span>
                    </div>
                    <div class="mb-3">
                        <span class="data-label">Jenis Kelamin:</span>
                        <span class="data-value">{{ $penduduk->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                    </div>
                    <div class="mb-3">
                        <span class="data-label">Usia:</span>
                        <span class="data-value">{{ $penduduk->usia ? $penduduk->usia . ' tahun' : '-' }}</span>
                    </div>
                </div>
                <div class="mb-3">
                    <span class="data-label">Pekerjaan:</span>
                    <span class="data-value">{{ $penduduk->pekerjaan }}</span>
                </div>
            </div>

            <!-- Birth Information -->
            <div class="data-section">
                <h5><i class="fas fa-calendar-alt me-2"></i>Data Kelahiran</h5>
                <div class="grid-2">
                    <div class="mb-3">
                        <span class="data-label">Tempat Lahir:</span>
                        <span class="data-value">{{ $penduduk->tempat_lahir }}</span>
                    </div>
                    <div class="mb-3">
                        <span class="data-label">Tanggal Lahir:</span>
                        <span class="data-value">{{ \Carbon\Carbon::parse($penduduk->tgl_lahir)->translatedFormat('d F Y') }}</span>
                    </div>
                </div>
                <div class="mb-3">
                    <span class="data-label">Pendidikan Terakhir:</span>
                    <span class="data-value">{{ $penduduk->tamatan }}</span>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="data-section">
                <h5><i class="fas fa-info-circle me-2"></i>Informasi Tambahan</h5>
                <div class="grid-2">
                    <div class="mb-3">
                        <span class="data-label">ID Penduduk:</span>
                        <span class="data-value">#{{ str_pad($penduduk->id, 6, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="mb-3">
                        <span class="data-label">ID Kartu Keluarga:</span>
                        <span class="data-value">#{{ $penduduk->kartu_keluarga_id ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Timestamp Information -->
            <div class="data-section">
                <h5><i class="fas fa-clock me-2"></i>Waktu Pencatatan</h5>
                <div class="grid-2">
                    <div class="mb-3">
                        <span class="data-label">Dibuat pada:</span>
                        <span class="data-value">{{ $penduduk->created_at ? \Carbon\Carbon::parse($penduduk->created_at)->translatedFormat('d F Y H:i') : '-' }}</span>
                    </div>
                    <div class="mb-3">
                        <span class="data-label">Terakhir diperbarui:</span>
                        <span class="data-value">{{ $penduduk->updated_at ? \Carbon\Carbon::parse($penduduk->updated_at)->translatedFormat('d F Y H:i') : '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ route('penduduk.index') }}" class="btn btn-secondary btn-custom">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
                <a href="{{ route('penduduk.edit', $penduduk->id) }}" class="btn btn-primary-custom btn-custom">
                    <i class="fas fa-edit me-2"></i>Ubah Data
                </a>
                <button type="button" class="btn btn-danger btn-custom" onclick="confirmDelete()">
                    <i class="fas fa-trash me-2"></i>Hapus Data
                </button>
                <button type="button" class="btn btn-info btn-custom" onclick="window.print()">
                    <i class="fas fa-print me-2"></i>Cetak
                </button>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title">Konfirmasi Hapus Data Penduduk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('penduduk.destroy', $penduduk->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus data penduduk <strong>{{ $penduduk->nama }}</strong>?</p>
                        <p class="text-danger mb-3">Tindakan ini tidak dapat dibatalkan dan akan dicatat dalam sistem mutasi.</p>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Jenis Mutasi:</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_mutasi" id="mutasi_pindah" value="PINDAH" checked>
                                <label class="form-check-label" for="mutasi_pindah">
                                    <i class="fas fa-arrows-alt text-warning"></i> Pindah
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_mutasi" id="mutasi_mati" value="MATI">
                                <label class="form-check-label" for="mutasi_mati">
                                    <i class="fas fa-cross text-dark"></i> Meninggal
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="alasan" class="form-label fw-bold">Alasan/Keterangan:</label>
                            <textarea class="form-control" name="alasan" id="alasan" rows="2" placeholder="Contoh: Pindah ke luar kota, Meninggal karena sakit, dll."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Hapus & Catat Mutasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Confirm delete function
        function confirmDelete() {
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }

        // Format NIK with spaces for better readability
        document.addEventListener('DOMContentLoaded', function() {
            const nikElements = document.querySelectorAll('[data-nik]');
            nikElements.forEach(element => {
                const nik = element.textContent;
                if (nik.length === 16) {
                    const formatted = nik.replace(/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})(\d{4})/, '$1 $2 $3 $4 $5 $6');
                    element.textContent = formatted;
                }
            });
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>

    <!-- Print Styles -->
    <style>
        @media print {
            .action-buttons, .alert, .modal, body > div > div > div.header-section > p {
                display: none !important;
            }
            .show-container {
                box-shadow: none;
                margin: 0;
                max-width: 100%;
                padding: 1rem;
            }
            .header-section {
                background: none !important;
                color: #212529 !important;
                border-bottom: 2px solid #dee2e6;
            }
            .data-section {
                break-inside: avoid;
            }
        }
    </style>
</body>
</html>