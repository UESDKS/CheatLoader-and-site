<?php 

require_once '../../controllers/DbController.php';
include_once '../../controllers/UserController.php';
include_once '../../controllers/BanController.php';

$UserCookie = login($_COOKIE['login'], $_COOKIE['password']);

if(!$UserCookie)
{
   return header('Location: /index.php');
}
else
{
  $userRole = getUserInfo($_COOKIE['login']);
  if($userRole['role'] == "admin" )
  {
    // nothing
  }
  else{
    return header('Location: index.php');
  }
}

$hwidsArray = getAllHwids();

if(isset($_GET['type']))
{
    if($_GET['type'] == "ban")
    {
        banHwid($_GET['hwid'], $_GET['reason']);
    }
    else if($_GET['type'] == "unban")
    {
        unbanHwid($_GET['hwid']);
    }
    return header("Location: ../admin/bans");

}

?>

<!doctype html>
<html lang="en">
<?php include '../content/header.php';?>
<title>Bans | Divan Technologies</title>
<link rel="icon" type="image/png" href="https://divan-technologies.ru/favicon.ico"/>

<body class="theme-dark">
<div class="wrapper">

<?php include '../content/navigation.php';?>

    <div class="content">
        <div class="container-xl">

        <div class="row row-cards">

            <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Manual ban HWID</h3>
                        </div>
                        <div class="card-body">
                        <form action="bans.php" method="GET">
                          <div class="mb-3">
                            <div class="form-group mb-3 ">
                              <label class="form-label">HWID</label>
                              <input type="text" name="hwid" class="form-control"  autocomplete="off">   
                            </div>

                            <div class="form-group mb-3 ">
                              <label class="form-label">Reason</label>
                              <input type="text" name="reason" class="form-control"  autocomplete="off">
                            </div>

                            <input type="hidden" name="type" value="ban">

                          </div>
                          <button type="submit" class="btn btn-primary ms-auto">Ban</button>
                        </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Banned HWID's</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>HWID</th>
                                    <th>Reason</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php 
                                    if (is_array($hwidsArray)) { 
                                        foreach( $hwidsArray as $hwid ) {
                                        ?>
                                    <tr>
                                    <td style="font-size: 12px;">
                                    <?php  echo $hwid['id']; ?>
                                    </td>
                                    <td style="font-size: 12px;">
                                    <?php  echo $hwid['hwid']; ?>
                                    </td>
                                    <td style="font-size: 12px;">
                                    <?php  echo $hwid['reason']; ?>
                                    </td>
                                    <td style="font-size: 12px;">
                                    <a href="../admin/bans.php?type=unban&hwid=<?php echo $hwid['hwid']; ?>" class="badge bg-green-lt">Unban</a>
                                    </td>
                                    </tr>
                                    <?php 
                                        } 
                                    }?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include '../content/footer.php';?>
    </div>
</div>
</body>

</html>