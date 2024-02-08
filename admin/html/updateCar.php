<?php
  include_once('includes/loginChecker.php');
  if(isset($_GET['id']) and $_GET['id'] > 0){
    include_once('../../includes/conn.php');
    $id = $_GET['id'];

  // insert car into DB
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    try{
      $title = $_POST['title'];
      $content = $_POST['content'];
      $model = $_POST['model'];
      $automatic = isset($_POST['automatic']);
      $consumption = $_POST['consumption'];
      $options = $_POST['options'];
      $category_id = $_POST['category_id'];
      $price = $_POST['price'];
      $published = isset($_POST['published']);
      if ($_FILES['image']['error'] === UPLOAD_ERR_OK){
        include_once('includes/upload.php');
        $carImage = $image_name;
      }else{
        $carImage = $_POST['oldImage'];
      }
      
      $sql = "UPDATE `cars` SET `title`=?,`image`=?,`content`=?,`model`=?,`automatic`=?,`consumption`=?,`options`=?,`category_id`=?,`published`=?, `price`=? WHERE `id` = ?";
      $stmt = $conn->prepare($sql);
      $stmt->execute([$title, $carImage, $content, $model, $automatic, $consumption, $options, $category_id, $published, $price, $id]);
    }catch(PDOEXCEPTION $e){
      echo $e->getMessage();
    }
  }

   // get current car details
   try{
    $sql = "SELECT * FROM `cars` WHERE id = ?";
    $stmtCar = $conn->prepare($sql);
    $stmtCar->execute([$id]);
    $resultCar = $stmtCar->fetch();
  }catch(PDOEXCEPTION $e){
    echo $e->getMessage();
  }

  // show categories in the select tag
  try{
    $sql = "SELECT * FROM `categories`";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
  }catch(PDOEXCEPTION $e){
    echo $e->getMessage();
  }
}
?>

<!doctype html>
<html lang="en">

<head>
<?php
  $title = "Update Car";
  include_once('includes/head.php');
?>
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
    <?php
      include_once('includes/sideScroller.php');
      include_once('includes/navigation.php');
    ?>
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
    <?php
      include_once('includes/header.php');
    ?>
      <div class="container-fluid">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title fw-semibold mb-4"><?php echo $title ?></h5>
            <form action="" method="post" enctype="multipart/form-data">
              <div class="mb-3">
                <label for="title" class="form-label">Car Title</label>
                <input type="text" class="form-control" id="title" aria-describedby="emailHelp" name="title" value="<?php echo $resultCar['title'] ?>">
              </div>
              <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" name="content"><?php echo $resultCar['content'] ?></textarea>
              </div>
              <div class="mb-3">
                <input type="checkbox" class="form-check-input" id="automatic" name="automatic" <?php echo $resultCar['automatic']? "checked" : "" ?>>
                <label for="automatic" class="form-label">Automatic</label>
              </div>
              <div class="mb-3">
                <label for="consumption" class="form-label">Consumption </label>
                <input type="number" class="form-control" id="consumption" name="consumption" value="<?php echo $resultCar['consumption'] ?>">
              </div>
              <div class="mb-3">
                <label for="price" class="form-label">Price </label>
                <input type="number" class="form-control" id="price" name="price" value="<?php echo $resultCar['price'] ?>">
              </div>
              <div class="mb-3">
                <label for="options" class="form-label">Car Options</label>
                <input type="text" class="form-control" id="options" aria-describedby="emailHelp" name="options" value="<?php echo $resultCar['options'] ?>">
              </div>
              <div class="mb-3">
                <label for="model" class="form-label">Car Model</label>
                <input type="number" class="form-control" id="model" aria-describedby="emailHelp" name="model" value="<?php echo $resultCar['model'] ?>">
              </div>
              <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="active" name="published" <?php echo $resultCar['published']? "checked" : "" ?>>
                <label class="form-check-label" for="published">Published</label>
              </div>
              <div class="mb-3 form-check">
                <label class="form-check-label" for="category_id">Category</label>
                <select name="category_id" id="" class="form-check-select">
                  <?php
                    foreach($result as $category){
                  ?>
                  <option value="<?php echo $category['id'] ?>" <?php echo $resultCar['category_id'] ==  $category['id']? "selected" : "" ?> ><?php echo $category['category'] ?></option>
                  <?php
                    }
                  ?>
                </select>
              </div>
              <div class="mb-3">
                <label for="image" class="form-label">Car Image</label>
                <input type="file" class="form-control" id="image" aria-describedby="emailHelp" name="image">
                <br>
                <img src="../assets/images/<?php echo $resultCar['image'] ?>" alt="<?php echo $resultCar['title'] ?>" style="width:300px;">
              </div>
              <input type="hidden" name="oldImage" value="<?php echo $resultCar['image'] ?>">
              <button type="submit" class="btn btn-primary">Update Car</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
    include_once('includes/footerJS.php');
  ?>
</body>

</html>