<?php 
    include_once 'header.php';
?>

    <main>
        <div class="about-container">
            <div class="about">
                <h1>Special Winter Offer!!</h1>
                <h4>Get special reward on purchase of all kind of products.</h4>
                <a href="products.php"><button>View Products</button></a>
            </div>
        </div>

        <div class="featured-container" id="products">
            <h1>Featured Products</h1>

            <div class="featured-products">
            <?php
                $conn = mysqli_connect('localhost', 'root', '', 'kantipur');
                $sql = "SELECT * FROM product WHERE Pid > 0 AND Pid < 5";
                $res = mysqli_query($conn, $sql);

                while($rows = $res -> fetch_assoc()){
                    echo '<div class="featured-img">';
                    if(isset($_SESSION["userid"])){
                        echo '<form action="managecart.php" method="post">';
                    }
                    else{
                        echo '<form action="signup.php" method="post">';
                    }
                    echo'
                        <img src="images/'; echo $rows['prdImg']; echo'" alt="" srcset="">
                        <label>'; echo $rows["prdName"]; echo'</label>
                        <label class="price">Rs.'; echo $rows["prdPrice"]; echo'</label>
                        <label class="qty">Available: '; echo $rows["Quantity"]; echo'</label>
                        <input type="number" value="1" min="1" max="';echo $rows["Quantity"]; echo'" name="num" class="num">
                        <input type="hidden" value="'; echo $rows["prdNo"]; echo'" name="Pid">
                        <input type="hidden" value="'; echo $rows["prdName"]; echo'" name="Pname">
                        <input type="hidden" value="'; echo $rows["prdPrice"]; echo'" name="Pprice">
                        <button type="submit" name="add-to-cart"'; if($rows["Quantity"]==0)echo "disabled"; echo'>Add to Cart</button>
                        </form>
                        </div>
                    ';
                }   
            ?>
                </div>
            </div>
        </div>

        <hr>

        <div class="products-container">
        <?php
            $conn = mysqli_connect('localhost', 'root', '', 'kantipur');
            $sql = "SELECT * FROM product WHERE Pid > 4 AND Pid < 11";
            $res = mysqli_query($conn, $sql);

            while($rows = $res -> fetch_assoc()){
                echo '<div class="products-img">';
                if(isset($_SESSION["userid"])){
                    echo '<form action="managecart.php" method="post">';
                }
                else{
                    echo '<form action="signup.php" method="post">';
                }
                echo'
                    <img src="images/'; echo $rows['prdImg']; echo'" alt="" srcset="">
                    <label>'; echo $rows["prdName"]; echo'</label>
                    <label class="price">Rs.'; echo $rows["prdPrice"]; echo'</label>
                    <label class="qty">Available: '; echo $rows["Quantity"]; echo'</label>
                    <input type="number" value="1" min="1" max="';echo $rows["Quantity"]; echo'" name="num" class="num">
                    <input type="hidden" value="'; echo $rows["prdNo"]; echo'" name="Pid">
                    <input type="hidden" value="'; echo $rows["prdName"]; echo'" name="Pname">
                    <input type="hidden" value="'; echo $rows["prdPrice"]; echo'" name="Pprice">
                    <button type="submit" name="add-to-cart"'; if($rows["Quantity"]==0)echo "disabled"; echo'>Add to Cart</button>
                    </form>
                    </div>
                ';
            }   
        ?>
            </div>
        </div>
    </main>

    <?php
        function dataFetch(int $id){
            $conn = mysqli_connect("localhost", "root", "", "kantipur");
            $sql = "SELECT * FROM product WHERE prdNo=$id";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            mysqli_close($conn);
            
            $GLOBALS['name'] = $row['prdName'];
            $GLOBALS['price'] = $row['prdPrice'];
            $GLOBALS['qty'] = $row['Quantity'];
        }
    ?>

    <footer>
        <div class="p">
            <p class="social">Social Media: <a href="#">Instagram</a> | <a href="https://www.facebook.com/kantipurchocolatemart">Facebook</a></p>
            <p>Kantipur Chocolate Mart &copy; All Rights Reserved</p>
        </div>
        <div class="feedback">
            <label>Send Us a Feedback</label>
            <textarea name="" id="" rows=3></textarea>
            <button>Send</button>
        </div>
    </footer>
    <script src="js/script.js"></script>
</body>
</html>