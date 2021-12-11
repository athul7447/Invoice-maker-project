<style type="text/css">
    #invoice{
    padding: 30px;
}

.invoice {
    position: relative;
    background-color: #FFF;
    min-height: 680px;
    padding: 15px
}

.invoice header {
    padding: 10px 0;
    margin-bottom: 20px;
    border-bottom: 1px solid #3989c6
}

.invoice .company-details {
    text-align: right
}

.invoice .company-details .name {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .contacts {
    margin-bottom: 20px
}

.invoice .invoice-to {
    text-align: left
}

.invoice .invoice-to .to {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .invoice-details {
    text-align: right
}

.invoice .invoice-details .invoice-id {
    margin-top: 0;
    color: #3989c6
}

.invoice main {
    padding-bottom: 50px
}

.invoice main .thanks {
    margin-top: -100px;
    font-size: 2em;
    margin-bottom: 50px
}

.invoice main .notices {
    padding-left: 6px;
    border-left: 6px solid #3989c6
}

.invoice main .notices .notice {
    font-size: 1.2em
}

.invoice table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    margin-bottom: 20px
}

.invoice table td,.invoice table th {
    padding: 15px;
    background: #eee;
    border-bottom: 1px solid #fff
}

.invoice table th {
    white-space: nowrap;
    font-weight: 400;
    font-size: 16px
}

.invoice table td h3 {
    margin: 0;
    font-weight: 400;
    color: #3989c6;
    font-size: 1.2em
}

.invoice table .qty,.invoice table .total,.invoice table .unit {
    text-align: right;
    font-size: 1.2em
}

.invoice table .no {
    color: #fff;
    font-size: 1.6em;
    background: #3989c6
}

.invoice table .unit {
    background: #ddd
}

.invoice table .total {
    background: #3989c6;
    color: #fff
}

.invoice table tbody tr:last-child td {
    border: none
}

.invoice table tfoot td {
    background: 0 0;
    border-bottom: none;
    white-space: nowrap;
    text-align: right;
    padding: 10px 20px;
    font-size: 1.2em;
    border-top: 1px solid #aaa
}

.invoice table tfoot tr:first-child td {
    border-top: none
}

.invoice table tfoot tr:last-child td {
    color: #3989c6;
    font-size: 1.4em;
    border-top: 1px solid #3989c6
}

.invoice table tfoot tr td:first-child {
    border: none
}

.invoice footer {
    width: 100%;
    text-align: center;
    color: #777;
    border-top: 1px solid #aaa;
    padding: 8px 0
}

@media print {
    .invoice {
        font-size: 11px!important;
        overflow: hidden!important
    }

    .invoice footer {
        position: absolute;
        bottom: 10px;
        page-break-after: always
    }

    .invoice>div:last-child {
        page-break-before: always
    }
}
</style>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!--Author      : @arboshiki-->
<div id="invoice">
    <div class="invoice overflow-auto">
        <div style="min-width: 600px">
            <header>
                <div class="row">
                
                </div>
            </header>
            <main>
                 @foreach($data as $row)
                <div class="row contacts">
                    <div class="col invoice-to">
                        <div class="text-gray-light">INVOICE TO:</div>
                        <h2 class="to">{{ $row->name }}</h2>
                        <div class="email"><a href="mailto:john@example.com">{{ $row->email }}</a></div>
                    </div>
                    <div class="col invoice-details">
                        <h1 class="invoice-id">INVOICE : #{{ $row->id }}</h1>
                        <div class="date">Date of Invoice: {{date('d/m/Y')}}</div>
                    </div>
                </div>
                 @endforeach
                <table border="0" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class="text-center">NAME</th>
                            <th class="text-center">QUANTITY</th>
                            <th class="text-center">UNIT PRIZE</th>
                            <th class="text-center">TAX</th>
                            <th class="text-center">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach($invoicedata as $key)
                        <tr>
                            <td class="no text-center">{{ $i }}</td>
                            <td class="text-center">{{$key->name}}</td>
                            <td class="unit text-center">{{$key->quantity}}</td>
                            <td class="qty text-center">$ {{number_format($key->unit_prize,2)}}</td>
                            <td class="tax text-center">{{$key->tax}}%</td>
                            <td class="total text-center">${{number_format($key->total,2)}}</td>
                        </tr>
                         <?php $i++; ?>
                        @endforeach
                       
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="3">Total Amount Without Tax</td>
                            <td style="text-align: center;">${{ number_format($row->subtotal_without_tax,2)}}</td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="3">Total Amount With Tax</td>
                            <td style="text-align: center;">${{ number_format($row->subtotal,2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="3">Discount</td>
                            <?php 
                            $discount_type=$row->discount_type;
                            if($discount_type=="amount")
                            {
                                $grand_total= $row->subtotal-$row->discount;
                                $per="";
                                $discount=$row->discount;
                            }
                            else
                            {
                                $discount=($row->subtotal*$row->discount)/100;
                                $grand_total=$row->subtotal-$discount;
                                $per="(".$row->discount."%)";
                            }
                            
                            ?>
                            <td style="text-align: center;">${{ number_format($discount,2) }}{{ $per }}</td>
                        </tr>
                        
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="3">Grand Total</td>
                            <td style="text-align: center;">${{number_format($grand_total,2)}}</td>
                        </tr>
                    </tfoot>
                </table>
                <div class="thanks">Thank you!</div>

            </main>

        </div>
        <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
        <div></div>
    </div>
</div>
<script type="text/javascript">
    window.onload = function () {
    window.print();
}
</script>