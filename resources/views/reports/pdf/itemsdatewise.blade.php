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
    padding: 3px;
    font-family: 'kalpurush', sans-serif;
    font-size: 14px;
  }
  </style>
</head>
<body>
  <center>
    <span style="font-size: 20px;"><b>কুইন আইল্যান্ড কিচেন</b></span><br/>
    <span style="font-size: 15px;"><b>তারিখ অনুযায়ী নির্দিষ্ট খাদ্যপণ্য বিক্রয়ের হিসাব</b></span><br/>
    <span style="font-size: 15px;"><b><u>{{ $data[0] }} - {{ $data[1] }}</u></b></span><br/>
  </center>
  <div class="">
    <table class="">
      <thead>
        <tr style="background: #D3D3D3;">
          <th>খাদ্য সামগ্রীর নাম</th>
          <th>মোট পরিমাণ</th>
          <th>মোট বিক্রয় (টাকা)</th>
        </tr>
      </thead>
      <tbody>
        @foreach($grossitems as $item)
        <tr>
          <td>{{ $item[0]['name'] }}</td>
          <td>{{ $item[0]['qty'] }}</td>
          <td>৳ {{ $item[0]['price'] }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</body>
</html>