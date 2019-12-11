<?php
    include('inc/user.php');
    $id_no      =   $_SESSION['id_no'];
    $user_id    =   $_SESSION['user_id'];

    if(isset($_SESSION['cart'])){
        $cart = $_SESSION['cart'];
    }

    foreach ($cart as $key) {
        $book_id = $key['book'];
        $queryBook  = "SELECT * FROM `books` WHERE `book_id` =:book_id";
        $resBook    = $pdo->prepare($queryBook);
        $resBook->execute(['book_id'=>$book_id]);
        $books      = $resBook->fetchAll();
        foreach ($books as $book) {
            $catId         =   $book->cat_id;
            $q_remaining   =   $book->quantity_remaining;
        }
        //querry to check whehther user has reach maximun limit of borrowing
        $borrowQuery    =   "SELECT * FROM `books_borrowed` WHERE user_id =:user_id AND `expired` = 0 AND `renewed` = 0 AND `returned` = 0";
        $resBorrow      =$pdo->prepare($borrowQuery);
        $resBorrow->execute(['user_id'=>$user_id]);
        if ($resBorrow->rowCount() >= 3) {
            echo "You are yet to return the books you borrow";
        }else{
            if ($q_remaining > 0) {
                $bQUery =   "INSERT INTO `books_borrowed`(`book_id`, `cat_id`, `user_id`) 
                                    VALUES (:book_id,:cat_id,:user_id)";
                $bRes   = $pdo->prepare($bQUery);
                if ($bRes->execute(['book_id'=>$book_id,'cat_id'=>$catId,'user_id'=>$user_id])) {
                    $q_remaining    = $q_remaining-1;
                    $uQuery         = "UPDATE `books` SET `quantity_remaining`=:q_remaining WHERE `book_id` =:book_id";
                    $rUpate         = $pdo->prepare($uQuery);
                    $rUpate->execute(['q_remaining'=>$q_remaining,'book_id'=>$book_id]);
                    echo "You have successfully borrowed";
                    unset($_SESSION['cart'][$book_id]);
                }else{
                
                }
            }else {
                echo "Book out of stock";
            } 

        }

    }



?>