<html>
<head>
  <title>Stock | PDF</title>
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
    padding: 5px;
    font-family: 'kalpurush', sans-serif;
    font-size: 15px;
  }
  </style>
</head>
<body>
  <h2 align="center">কুইন আইল্যান্ড কিচেন</h2>
  <p align="center">বর্তমানে স্টকের অবস্থা</p>
  <p align="center"><b><u>{{ $message }}</u></b></p>
  <div class="">
    <table class="">
      <tr style="background: #D3D3D3;">
        <th>পণ্য/ সামগ্রী/ খাত</th>
        <th>পরিমাণ</th>
        <th>তারিখ</th>
      </tr>
      @foreach($stocks as $stock)
        <tr>
          <td>{{ $stock->category->name }}</td>
          <td>{{ $stock->quantity }} {{ $stock->category->unit }}</td>
          <td>{{ date('F d, Y', strtotime($stock->created_at)) }}</td>
        </tr>
      @endforeach
    </table>
  </div>
</body>
</html>