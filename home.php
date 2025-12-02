<?php
session_start();
include 'inc/functions.php';
include 'config/config.php';
checkLogin();
ob_start(); 

// ROLE MIDDLEWARE
$currentPage = $_GET['page'] ?? 'dashboard';
$level_id    = $_SESSION['LEVEL_ID'] ?? null;

// Jika level tidak ditemukan, blokir
if (!$level_id) {
    echo "<h1>Access Denied!</h1>";
    echo "Your session level is invalid.";
    exit;
}

// Jika admin (level 1), bypass middleware
if ($level_id == 1) {
    goto SKIP_ROLE_CHECK;
}
// Ambil menu sesuai level pengguna
$sql = "SELECT menus.link 
        FROM menus 
        JOIN level_menus ON level_menus.menu_id = menus.id 
        WHERE level_menus.level_id = '$level_id'";

$query = mysqli_query($config, $sql);

if (!$query) {
    die("Query Error: " . mysqli_error($config));
}

$allowed_pages = array_column(mysqli_fetch_all($query, MYSQLI_ASSOC), 'link');

// Jika page tidak ditemukan dalam role
if (!in_array($currentPage, $allowed_pages) && $currentPage != 'dashboard') {
    echo "<h1>Access Failed!</h1>";
    echo "You don't have access to the <strong>" . ucfirst($currentPage) . "</strong> page.<br>";
    echo '<a href="home.php?page=dashboard">Back to Dashboard</a>';
    exit;
}

SKIP_ROLE_CHECK:
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Laundry PPKD JP</title>
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    <?php include 'inc/header.php'; ?>

    <!-- ======= Sidebar ======= -->
    <?php include 'inc/sidebar.php'; ?>

    <main id="main" class="main">

        <?php
        if (isset($_GET['page'])) {
            if (file_exists('pages/' . $_GET['page'] . '.php')) {
                include 'pages/' . $_GET['page'] . '.php';
            }else{
                include 'pages/notfound.php';
            }
        } else {
            include 'pages/dashboard.php';
        }
        
        ?>




    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>Laundry PPKD JP</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
            Designed by <a href="https://bootstrapmade.com/">PPKD Jakarta Pusat</a>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>
