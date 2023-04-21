<?php include("template/header.php"); ?>

<?php 
    include("administrador/config/bd.php");
    $sentenceSQL = $connect->prepare("SELECT * FROM books");
    $sentenceSQL->execute();
    $listBooks = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<?php foreach($listBooks as $book) { ?>
<div class="col-md-3">
    <div class="card">
        <img class="card-img-top" height="400" src="./img/<?php echo $book['image']; ?>" alt="">
        <div class="card-body">
            <h4 class="card-title"><?php echo $book['name']; ?></h4>
            <a name="" id="" class="btn btn-primary" href="https://goalkicker.com/" role="button">See more</a>
        </div>
    </div>
</div>
<?php } ?>

<?php include("template/footer.php"); ?>