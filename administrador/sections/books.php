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
            $sentenceSQL->bindParam(':image',$txtImage);
            $sentenceSQL->execute();
            break;
        case "modify":
            echo "presionado boton modify";
            break;
        case "cancel":
            echo "presionado boton cancel";
            break;
        case "select":
            echo "presionado boton select";
            break;
        case "delete":
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
                    <input type="text" class="form-control" id="txtId" name="txtId" placeholder="ID">
                </div>

                <div class="form-group">
                    <label for="txtName">Name</label>
                    <input type="text" class="form-control" id="txtName" name="txtName" placeholder="Name">
                </div>

                <div class="form-group">
                    <label for="txtImage">Image</label>
                    <input type="file" class="form-control" id="txtImage" name="txtImage" placeholder="Image">
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
                <td><?php echo $book['image'];?></td>
                <td>
                    seleccionar|borrar

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