<?php include("../template/header.php") ?>
<?php
    $txtId=(isset($_POST['txtId']))?$_POST['txtId']:"";
    $txtName=(isset($_POST['txtName']))?$_POST['txtName']:"";
    $txtImage=(isset($_FILES['txtImage']['name']))?$_FILES['txtImage']['name']:"";
    $action=(isset($_POST['action']))?$_POST['action']:"";

    echo $txtId."<br/>";
    echo $txtName."<br/>";
    echo $txtImage."<br/>";
    echo $action."<br/>";

    $host="localhost";
    $bd="sitio";
    $usuario="root";
    $contraseña="";

    try {
        $connect=new PDO("mysql:host=$host;dbname=$bd",$usuario,$contraseña);
        if($connect){echo "Connect to ".$bd." DB";}
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }

    switch($action){

        //INSERT INTO `books` (`id`, `name`, `image`) VALUES (NULL, 'Libro de php', 'imagen.jpg');
        case "add":
            echo "presionado boton add";
            $sentenciaSQL = $connect->prepare("INSERT INTO `books` (`id`, `name`, `image`) VALUES (NULL, 'Libro de php', 'imagen.jpg')");
            $sentenciaSQL->execute();
            break;
        case "modify":
            echo "presionado boton modify";
            break;
        case "cancel":
            echo "presionado boton cancel";
            break;
    }
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
            <tr>
                <td>2</td>
                <td>Aprende php</td>
                <td>imagen.jpg</td>
                <td>seleccionar|borrar</td>
            </tr>

        </tbody>
    </table>
</div>

<?php include("../template/footer.php") ?>