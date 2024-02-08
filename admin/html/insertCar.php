<?php
  include_once('includes/loginChecker.php');
  include_once('../../includes/conn.php');
  // show categories in the select tag
  try{
    $sql = "SELECT * FROM `categories`";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
  }catch(PDOEXCEPTION $e){
    echo $e->getMessage();
  }

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
      include_once('includes/upload.php');
      
      $sql = "INSERT INTO `cars`(`title`, `image`, `content`, `model`, `automatic`, `consumption`, `options`, `category_id`, `published`, `price`) VALUES (?,?,?,?,?,?,?,?,?,?)";
      $stmt = $conn->prepare($sql);
      $stmt->execute([$title, $image_name, $content, $model, $automatic, $consumption, $options, $category_id, $published, $price]);
    }catch(PDOEXCEPTION $e){
      echo $e->getMessage();
    }
  }
?>

<!doctype html>
<html lang="en">

<head>
<?php
  $title = "Insert Car";
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
                <input type="text" class="form-control" id="title" aria-describedby="emailHelp" name="title">
              </div>
              <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" name="content"></textarea>
              </div>
              <div class="mb-3">
                <input type="checkbox" class="form-check-input" id="automatic" name="automatic">
                <label for="automatic" class="form-label">Automatic</label>
              </div>
              <div class="mb-3">
                <label for="consumption" class="form-label">Consumption </label>
                <input type="number" class="form-control" id="consumption" name="consumption">
              </div>
              <div class="mb-3">
                <label for="price" class="form-label">Price </label>
                <input type="number" class="form-control" id="price" name="price">
              </div>
              <div class="mb-3">
                <label for="options" class="form-label">Car Options</label>
                <input type="text" class="form-control" id="options" aria-describedby="emailHelp" name="options">
              </div>
              <div class="mb-3">
                <label for="model" class="form-label">Car Model</label>
                <input type="number" class="form-control" id="model" aria-describedby="emailHelp" name="model">
              </div>
              <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="active" name="published">
                <label class="form-check-label" for="published">Published</label>
              </div>
              <div class="mb-3 form-check">
                <label class="form-check-label" for="category_id">Category</label>
                <select name="category_id" id="" class="form-check-select">
                  <option value="">Please Select car</option>
                  <?php
                    foreach($result as $category){
                  ?>
                  <option value="<?php echo $category['id'] ?>"><?php echo $category['category'] ?></option>
                  <?php
                    }
                  ?>
                </select>
              </div>
              <div class="mb-3">
                <label for="image" class="form-label">Car Image</label>
                <input type="file" class="form-control" id="image" aria-describedby="emailHelp" name="image">
              </div>
              <button type="submit" class="btn btn-primary">Insert Car</button>
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