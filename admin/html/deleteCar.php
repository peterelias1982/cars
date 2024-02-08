<?php
  include_once('includes/loginChecker.php');
  if(isset($_GET['id']) and $_GET['id'] > 0){
    include_once('../../includes/conn.php');
    try{
      $id = $_GET['id'];
      
      $sql = "DELETE FROM `cars` WHERE `id` = ?";
      $stmt = $conn->prepare($sql);
      $stmt->execute([$id]);
      $msg = "Deleted Successfuly";
      $alert = "alert-success";
    }catch(PDOEXCEPTION $e){
      $msg = "Error: ". $e->getMessage();
      $alert = "alert-danger";
    }
  }
?>

<!doctype html>
<html lang="en">

<head>
<?php
  $title = "Delete Car";
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

            <div class="alert <?php echo $alert ?>">
              <?php echo $msg ?>
            </div>

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