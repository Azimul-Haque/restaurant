<html>
<head>
  <title>Item Wise | PDF</title>
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
  <p align="center">তারিখ অনুযায়ী খাদ্যপণ্য বিক্রয়ের হিসাব</p>
  <p align="center"><b><u>{{ $data[0] }} - {{ $data[1] }}</u></b></p>
  <div class="">
    <table class="">
      <tr style="background: #D3D3D3;">
        <th>তারিখ</th>
        <th>মোট বিক্রয়</th>
      </tr>
      @foreach($incomes as $income)
        <tr>
          <td>{{ date('F d, Y', strtotime($income->created_at)) }}</td>
          <td align="right">৳ {{ $income->totalsale }}</td>
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