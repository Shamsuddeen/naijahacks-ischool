<?php
  
  include('inc/user.php');

      if(!isLoggedIn()){
        header("Location: login.php");
      }else{
        
      }
      
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> <?php info('site_name'); ?>  | View book</title>

    <!-- Bootstrap -->
    <?php include('inc/styles.php'); ?>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <?php include('inc/sidebar.php'); ?>
        <?php include('inc/top.php'); ?>
        <!-- page content -->
        <div class="right_col" role="main">

          <div class="">
            <div class="page-title">
              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>E-commerce page design</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                        <?php
                            if (isset($_GET['id']) && !empty($_GET['id'])) {
                              $bookId   = $_GET['id'];
                              $getQuery = "SELECT * FROM books WHERE book_id=:bookId";
                              $resGet   = $pdo->prepare($getQuery);
                              $resGet->execute(['bookId'=>$bookId]);
                              $bookRes  = $resGet->fetchAll();
                            }
                            foreach ($bookRes as $book) {
                        ?>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                                <div class="product-image">
                                  <img src="<?php echo $book->thumb?>" alt="<?php echo $book->thumb; ?>" />
                                </div>
                        </div>
                        <div class="col-md-5 col-sm-5 col-xs-12" style="border:0px solid #e5e5e5;">
                              <h3 class="prod_title"><em>Book Name:</em> <?php echo $book->book_title;?></h3>
                              <p><em>Book Decription: </em><?php echo $book->book_desc?></p>
                              <p><em>Book Author(s): </em><?php echo $book->author?></p>
                              <p><em>Book Publishers: </em><?php echo $book->publishers?></p>
                              <p><em>Book Edition: </em><?php echo $book->edition?></p>
                              <p><em>Year of Publication: </em><?php echo $book->pub_year?></p>
                              <p><em>Book ISBN: </em><?php echo $book->isbn?></p>
                              <br />
                              <div class="">
                                  <a href="add-to-cart.php?id=<?php echo $book->book_id?>" class="btn btn-primary">Add To Cart</a>
                                  <a href="check-out.php?id=<?php echo $book->book_id?>" class="btn btn-primary">Borrow!</a>
                              </div>
                      </div>
                        <?php
                          }
                        ?>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

          <!-- footer content -->
          <?php include('inc/footer.php'); ?>
          <!-- /footer content -->
      </div>
    </div>

   <!-- jQuery -->
   <?php include('inc/scripts.php'); ?>
  </body>
</html>