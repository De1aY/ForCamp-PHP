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
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <?php
        require_once 'scripts/php/database.php';

        $DB = db_connect();
        if($_GET['page'] == "my"){
            echo "";
        }
        elseif($_GET['page'] == "group"){
            echo"<script type='text/javascript'>
                google.charts.load('current', {'packages':['corechart']});
                google.charts.setOnLoadCallback(drawSeriesChart);
                function drawSeriesChart() {

                var data = google.visualization.arrayToDataTable([
                    ['Статус', 'Общий балл', 'Средний балл', 'Цвет',     ' '],
                    ['Иванов Иван Иванович',    80.66,              1.67,      '1',    1],
                    ['Иванов Иван Иванович',    79.84,              1.36,      '2',    1],
                    ['Иванов Иван Иванович',    78.6,               1.84,      '3',    1],
                    ['Иванов Иван Иванович',    72.73,              2.78,      '4 ',   1],
                    ['Иванов Иван Иванович',    80.05,              2,         '5',    1],
                    ['Иванов Иван Иванович',    72.49,              1.7,       '6',    1],
                    ['Иванов Иван Иванович',    68.09,              4.77,      '7',    1],
                    ['Иванов Иван Иванович',    81.55,              2.96,      '8',    1],
                    ['Иванов Иван Иванович',    68.6,               1.54,      '9',    1],
                    ['Иванов Иван Иванович',    78.09,              2.05,      '10',  1]
                ]);

                var options = {
                    hAxis: {title: 'Общий балл'},
                    vAxis: {title: 'Средний балл'},
                    bubble: {textStyle: {fontSize: 11}}
                };

                var chart = new google.visualization.BubbleChart(document.getElementById('CommonChart'));
                chart.draw(data, options);
                }
                </script>";
        }
        else{
            $Results = array(1,2,3,4,5,6,7,8,9,10);
            $Middle = array(1,2,3,4,5,6,7,8,9,10);
            $Counts = array(1,2,3,4,5,6,7,8,9,10);
            $Arts = array(1,2,3,4,5,6,7,8,9,10);
            $Sports = array(1,2,3,4,5,6,7,8,9,10);
            $Disciplines = array(1,2,3,4,5,6,7,8,9,10);
            $Studies = array(1,2,3,4,5,6,7,8,9,10);
            for($i = 1; $i <= 10; $i++){
                $Counter = 0;
                $Squads = $DB->query("SELECT `Sport`, `Art`, `Study`, `Discipline` FROM `children` WHERE `Squad`='$i'");
                while($Result = mysqli_fetch_array($Squads)){
                    $Counter += 1;
                    $Arts[$i-1] += $Result['Art'];
                    $Sports[$i-1] += $Result['Sport'];
                    $Studies[$i-1] += $Result['Study'];
                    $Disciplines[$i-1] += $Result['Discipline'];
                    $Results[$i-1] += $Result['Sport']+$Result['Art']+$Result['Study']+$Result['Discipline'];
                }
                $Middle[$i-1] = $Results[$i-1]/$Counter;
                $Counts[$i-1] = $Counter;
            }
            echo"<script type='text/javascript'>
                google.charts.load('current', {'packages':['corechart']});
                google.charts.setOnLoadCallback(drawSeriesChart);
                google.charts.setOnLoadCallback(drawChartS);
                google.charts.setOnLoadCallback(drawChartSt);
                google.charts.setOnLoadCallback(drawChartDis);
                google.charts.setOnLoadCallback(drawChartArt);
                google.charts.load('current', {'packages':['table'], 'callback': drawTable});
                function drawChartArt() {
                var data = google.visualization.arrayToDataTable([
                    ['Номер отряда', 'Балл', { role: 'style' } ],
                    ['Отряд 1', $Arts[0], '#b87333'],
                    ['Отряд 2', $Arts[1], 'silver'],
                    ['Отряд 3', $Arts[2], 'gold'],
                    ['Отряд 4', $Arts[3], 'color: #e5e4e2'],
                    ['Отряд 5', $Arts[4], 'black'],
                    ['Отряд 6', $Arts[5], 'blue'],
                    ['Отряд 7', $Arts[6], 'brown'],
                    ['Отряд 8', $Arts[7], 'red'],
                    ['Отряд 9', $Arts[8], 'lime'],
                    ['Отряд 10', $Arts[9], 'color: #0015ff']
                ]);

                var view = new google.visualization.DataView(data);
                view.setColumns([0, 1,
                                { calc: 'stringify',
                                    sourceColumn: 1,
                                    type: 'string',
                                    role: 'annotation' },
                                2]);

                var options = {
                    title: 'Искусство',
                    bar: {groupWidth: '100%'},
                    legend: { position: 'none' },
                };
                var chart1 = new google.visualization.ColumnChart(document.getElementById('ArtChart'));
                chart1.draw(view, options);
                }
                function drawChartSt() {
                var data = google.visualization.arrayToDataTable([
                    ['Номер отряда', 'Балл', { role: 'style' } ],
                    ['Отряд 1', $Studies[0], '#b87333'],
                    ['Отряд 2', $Studies[1], 'silver'],
                    ['Отряд 3', $Studies[2], 'gold'],
                    ['Отряд 4', $Studies[3], 'color: #e5e4e2'],
                    ['Отряд 5', $Studies[4], 'black'],
                    ['Отряд 6', $Studies[5], 'blue'],
                    ['Отряд 7', $Studies[6], 'brown'],
                    ['Отряд 8', $Studies[7], 'red'],
                    ['Отряд 9', $Studies[8], 'lime'],
                    ['Отряд 10', $Studies[9], 'color: #0015ff']
                ]);

                var view = new google.visualization.DataView(data);
                view.setColumns([0, 1,
                                { calc: 'stringify',
                                    sourceColumn: 1,
                                    type: 'string',
                                    role: 'annotation' },
                                2]);

                var options = {
                    title: 'Учёба',
                    bar: {groupWidth: '100%'},
                    legend: { position: 'none' },
                };
                var chart2 = new google.visualization.ColumnChart(document.getElementById('StudyChart'));
                chart2.draw(view, options);
                }
                function drawChartS() {
                var data = google.visualization.arrayToDataTable([
                    ['Номер отряда', 'Балл', { role: 'style' } ],
                    ['Отряд 1', $Sports[0], '#b87333'],
                    ['Отряд 2', $Sports[1], 'silver'],
                    ['Отряд 3', $Sports[2], 'gold'],
                    ['Отряд 4', $Sports[3], 'color: #e5e4e2'],
                    ['Отряд 5', $Sports[4], 'black'],
                    ['Отряд 6', $Sports[5], 'blue'],
                    ['Отряд 7', $Sports[6], 'brown'],
                    ['Отряд 8', $Sports[7], 'red'],
                    ['Отряд 9', $Sports[8], 'lime'],
                    ['Отряд 10', $Sports[9], 'color: #0015ff']
                ]);

                var view = new google.visualization.DataView(data);
                view.setColumns([0, 1,
                                { calc: 'stringify',
                                    sourceColumn: 1,
                                    type: 'string',
                                    role: 'annotation' },
                                2]);

                var options = {
                    title: 'Спорт',
                    bar: {groupWidth: '100%'},
                    legend: { position: 'none' },
                };
                var chart3 = new google.visualization.ColumnChart(document.getElementById('SportChart'));
                chart3.draw(view, options);
                }
                function drawChartDis() {
                var data = google.visualization.arrayToDataTable([
                    ['Номер отряда', 'Балл', { role: 'style' } ],
                    ['Отряд 1', $Disciplines[0], '#b87333'],
                    ['Отряд 2', $Disciplines[1], 'silver'],
                    ['Отряд 3', $Disciplines[2], 'gold'],
                    ['Отряд 4', $Disciplines[3], 'color: #e5e4e2'],
                    ['Отряд 5', $Disciplines[4], 'black'],
                    ['Отряд 6', $Disciplines[5], 'blue'],
                    ['Отряд 7', $Disciplines[6], 'brown'],
                    ['Отряд 8', $Disciplines[7], 'red'],
                    ['Отряд 9', $Disciplines[8], 'lime'],
                    ['Отряд 10', $Disciplines[9], 'color: #0015ff']
                ]);

                var view = new google.visualization.DataView(data);
                view.setColumns([0, 1,
                                { calc: 'stringify',
                                    sourceColumn: 1,
                                    type: 'string',
                                    role: 'annotation' },
                                2]);

                var options = {
                    title: 'Дисциплина',
                    bar: {groupWidth: '100%'},
                    legend: { position: 'none' },
                };
                var chart = new google.visualization.ColumnChart(document.getElementById('DisChart'));
                chart.draw(view, options);
                }
                function drawSeriesChart() {

                var data = google.visualization.arrayToDataTable([
                    ['Название отряда', 'Общий балл', 'Средний балл', 'Цвет',     'Кол-во человек'],
                    ['Отряд 1',    $Results[0],              $Middle[0],      '1',    $Counts[0]],
                    ['Отряд 2',    $Results[1],              $Middle[1],      '2',    $Counts[1]],
                    ['Отряд 3',    $Results[2],              $Middle[2],      '3',    $Counts[2]],
                    ['Отряд 4',    $Results[3],              $Middle[3],      '4',    $Counts[3]],
                    ['Отряд 5',    $Results[4],              $Middle[4],      '5',    $Counts[4]],
                    ['Отряд 6',    $Results[5],              $Middle[5],      '6',    $Counts[5]],
                    ['Отряд 7',    $Results[6],              $Middle[6],      '7',    $Counts[6]],
                    ['Отряд 8',    $Results[7],              $Middle[7],      '8',    $Counts[7]],
                    ['Отряд 9',    $Results[8],              $Middle[8],      '9',    $Counts[8]],
                    ['Отряд 10',    $Results[9],             $Middle[9],      '10',   $Counts[9]]
                ]);

                var options = {
                    hAxis: {title: 'Общий балл'},
                    vAxis: {title: 'Средний балл'},
                    width: '100%',
                    height: '100%',
                    bubble: {textStyle: {fontSize: 11}}
                };
                var chart = new google.visualization.BubbleChart(document.getElementById('CommonChart'));
                chart.draw(data, options);
                }
                function drawTable() {
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Кол-во человек');
                data.addColumn('string', 'Спорт');
                data.addColumn('string', 'Учёба');
                data.addColumn('string', 'Искусство');
                data.addColumn('string', 'Дисциплина');
                data.addRows([
                ['$Counts[0]', '$Sports[0]', '$Studies[0]', '$Arts[0]', '$Disciplines[0]' ],
                ['$Counts[1]', '$Sports[1]', '$Studies[1]', '$Arts[1]', '$Disciplines[1]' ],
                ['$Counts[2]', '$Sports[2]', '$Studies[2]', '$Arts[2]', '$Disciplines[2]' ],
                ['$Counts[3]', '$Sports[3]', '$Studies[3]', '$Arts[3]', '$Disciplines[3]' ],
                ['$Counts[4]', '$Sports[4]', '$Studies[4]', '$Arts[4]', '$Disciplines[4]' ],
                ['$Counts[5]', '$Sports[5]', '$Studies[5]', '$Arts[5]', '$Disciplines[5]' ],
                ['$Counts[6]', '$Sports[6]', '$Studies[6]', '$Arts[6]', '$Disciplines[6]' ],
                ['$Counts[7]', '$Sports[7]', '$Studies[7]', '$Arts[7]', '$Disciplines[7]' ],
                ['$Counts[8]', '$Sports[8]', '$Studies[8]', '$Arts[8]', '$Disciplines[8]' ],
                ['$Counts[9]', '$Sports[9]', '$Studies[9]', '$Arts[9]', '$Disciplines[9]' ]
                ]);

                var table1 = new google.visualization.Table(document.getElementById('TableChart'));

                table1.draw(data, {showRowNumber: true, width: '100%', height: '100%'});
                }
                </script>";
        }
    ?>    
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
    <div id="CommonChart" class="col-md-12" style="height: 50vh"></div>
    <div id="TableChart" class="col-md-12" style="height: 50vh"></div>
    <div id="SportChart" class="col-md-6" style="height: 40vh"></div>
    <div id="StudyChart" class="col-md-6" style="height: 40vh"></div>
    <div id="ArtChart" class="col-md-6" style="height: 40vh"></div>
    <div id="DisChart" class="col-md-6" style="height: 40vh"></div>
    `<!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>