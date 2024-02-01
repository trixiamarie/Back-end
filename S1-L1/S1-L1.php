<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>League of Legends</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <?php
   
   $data =(date("d-m-y"));
    echo "Oggi è il $data buona giornata!";
    echo "<p>$data</p> <p>$data</p> <p>$data</p>";


    $G2 = ['expect', 'trick', 'perks', 'zven', 'mithy'];
    $T1 = ['zeus', 'faker', 'oner', 'guma', 'keria'];
    $DRX = ['canna', 'canyon', 'showmaker', 'deft', 'kellin'];
    $teams = [$G2, $T1, $DRX];
    
    echo '<table class="border border-1 text-center">';
    echo '<thead><tr><th></th><th>TOP</th><th>MID</th><th>JUNGLE</th><th>BOT</th><th>SUPPORT</th></tr></thead><tbody>';
    
    for ($i = 0; $i < count($teams); $i++) {
        echo "<tr><td class='bg-dark text-white px-3'>SQUADRA " . ($i + 1) . "</td>";
        for ($j = 0; $j < count($teams[$i]); $j++) {
            echo "<td class='p-3'>{$teams[$i][$j]}</td>";
        }
        echo '</tr>';
    }
    echo '</tbody></table>';
    
    $partita1 = [$G2, $T1];
    $partita2 = [$G2, $DRX];
    $partita3 = [$T1, $DRX];
    
    $partite = [$partita1, $partita2, $partita3];
    
    echo "<table class='border border-1 text-center'><thead><tr>";
    
    for ($i = 0; $i < count($partite); $i++) {
        echo "<th colspan='5'>Partita " . ($i + 1) . "</th>";
    }
    echo "</tr></thead><tbody>";
    
    for ($j = 0; $j < count($partite[0]); $j++) {
        echo "<tr>";
    
        for ($i = 0; $i < count($partite); $i++) {
            echo "<td>";
            for ($z = 0; $z < count($partite[$i][$j]); $z++) {
                echo "<ul><li>" . $partite[$i][$j][$z]. "</li></ul>";
            }
            echo "</td>";
        }
    
        echo "</tr>";
    }
    
    echo "</tbody></table>";

 
?>


</body>
</html>