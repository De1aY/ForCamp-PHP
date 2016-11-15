<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ForCamp</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/index.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">ForCamp</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav MainMenu">
                    <?php
                        if($_GET['page'] == "my"){
                            echo "<li><a href='index.php?page=all'><i class='fa fa-trophy fa-2x' aria-hidden='true'></i></a></li>
                                <li><a href='index.php?page=group'><i class='fa fa-users fa-2x' aria-hidden='true'></i></a></li>
                                <li class='active'><a href='index.php?page=my'><i class='fa fa-street-view fa-2x' aria-hidden='true'></i><span class='sr-only'>(current)</span></a></li>";
                        }
                        elseif($_GET['page'] == "group"){
                            echo "<li><a href='index.php?page=all'><i class='fa fa-trophy fa-2x' aria-hidden='true'></i></a></li>
                                <li class='active'><a href='index.php?page=group'><i class='fa fa-users fa-2x' aria-hidden='true'></i><span class='sr-only'>(current)</span></a></li>
                                <li><a href='index.php?page=my'><i class='fa fa-street-view fa-2x' aria-hidden='true'></i></a></li>";
                        }
                        else{
                            echo "<li class='active'><a href='index.php?page=all'><i class='fa fa-trophy fa-2x' aria-hidden='true'></i><span class='sr-only'>(current)</span></a></li>
                                <li><a href='index.php?page=group'><i class='fa fa-users fa-2x' aria-hidden='true'></i></a></li>
                                <li><a href='index.php?page=my'><i class='fa fa-street-view fa-2x' aria-hidden='true'></i></a></li>";
                        }
                    ?>
                </ul>
                <ul class="nav navbar-nav navbar-right Exit">
                    <li><a href="#"><i class="fa fa-sign-in fa-2x" aria-hidden="true"></i></a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>