<?php 

    session_start();

    
    require_once "config/db.php";


    try{
        //get all item in the database and store it
        $item2 = $conn->prepare("SELECT * FROM item");
        $item2->execute();
        $selectrow = $item2->fetchAll();
        }
        catch(exception $e){
            echo($ex -> getMessage());
        }

    if (isset($_POST['update'])) {
        //if update button is pressed and this file was called
        $itemID = $_POST['itemID'];
        $itemName = $_POST['itemName'];
        $expDate = $_POST['expDate'];
        $Img = $_FILES['Img'];
        $quantity = $_POST['quantity'];
        $Img2 = $_POST['Img2'];
        $upload = $_FILES['Img']['name'];
        // storing the old data before updating
        if ($upload != '') {
            $allow = array('jpg', 'jpeg', 'png');
            $extension = explode('.', $Img['name']);
            $fileActExt = strtolower(end($extension));
            $fileNew = rand() . "." . $fileActExt;  // rand function create the rand number for filename uploaded
            $filePath = 'uploads/'.$fileNew;
            //if any file is uploaded we store the new file in here for images
            if (in_array($fileActExt, $allow)) {
                if ($Img['size'] > 0 && $Img['error'] == 0) {
                   move_uploaded_file($Img['tmp_name'], $filePath);
                   //for checking if image is uploaded and move it to the upload folder
                }
            }
        }else {
            //if no new image is uploaded we replace with the old image
            $fileNew = $Img2;
        }
        //start updating the database for changes
        $sql = $conn->prepare("UPDATE item SET itemID = :itemID, itemName = :itemName, expDate = :expDate, Img = :Img ,quantity = :quantity WHERE itemID = :itemID");
        $sql->bindParam(":itemID", $itemID);
        $sql->bindParam(":itemName", $itemName);
        $sql->bindParam(":expDate", $expDate);
        $sql->bindParam(":Img", $fileNew);
        $sql->bindParam(":quantity", $quantity);
        $sql->execute();

        if ($sql) {
            //success lead back to homepage
            header("refresh:1; url=Homepage.php");
            header("location: Homepage.php");
           
        } else {
            //otherwise error
            $_SESSION['error'] = "Data has not been updated successfully";
            header("location: Homepage.php");
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

   
</head>
<body>
    <div class="container my-5">
        <h1>Edit Data</h1>
        <hr>
        <form action="edit.php" method="post" enctype="multipart/form-data">
            <?php
                if (isset($_GET['id'])) {
                    //get itemID from the edit button
                        $id = $_GET['id'];
                        $stmt = $conn->query("SELECT * FROM item WHERE itemID = $id");
                        $stmt->execute();
                        $data = $stmt->fetch();            
                }
            ?>
                <div class="mb-3">
                    <label for="itemID" class="col-form-label">item ID:</label>
                    <input type="text" readonly value="<?php echo $data['itemID']; ?>" required class="form-control" name="itemID" >
                    <input type="hidden" value="<?php echo $data['Img']; ?>" required class="form-control" name="Img2" >
                </div>
                <div class="mb-3">
                    <label for="itemName" class="col-form-label">Name:</label>
                    <input type="text" value="<?php echo $data['itemName']; ?>" required class="form-control" name="itemName">
                </div>
                <div class="mb-3">
                    <label for="expDate" class="col-form-label">Expiry Date:</label>
                    <input type="date" value="<?php echo $data['expDate']; ?>" required class="form-control" name="expDate">
                    
                </div>
                <div class="mb-3">
                    <label for="Img" class="col-form-label">Image:</label>
                    <input type="file" class="form-control" id="ImgInput" name="Img">
                    <Img width="100%" src="uploads/<?php echo $data['Img']; ?>" id="previewImg" alt="">
                    </div>
                <div class="mb-3">
                    <label for="quantity" class="col-form-label">Quantity:</label>
                    <input type="text" value="<?php echo $data['quantity']; ?>" class="form-control" name="quantity">
                </div>
                <hr>
                <a href="Homepage.php" class="btn btn-secondary">Go Back</a>
                <button type="submit" name="update" class="btn btn-primary">Update</button>
            </form>
    </div>

    <script>
        let ImgInput = document.getElementById('ImgInput');
        let previewImg = document.getElementById('previewImg');

        ImgInput.onchange = evt => {
            const [file] = ImgInput.files;
                if (file) {
                    previewImg.src = URL.createObjectURL(file)
            }
        }

    </script>
</body>
</html>

<style>

@import url('https://fonts.googleapis.com/css?family=Fredoka+One:400,800');
        .container {
            max-width: 550px;
        }

        body
        {
            background-color: #E9F4FF;
            font-family: 'Fredoka One',monospace;

        }

        input:hover{
            background-color: papayawhip;
        }
        .btn-primary{
            background-color: forestgreen;
            border: 0px;
        }

        .btn-secondary{
            background-color: slategrey;
            border: 0px;
        }
    </style>