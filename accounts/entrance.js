$("#loginForm").submit(function(ev){
    ev.preventDefault();

    var username = document.forms["loginForm"]["username"].value;
    var password = document.forms["loginForm"]["pw"].value;

    if (password == "" || username == "") {
        swal("Oops...", "You didn't fill one of the fields.", "error");
        return false;
    }

    $.post(
        '/accounts/login.php',
        {
        'username' : username,
        'password' : password
        },
        function(data) {
            var response = data['login'];
            switch(response) {
                case 'login_false':
                    alert("Oops... Something went wrong!");
                    break;
                case 'login_true':
                    alert("Logined in successfully");
                    break;
                default:
                    //displayError("Error while processing the login...");
                    break;
            }
    }).fail(function(error) {
                return false;
        });              
});