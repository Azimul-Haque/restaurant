<html>
<head>
  <title>Staffs Payment | PDF</title>
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
    স্টাফদের পেমেন্টের হিসাব<br/>
    <b><u>{{ $date[0] }} - {{ $date[1] }}</u></b></p>
  <div class="">
    <table class="">
      <tr style="background: #D3D3D3;">
        <th>স্টাফ</th>
        <th>টাকার পরিমাণ</th>
        <th>তারিখ</th>
      </tr>
      @foreach($stuffpayments as $stuffpayment)
        <tr>
          <td>{{ $stuffpayment->stuff->name }}</td>
          <td align="right">৳ {{ $stuffpayment->amount }}</td>
          <td>{{ date('F d, Y h:i A', strtotime($stuffpayment->created_at)) }}</td>
        </tr>
      @endforeach
      <tr style="background: #D3D3D3;">
        <th>মোট</th>
        <th align="right">৳ {{ $date[2] }}</th>
        <th></th>
      </tr>
    </table>
  </div>
</body>
</html>