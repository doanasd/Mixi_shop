<?php
session_start();
require_once 'func/connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include "./page/header.php";
$current_user_id = $_SESSION['user_id'];

// Truy vấn có điều kiện WHERE user_id
$sql = "SELECT cart.id as cart_id, products.* FROM cart 
        JOIN products ON cart.product_id = products.id 
        WHERE cart.user_id = '$current_user_id'";
$result = mysqli_query($conn, $sql);
?>

<main>
    <div class="cart-container" style="padding: 50px;">
        <h1>GIỎ HÀNG CỦA BẠN</h1>
        <table>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo number_format($row['price']); ?>đ</td>
                <td>
                    <a href="remove_cart.php?id=<?php echo $row['cart_id']; ?>" style="color:red;">Xóa</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</main>

<?php include "./page/footer.php"; ?>
