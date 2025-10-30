<?php
include("conn.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./bootstrap/bootstrap.css">
    <link rel="stylesheet" href="./css/adminPage.css">
    <title>Document</title>
</head>
<body>
    <nav class="nav-list">
        <h2>Admin dasboard</h2>
    </nav>
    <div class="container my-5">
            <?php
            if(isset($_GET['msg'])){
                            ?>
            <div class="alert alert-warning alert-dismissible fade show header-notification" role="alert" style="  color: #06310a; background-color: #69e77668;">
            <strong><img src="./img/award-fill.svg" alt=""
            style="filter: brightness(0) saturate(100%) invert(32%) sepia(82%) saturate(3094%) hue-rotate(350deg) brightness(101%) contrast(98%);"
            ></strong><?php echo $_GET['msg']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            
            <?php
            }
            ?>
            <h2 class="heading-2">List Of Students</h2>
        <a class="btn btn-primary mb-3" role="button" href="create.php">Add Exam Questions</a>
        <br>
        <table class="table table-hover-color">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Email</th>
                <th scope="col">Reg Date</th>
                <th scope="col">Profil Picture</th>
                <th scope="col">Edit & Delete</th>
                </tr>
            </thead>
            <?php
            $sql="SELECT * FROM customer";
            
            $result=mysqli_query($conn,$sql);
             
            if($result){
                while($row=mysqli_fetch_assoc($result)){
                    $fname=$row['first_name'];
                    $id=$row['ID'];
                    $lname=$row['last_name'];
                    $email=$row['email'];
                    $date=$row['reg_date'];
                    $imageName=$row['file'];
                    
                    ?>
                    <tbody>
                <tr>
                <th scope="row" style="color:#fc411e">'<?php echo$id; ?></th>
                <td><?php echo $fname; ?></td>
                <td style="color:#fc411e"><?php echo$lname; ?></td>
                <td><?php echo$email; ?></td>
                <td style="color:#fc411e"><?php echo$date; ?></td>

                <td><img src="upload/<?php  echo$imageName;  ?>" alt="" style=" border-radius: 20px; object-fit:cover;" width="36px" height="36px"></td>
                <td>
                   
                      <div class="row">
                            <div class="col-6"><a href="edit.php?editid=<?php echo $id; ?>" role="button" name="edit" id="edit-logo"><img src="./img/pencil-square.svg" alt="" width="22px"></a></div>
                            <div class="col-6"><a href="delet.php?id=<?php echo $id; ?>" role="button" name="delete" id="delete-logo" onclick="return confirm('are you sure')"><img src="./img/trash3-fill.svg" alt="" width="22px"></a></div>
                        </div>
                </td>
                </tr>
            </tbody>
            <?php    }
            } else {
                echo 'error';
            }
            
            ?>
    <script src="./js/bootstrap.js"></script>        
</table>
    </div>
</body>
</html>