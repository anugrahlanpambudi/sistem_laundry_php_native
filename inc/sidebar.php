<?php 
$level_id = $_SESSION['LEVEL_ID'] ?? '';

$queryLevelMenu = mysqli_query(
    $config,
    "SELECT menus.*, level_menus.level_id 
     FROM menus 
     JOIN level_menus ON menus.id = level_menus.menu_id 
     WHERE level_menus.level_id ='$level_id' 
     ORDER BY menus.`order` ASC"
);

$rowLevelMenus = mysqli_fetch_all($queryLevelMenu, MYSQLI_ASSOC);

// Debug jika tidak muncul
// if(!$queryLevelMenu){ echo mysqli_error($config); }
?>
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <?php foreach($rowLevelMenus as $rowLevelMenu): ?>
        <li class="nav-item">
            <a class="nav-link collapsed" href="?page=<?php echo $rowLevelMenu['link']; ?>">
                <i class="<?php echo $rowLevelMenu['icon']; ?>"></i>
                <span><?php echo $rowLevelMenu['name']; ?></span>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
</aside>
