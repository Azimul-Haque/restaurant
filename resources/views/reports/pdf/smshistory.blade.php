<html>
<head>
  <title>SMS History | PDF</title>
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
    এসএমএস (SMS) রিপোর্ট<br/>
    <b><u>{{ $date[0] }} - {{ $date[1] }}</u></b>
  </p>
  <div class="">
    <table class="">
      <tr style="background: #D3D3D3;">
        <th>সদস্যের নাম</th>
        <th>মোবাইল নম্বর</th>
        <th>SMS এর পরিমাণ</th>
        <th>খরচ</th>
        <th>তারিখ</th>
      </tr>
      @foreach($smshistory as $sms)
        <tr>
          <td>{{ $sms->membership->name }}</td>
          <td>{{ $sms->membership->phone }}</td>
          <td align="right">{{ $sms->smscount }}</td>
          <td align="right">৳ {{ number_format((float) ($sms->smscount * 0.40), 2, '.', '') }}</td>
          <td>{{ date('F d, Y', strtotime($sms->created_at)) }}</td>
        </tr>
      @endforeach
      <tr style="background: #D3D3D3;">
        <th colspan="2">মোট</th>
        <th align="right">{{ $date[2] }}</th>
        <th align="right">৳ {{ number_format((float) ($date[2] * 0.40), 2, '.', '') }}</th>
        <th></th>
      </tr>
    </table>
  </div>
</body>
</html>