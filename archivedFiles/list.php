<?php
require_once "config.php";
$user_id = $_SESSION["id"];
?>

<div>
    <div class="d-flex align-items-center justify-content-between mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Archived Files</li>
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
                $sql2 = "SELECT * FROM files WHERE isArchived = 1 AND created_by = $user_id";
                if($result2 = $mysqli->query($sql2)){
                    if($result2->num_rows > 0){
                        while($row2 = $result2->fetch_array()){
                            echo "<tr>";
                                echo '<td><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark me-2" viewBox="0 0 16 16">
                                <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/>
                              </svg>' . $row2['file_name'] . '</td>';
                                echo "<td>" . $row2['file_type'] . "</td>";
                                echo "<td>" . ($row2['file_size'] * 0.001) . "</td>";
                                echo "<td>";
                                    echo '<a href="archivedFiles.php?page=archived&isArchived=0&id='. $row2['id'] .'" class="me-3" title="Archive" data-toggle="tooltip">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16">
                                    <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1V2zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5H2zm13-3H1v2h14V2zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                                    </svg>
                                </a>';
                                echo "</td>";
                            echo "</tr>";
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