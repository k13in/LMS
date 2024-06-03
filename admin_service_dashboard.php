<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <style>
        /* Global Styles */
        body {
            background-image: url('images/library.png');
            background-size: cover;
            background-attachment: fixed;
            font-family: 'Montserrat', sans-serif;
            color: #333;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            width: 80%;
            max-width: 1200px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            display: flex;
            gap: 24px;
        }

        .innerdiv {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .leftinnerdiv {
            width: 25%;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .rightinnerdiv {
            width: 70%;
            padding: 15px;
        }

        .portion {
            display: none;
            background: #e0f7fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 24px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
            width: 100%;
        }

        .greenbtn:hover {
            background-color: #218838;
        }

        .icons {
            margin-right: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background: white;
            border-radius: 8px;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #16DE52;
            color: #000;
        }

        td {
            background-color: #b1fec7;
            color: #000;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="password"],
        select,
        textarea {
            width: 80%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-bottom: 8px;
        }

        label {
            margin-bottom: 4px;
            font-weight: bold;
        }

        input[type="submit"],
        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            color: #fff;
            cursor: pointer;
            margin-top: 8px;
        }

        input[type="submit"]:hover,
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <?php
    include("data_class.php");

    $msg = "";
    if (!empty($_REQUEST['msg'])) {
        $msg = $_REQUEST['msg'];
        echo "<script>alert('$msg');</script>";
    }
    ?>

    <div class="container">
        <div class="innerdiv">
            <div class="leftinnerdiv">
                <button class="greenbtn" onclick="openpart('addbook')">
                    <img class="icons" src="images/icon/book.png" width="30px" height="30px" />添加书籍
                </button>
                <button class="greenbtn" onclick="openpart('bookreport')">
                    <img class="icons" src="images/icon/open-book.png" width="30px" height="30px" />书籍记录
                </button>
                <button class="greenbtn" onclick="openpart('bookrequestapprove')">
                    <img class="icons" src="images/icon/interview.png" width="30px" height="30px" />书籍请求
                </button>
                <button class="greenbtn" onclick="openpart('addperson')">
                    <img class="icons" src="images/icon/add-user.png" width="30px" height="30px" />添加人员
                </button>
                <button class="greenbtn" onclick="openpart('studentrecord')">
                    <img class="icons" src="images/icon/monitoring.png" width="30px" height="30px" />人员记录
                </button>
                <button class="greenbtn" onclick="openpart('issuebook')">
                    <img class="icons" src="images/icon/test.png" width="30px" height="30px" />发放书籍
                </button>
                <button class="greenbtn" onclick="openpart('issuebookreport')">
                    <img class="icons" src="images/icon/checklist.png" width="30px" height="30px" />发放记录
                </button>
                <a href="index.php">
                    <button class="greenbtn">
                        <img class="icons" src="images/icon/logout.png" width="30px" height="30px" />注销
                    </button>
                </a>
            </div>

            <div class="rightinnerdiv">
                <div id="bookrequestapprove" class="innerright portion" style="display:none">
                    <button class="greenbtn">书籍请求</button>
                    <?php
                    $u = new data;
                    $u->setconnection();
                    $recordset = $u->requestbookdata();
                    $table = "<table><tr><th>人员姓名</th><th>人员类型</th><th>书名</th><th>天数</th><th>批准</th></tr>";
                    foreach ($recordset as $row) {
                        $table .= "<tr><td>$row[1]</td><td>$row[3]</td><td>$row[2]</td><td>$row[6]</td>";
                        $table .= "<td><a href='approvebookrequest.php?reqid=$row[0]&book=$row[5]&userselect=$row[3]&days=$row[6]'><button type='button' class='btn-primary'>批准</button></a></td></tr>";
                    }
                    $table .= "</table>";
                    echo $table;
                    ?>
                </div>

                <div id="addperson" class="innerright portion" style="display:none">
                    <button class="greenbtn">添加人员</button>
                    <form action="addpersonserver_page.php" method="post" enctype="multipart/form-data" style="margin-top: 20px;">
                        <label>姓名:</label><input type="text" name="addname" /></br>
                        <label>密码:</label><input type="password" name="addpass" /></br>
                        <label>邮箱:</label><input type="email" name="addemail" /></br>
                        <label for="typw">选择类型:</label>
                        <select name="type">
                            <option value="student">学生</option>
                            <option value="teacher">教师</option>
                        </select></br>
                        <input type="submit" value="提交" />
                    </form>
                </div>

                <div id="addbook" class="innerright portion">
                    <button class="greenbtn">添加新书</button>
                    <form action="addbookserver_page.php" method="post" enctype="multipart/form-data" style="margin-top: 20px;">
                        <label>书名:</label><input type="text" name="bookname" /></br>
                        <label>详情:</label><input type="text" name="bookdetail" /></br>
                        <label>作者:</label><input type="text" name="bookaudor" /></br>
                        <label>出版社:</label><input type="text" name="bookpub" /></br>
                        <div>
                            <label>分支:</label>
                            <input type="radio" name="branch" value="computer" />计算机
                            <input type="radio" name="branch" value="law" />法律

                            <input type="radio" name="branch" value="science" />科学
                            <input type="radio" name="branch" value="other" />其他

                        </div>
                        <label>价格:</label><input type="number" name="bookprice" /></br>
                        <label>数量:</label><input type="number" name="bookquantity" /></br>
                        <label>书籍照片:</label><input type="file" name="bookphoto" /></br>
                        <input type="submit" value="提交" />
                    </form>
                </div>

                <div id="studentrecord" class="innerright portion" style="display:none">
                    <button class="greenbtn">人员记录</button>
                    <?php
                    $recordset = $u->userdata();
                    $table = "<table><tr><th>姓名</th><th>邮箱</th><th>类型</th></tr>";
                    foreach ($recordset as $row) {
                        $table .= "<tr><td>$row[1]</td><td>$row[2]</td><td>$row[4]</td></tr>";
                    }
                    $table .= "</table>";
                    echo $table;
                    ?>
                </div>

                <div id="issuebookreport" class="innerright portion" style="display:none">
                    <button class="greenbtn">发放书籍记录</button>
                    <?php
                    $recordset = $u->issuereport();
                    $table = "<table><tr><th>发放人员姓名</th><th>书名</th><th>发放日期</th><th>归还日期</th><th>罚款</th><th>发放人员类型</th></tr>";
                    foreach ($recordset as $row) {
                        $table .= "<tr><td>$row[2]</td><td>$row[3]</td><td>$row[6]</td><td>$row[7]</td><td>$row[8]</td><td>$row[4]</td></tr>";
                    }
                    $table .= "</table>";
                    echo $table;
                    ?>
                </div>

                <div id="issuebook" class="innerright portion" style="display:none">
                    <button class="greenbtn">发放书籍</button>
                    <form action="issuebook_server.php" method="post" enctype="multipart/form-data">
                        <label for="book">选择书籍:</label>
                        <select name="book">
                            <?php
                            $recordset = $u->getbookissue();
                            foreach ($recordset as $row) {
                                echo "<option value='" . $row[2] . "'>" . $row[2] . "</option>";
                            }
                            ?>
                        </select>
                        <br>
                        <label for="Select Student">选择学生:</label>
                        <select name="userselect">
                            <?php
                            $recordset = $u->userdata();
                            foreach ($recordset as $row) {
                                echo "<option value='" . $row[1] . "'>" . $row[1] . "</option>";
                            }
                            ?>
                        </select>
                        <br>
                        <label>天数</label> <input type="number" name="days" />
                        <input type="submit" value="提交" />
                    </form>
                </div>

                <div id="bookreport" class="innerright portion" style="display:none">
                    <button class="greenbtn">书籍记录</button>
                    <?php
                    $recordset = $u->getbook();
                    $table = "<table><tr><th>书名</th><th>价格</th><th>数量</th><th>可用</th><th>借出</th><th>查看</th></tr>";
                    foreach ($recordset as $row) {
                        $table .= "<tr><td>$row[2]</td><td>$row[7]</td><td>$row[8]</td><td>$row[9]</td><td>$row[10]</td>";
                        $table .= "<td><a href='admin_service_dashboard.php?viewid=$row[0]'><button type='button' class='btn-primary'>查看书籍信息</button></a></td></tr>";
                    }
                    $table .= "</table>";
                    echo $table;
                    ?>
                </div>

                <div id="bookdetail" class="innerright portion" style="<?php if (!empty($_REQUEST['viewid'])) {
                                                                            echo 'display: block !important;';
                                                                        } else {
                                                                            echo 'display:none';
                                                                        } ?>">
                    <button class="greenbtn">书籍详情</button>
                    <?php
                    $viewid = $_REQUEST['viewid'] ?? null;
                    if ($viewid) {
                        $recordset = $u->getbookdetail($viewid);
                        foreach ($recordset as $row) {
                            echo "<img width='150px' height='150px' style='border:1px solid #333333; float:left;margin-left:20px' src='uploads/$row[1]' />";
                            echo "<p style='color:black'><u>书名:</u> &nbsp&nbsp$row[2]</p>";
                            echo "<p style='color:black'><u>书籍详情:</u> &nbsp&nbsp$row[3]</p>";
                            echo "<p style='color:black'><u>作者:</u> &nbsp&nbsp$row[4]</p>";
                            echo "<p style='color:black'><u>出版社:</u> &nbsp&nbsp$row[5]</p>";
                            echo "<p style='color:black'><u>分支:</u> &nbsp&nbsp$row[6]</p>";
                            echo "<p style='color:black'><u>价格:</u> &nbsp&nbsp$row[7]</p>";
                            echo "<p style='color:black'><u>可用数量:</u> &nbsp&nbsp$row[9]</p>";
                            echo "<p style='color:black'><u>借出:</u> &nbsp&nbsp$row[10]</p>";
                        }
                    }
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