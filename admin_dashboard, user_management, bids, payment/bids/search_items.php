<?php
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $conn = new mysqli('localhost', 'root', '', 'auctionsystem');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT Item_ID, seller_name, Conditions, Brand, Model, Price, Description FROM seller_item WHERE Item_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
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

    $stmt->close();
    $conn->close();
}
?>