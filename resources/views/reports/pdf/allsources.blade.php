<html>
<head>
  <title>Sources Report | PDF</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="icon" sizes="192x192" href="{{ asset('images/pdf-icon.png') }}">
  <style>
  body {
    font-family: 'kalpurush', sans-serif;
  }
  table {
      border-collapse: collapse;
      width: 100%;
  }

  table, td, th {
      border: 1px solid black;
  }
  th, td{
    padding: 3px;
    font-family: 'kalpurush', sans-serif;
    font-size: 14px;
  }
  </style>
</head>
<body>
  <h2 align="center">কুইন আইল্যান্ড কিচেন</h2>
  <p align="center">সোর্স/ দোকানের হিসাব</p>
  <div class="">
    <table class="">
      <tr style="background: #D3D3D3;">
        <th>নাম</th>
        <th>মোট</th>
        <th>পরিশোধিত</th>
        <th>বকেয়া</th>
      </tr>
      @foreach($sources as $source)
        <tr>
          <td>{{ $source->name }}</td>
          <td align="right">{{ $source->total }} ৳</td>
          <td align="right">{{ $source->paid }} ৳</td>
          <td align="right">{{ $source->due }} ৳</td>
        </tr>
      @endforeach
    </table>
  </div>
</body>
</html>