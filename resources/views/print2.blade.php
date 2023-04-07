<?php
  ob_start();
?>
<?php
 error_reporting(0);
 include_once "conn.php";
 $page="bill";
 $page2="bill";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Office Management</title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />

    <?php include 'header.php'; ?>
    <style type="text/css">
        .addcss td {
            border: none !important;
            border-right: solid 1px #ccc !important;
            border-left: solid 1px #ccc !important;
        }
    </style>
</head>

<body>
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    <!-- [ navigation menu ] start -->
    <?php include 'menu.php'; ?>
    <!-- [ Header ] end -->

    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ Main Content ] start -->
                            <?php
                              if($_GET[view])
                              {  
    $qry=mysqli_query($con,"select `id`,`invoice_no`,`invoice_date`,`name`,`qnt`,`price`,`tprice`,`discount`,`free_product`,`free_qty`,`due_payment`,`supplier_id`,`supplier_name`,`supplier_phone`, `supplier_email`,`supplier_gst`,`supplier_address` from `report` INNER JOIN `add-supplier` ON `report`.`customer`=`add-supplier`.`supplier_id` where `report`.`id`='$_GET[view]'");                         
    $row=mysqli_fetch_assoc($qry);
                              }
                              
                            ?>
                             <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <h5>Print Bill</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div id="printableArea">
                                            <div class="print-main-div">
                                                <h5 class="text-center">INVOICE</h5>
                                                <h4 class="text-center">NATIONAL ENTERPRISE</h4><hr>
                                                <h6 class="text-center">Authorised Distributor of: Bengal Bevarages Pvt. Ltd.</h6>
                                                <table class="bil-table">
                                                        <tbody>
                                                        	<tr>
                        <td rowspan="4">
                            <p>Seller :</p>
                            <strong>NATIONAL ENTERPRISE</strong>
                            <p>45,SRI CHARAN SARANI,BALLY,HOWRAH -711201</p>
                            <!--<p>PH: 8617282577</p>-->
                            <p>GST: 19ADXPG2850L2ZV</p>
                            <p>FASSAI NO: 12820008000044</p>
                        </td>
                        <td>
                            Invoice No :
                            <strong><?= $row[invoice_no] ?></strong>
                        </td>                        
                        <td>
                            Date :
                            <strong><?= date("d-m-Y",strtotime($row[invoice_date])) ?></strong>
                        </td>
                    <tr>
                        <td>
                            Delivery Note
                            <p></p>
                        </td>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td>
                            Supplier's Ref <p></p>
                        </td>
                        <td colspan="2">
                            <p></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                           Buyer's Order No     <p></p>
                        </td>
                        <td colspan="2">
                            
                        </td>
                    </tr>
                    </tr>
                    <tr>
                        <td rowspan="3">
                            <p>Consignee :</p>
                            <strong><?= $row[supplier_name] ?></strong>
                            <p><?= $row[supplier_address] ?></p>
                            <p>PH: <?= $row[supplier_phone] ?></p>
                            <p>GST: <?= $row[supplier_gst] ?></p>
                            <p>FASSAI NO: </p>
                        </td>
                        <td>
                           Despatch Document NO
                            <strong></strong>
                        </td>
                        <td colspan="2">
                           Delivery Note Date
                        </td>

                    <tr>
                        <td>
                           Despath Through
                            <p></p>
                        </td>
                        <td colspan="2">
                           Destination
                            <p></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Bill of Lading/LR-RR No
                            <p></p>
                        </td>
                        <td colspan="2">
                            Motor Vehicle NO
                            <p></p>
                        </td>
                    </tr>

                    </tr> 
                    <tr>
                        <td rowspan="3">
                            <p>Buyer (if other than consignee):</p>
                            <strong><?= $row[supplier_name] ?></strong>
                            <p><?= $row[supplier_address] ?></p>
                            <p>PH: <?= $row[supplier_phone] ?></p>
                            <p>GST: <?= $row[supplier_gst] ?></p>
                            <p>FASSAI NO: </p>
                        </td>
                        <td colspan="2" rowspan="3">
                           Terms of Delivery
                            <strong></strong>
                        </td>                              
                    </tr>
                                                           
                                                          
                                                        </tbody>                                          
                                                    </table>
                                                
                                                <table class="bil-table">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%">#</th>
                                                            <th>Products</th>
                                                            <th>Quantity</th>
                                                            <th>Price</th>
                                                            <th>Sub total</th>
                                                        </tr>
                                                    </thead>                                                   
                                                    <tbody class="addcss">
                                                        <?php 
                                                        $name=explode(",", $row[name]);
                                                        $qnt=explode(",", $row[qnt]);
                                                        $price=explode(",", $row[price]);
                                                        $tprice=explode(",", $row[tprice]);
                                                        $qntt=0; $pricee=0; $tpricee=0; $c=0;                                                     
                                                        for($i=0;$i<count($name);$i++)
                                                        {  $c++;
                                                            $qntt=$qntt+$qnt[$i];
                                                            $pricee=$pricee+$price[$i]; 
                                                            $tpricee=$tpricee+$tprice[$i];
                                                             $pname=$name[$i];
                                                              if(is_numeric($pname)){
                                                        $productt=mysqli_query($con,"select * from `product` where `product_id`='$pname'");
                                                        $row_prod=mysqli_fetch_assoc($productt); }
                                                          ?>
                                                        <tr>
                                                            <td><?= $c ?></td>
                                                            <td><?php if(is_numeric($pname)){ echo $row_prod['product_name']; } else { echo $pname; } ?></td>
                                                            <td><?= $qnt[$i]; ?> case</td>
                                                            <td><?= $price[$i]."/-"; ?></td>
                                                            <td><?= round($tprice[$i], 2)."/-"; ?></td>
                                                        </tr>
                                                        <?php } 
                                             if($row[free_product]!=""){ ?>
                                                        <tr>
                                                            <td><?= $c+1; ?></td>
                                                            <td><b><?= $row[free_product]." "; ?>(Free)</b></td>
                                                            <td><?= $row[free_qty]; ?> pcs</td>
                                                            <td>0/-</td>
                                                            <td>0/-</td>
                                                        </tr>
                                             <?php } if($row[due]!=""){ ?> 
                                                        <tr>
                                                            <td>Due Bill Amount</td>
                                                            <td><?= $row[free_qnt]; ?> pcs</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td><?= $row[tprice10]."/-"; ?></td>
                                                        </tr>
                                              <?php } if($row[discount]>0){ ?> 
                                                         <tr>
                                                            <td></td>
                                                            <td>Discount Amount</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td><?= $row[discount]."/-"; ?></td>
                                                        </tr> 
                                             <?php } ?>                 
                                                    </tbody>
                                                    <tbody>
                                                        <th style="font-size: 20px; font-weight: 20px;">Total</th>
                                                        <td></td>
                                                        <th style="font-size: 20px; font-weight: 20px;"><?php echo $qntt."cases";
                                                                // if($payment_status!="p"){
                                                                // if($row[due_payment]>0) 
                                                                //     { echo "Pay-". $tpricee - $row[discount] - $row[due_payment]."/-"; 
                                                                //     } 
                                                                // elseif($payment_status=="d") 
                                                                //    { echo "Pay- 0/-";  } }
                                                                 ?>                   
                                                        </th>
                                                        <td><b>Paid-</b><?php  echo $tpricee - $row[due_payment]."/-";
                                                                // if($payment_status!="p"){
                                                                // if($row[due_payment]>0) 
                                                                //     { echo "Due-". $row[due_payment]."/-";
                                                                //     } 
                                                                // elseif ($payment_status=="d") 
                                                                //     { echo "Due- ".round($tpricee - $row[discount])."/-"; }
                                                                //     else { echo "Fully Paid";} } 
                                                                ?>                    
                                                        </td>
                                                        <?php
 $number = $row[due_payment] - $row[discount];
   $no = floor($number);
   $point = round($number - $no, 2) * 100;
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => '', '1' => 'One', '2' => 'Two',
    '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
    '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
    '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
    '13' => 'Thirteen', '14' => 'Fourteen',
    '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
    '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
    '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
    '60' => 'Sixty', '70' => 'Seventy',
    '80' => 'Eighty', '90' => 'Ninety');
   $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;
     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  $points = ($point) ?
    "." . $words[$point / 10] . " " . 
          $words[$point = $point % 10] : '';
  $pointt=($points)? $points . " Paise": null;
 ?> 
                                                        <th style="font-size: 20px; font-weight: 20px;">Due: <?= $row[due_payment] - $row[discount]."/-" ?></th>
                                                        
                                                    </tbody>
                                                </table><br>
  <h6> Amount (in words): * <?php echo $result . "Rupees  " . $pointt; ?></h6> 
   <b><i><u>Previous Due:</u>
             <?php $pre_due=mysqli_query($con,"select invoice_no,due_payment,invoice_date from `report` where `customer`='$row[supplier_id]' and `payment_status`!='f' and `invoice_no`!='$row[invoice_no]'");
             while($row_pre_due=mysqli_fetch_assoc($pre_due)){
            echo "<br>"."Invoice No - $row_pre_due[invoice_no] and due $row_pre_due[due_payment] on date $row_pre_due[invoice_date]"; } ?></i></b>
                                                 <div class="signa">
                                                 	
                    <p><strong><b>Declaration</b></strong><br>
                    	       <i>Inclusive all taxes</i> <br>
                               We declare that this invoice shows the actual<br> price of the goods described and that all particulars are true and correct                               
                     </p>
                    <h4><span>NATIONAL ENTERPRISE</span>Signature</h4>
                                                 </div>                                                
                                            </div> 
                                            </div>
                                            </div>                                              


                                            </div>


                                            <div class="print-div">
                                                <input type="button" class="btn btn-md btn-success" onclick="printDiv('printableArea')" value="Print" />
                                                <input type="button" class="btn btn-md btn-success" onclick="document.location='report.php'" value="Back" />
                                            </div>
                                             
                                            <script>
                                                function printDiv(divName) {
                                                    var printContents = document.getElementById(divName).innerHTML;
                                                    var originalContents = document.body.innerHTML;

                                                    document.body.innerHTML = printContents;

                                                    window.print();

                                                    document.body.innerHTML = originalContents;
                                                }

                                            </script>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ Main Content ] end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->

    <!-- Required Js -->
    <?php include'footer.php'; ?>
    <script src="assets/js/script.js"></script>

</body>

</html>
