<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tanggapan Keluhan</title>
</head>
<body>
    <h3>Hai, {{ $keluhan->user->name }}</h3>
    <p>Berikut adalah tanggapan terkait keluhan Anda: </p>
    <p><strong>Judul Keluhan: </strong>{{ $keluhan->judul_keluhan }}</p>
    <p><strong>Tanggapan: </strong>{{ $tanggapan }}</p>
    <p>Terima Kasih telah memberikan keluhan. Kami akan terus berusaha memberikan pelayanan terbaik.</p>
</body>
</html>