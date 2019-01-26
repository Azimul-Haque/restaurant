<title>হিসাব প্রিন্টিং...</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('js/dateformat.js') }}"></script>
<style type="text/css">
   @page { 
        size: 80mm auto;
        margin: 0mm;
    }
   /* output size */
  .sources .sheet {
      width: 80mm; 
      height: auto; 
      font-family: Courier; 
      font-size: 14px; 
  } /* sheet size */
  /*.sheet { text-align: justify; text-justify: inter-word;  }*/
  @media print { 
      .sources { width: 80mm } 

      .noPrint, .no-print *
      {
          display: none !important;
      }
      #printArea {
          width: 80mm; 
          height: auto; 
          font-family: Courier; 
          font-size: 14px; 
          padding: 0px;
          margin: 0px; 
      }
  }

  .rightalign {
      text-align: right;
  }

  .centeralign {
      text-align: center;
  }
  table tr td {
    padding: 0px !important;
    margin: 0px !important;
  }
</style>
<script type="text/javascript">
  $(document).ready(function(){
    setTimeout(function () {
        window.print();
        window.close();
    }, 1000);
  });
</script>

<div class="sources" id="printArea">
  <section class="sheet padding-10mm">
  <center>
    <img src="{{ asset('images/icon-white.png') }}" style="width: 50px; height: auto;"><br>
    <span>Queen Island Kitchen</span><br>
    <span>Press Club, Bhola-8300</span><br>
    <span>Phone: 01704-828518</span><br>
    <span>queenislandkitchen.com</span><br>
    <span id="dateTimeP"></span><br>
  </center>
  <script>
    document.getElementById("dateTimeP").innerHTML = dateTime = dateFormat(new Date(), "mmmm dd, yyyy, HH:MM TT");;
  </script>
  <p align="center" style="font-size: 12px;">দোকান/সোর্সের হিসাব</p>
  <div width="100%">
    <table width="100%" style="width: 100%">
      <tr>
        <th>দোকান/সোর্সের নাম</th>
        <th>মোট</th>
        <th>পরিশোধিত</th>
        <th>বক্যেয়া</th>
      </tr>
      @foreach($sources as $source)
        <tr>
          <td><big><b>{{ $source->name }}</b></big></td>
          <td>{{ $source->total }}/-</td>
          <td>{{ $source->paid }}/-</td>
          <td>{{ $source->due }}/-</td>
        </tr>
      @endforeach
    </table>
  </div><br><br/>
  <div style="float: right; margin-top: 20;">Signature</div>
  
  <script type="text/javascript">
    $(document).ready(function(){
      setTimeout(function () {
          window.print();
          window.close();
      }, 1000);
    });
  </script>

  </section>
</div>
