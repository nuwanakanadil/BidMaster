<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bids Management</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="bids.css">
    <script src="bids.js"></script>
</head>
<body>

<div class="sidebar">
    <div class="logo_content">
        <div class="logo">
            <i></i>
            <div class="logo_name">BidMaster</div>
        </div>
    </div>
    <ul class="nav_list">
        <li>
            <a href="../admin_dashboard/dashboard.php">
                <i class='bx bx-grid-alt'></i>
                <span class="links_name">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="../user management/user_management.php">
                <i class='bx bxs-user'></i>
                <span class="links_name">Users</span>
            </a>
        </li>
        <li>
            <a href="#">
                <i class='bx bxs-box'></i>
                <span class="links_name">Bids</span>
            </a>
        </li>
        <li>
            <a href="Contact Us/Admin-feedback-pannel.php">
                <i class='bx bxs-message-dots' ></i>
                <span class="links_name">Feedback</span>
            </a>
            <!-- <span class="tooltip">Dashboard</span>  -->
         </li>
    </ul>
    <div class="profile_content">
        <div class="profile">
            <div class="profile_details">
                <img src="icon-5359553_640.webp" alt="" id="profile_view">
                <div class="name_job">
                    <div class="name">Admin</div>
                    <div class="job">System Administrator</div>
                </div>
            </div>
            <i class='bx bx-log-out' id="log_out"></i>
        </div>
    </div>
</div>

<!--approve bids-->
<main class="table">
            <section class="table-header">
                        <h1>Items To Be Accepted</h1>
                        
            </section>
            <section class="table-body">
            <table>
                <thead>
                    <tr>
                        <th>Item ID</th>
                        <th>Condition</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="eventsTableBody2">
                <?php
                // Database connection
                $conn = new mysqli('localhost', 'root', '', 'auctionsystem');

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch data from database
                $sql = "SELECT Item_ID, Conditions, Brand, Model, Price, Description FROM seller_item";
                $result = $conn->query($sql);

                // Check if the query was successful
                if ($result === false) {
                    // Output the error
                    echo "Error: " . $conn->error;
                } else {
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row["Item_ID"] . "</td>
                                    <td>" . $row["Conditions"] . "</td>
                                    <td>" . $row["Brand"] . "</td>
                                    <td>" . $row["Model"] . "</td>
                                    <td>" . $row["Price"] . "</td>
                                    <td>" . $row["Description"] . "</td>
                                    <td>
                                        <button class='updateBtn'>Accept</button>
                                        <button class='removeBtn'>Decline</button>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No items found</td></tr>";
                    }
                }

                $conn->close();
                ?>
                </tbody>
            </table>
            </section>

    <div class="input-box">
        <div class="input-field">
            <input type="text" id="searchId2" placeholder="Enter Item ID">
            <button class="updateBtn" onclick="searchItemsById()">Search</button>
            <button class="reloadBtn" onclick="resetTable()">Reset</button>
       </div>
   </div>
</main>

<!-- Ongoing Bid List Section -->
<main class="table">
    <section class="table-header">
        <h1>Ongoing Bid List</h1>
    </section>
    <section class="table-body">
        <table>
            <thead>
                <tr>
                    <th>Bid ID</th>
                    <th>Item ID</th>
                    <th>Started Bid</th>
                    <th>Highest Bid</th>
                    <th>Started Date</th>
                    <th>Ending Date</th>
                </tr>
            </thead>
            <tbody id="eventsTableBody">
                <?php
                // Database connection
                $conn = new mysqli('localhost', 'root', '', 'auctionsystem');
                
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch data from database
                $sql = "SELECT bid_id, Item_ID, started_bid, highest_bid, started_date, ending_date FROM bids";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["bid_id"] . "</td>
                                <td>" . $row["Item_ID"] . "</td>
                                <td>" . $row["started_bid"] . "</td>
                                <td>" . $row["highest_bid"] . "</td>
                                <td>" . $row["started_date"] . "</td>
                                <td>" . $row["ending_date"] . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No bids found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </section>

    <div class="input-box">
        <div class="input-field">
            <input type="text" id="searchId" placeholder="Enter Bid ID">
            <button class="updateBtn" onclick="searchById()">Search</button>
            <button class="reloadBtn" onclick="resetTable()">Reset</button>
        </div>
        <div class="input-field">
            <input type="text" id="deleteId" placeholder="Enter Bid ID">
            <button class="removeBtn" onclick="deleteById()">Delete</button>
        </div>
        <div id="result"></div>
    </div>
</main>

</body>
</html>
