<?php

if(empty($_GET['search']) === true){
    while($row = $connect_statment->fetch(PDO::FETCH_ASSOC)){
        echo'<tr>';
        echo'<td>'.$row['title'].'<td>';
        echo'<td>'.$row['title'].'<td>';
    }

}