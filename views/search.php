<?php
function pinPoints( array $times ){
    $detections = '';

    foreach ( $times as $time ){
        $minutes = substr(($time / 60), 0, 1);
        $seconds = floatval(('0'. substr(($time / 60), 1)));
        $seconds = str_pad((round($seconds * 60)), 2, 0, STR_PAD_LEFT);

        $detections .= " $minutes:$seconds";
    }

    return trim($detections);
}
if ( isset( $_GET[ 'search' ] ) ){
    require_once '../controllers/database.php';
    require_once '../controllers/process.php';
    require_once '../controllers/filesController.php';

    $ids = [];
    $contents = Processor::select('audios');
    $index = 0;
    foreach ($contents as $content) {

        $ids[$index] = $content['content'];
        $index++;
    }

    $search = new FilesController();
    $matches = [];
    $results = '';

    foreach ($ids as $index => $id) {

        $match = $search->search($_GET['search'],$id);
        array_push($contents[$index], json_decode($match, true));

        if (!empty($contents[$index][0]['startTime'])){
            $results .= '<div class="col-lg-10 col-lg-offset-1">
    <div class="col-lg-2">
        <a class="thumbnail">
            <img src="http://'.$contents[$index]["logo"].'">
        </a>
    </div>
    <div class="col-lg-10">
        <h5><strong>'.$contents[$index]["name"].'</strong> - '.$contents[$index]["frequency"].': '.$contents[$index]["city"].' - '.$contents[$index]["country"].'</h5>
        <p>'.$contents[$index]["show_name"].' : '.$contents[$index]["createdOn"].'</p>
        <audio class="col-lg-12" controls>
            <source src="http://'.$contents[$index]["data_url"].'" type="audio/mpeg">
        </audio>
        <div class="col-lg-12" style="margin-top: 10px">
            Pin Points: <i>'.pinPoints($contents[$index][0]['startTime']).'</i>
        </div>
        <div class="col-lg-12" style="margin-top: 10px">
            <i class="fa fa-facebook-square fa-2x" aria-hidden="true" style="margin-left: 3px"></i>
            <i class="fa fa-twitter-square fa-2x" aria-hidden="true" style="margin-left: 3px"></i>
        </div>
    </div>
    <div class="col-xs-12"><hr></div>
</div>';
        }

//        print_r($contents[$index]);
//        echo "<br>";
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Qisimah Audio Insights</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:300,400">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/stylesheet.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="js/qisimah.min.js"></script>


</head>
<body>
<!--Navbar-->
<div id="searchnavbar" class="nav navbar-default">
    <div class="container">
        <a href="../index.html"><img src="../img/logo.png" width="20%" class="col-lg-2" /></a>
        <div id="searchable" class="input-group col-xs-8 col-sm-8 col-md-8 col-lg-8">
            <form method="get" action="">
                <input type="text" class="form-control" name="search" value="<?php echo $_GET['search'] ?>">
            </form>
        </div>
    </div>
</div>
<!--Navbar-->

<!--Search Results-->
<?php echo $results ?>
<!--<div class="col-lg-10 col-lg-offset-1">-->
<!--    <div class="col-lg-2">-->
<!--        <a class="thumbnail">-->
<!--            <img src="../img/peacfm.png">-->
<!--        </a>-->
<!--    </div>-->
<!--    <div class="col-lg-10">-->
<!--        <h5><strong>Name of Radio Station</strong> - 000.00MHz: City - Country</h5>-->
<!--        <p>Name of program : 13-02-2017 0935hr</p>-->
<!--        <audio class="col-lg-12" controls>-->
<!--            <source src="http://q.sigconert.com/uploads/022017/13/1486981429.mp3" type="audio/mpeg">-->
<!--        </audio>-->
<!--        <div class="col-lg-12" style="margin-top: 10px">-->
<!--            <i class="fa fa-facebook-square fa-2x" aria-hidden="true" style="margin-left: 3px"></i>-->
<!--            <i class="fa fa-twitter-square fa-2x" aria-hidden="true" style="margin-left: 3px"></i>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="col-xs-12"><hr></div>-->
<!--</div>-->

<!--Search Results-->

</body>
</html>
