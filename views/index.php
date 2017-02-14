<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../controllers/database.php';
require_once '../controllers/process.php';
require_once '../controllers/filesController.php';

$stations = Processor::select('stations');
$shows = Processor::select('shows');

//1486721553-0647ca59-6631-4f14-becb-6400ca36c736-7881780588

if (isset($_POST['upload'])){

    $uploadFile = new FilesController();
    $upload = $uploadFile->upload( $_FILES[ 'files' ] );

    if ( gettype( $upload ) === 'array' ){

        $data = [
            ':station_id' => $_POST['station'],
            ':show_id' => $_POST['show'],
            ':id' => json_decode($upload[1],true)['contentID'],
            ':data_url' => $upload[2]
        ];

        $save = Processor::insert('contents', $data );

        if ($save){
            echo "<script>alert('Data saved successfully!');</script>";
        }
    } else {
        var_dump( $upload );
    }


} else if (isset($_POST['save_station'])){

    $file = new FilesController();
    $uploadFile = $file->logo( $_FILES['image'] );

    if (gettype($uploadFile) === 'array'){
        $data = [
            ':name' => ucfirst(strtolower(trim($_POST[ 'name' ]))),
            ':frequency' => trim($_POST[ 'freq' ]),
            ':city' => ucfirst(strtolower(trim($_POST[ 'city' ]))),
            ':country' => ucfirst(strtolower(trim($_POST[ 'country' ]))),
            ':telephone' => trim($_POST[ 'telephone' ]),
            ':logo' => $uploadFile[1]
        ];

        $save = Processor::insert('stations', $data);

        if ($save){
            echo "<script>alert('Data saved successfully!');</script>";
        }

    } else {
        var_dump($uploadFile);
    }


} else if ( isset($_POST['save_show'])){

    $data = [
        ':station_id' => $_POST['station'],
        ':name' => ucfirst(strtolower(trim($_POST[ 'name' ]))),
        ':host'=> ucfirst(strtolower(trim($_POST[ 'host' ]))),
        ':start'=> trim($_POST['start']),
        ':finish'=> trim($_POST['finish'])

    ];

    $save = Processor::insert('shows', $data);
    if ($save){
        echo "<script>alert('Data saved successfully!');</script>";
    }
}

?>

<html>
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
</head>
<body>

<!--Navbar-->
<div id="searchnavbar" class="nav navbar-default">
    <div class="container">
        <img src="../img/logo.png" width="20%" class="col-lg-2" />
    </div>
</div>
<!--Navbar-->
<!--Add Radio Station-->
<div class="container" style="margin-top: 20px">
    <form class="form-horizontal container" method="post" action="index.php" enctype="multipart/form-data">
        <fieldset>
            <h4>Add Radio Station</h4>
        </fieldset>
        <div class="form-group col-xs-12">
            <div class="col-lg-2 text-right">
                <label class="control-label" for="station-name">Name:</label>
            </div>
            <div class="col-lg-5 input-group">
                <input type="text" name="name" class="form-control" placeholder="Station Name">
                <span class="input-group-addon">FM</span>
            </div>
        </div>

        <div class="form-group col-xs-12">
            <div class="col-lg-2 text-right">
                <label class="control-label text-right" for="station-name">Frequency:</label>
            </div>
            <div class="col-lg-5 input-group">
                <input type="text" name="freq" class="form-control" placeholder="123.45">
                <span class="input-group-addon">MHz</span>
            </div>
        </div>

        <div class="form-group col-xs-12">
            <div class="col-lg-2 text-right">
                <label class="control-label text-right" for="station-name">Country:</label>
            </div>
            <div class="col-lg-5 input-group">
                <input type="text" name="country" class="form-control" placeholder="Ghana">
                <span class="input-group-addon"><i class="fa fa-globe"></i></span>
            </div>
        </div>

        <div class="form-group col-xs-12">
            <div class="col-lg-2 text-right">
                <label class="control-label text-right" for="station-name">City:</label>
            </div>
            <div class="col-lg-5 input-group">
                <input type="text" name="city" class="form-control" placeholder="Accra">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
            </div>
        </div>

        <div class="form-group col-xs-12">
            <div class="col-lg-2 text-right">
                <label class="control-label text-right" for="station-name">Telephone:</label>
            </div>
            <div class="col-lg-5 input-group">
                <input type="telephone" name="telephone" class="form-control" placeholder="0249621938">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
            </div>
        </div>

        <div class="form-group col-xs-12">
            <div class="col-lg-2 text-right">
                <label class="control-label text-right" for="station-name">Logo:</label>
            </div>
            <div class="col-lg-5 input-group">
                <input type="file" name="image" class="form-control" placeholder="Accra">
                <span class="input-group-addon"><i class="fa fa-file-image-o"></i></span>
            </div>
        </div>

        <div class="form-group col-xs-12">

            <div class="col-lg-5 col-lg-offset-2 input-group">
                <input type="submit" name="save_station" class="btn btn-primary form-control" value="Save">
            </div>
        </div>
    </form>
    <hr>
</div>

<!--Add Program-->
<div class="container" style="margin-top: 20px">
    <form class="form-horizontal container" method="post" action="" enctype="multipart/form-data">
        <fieldset>
            <h4>Add Show</h4>
        </fieldset>
        <div class="form-group col-xs-12">
            <div class="col-lg-2 text-right">
                <label for="select" class="control-label">Radio Station:</label>
            </div>

            <div class="col-lg-5">

                <select class="form-control col-lg-12" id="select" name="station">
                    <option value="" disabled selected>Select Radio Station</option>
                    <?php
                    foreach ( $stations as $station ){?>
                        <option value="<?php echo $station['id']?>"><?php echo $station['name']?></option>
                    <?php } ?>

                </select>
            </div>
        </div>

        <div class="form-group col-xs-12">
            <div class="col-lg-2 text-right">
                <label class="control-label text-right" for="station-name">Name:</label>
            </div>
            <div class="col-lg-5 input-group">
                <input type="text" name="name" class="form-control" placeholder="Enter program name">
            </div>
        </div>

        <div class="form-group col-xs-12">
            <div class="col-lg-2 text-right">
                <label class="control-label text-right" for="station-name">Host:</label>
            </div>
            <div class="col-lg-5 input-group">
                <input type="text" name="host" class="form-control" placeholder="Enter name of host">
            </div>
        </div>

        <div class="form-group col-xs-12">
            <div class="col-lg-2 text-right">
                <label class="control-label text-right" for="station-name">Start Time:</label>
            </div>
            <div class="col-lg-5 input-group">
                <input type="text" name="start" class="form-control" placeholder="13:15:00">
            </div>
        </div>

        <div class="form-group col-xs-12">
            <div class="col-lg-2 text-right">
                <label class="control-label text-right" for="station-name">End Time:</label>
            </div>
            <div class="col-lg-5 input-group">
                <input type="text" name="finish" class="form-control" placeholder="15:00:00">
            </div>
        </div>

<!--        <div class="form-group col-xs-12">-->
<!--            <div class="col-lg-2 text-right">-->
<!--                <label class="control-label text-right" for="station-name">Logo:</label>-->
<!--            </div>-->
<!--            <div class="col-lg-5 input-group">-->
<!--                <input type="file" class="form-control" placeholder="Accra">-->
<!--                <span class="input-group-addon"><i class="fa fa-file-image-o"></i></span>-->
<!--            </div>-->
<!--        </div>-->

        <div class="form-group col-xs-12">

            <div class="col-lg-5 col-lg-offset-2 input-group">
                <input type="submit" name="save_show" class="btn btn-primary form-control" value="Save">
            </div>
        </div>
    </form>
    <hr>
</div>

<!--Upload file-->
<div class="container" style="margin-top: 20px">
    <form class="form-horizontal" method="post" action="index.php" enctype="multipart/form-data">
        <fieldset>
            Upload Audio
        </fieldset>
        <div class="form-group col-xs-12">
            <div class="col-lg-2 text-right">
                <label for="select" class="control-label">Radio Station:</label>
            </div>

            <div class="col-lg-5">
                <select class="form-control col-lg-12" id="station" name="station">
                    <option value="" disabled selected>Select Radio Station</option>
                    <?php
                    foreach ( $stations as $station){?>
                        <option value="<?php echo $station['id']?>"><?php echo $station['name']?></option>
                    <?php }?>
                </select>
            </div>
        </div>

        <div class="form-group col-xs-12">
            <div class="col-lg-2 text-right">
                <label for="select" class="control-label">Name of show:</label>
            </div>

            <div class="col-lg-5">
                <select class="form-control col-lg-12" id="show" name="show">
                    <option value="" disabled selected>Select Show</option>
                    <?php
                    foreach ( $shows as $show){?>
                    <option value="<?php echo $show['id']?>"><?php echo $show['name']?></option>
                    <?php }?>
                </select>
            </div>
        </div>


        <div class="form-group">
            <div class="col-lg-2 text-right">
                <label>Audio file:</label>
            </div>
            <div class="col-lg-5">
                <input type="file" name="files" class="form-control">
            </div>
        </div>
        <div class="form-group col-xs-12">

            <div class="col-lg-5 col-lg-offset-2 input-group">
                <input type="submit" class="btn btn-primary form-control" name="upload" value="Upload">
            </div>
        </div>
    </form>
    <hr>
</div>

</body>
</html>
