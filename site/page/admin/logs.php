<?php

require_once '../../controllers/DbController.php';
include_once '../../controllers/UserController.php';
include_once '../../controllers/LogsController.php';

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

$logsArray = getAllLogs();
?>

<!doctype html>
<html lang="en">

<?php include '../content/header.php'; ?>
<title>Logs | Divan Technologies</title>
<link rel="icon" type="image/png" href="https://divan-technologies.ru/favicon.ico"/>

<body class="theme-dark">
    <div class="wrapper">

        <?php include '../content/navigation.php'; ?>

        <div class="content">
            <div class="container-xl">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">All logs</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>Key</th>
                                        <th>HWID</th>
                                        <th>Message</th>
                                        <th>IP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (is_array($logsArray)) foreach ($logsArray as $logs) { ?>
                                        <tr>
                                            <td style="font-size: 12px;">
                                                <?php echo $logs['key']; ?>
                                            </td>
                                            <td style="font-size: 12px;">
                                                <?php echo $logs['hwid']; ?>
                                            </td>
                                            <td style="font-size: 12px;">
                                                <?php echo  $logs['message'] ?>
                                            </td>
                                            <td style="font-size: 12px;">
                                                <?php echo  $logs['ip'] ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
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