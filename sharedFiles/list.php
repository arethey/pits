<?php
require_once "config.php";
$user_id = $_SESSION["id"];
?>

<div>
    <div class="d-flex align-items-center justify-content-between mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Shared Files</li>
            </ol>
        </nav>
    </div>
    
    <table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">Name</th>
            <th scope="col">Type</th>
            <th scope="col">Size (kb)</th>
            <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $sql2 = "SELECT * FROM sharedfiles INNER JOIN files ON files.id = sharedfiles.file_id WHERE sharedfiles.shared_to = $user_id";
                if($result2 = $mysqli->query($sql2)){
                    if($result2->num_rows > 0){
                        while($row2 = $result2->fetch_array()){
                            if($row2['isArchived'] == 0){
                                echo "<tr>";
                                echo '<td><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark me-2" viewBox="0 0 16 16">
                                <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/>
                              </svg>' . $row2['file_name'] . '</td>';
                                echo "<td>" . $row2['file_type'] . "</td>";
                                echo "<td>" . ($row2['file_size'] * 0.001) . "</td>";
                                echo "<td>";
                                    echo '<a href="download.php?file='.urlencode($row2['file_name']).'" class="me-3" title="Download" data-toggle="tooltip">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                        <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                                        </svg>
                                    </a>';
                                echo "</td>";
                            echo "</tr>";
                            }
                        }
                    // Free result set
                    $result2->free();
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            ?>
        </tbody>
    </table>
</div>