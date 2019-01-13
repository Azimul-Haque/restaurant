<html>
<head>
  <title>Commodity | PDF</title>
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
  <p align="center">
    পণ্যসামগ্রী কেনা/ খরচের তালিকা<br/>
    <b><u>{{ $data[0] }} - {{ $data[1] }}</u></b></p>
  <div class="">
    <table class="">
      <tr style="background: #D3D3D3;">
        <th>পণ্য/ খাত</th>
        <th>উৎস</th>
        <th>পরিমাণ</th>
        <th>রেট</th>
        <th>মোট প্রদেয়</th>
        <th>তারিখ</th>
      </tr>
      @foreach($commodities as $commodity)
        <tr>
          <td>{{ $commodity->category->name }}</td>
          <td>{{ $commodity->source->name }}</td>
          <td>{{ $commodity->quantity }}</td>
          <td>৳ {{ $commodity->rate }}</td>
          <td align="right">৳ {{ $commodity->total }}</td>
          <td>{{ date('F d, Y', strtotime($commodity->created_at)) }}</td>
        </tr>
      @endforeach
      <tr style="background: #D3D3D3;">
        <th colspan="4">মোট</th>
        <td align="right">৳ {{ $data[2] }}</td>
        <th></th>
      </tr>
    </table>
  </div>
</body>
</html>