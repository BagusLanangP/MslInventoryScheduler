<!DOCTYPE html>
<html>
<head>
    <title>Notifikasi Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <h2>Halo, {{ $data['name'] }}!</h2>
    <p>{{ $data['catatan'] }}</p>

    <button class="bg-blue-500">Klik Disini</button>
</body>
</html>
