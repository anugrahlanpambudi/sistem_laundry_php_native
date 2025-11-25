<?php 
    $role_id = $_SESSION['LEVEL_ID'] ?? '';
    $queryLevelMenu = mysqli_query($config, "SELECT * FROM menus JOIN level_menus ON menus.id = level_menus.menu_id WHERE level_id ='$role_id' ORDER BY menus.id DESC");
    $rowLevelMenus = mysqli_fetch_all($queryLevelMenu, MYSQLI_ASSOC);
?>
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        <?php foreach($rowLevelMenus as $rowLevelMenu): ?>
        <li class="nav-item">
            <a class="nav-link collapsed" href="?page=<?php echo $rowLevelMenu['link']?>">
                <i class="<?php echo $rowLevelMenu['icon']?>"></i>
                <span><?php echo $rowLevelMenu['name']?></span>
            </a>
        </li><!-- End Dashboard Nav -->
        <?php endforeach?>



    </ul>

</aside><!-- End Sidebar-->
