<?php
include '../config/koneksi.php';
date_default_timezone_set('Asia/Jakarta');

$queryLev = mysqli_query($config, 'SELECT * FROM levels');
$fetchCats = mysqli_fetch_all($queryCat, MYSQLI_ASSOC);

$queryProducts = mysqli_query($config, 'SELECT c.category_name, p.* FROM products p LEFT JOIN categories c ON c.id = p.category_id');
$fetchProducts = mysqli_fetch_all($queryProducts, MYSQLI_ASSOC);

if (isset($_GET['payment'])) {
    //transaction
    mysqli_begin_transaction($config);
    $data = json_decode(file_get_contents('php://input'), true);
    
    $cart = $data['cart'];
    $total = array_reduce(
        $cart,
        function ($sum, $item) {
            return $sum + $item['product_price'] * $item['quantity'];
        },
        0,
    );

    $tax = $data['tax'];
    $orderAmounth = $data['grandTotal'];
    $ordercode = $data['order_code'];
    $orderDate = date("Y-m-d H:i:s");
    $orderChange = 0;
    $orderStatus = 1;
    $subtotal = $data['subtotal'];
    try{
        $insertOrder = mysqli_query(
            $config,
            "INSERT INTO orders(order_code, order_date, order_amount, order_subtotal, order_status) 
        VALUES('$ordercode', '$orderDate', '$orderAmounth', '$subtotal', '$orderStatus')",
        );

        if(!$insertOrder){
            throw new Exception("Insert failed to table orders", mysqli_error($config));
        }
        
        $idOrder = mysqli_insert_id($config);
        
        foreach ($cart as $v){
            $product_id = $v['id'];
            $qty = $v['quantity'];
            $order_price = $v['product_price'];
            $subtotal = $qty * $order_price;
            
            $insertOrderDetails = mysqli_query($config, "INSERT INTO order_details (order_id, product_id, qty, order_price, order_subtotal) VALUES ('$idOrder', '$product_id', '$qty', '$order_price', '$subtotal')");
            
            if(!$insertOrderDetails){
                throw new Exception("Insert failed to table orders", mysqli_error($config));
                
            }
        }
        mysqli_commit($config);
        $response=[
            'status'    => 'success',
            'message'   => 'Transaction success',
            'order_id'  => $idOrder,
            'order_code'=> $ordercode,
        ];
        echo json_encode($response, 201); die;
    }catch(\Throwable $th){
        mysqli_rollback($config);
        $response = ['status'=>'error', 'message'=> $th->getMessage()];
        echo json_encode($response, 500); die;

    }

    // if (!$insertOrder) {
    //     echo 'Error: ' . mysqli_error($config); // Ini akan menampilkan pesan error SQL
    // } else {
    //     echo 'Order inserted successfully!';
    // }
}
$orderNumber = mysqli_query($config, "SELECT id FROM orders ORDER BY id DESC LIMIT 1");
$row = mysqli_fetch_assoc($orderNumber);
$nextId = $row ? $row['id'] + 1 : 1; //Jika kondisi bernilai true (yaitu, jika $row ada dan tidak kosong), maka hasil dari ekspresi tersebut adalah nilai di sebelah kiri tanda :, yaitu $row['id'] + 1.
                                    //Jika kondisi bernilai false (misalnya $row tidak ada atau kosong), maka hasil dari ekspresi tersebut adalah nilai di sebelah kanan tanda :, yaitu 1.
$ordercode = "ORD-" . date('dmY') . str_pad($nextId,4, "0", STR_PAD_LEFT); // fungsi untuk nomor orderan
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Point Of Sale</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous" />
    <link rel="stylesheet" href="../assets/css/alan.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>

<body>
    <div class="container-fluid container-pos">
        <!--<div id="card"></div>-->
        <div class="row h-100">
            <div class="col-md-7 product-section">
                <div class="mb-4">
                    <h4 class="mb-3" id="product-title">
                        <i class="fas fa-store"></i>
                        Product
                    </h4>
                    <input type="text" name="" id="searchProduct" class="form-control search-box"
                        placeholder="Find Product...">
                </div>

                <div class="mb-4">
                    <button class="btn btn-primary category-btn active" onclick="filterCategory('all', this)">All
                        Menu</button>
                    <?php foreach($fetchCats as $cat):?>
                    <button class="btn btn-outline-primary category-btn"
                        onclick="filterCategory('<?php echo $cat['category_name']; ?>', this)">
                        <?php echo $cat['category_name']; ?>
                    </button>
                    <?php endforeach ?>
                </div>

                <div class="row" id="productGrid"></div>
            </div>
            <div class="col-md-5 cart-section">
                <div class="cart-header">
                    <h4>Cart</h4>
                    <small>Order # <span class="orderNumber"><?php echo $ordercode ?></span></small>
                </div>
                <div class="cart-items" id="cartItems">
                    <div class="text-center text-muted mt-5">
                        <i class="bi bi-cart mb-3"></i>
                        <p>Cart Empty</p>
                    </div>
                </div>
                <div class="cart-footer">
                    <div class="total-section">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal :</span>
                            <span id="subtotal">Rp. 100.000</span>
                            <input type="hidden" id="subtotal_value">
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tax (10%) :</span>
                            <span id="tax">Rp. 10.000</span>
                            <input type="hidden" id="tax_value">
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total :</span>
                            <span id="total">Rp. 110.000</span>
                            <input type="hidden" id="total_value">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <button id="clearCartBtn" class="btn btn-outline-danger w-100">
                                <i class="bi bi-trash"></i> Clear Cart
                            </button>
                        </div>

                        <div class="col-md-6">
                            <button class="btn btn-checkout btn-primary w-100" onclick="proccessPayment()">
                                <i class="bi bi-cash"></i> Process Payment
                            </button>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>


    <script>
        const products = <?php echo json_encode($fetchProducts); ?>;
        
        console.log("Products loaded:", products);
    </script>



    <script src="../assets/js/alan.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"
        integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous">
    </script>
</body>

</html>
