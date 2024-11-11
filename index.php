<?php
    require_once "connection.php";

    class MySQL_Exception extends Exception{
        public function __construct($message){
            parent::__construct($message);
        }
    }
    ////Достают все таблицы из бд
    // try{
    //     $result = mysqli_query($link, "SHOW TABLES");

    //     if(!$result) throw new MySQL_Exeption(mysqli_error($link));

    //     echo "<p>Таблицы имеющиеся в базе данных: </p><ul>";

    //     while($row = mysqli_fetch_row($result)){
    //         echo "<li>Таблица: {$row[0]}</li>";
    //     }

    //     echo "</ul>";
    // }catch(Exception $ex){
    //     echo "Ошибка при работе с MySql: <b style='color:red;'>".$ex->getMessage()."</b>";
    // }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Основы php и MySql</title>
    <Style>
    /* Стилизация таблиц */
    table { border-collapse:separate; border:none; border-spacing:0; margin:8px 12px 18px 6px; line-height:1.2em; margin-left:auto; margin-right:auto; overflow: auto }
    table th { font-weight:bold; background:#666; color:white; border:1px solid #666; border-right:1px solid white }
    table th:last-child { border-right:1px solid #666 }
    table caption { font-style:italic; margin:10px 0 20px 0; text-align:center; color:#666; font-size:1.2em }
    tr{ border:none }
    td { border:1px solid #666; border-width:1px 1px 0 0 }
    td, th { padding:15px }
    tr td:first-child { border-left-width:1px }
    tr:last-child td { border-bottom-width:1px }
    </Style>
</head>
<body>
    <?php 
        try{
            $result = $link->query('SHOW TABLES');

            if(!$result) throw new MySQL_Exception($link->error);

            $link->query("INSERT INTO customers VALUES ('Андрей'), ('Александр');");

            echo "<p> Таблицы имеющиеся в базе данных: </p><ul>";

            while($row = $result->fetch_row()){
                echo "<table><caption> {$row[0]} </caption><tr>";
                
                $result1 = $link->query("SELECT * FROM {$row[0]}");
                
                if(!$result1) throw new MySQL_Exception($link->error);
                
                for($i = 0; $i < $link->field_count; $i++ ){
                    $field_info = $result1->fetch_field();
                    echo "<th>{$field_info->name}</th>";
                }

                echo "</tr>";

                while($row1 = $result1->fetch_row()){
                    echo "<tr>";
                    
                    foreach($row1 as $_column){
                        echo "<td>{$_column}</td>";
                    }

                    echo "</tr>";
                }

                echo "</table>";

            }
        }catch(Exception $ex){
            echo "Ошибка при работе с MySQL: <b style='color:red;'>".$ex.getMessage()."</b>";
        }
            
    ?>
</body>
</html>