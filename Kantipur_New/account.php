<?php 
    include_once 'header.php'
?>

    <main class="acc-main">
        <?php echo "<h1>Welcome ". $_SESSION['username']. "</h1>" ?>
        <div class="user-history"></div>
        <div class="setting">
            <input type="checkbox" id="sett" class="sett">
            <label for="sett" class="sett-box"><p>Change user's info</p></label>
            <div class="user-profile">
                <h2>Profile</h2>
                <form method="post" class="user-form">
                    <label>Username:</label>
                    <input type="text" value="<?php echo $_SESSION['username'] ?>" name="uName">
                    <button type="submit" name="user-upd">Update</button>
                </form>
                <form method="post" class="user-form">
                    <label>Password:</label>
                    <input type="password" placeholder="Old Password" name="oldPass" required>
                    <input type="password" placeholder="New Password" name="newPass" required>
                    <button type="submit" name="pass-upd">Update</button>
                </form>
                <form method="post">
                    <button name="log-out" class='logout'>Log Out</button>
                </form>
            </div>
        </div>
    </main>

    <footer>
        <div class="p">
            <p class="social">Social Media: <a href="#">Instagram</a> | <a href="#">Facebook</a></p>
            <p>Kantipur Chocolate Mart &copy; All Rights Reserved</p>
        </div>
        <div class="feedback">
            <label>Send Us a Feedback</label>
            <textarea name="" id="" rows=3></textarea>
            <button>Send</button>
        </div>

    </footer>
    <?php 
        require 'include/dbh.inc.php';

        if(isset($_POST['user-upd'])){
            $user = $_POST['uName'];
            $uid = $_SESSION['userid'];
            $userSql = "UPDATE user_info SET userName='$user' WHERE userId=$uid";
            $conn =    $serverName = "localhost";
            $dbUsername = "sagwe";
            $dbPassword = "sagwe1";
            $dbName = "sql";

            $conn = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);

            if(!$conn){
                die("Connection Failed:".mysqli_connect_error());
            };
            mysqli_query($conn, $userSql);
            $_SESSION['username'] = $user;
            header("Refresh:0");
        }

        if(isset($_POST['pass-upd'])){
            $oldpass = $_POST['oldPass'];
            $newpass = $_POST['newPass'];
            $newPass_hash = password_hash($newpass, PASSWORD_DEFAULT);

            $hashedPass = $_SESSION['userpass'];
            $checkpass = password_verify($oldpass, $hashedPass);

            if($checkpass === false){
                echo'
                    <script>
                        alert("Old password did not match");
                    </script>
                ';
                exit();
            }
            else{
                $uid = $_SESSION['userid'];
                $passSql = "UPDATE user_info SET userPass='$newPass_hash' WHERE userId=$uid";
                mysqli_query($conn, $passSql);
                $_SESSION['userpass'] = $newPass_hash;
                header("Refresh:0");
            }
        }

        if(isset($_POST['log-out'])){
            if(isset($_SESSION['cart'])){
                foreach($_SESSION['cart'] as $key => $value){
                    $pid = $value['Pid'];
                    $conn = mysqli_connect("localhost", "root", "", "kantipur");
                    dataFetch($pid);
                    echo "Ayooooo:".$value['num'];
                    $stock = $GLOBALS['qty'] + $value['num'];
                    $sql2 = "UPDATE product SET  Quantity='$stock' WHERE prdNo = $pid";
                    mysqli_query($conn, $sql2) or die(mysqli_error($conn));
                    mysqli_close($conn);
                }
            }
            session_destroy();
            session_start();
            header('location:index.php');
        }

        function dataFetch(int $id){
            $conn = mysqli_connect("localhost", "root", "", "kantipur");
            $sql = "SELECT * FROM product WHERE prdNo=$id";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            mysqli_close($conn);
            
            $GLOBALS['name'] = $row['prdName'];
            $GLOBALS['price'] = $row['prdPrice'];
            $GLOBALS['qty'] = $row['Quantity'];
            $GLOBALS['id'] = $row['Pid'];
        }
    ?>
    <script src="js/script.js"></script>
</body>

</html>