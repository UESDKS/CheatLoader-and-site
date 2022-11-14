<?php

require_once '../../controllers/DbController.php';
include_once '../../controllers/UserController.php';
include_once '../../controllers/CheatController.php';

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

$allCheats = getAllCheats();

if (isset($_GET['type'])) {
    if ($_GET['type'] == "create") {
        if( $_GET['cheattype'] == "internal") { 
            сreateNewCheat($_COOKIE['login'], $_GET['name'], $_GET['dll_name'], $_GET['process'], 0, $_GET['injection_type']);
        } else {
            сreateNewCheat($_COOKIE['login'], $_GET['name'], $_GET['dll_name'], $_GET['process'], 1, $_GET['injection_type']);
        }
    } else if ($_GET['type'] == "freeze") {
        freezeCheat($_GET['id']);
    } else if ($_GET['type'] == "unfreeze") {
        unfreezeCheat($_GET['id']);
    } else if ($_GET['type'] == "delete") {
        deleteCheat($_GET['id']);
    }

    return header("Location: ../admin/cheats");
}

if (isset($_POST['uploadDllBtn']) && $_POST['uploadDllBtn'] == 'Upload') {
	$dllPath = $_FILES['govno']['tmp_name'];
	$bytes = file_get_contents($dllPath);
	file_put_contents("../../files/" . $_POST['f'], $bytes);

    echo '<script type="text/JavaScript">
            alert( "File '.$_POST['f'].' success loaded" );
          </script>';
          return header("Location: ../admin/cheats");

}

?>

<!doctype html>
<html lang="en">
<?php include '../content/header.php'; ?>
<title>Cheats | Divan Technologies</title>
<link rel="icon" type="image/png" href="https://divan-technologies.ru/favicon.ico"/>

<body class="theme-dark">
    <div class="wrapper">

        <?php include '../content/navigation.php'; ?>

        <div class="content">
            <div class="container-xl">

                <div class="row row-cards">

                    <div class="col-md-2">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Create new cheat</h3>
                            </div>
                            <div class="card-body">
                                <form action="cheats.php" method="GET">
                                    <div class="mb-3">
                                        <div class="form-group mb-3 ">

                                            <label class="form-label">Cheat Name</label>
                                            <input type="text" name="name" class="form-control" autocomplete="off">
                                        </div>

                                        <div class="form-group mb-3 ">
                                            <label class="form-label">Process Name</label>
                                            <input type="text" name="process" class="form-control" autocomplete="off">
                                        </div>

                                        <div class="form-group mb-3 ">
                                            <label class="form-label">File Name</label>
                                            <input type="text" name="dll_name" class="form-control" autocomplete="off">
                                        </div>

                                        <div class="form-group mb-3 ">
                                            <label class="form-label">Cheat Type</label>
                                            <select class="form-select" name="cheattype">
                                                <option value="<?php echo "internal"; ?>">Internal</option>
                                                <option value="<?php echo "external"; ?>">External</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-3 ">
                                            <label class="form-label">Injection Type</label>
                                            <select class="form-select" name="injection_type">
                                                <option value="<?php echo "default"; ?>">Default</option>
                                                <option value="<?php echo "rwx"; ?>">RWX</option>
                                                <option value="<?php echo "rwnx"; ?>">RW+NX</option>
                                                <option value="<?php echo "x86"; ?>">x86</option>
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" name="type" value="create">
                                    <button type="submit" class="btn btn-primary ms-auto">Create</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-10">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Cheats</h3>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Process</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                            <th>File</th>
                                            <th>Owner</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($userInfo['role'] == "admin") {
                                            if (is_array($allCheats)) {
                                                foreach ($allCheats as $cheat) { ?>
                                                    <tr>
                                                        <td style="font-size: 12px;">
                                                            <?php echo $cheat['id']; ?>
                                                        </td>
                                                        <td style="font-size: 12px;">
                                                            <?php echo $cheat['name']; ?>
                                                        </td>
                                                        <td style="font-size: 12px;">
                                                            <?php echo $cheat['process']; ?>
                                                        </td>
                                                        <td style="font-size: 12px;">
                                                            <?php echo $cheat['status']; ?>
                                                        </td>
                                                        <td style="font-size: 12px;">
                                                            <a href="../admin/cheats.php?type=freeze&id=<?php echo $cheat['id']; ?>" class="badge bg-blue-lt">Freeze</a>

                                                            <a href="../admin/cheats.php?type=unfreeze&id=<?php echo $cheat['id']; ?>" class="badge bg-green-lt">Unfreeze</a>

                                                            <a href="../admin/cheats.php?type=delete&id=<?php echo $cheat['id']; ?>" class="badge bg-red-lt">Delete</a>
                                                        </td>
                                                        <td style="font-size: 12px;">
                                                            <div>
                                                                <form method="POST" action="cheats.php" enctype="multipart/form-data">
                                                                    <input type="file" name="govno" />
                                                                    <input hidden type="text" name="f" value="<?php echo $cheat['filename']; ?>"/>
                                                                    <input type="submit" name="uploadDllBtn" value="Upload" />
                                                                </form>
                                                            </div>

                                                        </td>
                                                        <td style="font-size: 12px;">
                                                            <?php echo $cheat['creator']; ?>
                                                        </td>
                                                    </tr>
                                        <?php
                                                }
                                            }
                                        }
                                        ?>
                                        <?php
                                        if ($userInfo['role'] == "renter") {
                                            if (is_array($allCheats)) {
                                                foreach ($allCheats as $cheat) {
                                                    if ($cheat['creator'] == $_COOKIE['login']) {
                                        ?>
                                                        <tr>
                                                            <td style="font-size: 12px;">
                                                                <?php echo $cheat['id']; ?>
                                                            </td>
                                                            <td style="font-size: 12px;">
                                                                <?php echo $cheat['name']; ?>
                                                            </td>
                                                            <td style="font-size: 12px;">
                                                                <?php echo $cheat['process']; ?>
                                                            </td>
                                                            <td style="font-size: 12px;">
                                                                <?php echo $cheat['status']; ?>
                                                            </td>
                                                            <td style="font-size: 12px;">
                                                                <a href="../admin/cheats.php?type=freeze&id=<?php echo $cheat['id']; ?>" class="badge bg-blue-lt">Freeze</a>

                                                                <a href="../admin/cheats.php?type=unfreeze&id=<?php echo $cheat['id']; ?>" class="badge bg-green-lt">Unfreeze</a>

                                                                <a href="../admin/cheats.php?type=delete&id=<?php echo $cheat['id']; ?>" class="badge bg-red-lt">Delete</a>
                                                            </td>
                                                            <td style="font-size: 12px;">
                                                            <div>
                                                                <form method="POST" action="cheats.php" enctype="multipart/form-data">
                                                                    <input type="file" name="govno" />
                                                                    <input hidden type="text" name="f" value="<?php echo $cheat['filename']; ?>"/>
                                                                    <input type="submit" name="uploadDllBtn" value="Upload" />
                                                                </form>
                                                            </div>

                                                            </td>
                                                            <td style="font-size: 12px;">
                                                                <?php echo $cheat['creator']; ?>
                                                            </td>
                                                        </tr>
                                        <?php       }
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