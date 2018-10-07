<title>Receipt Printing...</title>
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
      <img src="{{ asset('images/icon.png') }}" style="width: 50px; height: auto;"><br>
      <span>Queen Island Kitchen</span><br>
      <span>Press Club, Bhola-8300</span><br>
      <span>Phone: 01704-828518</span><br>
      <span>queenislandkitchen.com</span><br>
    </center>
    <span style="border: 1px dotted #000000; margin: 5px; float: right;width: 30mm;">QTY:</span><br><br><br/>
    <span>Receipt # <span id="receiptnoRP">{{ $receipt->receiptno }}</span></span><br>
    <span id="dateTimeP"></span><br>
    <script>
      document.getElementById("dateTimeP").innerHTML = dateTime = dateFormat(new Date(), "mmmm dd, yyyy, HH:MM TT");;
    </script>
<div width="100%">
  <table width="100%" style="width: 100%">
    <thead>
      <tr>
        <td>Item Name</td>
        <td>Qty</td>
        <td class="rightalign">Price</td>
      </tr>
    </thead>
    <tbody id="receiptItemsTr{{ $receipt->receiptno }}"></tbody>
  </table>
</div><br>
<center>*** FEEL THE FOOD ***</center>
<script type="text/javascript">
  var receipt = JSON.parse({!! json_encode($receipt->receiptdata) !!});
  //console.log(receipt.items);
  var receipttable = '';
  for(i = 0; i < receipt.items.length; i++) {
    receipttable += '<tr>';
    receipttable += '  <td>' + receipt.items[i].name + '</td>';
    receipttable += '  <td>' + receipt.items[i].qty + '</td>';
    receipttable += '  <td class="rightalign">' + receipt.items[i].price + '</td>';
    receipttable += '</tr>';
  }
  receipttable += '<tr>';
    receipttable += '  <td  colspan="3" style="border: 1px dotted #000;"></td>';
  receipttable += '</tr>';

  receipttable += '<tr>';
    receipttable += '  <td  colspan="2" class="rightalign">Total:</td>';
    receipttable += '  <td class="rightalign">' + {{ $receipt->total }} + '</td>';
  receipttable += '</tr>';
  receipttable += '<tr>';
    receipttable += '  <td  colspan="2" class="rightalign">Discount:</td>';
    receipttable += '  <td class="rightalign">' + {{ $receipt->discount }} + '%</td>';
  receipttable += '</tr>';
  receipttable += '<tr>';
    receipttable += '  <td colspan="2" class="rightalign">Total Price:</td>';
    receipttable += '  <td class="rightalign">' + {{ $receipt->discounted_total }} + '</td>';
  receipttable += '</tr>';
  document.getElementById('receiptItemsTr{{ $receipt->receiptno }}').innerHTML = receipttable;
</script>

<script type="text/javascript">
  $(document).ready(function(){
      window.print();
      window.close();
  });
</script>
</section>
</div>