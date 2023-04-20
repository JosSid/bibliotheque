<?php include("../template/header.php") ?>
<?php
    $txtId=(isset($_POST['txtId']))?$_POST['txtId']:"";
    $txtName=(isset($_POST['txtName']))?$_POST['txtName']:"";
    $txtImage=(isset($_FILES['txtImage']['name']))?$_FILES['txtImage']['name']:"";
    $action=(isset($_POST['action']))?$_POST['action']:"";

    include("../config/bd.php");
    switch($action){

        case "add":
            $sentenceSQL = $connect->prepare("INSERT INTO books (name,image) VALUES (:name,:image);");
            $sentenceSQL->bindParam(':name',$txtName);

            $date = new DateTime();
            $fileName = ($txtImage!="")?$date->getTimestamp()."_".$_FILES["txtImage"]["name"]:"imagen.jpg";

            $tmpImage=$_FILES["txtImage"]["tmp_name"];

            if($tmpImage!="") {
                move_uploaded_file($tmpImage,"../../img/".$fileName);
            }
            $sentenceSQL->bindParam(':image',$fileName);
            $sentenceSQL->execute();
            break;
        case "modify":
            $sentenceSQL = $connect->prepare("UPDATE books SET name=:name WHERE id=:id");
            $sentenceSQL->bindParam(':name',$txtName);
            $sentenceSQL->bindParam(':id',$txtId);
            $sentenceSQL->execute();

            if($txtImage != "") {
                $date = new DateTime();
                $fileName = ($txtImage!="")?$date->getTimestamp()."_".$_FILES["txtImage"]["name"]:"imagen.jpg";

                $tmpImage=$_FILES["txtImage"]["tmp_name"];

                move_uploaded_file($tmpImage,"../../img/".$fileName);

                $sentenceSQL = $connect->prepare("SELECT image FROM books WHERE id=:id");
                $sentenceSQL->bindParam(':id',$txtId);
                $sentenceSQL->execute();
                $book = $sentenceSQL->fetch(PDO::FETCH_LAZY);
    
                if(isset($book["image"]) && ($book["image"]!="imagen.jpg")){
                    if(file_exists("../../img/".$book["image"])) {
                        unlink("../../img/".$book["image"]);
                    }
                }

                $sentenceSQL = $connect->prepare("UPDATE books SET image=:image WHERE id=:id");
                $sentenceSQL->bindParam(':image',$fileName);
                $sentenceSQL->bindParam(':id',$txtId);
                $sentenceSQL->execute();
            }

            break;
        case "cancel":
            echo "presionado boton cancel";
            break;
        case "select":
            $sentenceSQL = $connect->prepare("SELECT * FROM books WHERE id=:id");
            $sentenceSQL->bindParam(':id',$txtId);
            $sentenceSQL->execute();
            $book = $sentenceSQL->fetch(PDO::FETCH_LAZY);

            $txtName = $book['name'];
            $txtImage = $book['image'];

            break;
        case "delete":

            $sentenceSQL = $connect->prepare("SELECT image FROM books WHERE id=:id");
            $sentenceSQL->bindParam(':id',$txtId);
            $sentenceSQL->execute();
            $book = $sentenceSQL->fetch(PDO::FETCH_LAZY);

            if(isset($book["image"]) && ($book["image"]!="imagen.jpg")){
                if(file_exists("../../img/".$book["image"])) {
                    unlink("../../img/".$book["image"]);
                }
            }
            $sentenceSQL = $connect->prepare("DELETE FROM books WHERE id=:id");
            $sentenceSQL->bindParam(':id',$txtId);
            $sentenceSQL->execute();
            break;
    }

    $sentenceSQL = $connect->prepare("SELECT * FROM books");
    $sentenceSQL->execute();
    $listBooks = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="col-md-5 mt-5">

    <div class="card">
        <div class="card-header">
            Books Data
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="txtId">ID</label>
                    <input type="text" class="form-control" value="<?php echo $txtId; ?>" id="txtId" name="txtId" placeholder="ID">
                </div>

                <div class="form-group">
                    <label for="txtName">Name</label>
                    <input type="text" class="form-control" value="<?php echo $txtName; ?>" id="txtName" name="txtName" placeholder="Name">
                </div>

                <div class="form-group">
                    <label for="txtImage">Image: </label>
                    <?php echo $txtImage; ?>
                   <br/> 
                    <?php if($txtImage != "") { ?>
                        <img class="img-thumbnail rounded" src="../../img/<?php echo $fileName;?>" width="50" alt="image" />
                    <?php } ?>
                    <input type="file" class="form-control"  id="txtImage" name="txtImage" placeholder="Image">
                </div>

                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="action" value="add" class="btn btn-success">ADD</button>
                    <button type="submit" name="action" value="modify" class="btn btn-warning">MODIFY</button>
                    <button type="submit" name="action" value="cancel" class="btn btn-info">CANCEL</button>
                </div>

            </form>
        </div>

    </div>



</div>

<div class="col-md-7 mt-5">

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>IMAGE</th>
                <th>ACTIONS</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($listBooks as $book) { ?>
            <tr>
                <td><?php echo $book['id'];?></td>
                <td><?php echo $book['name'];?></td>
                <td>
                    <img class="img-thumbnail rounded" src="../../img/<?php echo $book['image'];?>" width="50" alt="image" />
                </td>
                <td>

                    <form method="post">

                        <input type="hidden" name="txtId" id="txtId" value="<?php echo $book['id'];?>">

                        <input type="submit" name="action" value="select" class="btn btn-primary">

                        <input type="submit" name="action" value="delete" class="btn btn-danger">

                    </form>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<?php include("../template/footer.php") ?>