<html>
<head>
  <title>QIK Usage | PDF</title>
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
    QIK Stock ব্যবহারের হিসাব<br/>
    <b><u>{{ $date[0] }} - {{ $date[1] }}</u></b></p>
  <div class="">
    <table class="">
      <tr style="background: #D3D3D3;">
        <th>পণ্য/ সামগ্রী/ খাত</th>
        <th>পরিমাণ</th>
        <th>তারিখ</th>
      </tr>
      @foreach($usages as $usage)
        <tr>
          <td>{{ $usage->qikstock->name }}</td>
          <td>{{ $usage->quantity }} {{ $usage->qikstock->unit }}</td>
          <td>{{ date('F d, Y', strtotime($usage->created_at)) }}</td>
        </tr>
      @endforeach
    </table>
  </div>
</body>
</html>