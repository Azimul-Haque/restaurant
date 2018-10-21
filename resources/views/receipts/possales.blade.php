<title>Sales Printing...</title>
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
      <img src="{{ asset('images/icon-white.png') }}" style="width: 50px; height: auto;"><br>
      <span>Queen Island Kitchen</span><br>
      <span>Press Club, Bhola-8300</span><br>
      <span>Phone: 01704-828518</span><br>
      <span>queenislandkitchen.com</span><br>
    </center><br/>
    <span id="dateTimeP"></span><br><br/>
    <script>
      document.getElementById("dateTimeP").innerHTML = dateTime = dateFormat(new Date(), "mmmm dd, yyyy, HH:MM TT");;
    </script>
<div width="100%">
  <table width="100%" style="width: 100%">
    <thead>
      <tr>
        <td>Item</td>
        <td>Qty</td>
        <td class="rightalign">Price</td>
      </tr>
    </thead>
    <tbody id="saleItemsTr"></tbody>
  </table>
</div><br>
<p class="rightalign">Signature</p>
<script type="text/javascript">
    var receipt = {!! json_encode($detail->receiptdata) !!};
    var receipt = '['+receipt+']';
    var receipt = JSON.parse(receipt);
    //console.log(receipt);
    merged = [];
    for(i = 0; i < receipt.length; i++) {
      var merged2 = receipt[i].items;
      var merged = merged.concat(merged2);
    }
    //console.log(merged);
    var mergedReceiptData = [];
    merged.forEach(function(value) {
      var existing = mergedReceiptData.filter(function(v, i) {
        return v.name == value.name;
      });
      //console.log(value.name);
      if (existing.length) {
        var existingIndex = mergedReceiptData.indexOf(existing[0]);
        mergedReceiptData[existingIndex].price = parseFloat(mergedReceiptData[existingIndex].price) + parseFloat(value.price);
        mergedReceiptData[existingIndex].qty = parseFloat(mergedReceiptData[existingIndex].qty) + parseFloat(value.qty);
      } else {
        if ((typeof value.price == 'string') || (typeof value.qty == 'string'))
          value.price = parseFloat(value.price);
          value.qty = parseFloat(value.qty);
        mergedReceiptData.push(value);
      }
    });

    console.dir(mergedReceiptData);
    var mergedreceipttable = '';
    for(i = 0; i < mergedReceiptData.length; i++) {
      mergedreceipttable += '<tr>';
      mergedreceipttable += '  <td style="font-size:11px;">' + mergedReceiptData[i].name + '</td>';
      mergedreceipttable += '  <td>' + mergedReceiptData[i].qty + '</td>';
      mergedreceipttable += '  <td class="rightalign">৳ ' + mergedReceiptData[i].price + '</td>';
      mergedreceipttable += '</tr>';
    }
    mergedreceipttable += '<tr>';
      mergedreceipttable += '  <td colspan="3" style="border: 1px dotted #000;"></td>';
    mergedreceipttable += '</tr>';

    mergedreceipttable += '<tr>';
      mergedreceipttable += '  <td colspan="2" class="rightalign"><b>Total Price: </b></td>';
      mergedreceipttable += '  <td class="rightalign"><b>৳ ' + {{ $sale->totalsale }} + '</b></td>';
    mergedreceipttable += '</tr>';
    document.getElementById('saleItemsTr').innerHTML = mergedreceipttable;
</script>

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