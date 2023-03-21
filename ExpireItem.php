<?php 
//เริ่มการทำงานของ php 
    session_start();

    require_once "config/db.php";
//Delete section
    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];
        $deletestmt = $conn->query("DELETE FROM item WHERE itemID = $delete_id");
        $deletestmt->execute();

        if ($deletestmt) {
            $delete_id = $_GET['delete'];
        $deletestmt2 = $conn->query("DELETE FROM item WHERE itemID = $delete_id");
        $deletestmt2->execute();
        if($deletestmt2){
            echo "<script>alert('Data has been deleted successfully');</script>";
            $_SESSION['success'] = "Data has been deleted succesfully";
            header("refresh:1; url=Homepage.php");
        }
        else{ $_SESSION['error'] = "Data has not been inserted successfully";
            header("location: Homepage.php");}
        }
        
    }

// query updated    
 $uid = $_SESSION['username'];    
 // Ascending Order
if(isset($_POST['ASC']))
{
   
    $query = $conn->query("SELECT * FROM item WHERE userID = '$uid' ORDER BY expDate ASC");
   
}
// Descending Order
elseif (isset ($_POST['DESC'])) 
    {
      
        $query = $conn->query("SELECT * FROM WHERE userID = '$uid' item ORDER BY expDate DESC");
       
    }  
//Default    
    else
    {
        $query = $conn->query("SELECT * FROM item WHERE userID = '$uid' ORDER BY fav DESC");
        
    }     
    $itemall = $query->execute();
    $users = $query->fetchAll();
?>
<!-- ส่วนเปลี่ยนภาษาไว้ประกาศตัวแปร lang เพื่อใช้เรียกภาษาอื่นจากใน en.php/th.php -->
<?php
	if (!isset($_SESSION['lang']))
		$_SESSION['lang'] = "en";
	else if (isset($_GET['lang']) && $_SESSION['lang'] != $_GET['lang'] && !empty($_GET['lang'])) {
		if ($_GET['lang'] == "en")
			$_SESSION['lang'] = "en";
		else if ($_GET['lang'] == "th")
			$_SESSION['lang'] = "th";
	}

	require_once "languages/" . $_SESSION['lang'] . ".php";

      
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InFridge - Expire Items</title>

    <!-- Library -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
</head>
<body style="background-color: #E9F4FF;">
<?php           



                try{
                $item = $conn->prepare("SELECT * FROM item");
                $item->execute();
                $selectrow = $item->fetchAll();
                }
                catch(exception $e){
                    echo($ex -> getMessage());
                }
?>

<!-- ADD Button ข้างใน add -->    



<div class="modal fade" id="ADDModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog" >
        <div class="modal-content" style="background-color: #9DB7D6;">
        <div class="modal-header" >
            <h5 class="modal-title" id="exampleModalLabel" style="color: white;"><?php echo $lang['adddata'] ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
        </div>
        <div class="modal-body">

            <form action="insert.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="itemName" class="col-form-label" style="color: white;"><?php echo $lang['name'] ?></label>
                    <input type="text" required class="form-control" name="itemName">
                </div>
                <div class="form-group mb-3">
                    <label for="expDate" class="col-form-label" style="color: white;"><?php echo $lang['expdate'] ?></label>
                    <input type="date" required class="form-control" name="expDate">
                </div>
               
                <div class="mb-3">
                    <label for="Img" class="col-form-label" style="color: white;"><?php echo $lang['image'] ?></label>
                    <input type="file" required class="form-control" id="imgInput" name="Img">
                    <img loading="lazy" width="100%" id="previewImg" alt="">
                    </div>
                <div class="mb-3">
                    <label for="quantity" class="col-form-label" style="color: white;"><?php echo $lang['quan'] ?></label>
                    <input type="text" class="form-control" name="quantity">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" ><?php echo $lang['close'] ?></button>
                    <button type="submit" name="submit" class="btn btn-success"><?php echo $lang['submit'] ?></button>
                </div>
          
        </div>
        
        </div>
    </div>
    </div>
<!-- เเจ้งเตือนของหมดอายุหรือใกล้หมด-->
<div class="modal fade" id="flukeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog" >
        <div class="modal-content" style="background-color: #fff;">
    <!-- เฮด -->
        <div class="modal-header" >
            <h1 class="modal-title" id="exampleModalLabel" style="color: brown;"><?php echo $lang['noti'] ?></h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
        </div>
        <!-- บอดี้ -->
        <div class="modal-body">
            <?php
               $query_n = $conn->query("SELECT * FROM item WHERE userID = '$uid' ORDER BY expDate DESC");
               $query_n->execute();
               $noti = $query_n->fetchAll();
               foreach($noti as $notic){
                $exp=strtotime($notic['expDate']);
                $now= time();
                $diff = ceil(($exp-$now)/(60*60*24));
                $left=$notic['quantity'];
                if($diff<5 && $diff>0) //ตั้งจำนวนวันตรงนี้เพื่อบอกเหลือกี่วันหมดอายุถ้าน้อยกว่า 5 วัน
                {
            ?>
                <div class="mb-3">
                <label class="modal-title" id="exampleModalLabel" style="color: #04263d;">
                <?php echo $notic['itemName']?> <?php echo $lang['almostexp'] ?> <?php echo $diff ?> <?php echo $lang['day'] ?> 

            </label>
            <hr>
                </div>
                 <?php 
                }
                else if($left==0)   //ของหมด
                {
                    ?>
                 <div class="mb-3">
                <label class="modal-title" id="exampleModalLabel" style="color: #04263d;">
                    <?php echo $notic['itemName'];?> <?php echo $lang['empty'] ?>
                </label> <hr>
                    </div>
                <?php
            }
            else if($left<3 && $left>0)   //ของใกล้หมด
            {
                ?>
             <div class="mb-3">
            <label class="modal-title" id="exampleModalLabel" style="color: #04263d;">
                <?php echo $notic['itemName'];?> <?php echo $lang['almostempty'] ?>
                </label> <hr>
                </div>
            <?php
        }
        
        }

            
            ?>
        
             

               

          
        </div>
        
        </div>
    </div>
    </div>


    <!----------Top bar 1---------->
    <nav class="navbar navbar-expand-sm navbar-dark bg-light">
  <div class="container-fluid">
    <a class="navbar-brand " href="Homepage.php">
    <image  src="img/infridgelog.png" alt="logo" width="196" height="74" class="d-inline-block align-text-top">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
      <span class="navbar-toggler-icon"></span>
    </button>


    <!----------Top bar center--Search bar------->
    <div class="input-group  me-2">
    <ul class="navbar navbar-expand-sm  navbar-center m-auto w-50 ">
    <form method="post"> </form>
    <form class="d-xxl-flex col-10" method="post">
         <input  class="form-control input-group border-0" style="margin-right: 0px;" type="search" placeholder="<?php echo $lang['searchbar'] ?>. . ." aria-label="Search" aria-describedby="basic-addon1 " name="search">
         <button  type="submit" name="submit" class="btn active btn-group m-0 " style="background-color: #005483;" data-bs-toggle="submit" autocomplete="off" aria-pressed="true" ><i class="fa fa-search  me-auto btn-m mt-1 " style="color: white;"></i> </button>
      </form>
    </ul>
    </div>
  <!----------Top bar center--Search bar------->
    <div class="me-2">
    <ul class="my-auto ">
   <div class="dropdown">
   <a href="#" class="d-flex align-items-center text-black text-decoration-none dropdown-toggle"  data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="mx-2"><?php echo $lang['language'] ?></span>
    </a>
    <div class="dropdown-menu p-auto">
        <li><a href="ExpireItem.php?lang=en" class="mx-3"><?php echo $lang['lang_en'] ?></a></li>
        <li><a href="ExpireItem.php?lang=th" class="mx-3"><?php echo $lang['lang_th'] ?></a></li>
    </div>
  </div>
    </ul>
</div>
                 <!--------------Logout-------------------->
                <div class="dropdown mx-1 " >
                    <a href="#" class="d-flex align-items-center text-black text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="d-flex d-inline-block mx-2"><?php echo $_SESSION['username'];?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow ">
                        
                        <li>
        <?php if (isset($_SESSION['username'])) : ?>  <?php endif ?>
        <a class="dropdown-item " href="login.php?logout='1'"><?php echo $lang['logout'] ?></a>
                        </li>
                    </ul>
                </div>   
                      
                    <!--------------Logout-------------------->
                    
  </div>
</nav>
    
    <!------------Top Bar 2------------->
    <nav class="navbar navbar-expand-sm navbar-light" style="background-color: #005483;">
  <div class="container-fluid">
     <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mynavbar">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="Homepage.php" style="color: white;"><?php echo $lang['home'] ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="ListItemPage.php"style="color: white;"><?php echo $lang['lists'] ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="ExpireItem.php"style="color: white;"> <?php echo $lang['expire'] ?></a>
        </li>
       
      </ul>
      
    </div>
  </div>
 <!--------------ADD button---------------->
  <div class="btn-group me-4 ">
  <button type="button" class="btn  d-inline-flex" style="color: white;"  data-bs-toggle="modal" data-bs-target="#ADDModal" data-bs-whatever="@mdo"><i class="fa fa-plus-circle me-2 btn-m mt-1 " ></i>  <?php echo $lang['addbtn'] ?></button>
<!--เปรี้ยว button-->
<button type="button" class="btn btn-sm  d-inline-flex mx-2" style="color: white; font-size: 20px;"  data-bs-toggle="modal" data-bs-target="#flukeModal" data-bs-whatever="@mdo"><i class="fa fa-bell-o me-2 btn-m mt-1 " ></i> </button>
          
        
</div>
    </nav>
<!--------------------------------->

 <!----------ส่วน content ข้างล่าง Top bar--------->  

<div class="container-fluid py-5" style="padding-left: 100px; padding-right: 100px;">
<div class="col-from-label " >
<!----------หัวข้อ---------> 
 <h1 class="mb-4">  <?php echo $lang['expire'] ?></h1>
<!----------ตาราง---------> 
 <table class="table table-borderless table-striped">
   <!----------หัวตาราง--------->    
    <thead>
        <tr>
        <th > <?php echo $lang['image'] ?></th>
        <th> <?php echo $lang['name'] ?></th>
        <th> <?php echo $lang['quan'] ?></th>
        <th> <?php echo $lang['expdate'] ?></th>
        <th> <?php echo $lang['dayleft'] ?></th>
        </tr>
    </thead>
    <!----------body ตาราง--------->   
    <tbody>
    <?php 
                   

                   //table query
                    $stmt = $conn->query("SELECT * FROM item ORDER BY fav DESC");
                    $stmt->execute();
                    $users = $stmt->fetchAll();
                    
                    //ถ้าไม่มีข้อมูล
                    if (!$users) {
                        echo "<p><td colspan='6' class='text-center'>No data available</td></p>";
                    }
                    //ถ้า search หา item ใน search bar  
                    elseif(isset($_POST["submit"])){
                            $str = $_POST["search"];
                            $sth = $conn->prepare("SELECT * FROM item WHERE (itemID = '$str') OR (itemName= '$str') ORDER BY itemID ASC");
                            $sth->setFetchMode(PDO:: FETCH_ASSOC);
                            $sth -> execute([]);
                            $test = $sth->fetchALL();
                            foreach($test as $test){
                        ?>
                        <tr>
                       <td width="200px" height = "200px"><Img class="rounded" width="100%" src="uploads/<?php echo $test['Img']; ?>" alt=""></td>
                        <td><?php echo $test['itemName']; ?></td>
                        <td><?php echo $test['quantity'] ?></td>
                        <td><?php echo $test['expDate'] ?></td>
                        <td>
                        <label> <?php
                            $exp=strtotime($user['expDate']);
                            $now= time();
                            $diff = ceil(($exp-$now)/(60*60*24));//calculating
                             if($diff > 0) // ถ้ายังไม่หมดอายุแสดงข้อความแจ้งเตือน
                             {
                             ?> 
                               <?php echo $diff; ?> <?php echo $lang['day'] ?></label> 
                             <?php 
                            }
                          else if($diff <= 0) // ถ้าหมดอายุแล้วแสดงข้อความแจ้งเตือน
                          {
                        ?>
                        <label> <?php echo $lang['expalready'] ?></label>
                        <?php
                        }
                        ?>
                        </td>       
                 </tr>
                    <?php 
                    }
                }
                 // เนื้อหาในตารางที่แสดงปกติ
                    else {
                    foreach($users as $user){
                ?>
                    <tr>
                        
                        <td width="200px" height = "200px"><Img class="rounded" width="100%" height="100%" src="uploads/<?php echo $user['Img']; ?>" alt=""></td>
                        <td><?php echo $user['itemName']; ?></td>
                        <td><?php echo $user['quantity']; ?></td>
                        <td><?php echo $user['expDate']; ?></td>
                      <td>
                        <label> <?php
                            $exp=strtotime($user['expDate']);
                            $now= time();
                            $diff = ceil(($exp-$now)/(60*60*24));//calculating
                             if($diff > 0) // ถ้ายังไม่หมดอายุแสดงข้อความแจ้งเตือน
                             {
                             ?> 
                               <?php echo $diff; ?> <?php echo $lang['day'] ?></label>
                             <?php 
                            }
                          else if($diff <= 0) // ถ้าหมดอายุแล้วแสดงข้อความแจ้งเตือน
                          {
                        ?>
                        <label> <?php echo $lang['expalready'] ?></label>
                        <?php
                        }
                        ?>
                        </td>         
                    </tr>
                <?php  
                } 
            }
 ?>
    
    </tbody>
</table>

</div>

</div>

<!-- upload รูปจากในไฟล์คอม -->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        let imgInput = document.getElementById('imgInput');
        let previewImg = document.getElementById('previewImg');

        imgInput.onchange = evt => {
            const [file] = imgInput.files;
                if (file) {
                    previewImg.src = URL.createObjectURL(file)
            }
        }

    </script>
   
   

    </body>
    <style>
       @import url('https://fonts.googleapis.com/css?family=Prompt:400,800');
       
       tr:hover {
            background-color: lightblue;
        }
       
      input[type=submit] {
        background-color: #145998;
        border: 5px;
        color: #fff;
        padding: auto;
        text-decoration: none;
        margin: 4px 2px;
        cursor: pointer;
      }
      .btn-edit {
    color: whitesmoke;
    background-color: #597D9F;
 }

 .btn-delete {
    color: whitesmoke;
    background-color: maroon;
 }
 body{
    
    font-family: 'Prompt',monospace;
    font-weight: bold;
}
 a {
	display: inline-block;
	text-decoration:none;
	
	color: black;
	
	font-size: 15px;
}     
   
    </style>