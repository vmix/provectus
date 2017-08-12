<?php
spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="keywords" content="Тестовое задание для Provectus">
    <meta name="author" content="Viacheslav Mykhailov <vm.php.academy@gmail.com>">
    <title>Тестовое задание для Provectus</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="container">
    <div class="col-lg-3">
        <h2>Введите даты: </h2>
        <form action="" method="post" class="form-group">
            <label for="start_date"></label><input type="date" name = "start_date" id="start_date" class="form-control">
            <label for="end_date"></label><input type="date" name = "end_date" id="end_date" class="form-control">
            <input type="submit" value="Рассчитать!" class="btn btn-primary">
        </form>
    </div>
    <?php
    if (!empty($_POST)) {

    $start_date = strip_tags($_POST['start_date']);
    $end_date = strip_tags($_POST['end_date']);
    $interval = new dayInterval($start_date, $end_date);
    ?>
    <div class="col-lg-9">
        <div class="alert alert-info"><?= "Прошло <b>" . $interval->dayInterval($start_date, $end_date) . "</b> дней между " .  $start_date . " и " . $end_date ?></div>
        <div class="alert alert-warning"><?=  "Годы: <b>" . $interval->years . "</b>" ?></div>
        <div class="alert alert-warning"><?=  "Месяцы: <b>" . $interval->months . "</b>" ?></div>
        <div class="alert alert-warning"><?=  "Дни: <b>" . $interval->days . "</b>" ?></div>
    </div>
</div>
<?php
}
?>

</body>
</html>
