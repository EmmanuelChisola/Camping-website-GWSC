<?php
// Connect to MySQL
include "db_conn.php";

// Insert the review into the database
if(isset($_POST['name'])) {
    $name = $_POST['name'];
    $site = $_POST['site'];
    $pitch = $_POST['pitch'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $created_at = date('Y-m-d H:i:s'); // get the current date and time

    $sql = "INSERT INTO reviews (name, site, pitch, rating, comment, created_at) VALUES ('$name', '$site', '$pitch', '$rating', '$comment', '$created_at')";
    $conn->query($sql);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: lightgreen;
        }

        h1 {
            text-align: center;
            margin-top: 2rem;
            margin-bottom: 1rem;
        }

        form {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: hsl(206, 34%, 20%);
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        label, select, textarea {
            display: block;
            margin: 1rem 0;
            font-size: 1.2rem;
            font-weight: bold;
        }

        input[type="text"],
        select,
        textarea {
            width: 100%;
            padding: 0.5rem;
            border-radius: 4px;
            border: 1px solid #ccc;
            background-color: #fff;
            font-size: 1.2rem;
            font-weight: normal;
        }

        select option.opt {
            font-weight: normal;
        }

        textarea {
            resize: vertical;
            height: 8rem;
        }

        button[type="submit"] {
            display: block;
            margin: 2rem auto 0;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            border: none;
            background-color: #333;
            color: #fff;
            font-size: 1.2rem;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #555;
        }

        .reviews {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .review {
            margin: 1rem 0;
            padding: 1rem;
            background-color: #f5f5f5;
            border-radius: 4px;
            box-shadow: 0 0 4px rgba(0,0,0,0.2);
        }

        .review h3 {
            margin: 0;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .review p {
            margin: 0;
            font-size: 1.1rem;
            font-weight: normal;
        }

        .pagination {
            margin: 2rem auto;
            text-align: center;
        }

        .pagination a,
        .pagination span {
            display: inline-block;
            margin: 0.5rem;
            padding: 0.5rem;
            border-radius: 4px;
            border: 1px solid #ccc;
            background-color: #fff;
            color: #333;
            font-size: 1.2rem;
            font-weight: normal;
            text-decoration: none;
            cursor: pointer;
        }

        .pagination a:hover {
            background-color: #f5f5f5;
        }

        .pagination span {
            background-color: #333;
            color: #fff;
        }
        
        </style>
</head>
<body>
    
    <form method="post" action="reviews.php">
        <label>Name:</label>
        <input type="text" name="name" required placeholder="Emmanuel">

        <div class="input-wrapper">
            <label for="Site" class="input-label">Site</label>
            <select name="site" id="site" class="input-field">
                <option value="Kalimba Farms" class="opt">Kalimba Farms</option>
                <option value="Monkey Pools" class="opt">Monkey Pools</option>
                <option value="Adventure City" class="opt">Adventure City</option>
            </select>

            <label for="pitch" class="input-label">Pitch</label>
            <select name="pitch" id="pitch" class="input-field">
                <option value="Mori Motorhome" class="opt">Mori Motorhome</option>
                <option value="Eureka Tent" class="opt">Eureka Tent</option>
                <option value="Nkobo Caravan" class="opt">Nkobo Caravan</option>
            </select>
        </div>

        <label>Rating:</label>
        <select name="rating" required>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
        
        <label>Review:</label>
        <textarea name="comment" required placeholder="My experiece is inexplicable, their customer service is on point and are very polite."></textarea>
        
        <button type="submit">Submit</button>
        
    </form>
</body>

</html>
<?php
include "db_conn.php";
$sql = "SELECT * FROM reviews ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Reviews</h2>";
    echo "<div id='reviews'>";
    while($row = $result->fetch_assoc()) {
        echo "<div class='review'>";
        echo "<h3>Name:" . $row["name"] . "</h3>";
        echo "<p><strong>Site:</strong> " . $row["site"] . "</p>";
        echo "<p><strong>Pitch:</strong> " . $row["pitch"] . "</p>";
        echo "<p><strong>Rating:</strong> " . $row["rating"] . "</p>";
        echo "<p><strong>Review:</strong> " . $row["comment"] . "</p>";
        echo "<p class='date'><strong>Date:</strong> " . $row["created_at"] . "</p>";
        echo "</div>";
    }
    echo "</div>";
}

// Display pagination links
echo "<div class='pagination'>";
    
// Get the current page number
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the offset
$offset = ($page - 1) * 5;

// Get the reviews for the current page
$sql = "SELECT * FROM reviews ORDER BY created_at DESC LIMIT 5 OFFSET $offset";
$result = $conn->query($sql);

// Calculate the total number of pages
$sql = "SELECT COUNT(*) AS count FROM reviews";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$total_pages = ceil($row['count'] / 5);

// Display the pagination links
echo "<div>";
for ($i = 1; $i <= $total_pages; $i++) {
    if ($i == $page) {
        echo "<span class='current'>$i</span>";
    } else {
        echo "<a href=\"reviews.php?page=$i\">$i</a>";
    }
}
echo "</div>";

echo "</div>";

$conn->close();
?>