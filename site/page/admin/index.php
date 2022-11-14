<?php

require_once '../../controllers/DbController.php';
include_once '../../controllers/UserController.php';
include_once '../../controllers/KeysController.php';
include_once '../../controllers/CheatController.php';


$UserCookie = login($_COOKIE['login'], $_COOKIE['password']);

if (!$UserCookie) {
    return header('Location: /index.php');
}


?>

<!doctype html>
<html lang="en">

<?php include '../content/header.php'; ?>
<title>Home | Divan Technologies</title>
<link rel="icon" type="image/png" href="https://divan-technologies.ru/favicon.ico"/>

<body class="theme-dark">
    <div class="wrapper">

        <?php include '../content/navigation.php'; ?>

        <div class="content">
            <div class="container-xl">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Statistics</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>Keys</th>
                                        <th>Activated Keys</th>
                                        <th>Cheats</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="font-size: 12px;">
                                            <?php echo getKeysCount(); ?>
                                        </td>
                                        <td style="font-size: 12px;">
                                            <?php echo getActivatedKeysCount(); ?>
                                        </td>
                                        <td style="font-size: 12px;">
                                            <?php echo getCheatsCount(); ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <?php include '../content/footer.php'; ?>
        </div>
    </div>
</body>

</html>