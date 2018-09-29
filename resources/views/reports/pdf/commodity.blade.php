<html>
<head>
  <title>Commodity</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
    padding: 5px;
    font-family: 'kalpurush', sans-serif;
    font-size: 15px;
  }
  </style>
</head>
<body>
  <h2 align="center">কুইন আইল্যান্ড কিচেন</h2>
  <p align="center">পণ্যসামগ্রী কেনা/ খরচের তালিকা</p>
  <p align="center"><b><u>{{ $data[0] }} - {{ $data[1] }}</u></b></p>
  <div class="">
    <table class="">
      <tr>
        <th>পণ্য/ খাত</th>
        <th>পরিমাণ</th>
        <th>উৎস</th>
        <th>মোট প্রদেয়</th>
        <th>পরিশোধিত</th>
        <th>বাকি</th>
        <th>তারিখ</th>
      </tr>
      @foreach($commodities as $commodity)
        <tr>
          <td>{{ $commodity->category->name }}</td>
          <td>{{ $commodity->quantity }}</td>
          <td>{{ $commodity->source->name }}</td>
          <td>৳ {{ $commodity->total }}</td>
          <td>৳ {{ $commodity->paid }}</td>
          <td>৳ {{ $commodity->due }}</td>
          <td>{{ date('F d, Y', strtotime($commodity->created_at)) }}</td>
        </tr>
      @endforeach
      <tr style="background: #D3D3D3;">
        <th colspan="3">মোট</th>
        <td>৳ {{ $data[2] }}</td>
        <td>৳ {{ $data[3] }}</td>
        <td>৳ {{ $data[4] }}</td>
        <th></th>
      </tr>
    </table>
  </div>
</body>
</html>