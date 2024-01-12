<?php
  include("../../backend/connect_db.php");

  $productId = $_POST['id'];
  $num = $_POST['num'];
  $result = $conn->query("SELECT * FROM product WHERE id = '$productId'");
  $data = $result->fetch_array();

?>


<body>
    <input type="hidden" id="id" value="<?php echo $data['id']; ?>">
    
    <div class="input-group mb-3">
      <span class="input-group-text">รหัสสินค้า</span>
      <input type="text" readonly class="form-control" value="<?php echo $num; ?>" required>
    </div>
    <div class="input-group mb-3">
      <span class="input-group-text">ชื่อ</span>
      <input type="text" class="form-control" id="name" value="<?php echo $data['name']; ?>" required>
    </div>
    <div class="input-group mb-3">
      <span class="input-group-text">รายละเอียด</span>
      <input type="text" class="form-control" id="detail" value="<?php echo $data['description']; ?>" required>
    </div>
    <div class="input-group mb-3">
      <span class="input-group-text">ราคา</span>
      <input type="text" class="form-control" id="price" value="<?php echo $data['price']; ?>" required>
    </div>
    
    <!-- <input type="hidden" class="form-control  my-4" id="img2" value="<?php echo $data['img']; ?>" required> -->
   
    
    <input type="file" class="form-control  my-4" id="img">
    <img width="100%" src="../../frontend_user/image/<?php echo $data['image']; ?>" id="previewImg" alt="">
    <button id="UpdateProduct" class="btn btn-warning form-control my-4">อัพเดต</button>

 
</body>

