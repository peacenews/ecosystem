function testtt(){
    alertify.alert("<p>asdasdasdasd dfgdfgd.</p><h3>dfg</h3>", function () {
    });
}

function confirm(){
    alertify.confirm("<p>Here we confirm something.<br><br><b>ENTER</b> and <b>ESC</b> correspond to <b>OK</b> or <b>Cancel</b></p>", function (e) {
        if (e) {
            alertify.success("You pressed '" + alertify.labels.ok + "'");
        } else {
            alertify.error("You pressed '" + alertify.labels.cancel + "'");
        }
    });
    return false
}

function data(){
    alertify.prompt("This is a <b>prompt</b>, enter a value:", function (e, str) {
        if (e){
            alertify.success("You pressed '" + alertify.labels.ok + "'' and enter: " + str);
        } else {
            alertify.error("You pressed '" + alertify.labels.cancel + "'");
        }
    });
    return false;
}

function notification(){
    alertify.log("This is a notification either.");
    return false;
}

function ok(){
    alertify.success("Visit <a href=\"http://www.devaddiction.com/\" style=\"color:white;\" target=\"_blank\"><b>Devaddiction.com</b></a>");
    return false;
}

function error(){
    alertify.error("Username or Password Incorrect.");
    return false;
}
