<title>হিসাব প্রিন্টিংঃ {{ $source->name }}...</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('js/dateformat.js') }}"></script>
<style type="text/css">
   @page { 
        size: 80mm auto;
        margin: 0mm;
    }
   /* output size */
  .receipt .sheet {
      width: 80mm; 
      height: auto; 
      font-family: Courier; 
      font-size: 14px; 
  } /* sheet size */
  /*.sheet { text-align: justify; text-justify: inter-word;  }*/
  @media print { 
      .receipt { width: 80mm } 

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



<div class="receipt" id="printArea">
  <section class="sheet padding-10mm">
  <center>
    <span>Queen Island Kitchen</span><br>
    <span>Press Club, Bhola-8300</span><br>
    <span>Phone: 01704-828518</span><br>
    <span>queenislandkitchen.com</span><br>
    <span id="dateTimeP"></span><br>
  </center>
  <script>
    document.getElementById("dateTimeP").innerHTML = dateTime = dateFormat(new Date(), "mmmm dd, yyyy, HH:MM TT");;
  </script>
  <p align="center" style="font-size: 12px;"><b><u><big>{{ $source->name }}</big></u></b><br/>লেনদেনের হিসাব</p>
  <div width="100%">
    <table width="100%" style="width: 100%">
      <tr>
        <td>Item</td>
        <td>Qty</td>
        <td>Total</td>
        <td>Paid</td>
        <td>Due</td>
        <td>Date</td>
      </tr>
      @foreach($sources as $commodity)
        <tr>
          <td style="font-size: 12px;">{{ $commodity->category->name }}</td>
          <td>{{ $commodity->quantity }}</td>
          <td align="right">{{ $commodity->total }}/-</td>
          <td align="right">{{ $commodity->paid }}/-</td>
          <td align="right">{{ $commodity->due }}/-</td>
          <td>{{ date('d/m/y', strtotime($commodity->created_at)) }}</td>
        </tr>
      @endforeach
      <tr>
        <td colspan="2"></td>
        <td colspan="3" style="border: 1px dotted #000;"></td>
        <td></td>
      </tr>
      <tr>
        <td colspan="2">Total:</td>
        <td align="right">{{ $sourcetotal->totalsource }}/-</td>
        <td align="right">{{ $sourcetotal->paidsource }}/-</td>
        <td align="right">{{ $sourcetotal->duesource }}/-</td>
        <td></td>
      </tr>
    </table>
  </div><br><br/>
  <div style="float: right; margin-top: 20;">Signature</div>
  
  <script type="text/javascript">
    $(document).ready(function(){
        window.print();
        window.close();
    });
  </script>

  </section>
</div>