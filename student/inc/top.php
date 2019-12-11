        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="images/img.jpg" alt="">John Doe
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="javascript:;"> Profile</a></li>
                    <li>
                      <a href="javascript:;">
                        <span class="badge bg-red pull-right">50%</span>
                        <span>Settings</span>
                      </a>
                    </li>
                    <li><a href="javascript:;">Help</a></li>
                    <li><a href="login.html"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>

                <li role="presentation" class="dropdown">
                <?php
                  if (!empty($_SESSION['cart'])) {
                    $bookId = $_SESSION['cart'];
                  }
                ?>
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-shopping-cart"></i>
                    <span class="badge bg-green"><?php if(isset($bookId)){echo count($bookId);} else{ echo '0'; } ?></span>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <?php 
                      foreach ($bookId as $key => $value) {
                          $navCartSql = "SELECT * FROM books WHERE book_id =:bookId";
                          $resCart    = $pdo->prepare($navCartSql);
                          $resCart->execute(['bookId'=>$key]);
                          $books = $resCart->fetchAll();
                          foreach ($books as $book) {
                           
                    ?>
                          <a href="book-view.php?ref=<?php echo $book->book_id?>">                  
                            <li>
                              <!-- <span class="image"><img src="<?php echo $book->thumb?>" alt="book image" /></span> -->
                              <span>
                              <span><?php echo $book->book_title?></span>
                              </span> <br>
                              <span class="message">
                              <span> by <em><?php echo $book->author?></em></span>
                              </span>
                            </li>
                          </a>
                    <?php
                          }
                        }
                    ?>
                    <li>
                      <div class="text-center">
                        <a href="check-out.php">
                          <strong>Check Out</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->