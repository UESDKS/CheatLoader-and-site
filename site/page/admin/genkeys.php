<?php

require_once '../../controllers/DbController.php';
include_once '../../controllers/UserController.php';
include_once '../../controllers/KeysController.php';
include_once '../../controllers/CheatController.php';

$UserCookie = login($_COOKIE['login'], $_COOKIE['password']);
if (!$UserCookie) {
    return header('Location: /index.php');
}

$userInfo = getUserInfo($_COOKIE['login']);

$KeysRow = getAllKeys();

// костыль ебаный, но так как сроки горят делаю максимально быстро
$keysRow = getAllKeys();
$allCheats = getAllCheats();

if (isset($_GET['type'])) {
    if ($_GET['type'] == "create") {
        for ($i = 0; $i < intval($_GET['amount']); $i++) {
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            generateNewKeys(substr(str_shuffle($permitted_chars), 0, 18), $_COOKIE['login'], $_GET['cheat'], $_GET['time'] * 86400);
        }
        return header("Location: ../admin/genkeys");
    }
}
?>

<!doctype html>
<html lang="en">
<title>Keys | Divan Technologies</title>
<?php include '../content/header.php'; ?>
<link rel="icon" type="image/png" href="https://divan-technologies.ru/favicon.ico"/>

<body class="theme-dark">
    <div class="wrapper">

        <?php include '../content/navigation.php'; ?>
        <div class="content">
            <div class="container-xl">

                <div class="row row-cards">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Create new keys</h3>
                        </div>
                        <div class="card-body">
                            <form action="keys.php" method="GET">
                                <div class="mb-3">
                                    <label class="form-label">Amount</label>
                                    <input type="text" name="amount" class="form-control" autocomplete="off">
                                    <input type="hidden" name="type" value="create" class="form-control">
                                </div>

                                <div class="form-group mb-3 ">
                                    <label class="form-label">Keys for</label>
                                    <select class="form-select" name="cheat">
                                        <?php if (is_array($allCheats))
                                            foreach ($allCheats as $cheats) {
                                                if ($userInfo['role'] == "renter") {
                                                    if ($cheats['creator'] == $_COOKIE['login']) { ?>
                                                    <option value="<?php echo $cheats['id']; ?>"><?php echo $cheats['name']; ?></option>
                                                <?php
                                                    }
                                                } else if ($userInfo['role'] == "seller") {
                                                    if ($userInfo['owner'] == $cheats['creator']) { ?>
                                                    <option value="<?php echo $cheats['id']; ?>"><?php echo $cheats['name']; ?></option>

                                                <?php
                                                    }
                                                } else { ?>
                                                <option value="<?php echo $cheats['id']; ?>"><?php echo $cheats['name']; ?></option>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Days</label>
                                    <input type="text" name="time" class="form-control" autocomplete="off">
                                </div>

                                <button type="submit" class="btn btn-primary ms-auto">Create</button>

                            </form>
                            <div class="form-group mb-3 ">
                                <label class="form-label">Not activated keys</label>
                                <textarea class="form-control" name="example-textarea-input" rows="5" placeholder="Content..">
                                    <?php if (is_array($keysRow))
                                        foreach ($keysRow as $key2) {
                                            if ($key2['status'] == "waiting") {
                                                if ($userInfo['role'] == "renter") {
                                                    if ($key2['creator'] == $_COOKIE['login']) {
                                                        echo "[";
                                                        echo $key2['subscribe'] / 86400;
                                                        echo "d] ";
                                                        echo $key2['key'];
                                                        $cheatInfo = getCheatInfo($key2['cheat']);
                                                        echo " - " . $cheatInfo['name'];
                                                        echo " created by " . $key2['creator'];

                                                        echo "\n";
                                                    }
                                                } else if ($userInfo['role'] == "seller") {
                                                    if ($key2['creator'] == $_COOKIE['login']) {
                                                        echo "[";
                                                        echo $key2['subscribe'] / 86400;
                                                        echo "d] ";
                                                        echo $key2['key'];
                                                        $cheatInfo = getCheatInfo($key2['cheat']);
                                                        echo " - " . $cheatInfo['name'];
                                                        echo "\n";
                                                    }
                                                } else if ($userInfo['role'] == "admin") {
                                                    echo "[";
                                                    echo $key2['subscribe'] / 86400;
                                                    echo "d] ";
                                                    echo $key2['key'];
                                                    $cheatInfo = getCheatInfo($key2['cheat']);
                                                    echo " - " . $cheatInfo['name'];
                                                    echo " created by " . $key2['creator'];

                                                    echo "\n";
                                                }
                                            }
                                        }
                                    ?>
                                </textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../content/footer.php'; ?>
</body>

</html>