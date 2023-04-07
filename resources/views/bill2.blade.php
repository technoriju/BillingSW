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
    <style>
        #panel {
            padding: 10px;
            display: none;
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
                            <?php
                              if(isset($_POST[invoice_no]))
                              {
                                $invoice_no=$_POST[invoice_no];
                                $invoice_date=$_POST[invoice_date];
                                $customer=$_POST[customer];
                                $payment_status=implode(', ',$_POST[payment_status]);
                                $totalamt=$_POST[totalamt];
                                $due_payment=$_POST[due_payment];
                                if(($payment_status=="f") || ($totalamt==$due_payment)){ $rdue=$totalamt; } else { $rdue=$due_payment; }
                                
                                mysqli_query($con,"insert into `report2` values('','$invoice_no','$rdue','$invoice_date')");
                                if(($payment_status=="f") || ($totalamt==$due_payment)){

                                if($payment_status=="f"){ $due_payment=$totalamt; }
                                $abc=mysqli_query($con,"update `report` set `payment_status`='f',`due_payment`=`due_payment`-'$due_payment' where `invoice_no`='$invoice_no'");

                                } else {

                                $abc=mysqli_query($con,"update `report` set `due_payment`=`due_payment`-'$due_payment' where `invoice_no`='$invoice_no'"); 
                                }
                                if($abc){
                                echo "<script>              
                                          swal({
                                                title: 'Great job!',
                                                text: 'Payment Successfull',
                                                type: 'success'
                                            }).then(function() {
                                                window.location = 'report.php?page=1';
                                            });
                                      </script>";
                              } }
                            ?>
                            <div class=" ">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <form id="idForm" action="bill2.php" method="post">
                                            <div class="card-header">
                                                <div class="row">
 <?php
                              if($_GET[view])
                              {  
    $pay=mysqli_query($con,"select `id`,`invoice_no`,`invoice_date`,`name`,`qnt`,`price`,`tprice`,`discount`,`free_product`,`free_qty`,`due_payment`,`supplier_id`,`supplier_name`,`supplier_phone`, `supplier_email`,`supplier_gst`,`supplier_address` from `report` INNER JOIN `add-supplier` ON `report`.`customer`=`add-supplier`.`supplier_id` where `report`.`id`='$_GET[view]'");                         
    $row_pay=mysqli_fetch_assoc($pay);
                              }
                              
                            ?>
                                                    <div class="col-sm-3">
                                                        <h5>Add Bill</h5>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="input-group">
                                                            <select name="customer" id="customer" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="basic-addon2" required="">
                                                                <option value="">Select any Customer</option>
                                                                <?php          
                                                                echo "<option value='$row_pay[supplier_id]' selected>$row_pay[supplier_name]</option>";?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="input-group">                                
                                                            <input type="text" id="invoice_no" name="invoice_no" class="form-control" placeholder="Invoice No" aria-label="Invoice No" aria-describedby="basic-addon2" required="" value="<?php echo $row_pay[invoice_no]; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="input-group">
                                                            <input type="date" id="invoice_date" required name="invoice_date" value="<?php echo date("Y-m-d"); ?>" class="form-control" aria-describedby="basic-addon2">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">                                               
                                                <table id="myTable" class="bill-table table order-list">
                                                    <thead>
                                                        <tr>
                                                            <td>Product Name</td>
                                                            <td>Quantity</td>
                                                            <td>Rate</td> 
                                                            <td>Total Amount</td>
                                                            <td></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="countrow">
                                                        <?php
                                                        $name=explode(",", $row_pay[name]);
                                                        $qnt=explode(",", $row_pay[qnt]);
                                                        $price=explode(",", $row_pay[price]);                   
                                                        $tprice=explode(",", $row_pay[tprice]);
                                                        $tpricee=0;                                                      
                                                        for($i=0;$i<count($name);$i++)
                                                        { 
                                                            $name_pro=$name[$i];
                                                            if(is_numeric($name_pro)){
                                                            $productt=mysqli_query($con,"select * from `product` where `product_id`='$name_pro'");
                                                            $row_prod=mysqli_fetch_assoc($productt); }
                                                            $tpricee=$tpricee+$tprice[$i]; ?> 
                                                        <tr>
                                                            <td><select class="form-control" name="name[]" id="name0" required="" onchange="Total(this.value,getAttribute('id'));">
                                                                    <option value="">Select any Product</option>
                                                                <option selected><?php if(is_numeric($name_pro)){ echo $row_prod['product_name']; } else { echo $name_pro; } ?></option>
                                                                </select>
                                                            </td>
                                                            <td><input type="text" name="qnt[]" id="qnt0" placeholder="Quantity" class="form-control" onkeyup="Calcu(this.value,this.id);" value="<?=  $qnt[$i] ?>" /></td>
                                                            <td><input type="text" name="price[]" id="price0" placeholder="Price" class="form-control" value="<?= $price[$i]; ?>" /></td> 
                                                            <td><input type="text" name="tprice[]" id="tprice0" placeholder="Total Amount" class="form-control" value="<?= round($tprice[$i], 2); ?>" /></td>
                                                            <td><a class="deleteRow"></a>
                                                                <input type="button" class="btn btn-md btn-success" id="addrow" value="Add Row" />
                                                            </td>
                                                        </tr>
                                                      <?php } ?>
                                                    </tbody>
                                                </table>
                                                <table class="table discount-table">
                                                    <tbody>
                                                        <?php if($row_pay[free_name]) { ?>
                                                        <tr id="sh11">
                                                            <td><select name="free_name" placeholder="Product Name" class="form-control">
                                                                    <option value="">Choose Free Product</option>
                                                                    <?php                
                                                                    echo "<option selected>$row_pay[free_name]</option>";
                                                                    ?>
                                                                </select>
                                                            </td>
                                                            <td><input type="text" name="free_qnt" placeholder="Quantity" class="form-control" /></td>
                                                            <td><input type="text" name="" placeholder="00" class="form-control" value="<?= $row_pay[free_qty] ?>" /></td>
                                                        </tr><?php } 
                                                         if($row_pay[discount]) {
                                                        ?>
                                                        <tr id="sh12">
                                                            <td><input type="text" value="Discount" class="form-control" /></td>
                                                            <td></td>
                                                            <td><input type="text" name="discount" id="discounts" placeholder="Amount" class="form-control" onkeyup="Calcu(this.value,this.id);" value="<?= $row_pay[discount] ?>"/></td>
                                                        </tr>
                                                        <?php } $paid=round($tpricee-$row_pay[due_payment]-$row_pay[discount]); 
                                                        if($paid>0){?>
                                                            <tr id="sh12">
                                                            <td><input type="text" value="Paid" class="form-control" /></td>
                                                            <td></td>
                                                            <td><input type="text" name="discount" id="discounts" placeholder="Amount" class="form-control" onkeyup="Calcu(this.value,this.id);" value="<?= $paid ?>"/></td>
                                                        </tr>
                                                    <?php } ?>
                                                        <tr>
                                                            <td><input type="text" value="Due" class="form-control" /></td>
                                                            <td></td>
                                                            <td><input type="text" name="totalamt" id="totalamt" placeholder="Total Amount" class="form-control" value="<?= $row_pay[due_payment] ?>"/></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>



                                            <div class="text-center mb-5">
                                                <button class="btn btn-md btn-info" name="payment_status[]" value="f" id="button1" onclick="return Fullpayment();">Full Payment</button>

                                                <button class="btn btn-md btn-warning" id="button2">Step Payment</button>                                              

                                                <div id="panel" class="w-100">

                                                    <div class="pice-form">
                                                        <input type="text" name="due_payment" class="form-control w-25" placeholder="Price" value="0">
                                                        <button name="payment_status[]" value="s" class="btn btn-md btn-success" onclick="return Fullpayment();">Submit</button>
                                                    </div>

                                                </div>
                                            </div>
                                        </form>

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
    <!-- <script src="assets/js/script.js"></script>  -->

    <script> 
       


        $("#button2").on('click', function(e) {
            e.preventDefault();
            $("#panel").slideToggle("slow");
        });

        function Fullpayment() {
            var x = confirm("Are you sure want to Submit?");
            if (x) {
                return true;
            } else {
                return false;
            }
        }        

    </script>
</body>

</html>
