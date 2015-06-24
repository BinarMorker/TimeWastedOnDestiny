$("[name='console']").bootstrapSwitch();
$("document").ready(function () {
    var platform = false;
    $("input[name='console']").on("switchChange.bootstrapSwitch", function (event, state) {
        platform = state;
    });
    $("#search").submit(function(event) {
        event.preventDefault();
        resetFields();
        
        $(".loading").attr("load", 0);
        $(".loading").text("Loading");
        var loading = window.setInterval(function () {
            var dots = "";
            var dotNum = $(".loading").attr("load");
            dotNum++;
            dotNum %= 4;
            for (var i = 0; i < dotNum; i++) {
                dots += ".";
            }
            $(".loading").attr("load", dotNum);
            $(".loading").text("Loading" + dots);
        }, 1000);
        
        var user = $("#username").val();
        if (platform) {
            var plat = 1;
        } else {
            var plat = 2;
        }
        console.log(user);
        var jsonUrl = "request.php?console="+plat+"&user="+user;
        $.getJSON(jsonUrl, function (json) {
            clearInterval(loading);
            console.log(json);
            var success = true;
            if ('Error' in json.Error) {
                showError(json.Error);
                success = false;
            } else if ('Warning' in json.Error) {
                showError(json.Error);
            }
            if (success) {
                showError(json.Error);
                $("#display_name").text(json.Response.displayName);
                $("#total_time").text(getTime(json.Response.totalTime));
                $("#total_time").attr("title", getHours(json.Response.totalTime));
                if ('playstation' in json.Response) {
                    $("#psn_name").text(json.Response.playstation.displayName);
                    $("#psn_icon").attr("src", "https://www.bungie.net" + json.Response.playstation.iconPath);
                    $("#psn_time").text(getTime(json.Response.playstation.timePlayed));
                    $("#psn_time").attr("title", getHours(json.Response.totalTime));
                } else {
                    $("#psn_name").text("Never played");
                    $("#psn_icon").attr("src", "");
                    $("#psn_time").text("");
                    $("#psn_time").attr("title", "");
                }
                if ('xbox' in json.Response) {
                    $("#xbl_name").text(json.Response.xbox.displayName);
                    $("#xbl_icon").attr("src", "https://www.bungie.net" + json.Response.playstation.iconPath);
                    $("#xbl_time").text(getTime(json.Response.xbox.timePlayed));
                    $("#xbl_time").attr("title", getHours(json.Response.totalTime));
                } else {
                    $("#xbl_name").text("Never played");
                    $("#xbl_icon").attr("src", "");
                    $("#xbl_time").text("");
                    $("#xbl_time").attr("title", "");
                }
            } else {
                resetFields();
            }
        });
    });
});

function resetFields() {
    $("#display_name").text("");
    $("#total_time").text("");
    $("#total_time").attr("title", "");
    $("#psn_name").text("");
    $("#psn_icon").attr("src", "");
    $("#psn_time").text("");
    $("#psn_time").attr("title", "");
    $("#xbl_name").text("");
    $("#xbl_icon").attr("src", "");
    $("#xbl_time").text("");
    $("#xbl_time").attr("title", "");
}

function showError(json) {
    if ('Error' in json) {
        var weight = "danger";
        $("#error").html("<div class='panel panel-"+weight+"'><div class='panel-body'><blockquote>"+json.Error+"</blockquote></div></div>");
    } else if ('Warning' in json) {
        var weight = "warning";
        $("#error").html("<div class='panel panel-"+weight+"'><div class='panel-body'><blockquote>"+json.Warning+"</blockquote></div></div>");
    } else {
        var weight = "success";
        $("#error").html("");
    }
}

function getHours(seconds) {
    var hours = Math.floor(seconds / (60 * 60));
    if (hours > 0) {
        hours = hours + " hours";
    } else {
        hours = "";
    }
    return hours;
}

function getTime(seconds) {
    var weeks = Math.floor(seconds / (7 * 24 * 60 * 60));
    if (weeks > 0) {
        weeks = weeks + " weeks ";
    } else {
        weeks = "";
    }
    var days = Math.floor(seconds / (24 * 60 * 60)) % 7;
    if (days > 0) {
        days = days + " days ";
    } else {
        days = "";
    }
    var hours = Math.floor(seconds / (60 * 60)) % 24;
    if (hours > 0) {
        hours = hours + " hours ";
    } else {
        hours = "";
    }
    var minutes = Math.floor(seconds / 60) % 60;
    if (minutes > 0) {
        minutes = minutes + " minutes ";
    } else {
        minutes = "";
    }
    var seconds = seconds % 60;
    if (seconds > 0) {
        seconds = seconds + " seconds";
    } else {
        seconds = "";
    }
    return weeks + days + hours + minutes + seconds;
}
