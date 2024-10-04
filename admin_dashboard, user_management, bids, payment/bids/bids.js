function searchById() {
    var id = document.getElementById('searchId').value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'search_bids.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        document.getElementById('eventsTableBody').innerHTML = this.responseText;
    };
    xhr.send('id=' + id);
}

function deleteById() {
    var id = document.getElementById('deleteId').value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'delete_bids.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        document.getElementById('result').innerHTML = this.responseText;
        location.reload(); // Reload the page to reflect changes
    };
    xhr.send('id=' + id);
}

function resetTable() {
    location.reload();   
}


function searchItemsById() {
    var id = document.getElementById('searchId2').value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'search_items.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        document.getElementById('eventsTableBody2').innerHTML = this.responseText;
    };
    xhr.send('id=' + id);
}