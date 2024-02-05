<?php
  // check if user logged
  include_once('includes/loginChecker.php');

  // db connection
  include_once('../../includes/conn.php');

  // get id if found or redirect to home page
  if(isset($_GET['id'])){
    $id = $_GET['id'];
  }else{
    header('location: users.php');
    die();
  }

  // update data
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    try{
      $sql = "UPDATE `users` SET `name`=?,`password`=?,`email`=?,`active`=? WHERE `id` =?";
      $name = $_POST['name'];
      $email = $_POST['email'];
      if(empty($_POST['password'])){
        $password = $_POST['oldPassword'];
      }else{
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
      }

      $active = isset($_POST['active']);
      
      $stmt = $conn->prepare($sql);
      $stmt->execute([$name, $password, $email, $active, $id]);
    }catch(PDOEXCEPTION $e){
      echo $e->getMessage();
    }
  }

  // retrieve data and add values to the form
  try{    
    $sql = "SELECT * FROM `users` WHERE `id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $result = $stmt->fetch();
    $name = $result['name'];
    $password = $result['password'];
    $email = $result['email'];
    $active = $result['active'] ? "checked" : "";

  }catch(PDOEXCEPTION $e){
    echo $e->getMessage();
  }

?>

<!doctype html>
<html lang="en">

<head>
<?php
  $title = "Update User";
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

            <form action="" method="post">
              <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" aria-describedby="emailHelp" name="name" value="<?php echo $name ?>">
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" value="<?php echo $email ?>">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="password">
              </div>
              <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="active" name="active" <?php echo $active ?> >
                <label class="form-check-label" for="active">Active</label>
              </div>
              <input type="hidden" name="oldPassword" value="<?php echo $password ?>">
              <button type="submit" class="btn btn-primary">Update</button>
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