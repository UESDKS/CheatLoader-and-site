<?php 

$UserCookie = login($_COOKIE['login'], $_COOKIE['password']);
if(!$UserCookie)
    return header('Location: https://google.com');


$userRole = getUserInfo($_COOKIE['login']);

?>


<header class="navbar navbar-expand-md navbar-dark d-print-none">
        <div class="container-xl">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbar-menu">
            <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" href="../admin/index">
                    <span class="nav-link-title">
                      Home
                    </span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../admin/keys" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                    <span class="nav-link-title">
                      All Keys
                    </span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../admin/activated_keys" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                    <span class="nav-link-title">
                      Activated Keys
                    </span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../admin/genkeys" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                    <span class="nav-link-title">
                      Generate Keys
                    </span>
                  </a>
                </li>
                <?php if($userRole['role'] == "admin" || $userRole['role'] == "renter"){ ?>
                <li class="nav-item">
                  <a class="nav-link" href="../admin/cheats">
                    <span class="nav-link-title">
                      Cheats
                    </span>
                  </a>
                </li>
                <?php } ?>
                <?php if($userRole['role'] == "admin"){ ?>
                <li class="nav-item">
                  <a class="nav-link" href="../admin/logs" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                    <span class="nav-link-title">
                      Logs
                    </span>
                  </a>
                </li>
                <?php } ?>
                <?php if($userRole['role'] == "admin"){ ?>
                <li class="nav-item">
                  <a class="nav-link" href="../admin/users" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                    <span class="nav-link-title">
                      Users
                    </span>
                  </a>
                </li>
                <?php } ?>
                <?php if($userRole['role'] == "admin"){ ?>
                <li class="nav-item">
                  <a class="nav-link" href="../admin/loader" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                    <span class="nav-link-title">
                      Loaders
                    </span>
                  </a>
                </li>
                <?php } ?>
                <?php if($userRole['role'] == "admin"){ ?>
                <li class="nav-item">
                  <a class="nav-link" href="../admin/bans" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                    <span class="nav-link-title">
                      Banned HWIDs
                    </span>
                  </a>
                </li>
                <?php } ?>
              </ul>
            </div>
          </div>
        </div>
</header>