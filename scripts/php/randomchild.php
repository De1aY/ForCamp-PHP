<?php
    require_once 'database.php';

    $DB = db_connect();
    $Names = array("Никита", "Андрей", "Саша", "Женя", "Тимур", "Алексей", "Тихон", "Булат", "Анатолий", "Эмиль", "Ренат", "Ринат");
    $Surnames = array("Иванов", "Романов", "Румянцев", "Хусаинов", "Юсупов", "Журавлёв", "Хайруллин", "Якупов", "Габдрахманов", "Гиматов", "Шакиров", "Ибрагимов");
    $ThirdNames = array("Егорович", "Анатольевич", "Чингизович", "Сергеевич", "Андреевич", "Георгиевич", "Тагирович", "Дмитриевич", "Александрович", "Николаевич", "Айратович", "Валерьевич");
    $Squad = rand(1,10);
    $Art = rand(1,10);
    $Sport = rand(1,10);
    $Discipline = rand(1,10);
    $Study = rand(1,10);
    $Name = $Names[rand(0,11)];
    $Surname = $Surnames[rand(0,11)];
    $ThirdName = $ThirdNames[rand(0,11)];
    $Password = md5("123456");
    $DB->query("INSERT INTO `children` (`Squad`, `Name`, `Surname`, `ThirdName`, `Art`, `Sport`, `Discipline`, `Study`, `Password`) VALUES ('$Squad', '$Name', '$Surname', '$ThirdName', '$Art', '$Sport','$Discipline' ,'$Study', '$Password')");
    $ID = mysqli_fetch_assoc($DB->query("SELECT `ID` FROM `children` WHERE `Name`='$Name' AND `Surname`='$Surname' AND `ThirdName`='$ThirdName' AND `Study`='$Study' AND `Squad`='$Squad'"))["ID"];
    $User = "user_".$ID;
    $DB->query("UPDATE `children` SET `Login`='$User' WHERE `Name`='$Name' AND `Surname`='$Surname' AND `ThirdName`='$ThirdName' AND `Study`='$Study' AND `Squad`='$Squad'");
    $DB->close();
    echo "Вы успешно добавили человека в лагерь!";
?>