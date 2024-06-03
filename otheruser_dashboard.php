<?php
session_start();
$userloginid = $_SESSION["userid"] = $_GET['userlogid'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <style>
        body {
            background-image: url('images/beautiful_background.jpg');
            background-size: cover;
            background-attachment: fixed;
            font-family: 'Montserrat', sans-serif;
            color: #000;
        }

        .container,
        .row,
        .imglogo {
            margin: auto;
        }

        .innerdiv {
            text-align: center;
            margin: 60px auto;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            padding: 40px;
        }

        .leftinnerdiv {
            float: left;
            width: 25%;
            padding: 15px;
        }

        .rightinnerdiv {
            float: right;
            width: 70%;
            padding: 15px;
        }

        .portion {
            display: none;
            background: #e0f7fa;
            padding: 20px;
            border-radius: 10px;
        }

        .greenbtn {
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            padding: 12px 20px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 95%;
            margin-top: 8px;
        }

        .greenbtn:hover {
            background-color: #218838;
        }

        th {
            background-color: #16DE52;
            color: black;
            padding: 8px;
        }

        td {
            background-color: #b1fec7;
            color: black;
            padding: 8px;
        }

        a {
            text-decoration: none;
            color: black;
            font-size: large;
        }

        .card {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background: white;
            margin: 16px;
            padding: 16px;
        }

        .card img {
            width: 100%;
            height: auto;
        }

        .card-content {
            padding: 12px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            color: #fff;
            cursor: pointer;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .icons {
            margin-right: 10px;
        }
    </style>
</head>

<body>

    <?php include("data_class.php"); ?>

    <div class="container">
        <div class="innerdiv">
            <div class="leftinnerdiv">
                <br>
                <button class="greenbtn" onclick="openpart('myaccount')">
                    <img class="icons" src="images/icon/profile.png" width="30px" height="30px">我的账户
                </button>
                <button class="greenbtn" onclick="openpart('requestbook')">
                    <img class="icons" src="images/icon/book.png" width="30px" height="30px">请求书籍
                </button>
                <button class="greenbtn" onclick="openpart('issuereport')">
                    <img class="icons" src="images/icon/monitoring.png" width="30px" height="30px">书籍记录
                </button>
                <a href="index.php"><button class="greenbtn">
                        <img class="icons" src="images/icon/logout.png" width="30px" height="30px">注销
                    </button></a>
            </div>

            <div class="rightinnerdiv">
                <div id="myaccount" class="innerright portion" style="<?php echo empty($_REQUEST['returnid']) ? '' : 'display:none'; ?>">
                    <button class="greenbtn">我的账户</button>
                    <?php
                    $u = new data;
                    $u->setconnection();
                    $recordset = $u->userdetail($userloginid);
                    foreach ($recordset as $row) {
                        $id = $row[0];
                        $name = $row[1];
                        $email = $row[2];
                        $pass = $row[3];
                        $type = $row[4];
                    }
                    ?>
                    <p><u>姓名:</u> &nbsp;<?php echo $name; ?></p>
                    <p><u>邮箱:</u> &nbsp;<?php echo $email; ?></p>
                    <p><u>账户类型:</u> &nbsp;<?php echo $type; ?></p>
                </div>
            </div>

            <div class="rightinnerdiv">
                <div id="issuereport" class="innerright portion" style="<?php echo empty($_REQUEST['returnid']) ? 'display:none' : ''; ?>">
                    <button class="greenbtn">书籍记录</button>
                    <?php
                    $u->setconnection();
                    $recordset = $u->getissuebook($userloginid);
                    $table = "<table style='width: 100%;'><tr><th>姓名</th><th>书名</th><th>发放日期</th><th>归还日期</th><th>罚款</th><th>归还</th></tr>";
                    foreach ($recordset as $row) {
                        $table .= "<tr>";
                        $table .= "<td>$row[2]</td>";
                        $table .= "<td>$row[3]</td>";
                        $table .= "<td>$row[6]</td>";
                        $table .= "<td>$row[7]</td>";
                        $table .= "<td>$row[8]</td>";
                        $table .= "<td><a href='otheruser_dashboard.php?returnid=$row[0]&userlogid=$userloginid'><button type='button' class='btn-primary'>归还</button></a></td>";
                        $table .= "</tr>";
                    }
                    $table .= "</table>";
                    echo $table;
                    ?>
                </div>
            </div>

            <div class="rightinnerdiv">
                <div id="requestbook" class="innerright portion" style="<?php echo empty($_REQUEST['returnid']) ? 'display:none' : ''; ?>">
                    <button class="greenbtn">请求书籍</button>
                    <?php
                    $u->setconnection();
                    $recordset = $u->getbookissue();
                    $table = "<table style='width: 100%;'><tr><th>图片</th><th>书名</th><th>作者</th><th>分支</th><th>价格</th><th>请求书籍</th></tr>";
                    foreach ($recordset as $row) {
                        $table .= "<tr>";
                        $table .= "<td><img src='uploads/$row[1]' width='100px' height='100px'></td>";
                        $table .= "<td>$row[2]</td>";
                        $table .= "<td>$row[4]</td>";
                        $table .= "<td>$row[6]</td>";
                        $table .= "<td>$row[7]</td>";
                        $table .= "<td><a href='requestbook.php?bookid=$row[0]&userid=$userloginid'><button type='button' class='btn-primary'>请求</button></a></td>";
                        $table .= "</tr>";
                    }
                    $table .= "</table>";
                    echo $table;
                    ?>
                </div>
            </div>

        </div>
    </div>

    <script>
        function openpart(portion) {
            var i;
            var x = document.getElementsByClassName("portion");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            document.getElementById(portion).style.display = "block";
        }
    </script>

</body>

</html>