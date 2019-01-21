<html>
<head>
  <title>Expenditure | PDF</title>
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
  <center>
    <span style="font-size: 20px;"><b>কুইন আইল্যান্ড কিচেন</b></span><br/>
    <span style="font-size: 15px;"><b>তারিখ অনুযায়ী ব্যয়ের হিসাব</b></span><br/>
    <span style="font-size: 15px;"><b><u>{{ $data[0] }} - {{ $data[1] }}</u></b></span><br/>
  </center>
  <div class="">
    <table class="">
      <tr style="background: #D3D3D3;">
        <th>তারিখ</th>
        <th>মোট ব্যয়</th>
      </tr>
      @foreach($expenses as $expense)
        <tr>
          <td>{{ date('F d, Y', strtotime($expense->created_at)) }}</td>
          <td align="right">৳ {{ $expense->totalprice }}</td>
        </tr>
      @endforeach
      <tr style="background: #D3D3D3;">
        <th>মোট</th>
        <td align="right">৳ {{ $data[2] }}</td>
      </tr>
    </table>
  </div>
</body>
</html>