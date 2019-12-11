<?php
session_start();

    if(isset($_GET['id']) & !empty($_GET['id'])){
		if (isset($_SESSION['cart']) && count($_SESSION['cart']) >= 3) {
			header('location: all-books.php?msg=exceeded');
		}else{
			$bookId = $_GET['id'];
			$_SESSION['cart'][$bookId] = array('book' => $bookId);
			// array_push($_SESSION['bookId'], $id);
			header('location: all-books.php');
		}
    }else{
    	header('location: all-books.php');
    }
		echo "<pre>";
		print_r($_SESSION['bookId']);
		echo "</pre>";
	

?>