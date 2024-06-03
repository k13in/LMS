<?php include("db.php");

class data extends db
{

    private $bookpic;
    private $bookname;
    private $bookdetail;
    private $bookaudor;
    private $bookpub;
    private $branch;
    private $bookprice;
    private $bookquantity;
    private $book;
    private $userselect;
    private $days;
    private $getdate;
    private $returnDate;
    private $name;
    private $pasword;
    private $email;
    private $type;
    private $id;


    function __construct()
    {
        // echo " constructor ";
        echo "</br></br>";
    }


    function addnewuser($name, $pasword, $email, $type)
    {
        $this->name = $name;
        $this->pasword = $pasword;
        $this->email = $email;
        $this->type = $type;


        $q = "INSERT INTO userdata (name, email, pass,type) VALUES ('$name','$email','$pasword','$type')";

        if ($this->connection->exec($q)) {
            echo "<script>alert('添加成功');window.location.href='admin_service_dashboard.php';</script>";
        } else {
            echo "<script>alert('添加失败');window.location.href='admin_service_dashboard.php';</script>";
        }
    }
    function userLogin($t1, $t2)
    {
        $q = "SELECT * FROM userdata where email='$t1' and pass='$t2'";
        // echo $q;
        $recordSet = $this->connection->query($q);
        if (!$recordSet) {
            error_log("Database query failed: " . $this->connection->errorInfo());
            exit;
        }
        $result = $recordSet->rowCount();
        if ($result > 0) {

            foreach ($recordSet->fetchAll() as $row) {
                $logid = $row['id'];

                echo "<script>window.location.href='otheruser_dashboard.php?userlogid=$logid';</script>";
            }
        } else {
            echo "<script>alert('无效');window.location.href='index.php';</script>";
        }
    }

    function adminLogin($t1, $t2)
    {

        $q = "SELECT * FROM admin where email='$t1' and pass='$t2'";
        $recordSet = $this->connection->query($q);
        if (!$recordSet) {
            error_log("Database query failed: " . $this->connection->errorInfo());
            exit;
        }
        $result = $recordSet->rowCount();

        if ($result > 0) {
            foreach ($recordSet->fetchAll() as $row) {
                $logid = $row['id'];
                echo "<script>window.location.href='admin_service_dashboard.php?userlogid=$logid';</script>";
            }
        } else {
            echo "<script>alert('无效');window.location.href='index.php';</script>";
        }
    }



    function addbook($bookpic, $bookname, $bookdetail, $bookaudor, $bookpub, $branch, $bookprice, $bookquantity)
    {
        $this->bookpic = $bookpic;
        $this->bookname = $bookname;
        $this->bookdetail = $bookdetail;
        $this->bookaudor = $bookaudor;
        $this->bookpub = $bookpub;
        $this->branch = $branch;
        $this->bookprice = $bookprice;
        $this->bookquantity = $bookquantity;


        $q = "INSERT INTO book (bookpic, bookname, bookdetail, bookaudor, bookpub, branch, bookprice, bookquantity, bookava, bookrent) VALUES ('$bookpic', '$bookname', '$bookdetail', '$bookaudor', '$bookpub', '$branch', '$bookprice', $bookquantity, $bookquantity, 0)";

        if ($this->connection->exec($q)) {
            echo "<script>alert('添加成功');window.location.href='admin_service_dashboard.php';</script>";
            // header("Location:admin_service_dashboard.php?msg=done");
        } else {
            // header("Location:admin_service_dashboard.php?msg=fail");
            echo "<script>alert('添加失败');window.location.href='admin_service_dashboard.php';</script>";
        }
    }


    function getissuebook($userloginid)
    {

        $newfine = "";
        $issuereturn = "";

        $q = "SELECT * FROM issuebook where userid='$userloginid'";
        $recordSetss = $this->connection->query($q);


        foreach ($recordSetss->fetchAll() as $row) {
            $issuereturn = $row['issuereturn'];
            $fine = $row['fine'];
            $newfine = $fine;


            //  $newbookrent=$row['bookrent']+1;
        }


        $getdate = date("Y/m/d");
        if ($issuereturn < $getdate) {
            $q = "UPDATE issuebook SET fine='$newfine' where userid='$userloginid'";

            if ($this->connection->exec($q)) {
                $q = "SELECT * FROM issuebook where userid='$userloginid' ";
                $data = $this->connection->query($q);
                return $data;
            } else {
                $q = "SELECT * FROM issuebook where userid='$userloginid' ";
                $data = $this->connection->query($q);
                return $data;
            }
        } else {
            $q = "SELECT * FROM issuebook where userid='$userloginid'";
            $data = $this->connection->query($q);
            return $data;
        }
    }

    function getbook()
    {
        $q = "SELECT * FROM book ";
        $data = $this->connection->query($q);
        return $data;
    }
    function getbookissue()
    {
        $q = "SELECT * FROM book where bookava !=0 ";
        $data = $this->connection->query($q);
        return $data;
    }

    function userdata()
    {
        $q = "SELECT * FROM userdata ";
        $data = $this->connection->query($q);
        return $data;
    }


    function getbookdetail($id)
    {
        $q = "SELECT * FROM book where id ='$id'";
        $data = $this->connection->query($q);
        return $data;
    }

    function userdetail($id)
    {
        $q = "SELECT * FROM userdata where id ='$id'";
        $data = $this->connection->query($q);
        return $data;
    }



    function requestbook($userid, $bookid)
    {

        $q = "SELECT * FROM book where id='$bookid'";
        $recordSetss = $this->connection->query($q);

        $q = "SELECT * FROM userdata where id='$userid'";
        $recordSet = $this->connection->query($q);

        foreach ($recordSet->fetchAll() as $row) {
            $username = $row['name'];
            $usertype = $row['type'];
        }

        foreach ($recordSetss->fetchAll() as $row) {
            $bookname = $row['bookname'];
        }

        if ($usertype == "student") {
            $days = 7;
        }
        if ($usertype == "teacher") {
            $days = 21;
        }


        $q = "INSERT INTO requestbook (userid, bookid, username, usertype, bookname, issuedays) VALUES ('$userid', '$bookid', '$username', '$usertype', '$bookname', '$days')";

        if ($this->connection->exec($q)) {
            echo "<script>window.location.href='otheruser_dashboard.php?userlogid=$userid';</script>";
        } else {
            echo "<script>alert('失败')</script>";
        }
    }


    function returnbook($id)
    {
        $fine = "";
        $bookava = "";
        $issuebook = "";
        $bookrentel = "";

        $q = "SELECT * FROM issuebook where id='$id'";
        $recordSet = $this->connection->query($q);

        foreach ($recordSet->fetchAll() as $row) {
            $userid = $row['userid'];
            $issuebook = $row['issuebook'];
            $fine = $row['fine'];
        }
        if ($fine == 0) {

            $q = "SELECT * FROM book where bookname='$issuebook'";
            $recordSet = $this->connection->query($q);

            foreach ($recordSet->fetchAll() as $row) {
                $bookava = $row['bookava'] + 1;
                $bookrentel = $row['bookrent'] - 1;
            }
            $q = "UPDATE book SET bookava='$bookava', bookrent='$bookrentel' where bookname='$issuebook'";
            $this->connection->exec($q);

            $q = "DELETE from issuebook where id=$id and issuebook='$issuebook' and fine='0' ";
            if ($this->connection->exec($q)) {

                echo "<script>window.location.href='otheruser_dashboard.php?userlogid=$userid';</script>";
            }
            //  else{
            //     header("Location:otheruser_dashboard.php?msg=fail");
            //  }
        }
        // if($fine!=0){
        //     header("Location:otheruser_dashboard.php?userlogid=$userid&msg=fine");
        // }


    }

    function delteuserdata($id)
    {
        $q = "DELETE from userdata where id='$id'";
        if ($this->connection->exec($q)) {
            // header("Location:admin_service_dashboard.php?msg=done");
            echo "<script>alert('删除成功');window.location.href='admin_service_dashboard.php';</script>";
        } else {
            // header("Location:admin_service_dashboard.php?msg=fail");
            echo "<script>alert('删除失败');window.location.href='admin_service_dashboard.php';</script>";
        }
    }

    function deletebook($id)
    {
        $q = "DELETE from book where id='$id'";
        if ($this->connection->exec($q)) {
            // header("Location:admin_service_dashboard.php?msg=done");
            echo "<script>alert('删除成功');window.location.href='admin_service_dashboard.php';</script>";
        } else {
            // header("Location:admin_service_dashboard.php?msg=fail");
            echo "<script>alert('删除失败');window.location.href='admin_service_dashboard.php';</script>";
        }
    }

    function issuereport()
    {
        $q = "SELECT * FROM issuebook ";
        $data = $this->connection->query($q);
        return $data;
    }

    function requestbookdata()
    {
        $q = "SELECT * FROM requestbook ";
        $data = $this->connection->query($q);
        return $data;
    }

    function issuebookapprove($book, $userselect, $days, $getdate, $returnDate, $redid)
    {
        $this->$book = $book;
        $this->$userselect = $userselect;
        $this->$days = $days;
        $this->$getdate = $getdate;
        $this->$returnDate = $returnDate;


        $q = "SELECT * FROM book where bookname='$book'";
        $recordSetss = $this->connection->query($q);

        $q = "SELECT * FROM userdata where name='$userselect'";
        $recordSet = $this->connection->query($q);
        $result = $recordSet->rowCount();

        if ($result > 0) {

            foreach ($recordSet->fetchAll() as $row) {
                $issueid = $row['id'];
                $issuetype = $row['type'];

                // header("location: admin_service_dashboard.php?logid=$logid");
            }
            foreach ($recordSetss->fetchAll() as $row) {
                $bookid = $row['id'];
                $bookname = $row['bookname'];

                $newbookava = $row['bookava'] - 1;
                $newbookrent = $row['bookrent'] + 1;
            }


            $q = "UPDATE book SET bookava='$newbookava', bookrent='$newbookrent' where id='$bookid'";
            if ($this->connection->exec($q)) {

                $q = "INSERT INTO issuebook (userid, issuename, issuebook, issuetype, issuedays, issuedate, issuereturn, fine)VALUES('$issueid','$userselect','$book','$issuetype','$days','$getdate','$returnDate','0')";

                if ($this->connection->exec($q)) {

                    $q = "DELETE from requestbook where id='$redid'";
                    $this->connection->exec($q);
                    echo "<script>alert('成功');window.location.href='admin_service_dashboard.php';</script>";
                } else {
                    echo "<script>alert('失败');window.location.href='admin_service_dashboard.php';</script>";
                }
            } else {
                echo "<script>alert('失败');window.location.href='admin_service_dashboard.php';</script>";
            }
        } else {
            echo "<script>alert('无效');window.location.href='index.php';</script>";
        }
    }

    // issue book
    function issuebook($book, $userselect, $days, $getdate, $returnDate)
    {
        $this->$book = $book;
        $this->$userselect = $userselect;
        $this->$days = $days;
        $this->$getdate = $getdate;
        $this->$returnDate = $returnDate;


        $q = "SELECT * FROM book where bookname='$book'";
        $recordSetss = $this->connection->query($q);

        $q = "SELECT * FROM userdata where name='$userselect'";
        $recordSet = $this->connection->query($q);
        $result = $recordSet->rowCount();

        if ($result > 0) {

            foreach ($recordSet->fetchAll() as $row) {
                $issueid = $row['id'];
                $issuetype = $row['type'];

                // header("location: admin_service_dashboard.php?logid=$logid");
            }
            foreach ($recordSetss->fetchAll() as $row) {
                $bookid = $row['id'];
                $bookname = $row['bookname'];

                $newbookava = $row['bookava'] - 1;
                $newbookrent = $row['bookrent'] + 1;
            }


            $q = "UPDATE book SET bookava='$newbookava', bookrent='$newbookrent' where id='$bookid'";
            if ($this->connection->exec($q)) {

                $q = "INSERT INTO issuebook (userid,issuename,issuebook,issuetype,issuedays,issuedate,issuereturn,fine) VALUES ('$issueid','$userselect','$book','$issuetype','$days','$getdate','$returnDate','0')";

                if ($this->connection->exec($q)) {
                    // header("Location:admin_service_dashboard.php?msg=done");
                    echo "<script>alert('发放成功');window.location.href='admin_service_dashboard.php';</script>";
                } else {
                    // header("Location:admin_service_dashboard.php?msg=fail");
                    echo "<script>alert('发放失败');window.location.href='admin_service_dashboard.php';</script>";
                }
            } else {
                // header("Location:admin_service_dashboard.php?msg=fail");
                echo "<script>alert('发放失败');window.location.href='admin_service_dashboard.php';</script>";
            }
        } else {
            // header("location: index.php?msg=Invalid Credentials");
            echo "<script>alert('无效');window.location.href='index.php';</script>";
        }
    }
}
