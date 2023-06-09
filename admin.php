<?php 
    session_start();
    if($_SESSION['admin'] != 'Admin'){
        header('location:login.php?wtf_bro');
    }
    $prd_pos = 11;
    $prd_name = "Golbon(1kg)";
    $conn = mysqli_connect("localhost", "root", "", "kantipur");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kantipur Admin</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/utils.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/responsive.css">
</head>
<body>
    <header class="head">
        <div class="logo"><a href="index.php">Kantipur</a></div>
        <nav class="adm-nav">
            <a href="admin.php">Dashboard</a>   
            <a href="admin-user.php">Users</a>
            <a href="admin-prd.php">Products</a>
            <form method="post">
                <button name="adm-logout">Log Out</button>
            </form>
        </nav>
    </header>
    <main class="admin-main">
        <div class="graph">
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
                google.charts.load('current', {'packages':['corechart']});
                google.charts.setOnLoadCallback(drawChart);

                <?php
                    $sqlSale = "SELECT * FROM sales";
                    $res3 = mysqli_query($conn, $sqlSale);
                ?>
                function drawChart() {
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Date');
                    data.addColumn('number', 'Sales');
                    data.addRows([
                        <?php 
                            while($data = $res3 -> fetch_assoc()){
                                $datedb = $data['date'];
                                $saledb = $data['sales'];
                                echo"
                                    ['".$datedb."',".$saledb."],
                                ";
                            }  
                        ?>
                    ]);

                    var options = {'title':'Sales per day',
                                    'width': '700',
                                    'height': '600',
                                    'backgroundColor': 'ffffff'
                                };

                    var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
                    chart.draw(data, options);
                }
            </script>
            <div id="chart_div"></div>
        </div>
        <div class="piechart">
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
                google.charts.load('current', {'packages':['corechart']});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    var data = new google.visualization.arrayToDataTable([   
                        ['Product Name', 'Quantities Sold'],           
                        <?php 
                            $sqlprd = "SELECT * FROM product";
                            $resp = mysqli_query($conn, $sqlprd) or die(mysqli_error($conn));
                            while($roww = $resp -> fetch_assoc()){
                                $prd_id = $roww['prdNo'];
                                $prd_name = $roww['prdName'];
                                $newsql = "SELECT SUM(pQty) FROM cart WHERE PrdNo = $prd_id AND status = 1";
                                $que = mysqli_query($conn, $newsql) or die(mysqli_error($conn));
                                if(mysqli_affected_rows($conn) > 0){
                                    $result = mysqli_fetch_array($que) or die(mysqli_error($conn));
                                    $res = $result['SUM(pQty)'];
                                    echo"
                                        ['".$prd_name."',".(int)$res."],
                                    ";
                                }
                                //mysqli_close($conn);
                            }  
                        ?>
                    ]);

                    var option2 = {'title':'Total Products Sold',
                                    'width': '700',
                                    'height': '600',
                                    'backgroundColor': 'ffffff'
                                };

                    var chart = new google.visualization.PieChart(document.getElementById('pie-chart'));
                    chart.draw(data, option2);
                }
            </script>
            <div id="pie-chart"></div>
        </div>
    </main>