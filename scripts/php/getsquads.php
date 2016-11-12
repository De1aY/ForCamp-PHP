<?php
    require_once 'database.php';
    
    $DB = db_connect();
    $Results = "";
    $Squads = $DB->query("SELECT `Name`, `Surname`, `ThirdName`, `Sport`, `Art`, `Study`, `Discipline`, `Squad` FROM `children`");
    while($Result = mysqli_fetch_array($Squads)){
        $Results = $Results.$Result['Squad']."!".$Result['Name']."!".$Result['Surname']."!".$Result['ThirdName']."!".$Result['Sport']."!".$Result['Art']."!".$Result['Study']."!".$Result['Discipline']."#";
    }
    echo $Results;
    $DB->close();
?>