<?php  
    $productId = $_POST['productId'];
?>
<input type="number" value="0" min="0" max="10" class="form-control" id="qtyOrder">
<button class="form-control btn btn-success mt-3" id="btnSubmitOrder" data-productid="<?php echo $productId ?>">เพิ่มรายการ</button>