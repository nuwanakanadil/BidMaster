<?php

// Database connection
$conn = new mysqli('localhost', 'root', '', 'auctionsystem');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to select item details
$SQL = "SELECT Item_ID, seller_name, Conditions, Brand, Model, Price, Description, image_path FROM bid_items";
$result = $conn->query($SQL);

if ($result === false) {
    // Handle SQL error
    die("SQL Error: " . $conn->error);
}

if ($result->num_rows > 0) {
    // Start the table with styles
    echo "<style>
            table {
                width: 80%;
                border-collapse: collapse;
                margin: 20px 0;
            }
            th, td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }
            th {
                background-color: #f2f2f2;
            }
            tr:hover {
                background-color: #f5f5f5;
            }
            img {
                max-width: 100px;
                margin: 5px;
            }
            .button {
                border: none;
                color: white;
                padding: 10px 15px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin: 4px 2px;
                cursor: pointer;
                border-radius: 5px;
                transition: background-color 0.3s;
            }
            .update-button {
                background-color: #4CAF50; /* Green */
            }
            .update-button:hover {
                background-color: #45a049;
            }
            .delete-button {
                background-color: #f44336; /* Red */
            }
            .delete-button:hover {
                background-color: #e53935;
            }
          </style>";

    echo "<table>";
    echo "<tr><th>Item No</th><th>Seller Name</th><th>Condition</th><th>Brand</th><th>Model</th><th>Price</th><th>Description</th><th>Images</th><th>Actions</th></tr>";

    

    // Loop through the results and display them in table rows
    while ($row = $result->fetch_assoc()) {
        $imagePath = $row['image_path'] ? $row['image_path'] : 'path/to/placeholder.jpg';
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["Item_ID"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["seller_name"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["Conditions"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["Brand"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["Model"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["Price"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["Description"]) . "</td>";

        // Display images if available
        echo "<td><img src='" . $imagePath . "' alt='Image' style='max-width: 100px; max-height: 100px;'></td>";
        
        // Action buttons: Update and Delete
        echo "<td>
                <a href='update_item.php?id=" . htmlspecialchars($row['Item_ID']) . "' class='button update-button'>Update</a>
                <form method='POST' action='seller_Item_Delete.php' style='display:inline;' onsubmit='return confirm(\"Are you sure you want to delete this item?\");'>
                    <input type='hidden' name='Item_ID' value='" . htmlspecialchars($row['Item_ID']) . "'>
                    <button type='submit' class='button delete-button'>Delete</button>
                </form>
              </td>";

        echo "</tr>";
    }

    // End the table
    echo "</table>";
} else {
    echo "No results found.";
}

// Close the database connection
$conn->close();

?>
