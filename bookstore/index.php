<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link rel="stylesheet" href="index.css">

</head>

<body>

    <?php

	session_start();
	include 'connectDB.php';

	if (isset($_POST['ac'])) {

		$sql = "SELECT * FROM book WHERE BookID = '" . $_POST['ac'] . "'";
		$result = $conn->query($sql);

		while ($row = $result->fetch_assoc()) {
			$bookID = $row['BookID'];
			$quantity = $_POST['quantity'];
			$price = $row['Price'];
		}

		$sql = "INSERT INTO cart(BookID, Quantity, Price, TotalPrice) VALUES('" . $bookID . "', " . $quantity . ", " . $price . ", Price * Quantity)";
		$conn->query($sql);
	}

	if (isset($_POST['delc'])) {
		$sql = "DELETE FROM cart";
		$conn->query($sql);
	}

	$sql = "SELECT * FROM book";
	$result = $conn->query($sql);
	?>

    <?php

	include 'header.php';
	?>
    <ul id='myTable'>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <li>
            <img src="<?php echo $row["Image"]; ?>">
            <div class="title"><strong>Title: <?php echo $row["BookTitle"]; ?></strong></div>
            <div>Author: <?php echo $row["Author"]; ?></div>
            <div>Type: <?php echo $row["Type"]; ?></div>
            <div class="price"><?php echo $row["Price"]; ?> VNĐ</div>
            <div>
                <form action="" method="post">
                    Quantity: <input type="number" value="1" name="quantity" class="quantity-input" /><br>
                    <input type="hidden" value="<?php echo $row['BookID']; ?>" name="ac" />
                    <input class="button" type="submit" value="Add to Cart" />
                </form>
            </div>
        </li>
        <?php } ?>
    </ul>

    <?php
	// hiển thị giỏ hàng
	$sql = "SELECT cart.CartID, book.BookTitle, book.Image, cart.Price, cart.Quantity, cart.TotalPrice FROM book, cart
    WHERE book.BookID = cart.BookID;";
	$result = $conn->query($sql);
	?>

    <div class='cart-container'>
        <h2><i class='fa fa-shopping-cart' style='font-size: 24px;'></i> Cart
            <form style='float: right;' action='' method='post'>
                <input type='hidden' name='delc' />
                <input class='cbtn' type='submit' value='Empty Cart'>
            </form>
        </h2>
        <?php
		$total = 0;
		while ($row = $result->fetch_assoc()) { ?>
        <div class='cart-item'>
            <strong><?php echo $row['BookTitle']; ?></strong><br>
            Price: <?php echo $row['Price']; ?> VNĐ<br>
            Quantity: <?php echo $row['Quantity']; ?><br>
            Total Price: <?php echo $row['TotalPrice']; ?> VNĐ
            <form action='' method='post' style='float: right;'>
                <input type='hidden' name='delItem' value='<?php echo $row['CartID']; ?>' />
                <button type='submit' class='remove-btn'>Remove</button>
            </form>
        </div>
        <?php
			$total += $row['TotalPrice'];
		}
		if (isset($_POST['delItem'])) {
			$sql = "DELETE FROM cart WHERE CartID = '" . $_POST['delItem'] . "'";
			$conn->query($sql);
		}
		?>
        <div class='total'>
            <strong>Total: <?php echo $total; ?> VNĐ</strong>
            <center>
                <form action='checkout.php' method='post'>
                    <input class='button checkout-btn' type='submit' name='checkout' value='CHECKOUT'>
                </form>
            </center>
        </div>
    </div>
</body>

</html>