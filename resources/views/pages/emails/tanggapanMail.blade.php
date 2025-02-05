<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tanggapan Keluhan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 30px;
        }
        .container {
            max-width: 700px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 18px;
        }
        td {
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }
        .header {
            background: #007BFF;
            color: #fff;
            text-align: center;
            padding: 20px;
            font-size: 24px;
            font-weight: bold;
            border-radius: 12px 12px 0 0;
        }
        .footer {
            text-align: center;
            font-size: 14px;
            color: #666;
            margin-top: 25px;
        }
        p {
            font-size: 18px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Tanggapan Keluhan</div>
        <table>
            <tr>
                <td><strong>Nama</strong></td>
                <td>{{ $keluhan->user->name }}</td>
            </tr>
            <tr>
                <td><strong>NPM</strong></td>
                <td>{{ $keluhan->user->npm }}</td>
            </tr>
            <tr>
                <td><strong>Kategori Keluhan</strong></td>
                <td>{{ $keluhan->kategori->nama_kategori_keluhan }}</td>
            </tr>
            <tr>
                <td><strong>Pemberi Tanggapan</strong></td>
                <td>{{ $keluhan->struktural->nama_struktural }}</td>
            </tr>
            <tr>
                <td><strong>Tanggapan</strong></td>
                <td>{{ $tanggapan }}</td>
            </tr>
        </table>
        <p>Terima kasih telah memberikan keluhan. Kami akan terus berusaha memberikan pelayanan terbaik.</p>
        <div class="footer">&copy; 2025 - Layanan Keluhan Fakultas Psikologi UNISBA</div>
    </div>
</body>
</html>
