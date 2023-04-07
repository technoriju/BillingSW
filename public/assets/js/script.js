$(document).ready(function () {
    var counter = 0;

    $("#addrow").on("click", function () {
        var newRow = $("<tr>");
        var cols = "";

        cols += '<td><select class="form-control" name="name' + counter + '" id="name' + counter + '"><option>test</option></select></td>';
        cols += '<td><input type="text" class="form-control" placeholder="Quantity" name="qnt' + counter + '"/></td>';
        cols += '<td><input type="text" class="form-control" placeholder="Price" name="price' + counter + '"/></td>';        
        cols += '<td><input type="text" class="form-control" placeholder="CGST" name="cgst' + counter + '"/></td>';
        cols += '<td><input type="text" class="form-control" placeholder="SGST" name="sgst' + counter + '"/></td>';
        cols += '<td><input type="text" class="form-control" placeholder="CESS" name="cess' + counter + '"/></td>';
        cols += '<td><input type="text" class="form-control" placeholder="Total price" name="tprice' + counter + '"/></td>';
        

        cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';
        newRow.append(cols);
        $("table.order-list").append(newRow);
        counter++;
    });



    $("table.order-list").on("click", ".ibtnDel", function (event) {
        $(this).closest("tr").remove();       
        counter -= 1
    });


});



function calculateRow(row) {
    var price = +row.find('input[name^="price"]').val();

}

function calculateGrandTotal() {
    var grandTotal = 0;
    $("table.order-list").find('input[name^="price"]').each(function () {
        grandTotal += +$(this).val();
    });
    $("#grandtotal").text(grandTotal.toFixed(2));
}


