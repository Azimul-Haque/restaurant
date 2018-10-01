<html>
<head>
  <title>Membership | PDF</title>
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
  <p align="center">মেম্বারশিপ রিপোর্ট</p>
  <p align="center"><b><u>{{ $message }}</u></b></p>
  <div class="">
    <table class="">
      <tr style="background: #D3D3D3;">
        <th>নাম</th>
        <th>মেম্বার আইডি</th>
        <th>পয়েন্ট</th>
        <th>মোট পুরষ্কারপ্রাপ্তির সংখা</th>
        <th>শেষ পুরষ্কার পেয়েছেন</th>
        <th>যোগদানের তারিখ</th>
      </tr>
      @foreach($members as $member)
        <tr>
          <td>{{ $member->name }}</td>
          <td>{{ $member->phone }}</td>
          <td>{{ $member->point }}</td>
          <td>{{ $member->awarded }}</td>
          <td>
            @if($member->awarded > 0)
              {{ date('F d, Y', strtotime($member->updated_at)) }}
            @else
              -
            @endif
          </td>
          <td>{{ date('F d, Y', strtotime($member->created_at)) }}</td>
        </tr>
      @endforeach
    </table>
  </div>
</body>
</html>