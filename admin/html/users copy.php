<?php
  include_once('includes/loginChecker.php');
?>

<!doctype html>
<html lang="en">

<head>
<?php
  $title = "Users";
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
            <p class="mb-0">This is a sample page </p>
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