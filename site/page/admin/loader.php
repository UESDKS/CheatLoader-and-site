<?php

require_once '../../controllers/DbController.php';
include_once '../../controllers/UserController.php';
include_once '../../controllers/CheatController.php';
include_once '../../controllers/LoaderController.php';

$UserCookie = login($_COOKIE['login'], $_COOKIE['password']);

if (!$UserCookie) {
    return header('Location: /index.php');
} else {
    $userRole = getUserInfo($_COOKIE['login']);
    if ($userRole['role'] == "admin" || $userRole['role'] == "renter") {
        // nothing
    } else {
        return header('Location: index.php');
    }
}

$userInfo = getUserInfo($_COOKIE['login']);

$loaderArray = getAllLoaders();

if (isset($_GET['type'])) {

    if ($_GET['type'] == "create"){
        createNewLoader($_GET['name'], $_GET['file_name']);
    }
    if ($_GET['type'] == "update"){
        setLoaderVersion($_GET['id']);
    }
    return header("Location: ../admin/loader");
}

if (isset($_POST['uploadDllBtn']) && $_POST['uploadDllBtn'] == 'Upload') {
	$dllPath = $_FILES['govno']['tmp_name'];
	$bytes = file_get_contents($dllPath);
	file_put_contents("../../files/" . $_POST['f'], $bytes);

    echo '<script type="text/JavaScript">
            alert( "File '.$_POST['f'].' success loaded" );
          </script>';
          return header("Location: ../admin/loader");

}

?>

<!doctype html>
<html lang="en">
<?php include '../content/header.php'; ?>
<title>Loaders | Divan Technologies</title>
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
                                <h3 class="card-title">Create new loader</h3>
                            </div>
                            <div class="card-body">
                                <form action="loader.php" method="GET">
                                    <div class="mb-3">
                                        <div class="form-group mb-3 ">

                                            <label class="form-label">Loader Name</label>
                                            <input type="text" name="name" class="form-control" autocomplete="off">
                                        </div>

                                        <div class="form-group mb-3 ">
                                            <label class="form-label">File Name</label>
                                            <input type="text" name="file_name" class="form-control" autocomplete="off">
                                        </div>

                                    </div>
                                    <input type="hidden" name="type" value="create">
                                    <button type="submit" class="btn btn-primary ms-auto">Create</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Loaders</h3>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Version</th>
                                            <th>File</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($userInfo['role'] == "admin") {
                                            if (is_array($loaderArray)) {
                                                foreach ($loaderArray as $loader) { ?>
                                                    <tr>
                                                        <td style="font-size: 12px;">
                                                            <?php echo $loader['id']; ?>
                                                        </td>
                                                        <td style="font-size: 12px;">
                                                            <?php echo $loader['name']; ?>
                                                        </td>
                                                        <td style="font-size: 12px;">
                                                            <?php echo $loader['version']; ?>
                                                        </td>
                                                        <td style="font-size: 12px;">
                                                            <div>
                                                            <form method="POST" action="loader.php" enctype="multipart/form-data">
                                                                    <input type="file" name="govno" />
                                                                    <input hidden type="text" name="f" value="<?php echo $loader['file']; ?>"/>
                                                                    <input type="submit" name="uploadDllBtn" value="Upload" />
                                                                </form>
                                                            </div>
                                                        </td>
                                                        <td style="font-size: 12px;">
                                                            <a href="../admin/loader.php?type=update&id=<?php echo $loader['id']; ?>" class="badge bg-green-lt">Update</a>
                                                        </td>
                                                    </tr>
                                        <?php
                                                }
                                            }
                                        }
                                        ?>
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