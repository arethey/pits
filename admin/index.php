<?php 
include "includes/header.php";

$users = array();
$users_data = array();
$sql = "SELECT * FROM users WHERE isAdmin = 0";
if($result = $mysqli->query($sql)){
    if($result->num_rows > 0){
        while($row = $result->fetch_array()){
            array_push($users, $row['fullname']);

            $id = $row['id'];
            $sql2 = "SELECT * FROM files WHERE created_by = $id AND isArchived = 0";
            if($result2 = $mysqli->query($sql2)){
                array_push($users_data, $result2->num_rows);
            }
        }
        // Free result set
        $result->free();
    }
}
?>

<div>
  <canvas id="myChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const users = <?php echo json_encode($users); ?>;
    const users_data = <?php echo json_encode($users_data); ?>;
console.log({users_data})
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
        labels: users,
        datasets: [{
            label: 'Count Per Upload File of a user',
            data: users_data,
            borderWidth: 1
        }]
        },
        options: {
        scales: {
            y: {
            beginAtZero: true
            }
        }
        }
    });
</script>

<?php include "includes/footer.php"; ?>