<?php

require_once '../../controllers/DbController.php';
include_once '../../controllers/UserController.php';

$UserCookie = login($_COOKIE['login'], $_COOKIE['password']);

if (!$UserCookie) {
  return header('Location: /index.php');
} else {
  $userRole = getUserInfo($_COOKIE['login']);
  if ($userRole['role'] == "admin") {
    // nothing
  } else {
    return header('Location: index.php');
  }
}

$usersArray = getAllUsers();

if (isset($_GET['type'])) {
  if ($_GET['type'] == "create") {
    if ($_GET['role'] == "admin") {
      register($_GET['username'], $_GET['password'], "admin", $_GET['owner']);
    }
    if ($_GET['role'] == "renter") {
      register($_GET['username'], $_GET['password'], "renter", $_GET['owner']);
    }
    if ($_GET['role'] == "seller") {
      register($_GET['username'], $_GET['password'], "seller", $_GET['owner']);
    }
  } else if ($_GET['type'] == "delete") {
    $getUserInfo = getUserInfo($_GET['username']);

    if($getUserInfo['owner'] != "God") {
      deleteUser($_GET['username']);
    } else {
      echo '<script type="text/JavaScript">
      alert( "Нет иди нахуй" );
    </script>';
    return header("Location: ../admin/users");    
  }

  }
  return header("Location: ../admin/users");
}

?>

<!doctype html>
<html lang="en">
<?php include '../content/header.php'; ?>
<title>Users | Divan Technologies</title>
<link rel="icon" type="image/png" href="https://divan-technologies.ru/favicon.ico"/>

<body class="theme-dark">
  <div class="wrapper">

    <?php include '../content/navigation.php'; ?>

    <div class="content">
      <div class="container-xl">

        <div class="row row-cards">

          <div class="col-md-4">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Create new user</h3>
              </div>
              <div class="card-body">
                <form action="users.php" method="GET">
                  <div class="mb-3">
                    <div class="form-group mb-3 ">
                      <label class="form-label">Username</label>
                      <input type="text" name="username" class="form-control" autocomplete="off">
                    </div>

                    <div class="form-group mb-3 ">
                      <label class="form-label">Password</label>
                      <input type="text" name="password" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group mb-3 ">
                      <label class="form-label">Usergroup</label>
                      <select class="form-select" name="role">
                        <option value="<?php echo "admin"; ?>">Administrator</option>
                        <option value="<?php echo "renter"; ?>">Renter</option>
                        <option value="<?php echo "seller"; ?>">Seller</option>
                      </select>
                    </div>
                    <div class="form-group mb-3 ">
                      <label class="form-label">Owner</label>
                      <input type="text" name="owner" class="form-control" autocomplete="off">
                    </div>
                    <input type="hidden" name="type" value="create">

                  </div>
                  <button type="submit" class="btn btn-primary ms-auto">Create</button>
                </form>
              </div>
            </div>
          </div>

          <div class="col-md-8">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users</h3>
              </div>
              <div class="table-responsive">
                <table class="table table-vcenter card-table">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Role</th>
                      <th>Actions</th>
                      <th>Owner</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if (is_array($usersArray)) {
                      foreach ($usersArray as $user) {
                    ?>
                        <tr>
                          <td style="font-size: 12px;">
                            <?php echo $user['id']; ?>
                          </td>
                          <td style="font-size: 12px;">
                            <?php echo $user['username']; ?>
                          </td>
                          <td style="font-size: 12px;">
                            <?php echo $user['role']; ?>
                          </td>
                          <td style="font-size: 12px;">
                          <?php
                              $getUser = getUserInfo($user['username']);
                            if($getUser['role'] != "God") { ?>  
                          <a href="../admin/users.php?type=delete&username=<?php echo $user['username']; ?>" class="badge bg-red-lt">Delete</a>
                          <?php } ?>
                          </td>
                          <td style="font-size: 12px;">
                            <?php echo $user['owner']; ?>
                          </td>
                        </tr>
                    <?php
                      }
                    } ?>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php include '../content/footer.php'; ?>
    </div>
  </div>
</body>

</html>




<!--
            
-->