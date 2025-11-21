<?php
// Script sederhana untuk test form submit
$ch = curl_init('http://127.0.0.1:8001/penduduk/create');

// Get CSRF token first
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
$response = curl_exec($ch);

// Extract CSRF token from cookies
preg_match('/XSRF-TOKEN=([^;]+)/', $response, $matches);
$xsrf_token = isset($matches[1]) ? urldecode($matches[1]) : '';

preg_match('/laravel-session=([^;]+)/', $response, $matches);
$session = isset($matches[1]) ? $matches[1] : '';

// Prepare form data
$post_data = [
    '_token' => $xsrf_token,
    'nomor_kk' => '1234567890123456',
    'kategori_sejahtera' => 'KS1',
    'jenis_bangunan' => 'Permanen',
    'pemakaian_air' => 'PDAM',
    'jenis_bantuan' => 'PKH',
    'anggota' => [
        [
            'nik' => '1234567890123456',
            'nama' => 'Test User',
            'jenis_kelamin' => 'Laki-laki',
            'tempat_lahir' => 'Jakarta',
            'tgl_lahir' => '1990-01-01',
            'pekerjaan' => 'Pegawai',
            'hubungan_keluarga' => 'Kepala Keluarga',
            'tamatan' => 'S1'
        ]
    ]
];

// Convert to proper format
$encoded_data = http_build_query($post_data);

// Setup POST request
curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8001/penduduk');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_COOKIE, "XSRF-TOKEN=$xsrf_token; laravel-session=$session");

// Execute request
$result = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

echo "HTTP Status: $http_code\n";
echo "Response:\n" . $result . "\n";

curl_close($ch);
?>