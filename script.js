function updateState(state, button) {
    var email = getCookie("email");
    var action;
    if (button.classList.contains('state-button-visited')) {
        button.classList.remove('state-button-visited');
        action = 'delete';
        //document.getElementById("changeme").innerHTML = "contains state btn visit: delete.";
    } else if (button.classList.contains('clicked')) {
        button.classList.remove('clicked');
        action = 'delete';
        //document.getElementById("changeme").innerHTML = "contains state btn clk: delete.";
    } else {
        button.classList.add("clicked");
        action = 'insert';
        //document.getElementById("changeme").innerHTML = "clicked: insert.";
    }

    $.ajax({
        url: 'updatestate.php',
        type: 'post',
        data: {
            state: state,
            email: email,
            action: action
        },
        success: function(response) {
            console.log('Success:', response);
            //alert('State updated successfully.');
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
            //alert('Error updating state.');
        }
    });
}


function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}