<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
<div class="col-md-12" style="padding-top: 50px;">
    <div class="text-center" style="padding-bottom: 20px;">
        <h1>Invoice Maker</h1>
    </div>
</div>
<section class="container">
    <form method="post" action="/submit">
        @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col">
                    <input type="text" class="form-control" placeholder="Custome Name" required="required" name="customer_name">
                </div>
                <div class="col">
                    <input type="email" class="form-control" placeholder="Customer Email" required="required" name="customer_email">
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive fm_box" style="padding: 15px 15px 0 15px;margin: 0 0 20px 0;position: relative;z-index: 9;">
        <table class="table" name="tbody" id="tbody">
            <thead>
                <tr style="background: #fff;">
                    <th style="width: 400px; text-align: center;">Name</th>
                    <th style="text-align: center; "> Quantity</th>
                    <th style="text-align: center;">Unit Prize($)</th>
                    <th style="text-align: center;">Tax(%)</th>
                    <th style="text-align: center;">Total($)</th>
                </tr>
            </thead>
            <tbody id="addroww">
                <tr class="middle">
                    <td><input type="text" required="required" id="name0" name="name[]"  class="form-control"  autocomplete="off" ></div></td>
                    <td><input type="text" id="qty0" name="qty[]" class="form-control" autocomplete="off" onkeyup="fn_qty(0);" onkeypress="return isNumberKey(event)"></td>
                    <td><input type="text" id="unit_prize0" required="required"name="unit_prize[]" class="form-control"  autocomplete="off" onkeyup="fn_unit_prize(0);" onkeypress="return isNumberKey(event)">
                        </td>
                    <td style="width: 125px;">
                        <select onchange="fn_tax(0);" class="form-select" aria-label="Default select example" name="tax[]" required="required" id="tax0">
                          <option  value="" selected>select </option>
                          <option value="0">0%</option>
                          <option value="1">1%</option>
                          <option value="5">5%</option>
                          <option value="10">10%</option>
                        </select>
                        
                    </td>
                    <td>
                    <input type="text" id="tax_prize0" name="tax_prize[]" class="form-control taxc"  autocomplete="off"  readonly="readonly" value="0.00">
                     <input type="hidden" id="qty_prize0" name="qty_prize[]" class="form-control amt"  autocomplete="off" value="0.00"  readonly></td>
                    <td style="width: 125px;"><button type="button" id="add_more" class="btn btn-success"> Add More</button></td>
                </tr>
            </tbody>
                <tr>
                    <td class="text-left">Total Amount Without Tax($)</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><input type="text" id="total_tax_amt" required="required"  name="total_tax_amt" class="form-control" readonly value="0.00"></td>
                </tr>
                <tr>
                    <td class="text-left">Total Amount With Tax($)</td>
                    <td></td>
                    <td></td>   
                    <td></td>
                    <td><input type="text" id="total_amt" name="total_amt"  class="form-control lesspp" autocomplete="off"  readonly="readonly" value="0.00">
                        <input type="hidden" id="total_disc" name="total_disc"  class="form-control lesspp" autocomplete="off"  readonly="readonly" value="0"></td>
                </tr>
                <tr>
                    <td class="text-left">Discount($ or %)</td>
                    <td></td>
                    <td></td>
                    <td><select class="form-select" aria-label="Default select example" name="discount_type" id="discount_way" onchange="fn_change_way();">
                        <option value="amount">Amount</option>
                        <option value="percentage">Percentage</option>
                    </select></td>
                    <td><input type="text" id="discount" name="discount"  class="form-control lesspp" autocomplete="off" onkeyup="fn_discount();"  onkeypress="return isNumberKey(event)"></td>
                </tr>
                <tr>
                    <td class="text-left">Grand Total($)</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><input type="text" id="grand_total" name="grand_total"  class="form-control lesspp" autocomplete="off" value="0.00" readonly></td>
                </tr>                    
        </table>
    </div>
</div>
</fieldset>
    <div class="row">
        <div class="col-md-12">
            <div class="text-center">
                    <button id="btn_sub" type="submit" class="btn btn-success"><i class="fa fa-file-invoice"></i> Generate Invoice</button>
                    <button type="reset" class="btn btn-danger" onclick="cancel_form();"><i class="fa fa-undo" aria-hidden="true"></i> Reset</button>
            </div>
        </div>
        <div id="files"></div>
    </div>
</form>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    var x = 0;
    $("#add_more").click(function(){
    x++;
   $("#tbody").append('<tr id="tr_id'+x+'" class="middle"><td><input type="text" id="name'+x+'" name="name[]" required="required" class="form-control"  autocomplete="off" ><div id="itemResult'+x+'" class="trip suggbox"></div></td><td><input type="text" id="qty'+x+'" name="qty[]" onkeypress="return isNumberKey(event)" class="form-control" autocomplete="off" onkeyup="fn_qty('+x+');" ></td><td><input type="text" id="unit_prize'+x+'" name="unit_prize[]" required="required" onkeypress="return isNumberKey(event)" class="form-control" autocomplete="off" onkeyup="fn_unit_prize('+x+');" ></td><td><select onchange="fn_tax('+x+');" class="form-select" aria-label="Default select example" id="tax'+x+'" name="tax[]" required="required"><option value="" selected>select </option><option value="0">0%</option><option value="1">1%</option><option value="5">5%</option><option value="10">10%</option></select></td><td><input type="text" value="0.00" readonly id="tax_prize'+x+'" name="tax_prize[]" class="form-control taxc"  autocomplete="off"  ><input type="hidden" id="qty_prize'+x+'" name="qty_prize[]" class="form-control amt"  autocomplete="off" value="0.00" readonly></td><td><button type="button" class="btn btn-danger remove"><i class="fa fa-trash" aria-hidden="true"></i> Remove</button></td></tr>');
    });
    $("body").on("click", ".remove", function (event) 
    {
        $(this).parents(".middle").remove();
        total_calc();
        total_tax_calc();        
    });
function fn_qty(id)
{
    var quantity=$('#qty'+id).val();
    if(quantity!="")
    {
    var unit_prize=$('#unit_prize'+id).val();
    if(unit_prize=="")
    {
        var unit_prize=0;
    }
    else
    {
        var unit_prize=unit_prize;
    }
    var total_amt_tax=parseFloat(quantity) * parseFloat(unit_prize);
    if(total_amt_tax=="NaN")
    {
        var total_amt_tax=0;
    }
    else
    {
        var total_amt_tax=total_amt_tax
    }
    $('#qty_prize'+id).val(parseFloat(total_amt_tax).toFixed(2));
    }
    else
    {
        $('#qty_prize'+id).val(parseFloat(0).toFixed(2));
    }
    fn_tax(id);
    total_calc(); 
}

function fn_unit_prize(id)
{
    var quantity=$('#qty'+id).val();
    var unit_prize=$('#unit_prize'+id).val();
    if(unit_prize!="")
    {
    if(quantity=="")
    {
        var quantity=0;
    }
    else
    {
        var quantity=quantity;
    }
    var total_amt_tax=parseFloat(quantity) * parseFloat(unit_prize);
    if(total_amt_tax=="NaN")
    {
        var total_amt_tax=0;
    }
    else
    {
        var total_amt_tax=total_amt_tax
    }
    $('#qty_prize'+id).val(parseFloat(total_amt_tax).toFixed(2));
    }
    else
    {
      $('#qty_prize'+id).val(parseFloat(0).toFixed(2));  
    }
    fn_tax(id);
    total_calc();
}
function total_calc()
{
    var tota_wtax = 0;
    $('.amt').each(function() 
    {
        var totals = (this.value).replace(/,/g, '');
        var each_amt=totals;
        if(each_amt=="")
        {
            each_amt='0';
        }
        tota_wtax += parseFloat(each_amt);
    });
    if(tota_wtax=='0')
    {
        $('#total_tax_amt').val(parseFloat(0).toFixed(2));
    }
    else
    {
        $('#total_tax_amt').val(parseFloat(tota_wtax).toFixed(2));
    }
    fn_discount();
    total_tax_calc();
}
function fn_tax(id)
{
    var quantity=$('#qty'+id).val();
    var unit_prize=$('#unit_prize'+id).val();
    var qty_prize=$('#qty_prize'+id).val();
    var tax=$('#tax'+id).val();
    if(tax!="")
    {
        if(qty_prize!="")
        {
            var tax_amt=(parseFloat(qty_prize)*parseFloat(tax))/100;
            var total=parseFloat(qty_prize)+parseFloat(tax_amt);
            $('#tax_prize'+id).val(parseFloat(total).toFixed(2));
        }
        else
        {
            $('#tax_prize'+id).val(parseFloat(0).toFixed(2));
        }
    }
    else
    {
        $('#tax_prize'+id).val(parseFloat(0).toFixed(2));
    }
    total_tax_calc();
    fn_discount();
}
function total_tax_calc()
{
    var total_tax = 0;
    $('.taxc').each(function() 
    {
        var totals = (this.value).replace(/,/g, '');
        var each_amt=totals;
        if(each_amt=="")
        {
            each_amt='0';
        }
        total_tax += parseFloat(each_amt);
    });
    if(total_tax=='0')
    {
        $('#total_amt').val(parseFloat(0).toFixed(2));
        $('#total_disc').val(parseFloat(0).toFixed(2));
        $('#grand_total').val(parseFloat(0).toFixed(2));
    }
    else
    {
        $('#total_amt').val(parseFloat(total_tax).toFixed(2));
        $('#total_disc').val(parseFloat(total_tax));
        $('#grand_total').val(parseFloat(total_tax).toFixed(2));
    }
}
function fn_discount()
{
    var discount_way=$('#discount_way').val();
    var discount=$('#discount').val();
    var amount_tax=$('#total_amt').val();
    var amount_cpy=$('#total_disc').val();
    if(discount_way=="amount")
    {
        if(amount_tax!="")
        {
            if(discount!="")
            {
                var after_discount=parseFloat(amount_tax)-parseFloat(discount);
                $('#grand_total').val(parseFloat(after_discount).toFixed(2));
            }
            else
            {
                $('#grand_total').val(parseFloat(amount_cpy).toFixed(2));
            }
        }
        else
        {
            $('#grand_total').val(parseFloat(0).toFixed(2));   
        }
    }
    else
    {
        if(amount_tax!="")
        {
            if(discount!="")
            {
                var per_disc=(parseFloat(amount_tax)*parseFloat(discount))/100;
                var after_discount=parseFloat(amount_tax)-parseFloat(per_disc); 
                $('#grand_total').val(parseFloat(after_discount).toFixed(2));
            }
            else
            {
                $('#grand_total').val(parseFloat(amount_cpy).toFixed(2));
            }
        }
        else
        {
            $('#grand_total').val(parseFloat(0).toFixed(2));   
        }
    }
}
function fn_change_way()
{
    var dis_way=$('#discount_way').val();
    var discount=$('#discount').val();
    if(dis_way=="percentage")
    {
        $("#discount").attr('maxlength','3');
        if(discount>100)
        {
            $('#discount').val(100);
        }
        else
        {
            $('#discount').val(discount);
        }
    }
    else
    {
        $("#discount").attr('maxlength','10');
    }
    fn_discount();   
}
    
function isNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
    return false;
    return true;
}
</script>