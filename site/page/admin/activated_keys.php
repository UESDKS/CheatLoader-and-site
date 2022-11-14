<?php 

require_once '../../controllers/DbController.php';
include_once '../../controllers/UserController.php';
include_once '../../controllers/KeysController.php';
include_once '../../controllers/CheatController.php';

$UserCookie = login($_COOKIE['login'], $_COOKIE['password']);
if(!$UserCookie){
    return header('Location: /index.php');
}

$userInfo = getUserInfo($_COOKIE['login']);

$KeysRow = getAllKeys();

// костыль ебаный, но так как сроки горят делаю максимально быстро
$allCheats = getAllCheats();

if(isset($_GET['type']))
{
    if($_GET['type'] == "delete")
    {
        deleteKey($_GET['id']);
        return header("Location: ../admin/keys");
    }
    else if($_GET['type'] == "reset")
    {
        resetHwidOnKey($_GET['key']);
        return header("Location: ../admin/keys");
    }
    else if($_GET['type'] == "ban")
    {
        banKey($_GET['key'], "banned by ".$_COOKIE['login']." from admin panel");
        return header("Location: ../admin/keys");
    }
    else if($_GET['type'] == "unban")
    {
        unbanKey($_GET['key']);
        return header("Location: ../admin/keys");
    }
    else if($_GET['type'] == "search")
    {
        $KeysRow = getKeyData($_GET['key']);
    }

}
?>

<!doctype html>
<html lang="en">
<title>Keys | Divan Technologies</title>
<?php include '../content/header.php';?>
<link rel="icon" type="image/png" href="https://divan-technologies.ru/favicon.ico"/>

<body class="theme-dark">
<div class="wrapper">

<?php include '../content/navigation.php';?>
    <div class="content">
        <div class="container-xl">

        <div class="row row-cards">
        <div class="col-12">
                <div class="card card-sm">
                    <div class="card-body">
                        <form role="form" method="GET" action="keys.php">
                            <div class="row g-2">
                                <div class="col">
                                    <input type="text" class="form-control" name="key" placeholder="Key to find" autocomplete="off">
                                    <input type="hidden" class="form-control" name="type" value="search" placeholder="Find Key">
                                </div>
                                <div class="col-auto">
                                    <button href="#" type="submit" class="btn btn-dark btn-icon" aria-label="Button">Find Key</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Activated keys</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Key</th>
                                    <th>HWID</th>
                                    <th>Days</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                    <th>Game</th>
                                    <th>Creator</th>
                                    <th>First IP</th>
                                    <th>Last IP</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if ($userInfo['role'] == "admin"){
                                        if (!isset($_GET['type'])){
                                                if(is_array($KeysRow)) {
                                                    foreach($KeysRow as $key) 
                                                    { if($key['status'] == "activated") { ?>
                                        <tr>
                                        <td style="font-size: 12px;">
                                            <?php  echo $key['id']; ?>
                                        </td>
                                        <td style="font-size: 12px;">
                                            <?php echo $key['key']; ?>
                                        </td>
                                        <td style="font-size: 12px;">
                                            <?php echo $key['hwid']; ?>
                                        </td>
                                        <td style="font-size: 12px;">
                                            <?php echo $key['subscribe'] / 86400; ?>
                                        </td>
                                        <td style="font-size: 12px;">
                                            <?php if($key['status'] == "waiting") { ?>
                                                <span class="badge bg-yellow-lt">Waiting</span>
                                            <?php } ?>
                                            <?php if($key['status'] == "banned") { ?>
                                                <span class="badge bg-red-lt">Banned</span>
                                            <?php } ?>
                                            <?php if($key['status'] == "activated") { ?>
                                                <span class="badge bg-green-lt">activated</span>
                                            <?php } ?>
                                        </td>
                                        
                                        <td style="font-size: 12px;">
                                        <a href="../admin/keys.php?type=delete&id=<?php echo $key['id']; ?>" class="badge bg-red-lt">Delete</a>
                                        <a href="../admin/keys.php?type=reset&key=<?php echo $key['key']; ?>" class="badge bg-yellow-lt">Reset HWID</a>
                                        <?php if( $key['status'] == "banned") { ?>
                                        <a href="../admin/keys.php?type=unban&key=<?php echo $key['key']; ?>" class="badge bg-green-lt">Unban</a>
                                        <?php } else { ?>
                                        <a href="../admin/keys.php?type=ban&key=<?php echo $key['key']; ?>" class="badge bg-blue-lt">Ban</a>
                                        <?php } ?>
                                        </td>
                                        <td style="font-size: 12px;">
                                        <?php $cheatInfo = getCheatInfo($key['cheat']); echo $cheatInfo['name']; ?>
                                        </td>
                                        <td style="font-size: 12px;">
                                        <?php echo $key['creator']; ?>

                                        </td>
                                        <td style="font-size: 12px;">
                                        <?php echo $key['firstip']; ?>

                                        </td>
                                        <td style="font-size: 12px;">
                                        <?php echo $key['lastip']; ?>

                                        </td>
                                    <?php } } 
                                    }
                                ?>
                                </tr>
                                <?php } else { ?>
                                        <td style="font-size: 12px;">
                                            <?php  echo $KeysRow['id']; ?>
                                        </td>
                                        <td style="font-size: 12px;">
                                            <?php echo $KeysRow['key']; ?>
                                        </td>
                                        <td style="font-size: 12px;">
                                            <?php echo $KeysRow['hwid']; ?>
                                        </td>
                                        <td style="font-size: 12px;">
                                            <?php echo $KeysRow['subscribe'] / 86400; ?>
                                        </td>
                                        <td style="font-size: 12px;">
                                            <?php if($KeysRow['status'] == "waiting") { ?>
                                                <span class="badge bg-yellow-lt">Waiting</span>
                                            <?php } ?>
                                            <?php if($KeysRow['status'] == "banned") { ?>
                                                <span class="badge bg-red-lt">Banned</span>
                                            <?php } ?>
                                            <?php if($KeysRow['status'] == "activated") { ?>
                                                <span class="badge bg-green-lt">activated</span>
                                            <?php } ?>
                                        </td>
                                        
                                        <td style="font-size: 12px;">
                                        <a href="../admin/keys.php?type=delete&id=<?php echo $KeysRow['id']; ?>" class="badge bg-red-lt">Delete</a>
                                        <a href="../admin/keys.php?type=reset&key=<?php echo $KeysRow['key']; ?>" class="badge bg-yellow-lt">Reset HWID</a>

                                        <?php if( $KeysRow['status'] == "banned") { ?>
                                        <a href="../admin/keys.php?type=unban&key=<?php echo $KeysRow['key']; ?>" class="badge bg-green-lt">Unban</a>
                                        <?php } else { ?>
                                        <a href="../admin/keys.php?type=ban&key=<?php echo $KeysRow['key']; ?>" class="badge bg-blue-lt">Ban</a>
                                        <?php } ?>

                                        </td>
                                        <td style="font-size: 12px;">
                                        <?php $cheatInfo = getCheatInfo($KeysRow['cheat']); echo $cheatInfo['name']; ?>
                                        </td>
                                        <td style="font-size: 12px;">
                                        <?php echo $KeysRow['creator']; ?>

                                        </td>
                                        <td style="font-size: 12px;">
                                        <?php echo $KeysRow['firstip']; ?>

                                        </td>
                                        <td style="font-size: 12px;">
                                        <?php echo $KeysRow['lastip']; ?>

                                        </td>
                                <?php } 
                                } else if ($userInfo['role'] == "renter" ) {
                                   if (!isset($_GET['type'])){
                                         if(is_array($KeysRow)) {
                                            foreach($KeysRow as $key) {  
                                                if($key['creator'] == $_COOKIE['login'])
                                                { if($key['status'] == "activated") { ?>
                                        <tr>
                                        <td style="font-size: 12px;">
                                            <?php  echo $key['id']; ?>
                                        </td>
                                        <td style="font-size: 12px;">
                                            <?php echo $key['key']; ?>
                                        </td>
                                        <td style="font-size: 12px;">
                                            <?php echo $key['hwid']; ?>
                                        </td>
                                        <td style="font-size: 12px;">
                                            <?php echo $key['subscribe'] / 86400; ?>
                                        </td>
                                        <td style="font-size: 12px;">
                                            <?php if($key['status'] == "waiting") { ?>
                                                <span class="badge bg-yellow-lt">Waiting</span>
                                            <?php } ?>
                                            <?php if($key['status'] == "banned") { ?>
                                                <span class="badge bg-red-lt">Banned</span>
                                            <?php } ?>
                                            <?php if($key['status'] == "activated") { ?>
                                                <span class="badge bg-green-lt">activated</span>
                                            <?php } ?>
                                        </td>
                                        <td style="font-size: 12px;">
                                        <a href="../admin/keys.php?type=delete&id=<?php echo $key['id']; ?>" class="badge bg-red-lt">Delete</a>
                                        <a href="../admin/keys.php?type=reset&key=<?php echo $key['key']; ?>" class="badge bg-yellow-lt">Reset HWID</a>
                                        <?php if( $key['status'] == "banned") { ?>
                                        <a href="../admin/keys.php?type=unban&key=<?php echo $key['key']; ?>" class="badge bg-green-lt">Unban</a>
                                        <?php } else { ?>
                                        <a href="../admin/keys.php?type=ban&key=<?php echo $key['key']; ?>" class="badge bg-blue-lt">Ban</a>
                                        <?php } ?>
                                        </td>

                                        <td style="font-size: 12px;">
                                        <?php $cheatInfo = getCheatInfo($key['cheat']); echo $cheatInfo['name']; ?>
                                        </td>
                                        <td style="font-size: 12px;">
                                        <?php echo $key['creator']; ?>

                                        </td>
                                        <td style="font-size: 12px;">
                                        <?php echo $key['firstip']; ?>

                                        </td>
                                        <td style="font-size: 12px;">
                                        <?php echo $key['lastip']; ?>

                                        </td>
                                    <?php } } 
                                        }
                                    }
                                ?>
                                </tr>
                                <?php } else { 
                                    if($userInfo['owner'] == $_COOKIE['login']) {?>
                                    <td style="font-size: 12px;">
                                            <?php  echo $KeysRow['id']; ?>
                                        </td>
                                        <td style="font-size: 12px;">
                                            <?php echo $KeysRow['key']; ?>
                                        </td>
                                        <td style="font-size: 12px;">
                                            <?php echo $KeysRow['subscribe'] / 86400; ?>
                                        </td>
                                        <td style="font-size: 12px;">
                                            <?php if($KeysRow['status'] == "waiting") { ?>
                                                <span class="badge bg-green-lt">Waiting</span>
                                            <?php } ?>
                                        </td>
                                        
                                        <td style="font-size: 12px;">
                                        <a href="../admin/keys.php?type=delete&id=<?php echo $KeysRow['id']; ?>" class="badge bg-red-lt">Delete</a>
                                        <a href="../admin/keys.php?type=reset&key=<?php echo $KeysRow['key']; ?>" class="badge bg-yellow-lt">Reset HWID</a>
                                        <?php if( $KeysRow['status'] == "banned") { ?>
                                        <a href="../admin/keys.php?type=unban&key=<?php echo $KeysRow['key']; ?>" class="badge bg-green-lt">Unban</a>
                                        <?php } else { ?>
                                        <a href="../admin/keys.php?type=ban&key=<?php echo $KeysRow['key']; ?>" class="badge bg-blue-lt">Ban</a>
                                        <?php } ?>                                
                                         
                                        </td>
                                        <td style="font-size: 12px;">
                                        <?php $cheatInfo = getCheatInfo($KeysRow['cheat']); echo $cheatInfo['name']; ?>
                                        </td>
                                        <td style="font-size: 12px;">
                                        <?php echo $KeysRow['creator']; ?>

                                        </td>
                                        <td style="font-size: 12px;">
                                        <?php echo $KeysRow['firstip']; ?>

                                        </td>
                                        <td style="font-size: 12px;">
                                        <?php echo $KeysRow['lastip']; ?>

                                        </td>
                                    <?php } }?>
                                     <?php  
                                    } else if ($userInfo['role'] == "seller" ) {
                                        if (!isset($_GET['type'])){
                                            if(is_array($KeysRow)) {
                                                foreach($KeysRow as $key) { if($key['creator'] == $_COOKIE['login']) { if($key['status'] == "activated") { ?>
                                            <tr>
                                            <td style="font-size: 12px;">
                                                <?php  echo $key['id']; ?>
                                            </td>
                                            <td style="font-size: 12px;">
                                                <?php echo $key['key']; ?>
                                            </td>
                                            <td style="font-size: 12px;">
                                            <?php echo $key['hwid']; ?>
                                            </td>
                                            <td style="font-size: 12px;">
                                                <?php echo $key['subscribe'] / 86400; ?>
                                            </td>
                                            <td style="font-size: 12px;">
                                                <?php if($key['status'] == "waiting") { ?>
                                                    <span class="badge bg-yellow-lt">Waiting</span>
                                                <?php } ?>
                                                <?php if($key['status'] == "banned") { ?>
                                                    <span class="badge bg-red-lt">Banned</span>
                                                <?php } ?>
                                                <?php if($key['status'] == "activated") { ?>
                                                    <span class="badge bg-green-lt">activated</span>
                                                <?php } ?>
                                            </td>
                                            <td style="font-size: 12px;">
                                            <a href="../admin/keys.php?type=reset&key=<?php echo $key['key']; ?>" class="badge bg-yellow-lt">Reset HWID</a>
                                            <?php if( $key['status'] == "banned") { ?>
                                            <a href="../admin/keys.php?type=unban&key=<?php echo $key['key']; ?>" class="badge bg-green-lt">Unban</a>
                                            <?php } else { ?>
                                            <a href="../admin/keys.php?type=ban&key=<?php echo $key['key']; ?>" class="badge bg-blue-lt">Ban</a>
                                            <?php } ?>         
                                            </td>
                                            <td style="font-size: 12px;">
                                            <?php $cheatInfo = getCheatInfo($key['cheat']); echo $cheatInfo['name']; ?>
                                            </td>
                                            <td style="font-size: 12px;">
                                            <?php echo $key['creator']; ?>

                                            </td>
                                            <td style="font-size: 12px;">
                                        <?php echo $key['firstip']; ?>

                                        </td>
                                        <td style="font-size: 12px;">
                                        <?php echo $key['lastip']; ?>

                                        </td>
                                        <?php } } 
                                        }
                                    }
                                    ?>
                                    </tr>
                                    <?php } else {  if($KeysRow['creator'] == $_COOKIE['login']) {?>
                                        <td style="font-size: 12px;">
                                                <?php  echo $KeysRow['id']; ?>
                                            </td>
                                            <td style="font-size: 12px;">
                                                <?php echo $KeysRow['key']; ?>
                                            </td>
                                            <td style="font-size: 12px;">
                                            <?php echo $KeysRow['hwid']; ?>
                                            </td>
                                            <td style="font-size: 12px;">
                                                <?php echo $KeysRow['subscribe'] / 86400; ?>
                                            </td>
                                            <td style="font-size: 12px;">
                                                <?php if($KeysRow['status'] == "waiting") { ?>
                                                    <span class="badge bg-yellow-lt">Waiting</span>
                                                <?php } ?>
                                                <?php if($KeysRow['status'] == "banned") { ?>
                                                    <span class="badge bg-red-lt">Banned</span>
                                                <?php } ?>
                                                <?php if($KeysRow['status'] == "activated") { ?>
                                                    <span class="badge bg-green-lt">activated</span>
                                                <?php } ?>
                                            </td>
                                            <td style="font-size: 12px;">
                                            <a href="../admin/keys.php?type=reset&key=<?php echo $KeysRow['key']; ?>" class="badge bg-yellow-lt">Reset HWID</a>
                                            <?php if( $KeysRow['status'] == "banned") { ?>
                                            <a href="../admin/keys.php?type=unban&key=<?php echo $KeysRow['key']; ?>" class="badge bg-green-lt">Unban</a>
                                            <?php } else { ?>
                                            <a href="../admin/keys.php?type=ban&key=<?php echo $KeysRow['key']; ?>" class="badge bg-blue-lt">Ban</a>
                                            <?php } ?>   
                                            </td>
                                            <td style="font-size: 12px;">
                                            <?php $cheatInfo = getCheatInfo($KeysRow['cheat']); echo $cheatInfo['name']; ?>
                                            </td>
                                            <td style="font-size: 12px;">
                                            <?php echo $KeysRow['creator']; ?>

                                            </td>
                                            <td style="font-size: 12px;">
                                            <?php echo $key['firstip']; ?>

                                            </td>
                                            <td style="font-size: 12px;">
                                            <?php echo $key['lastip']; ?>

                                            </td>
                                        <?php } 
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
