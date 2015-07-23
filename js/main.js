$("[name='console']").bootstrapSwitch();
$("document").ready(function () {
    var platform = false;
    $("input[name='console']").on("switchChange.bootstrapSwitch", function (event, state) {
        platform = state;
    });
    $("#search").submit(function(event) {
        event.preventDefault();
        var user = $("#username").val();
        if (platform) {
            var plat = 1;
        } else {
            var plat = 2;
        }
        if (user === undefined || user == "") {
            $("#error").html("<div class='panel panel-danger'><div class='panel-body'><blockquote>You must enter a username</blockquote></div></div>");
        } else {
            resetFields();
            $("#fields").addClass("hide");
            $("#error").html("<div id='load' class='panel panel-info'><div class='panel-body'><blockquote class='loading'></blockquote></div></div>");
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

            var jsonUrl = "/request.php?console="+plat+"&user="+user;
            $.getJSON(jsonUrl, function (json) {
                clearInterval(loading);
                $("#load").detach();
                showError(json.Info);
                if (json.Info.Status == "Error") {
                    resetFields();
                } else {
                    $("#display_name").text(json.Response.displayName);
                    $("#total_time").text(getHours(json.Response.totalTimePlayed));
                    $("#total_time").attr("title", getTime(json.Response.totalTimePlayed));
                    $("#total_wasted").html("<strong class='wasted-time'>Deleted characters only</strong>" + getHours(json.Response.totalTimeWasted));
                    $("#total_wasted").attr("title", getTime(json.Response.totalTimeWasted));
                    if ('playstation' in json.Response) {
                        $("#psn_name").text(json.Response.playstation.displayName + " (" + json.Response.playstation.characters.total + " characters)");
                        $("#psn_icon").attr("src", "https://www.bungie.net" + json.Response.playstation.iconPath);
                        $("#psn_time").text(getHours(json.Response.playstation.timePlayed));
                        $("#psn_time").attr("title", getTime(json.Response.playstation.timePlayed));
                        $("#psn_wasted").html("<strong class='wasted-time'>Deleted characters only (" + json.Response.playstation.characters.deleted + ")</strong>" + getHours(json.Response.playstation.timeWasted));
                        $("#psn_wasted").attr("title", getTime(json.Response.playstation.timeWasted));
                        $("#psn_rank").text("Rank " + json.Response.playstation.leaderboardPosition);
                    } else {
                        $("#psn_name").text("Never played");
                        $("#psn_icon").attr("src", "");
                        $("#psn_time").text("");
                        $("#psn_time").attr("title", "");
                        $("#psn_wasted").text("");
                        $("#psn_wasted").attr("title", "");
                        $("#psn_rank").text("");
                    }
                    if ('xbox' in json.Response) {
                        $("#xbl_name").text(json.Response.xbox.displayName + " (" + json.Response.xbox.characters.total + " characters)");
                        $("#xbl_icon").attr("src", "https://www.bungie.net" + json.Response.xbox.iconPath);
                        $("#xbl_time").text(getHours(json.Response.xbox.timePlayed));
                        $("#xbl_time").attr("title", getTime(json.Response.xbox.timePlayed));
                        $("#xbl_wasted").html("<strong class='wasted-time'>Deleted characters only (" + json.Response.xbox.characters.deleted + ")</strong>" + getHours(json.Response.xbox.timeWasted));
                        $("#xbl_wasted").attr("title", getTime(json.Response.xbox.timeWasted));
                        $("#xbl_rank").text("Rank " + json.Response.xbox.leaderboardPosition);
                    } else {
                        $("#xbl_name").text("Never played");
                        $("#xbl_icon").attr("src", "");
                        $("#xbl_time").text("");
                        $("#xbl_time").attr("title", "");
                        $("#xbl_wasted").text("");
                        $("#xbl_wasted").attr("title", "");
                        $("#xbl_rank").text("");
                    }
                    $("#fields").removeClass("hide");
                    if (plat == 1) {
                        var type = "xbox";
                        var name = encodeURI(json.Response.xbox.displayName).toLowerCase();
                    } else {
                        var type = "playstation";
                        var name = encodeURI(json.Response.playstation.displayName).toLowerCase();
                    }
                    changeUrl(json.Response.displayName, "http://" + window.location.hostname + "/" + type + "/" + name);
                }
            });
        }
    });
    
    $(".leaderboard-hours").each(function() {
        var time = $(this).text();
        $(this).text(getHours(time));
        $(this).attr("title", getTime(time));
    });
    
    var params = cleanArray(window.location.pathname.split('/'));
    if (params.length > 0) {
        if (params[0] == "xbox") {
            $("[name='console']").bootstrapSwitch('state', true, false);
        }
        $("#username").val(decodeURI(params[1]));
        $("#search").submit();
    }
    
    var targets = $('[rel~=tooltip]');
    var target = false;
    var tooltip = false;
    var title = false;
 
    targets.bind('mouseenter', function() {
        target = $(this);
        tip = target.attr('title');
        tooltip = $('<div id="tooltip"></div>');
 
        if (!tip || tip == '') {
            return false;
        }
 
        target.removeAttr('title');
        tooltip.css('opacity', 0).html(tip).appendTo('body');
 
        var init_tooltip = function() {
            if($(window).width() < tooltip.outerWidth() * 1.5) {
                tooltip.css('max-width', $(window).width() / 2);
            } else {
                tooltip.css('max-width', 340);
            }
            
            var pos_left = target.offset().left + (target.outerWidth() / 2) - (tooltip.outerWidth() / 2);
            var pos_top = target.offset().top - tooltip.outerHeight() - 20;
            if (pos_left < 0) {
                pos_left = target.offset().left + target.outerWidth() / 2 - 20;
                tooltip.addClass('left');
            } else {
                tooltip.removeClass('left');
            }
            if (pos_left + tooltip.outerWidth() > $(window).width()) {
                pos_left = target.offset().left - tooltip.outerWidth() + target.outerWidth() / 2 + 20;
                tooltip.addClass('right');
            } else {
                tooltip.removeClass('right');
            }
            if (pos_top < 0) {
                var pos_top = target.offset().top + target.outerHeight();
                tooltip.addClass('top');
            } else {
                tooltip.removeClass('top');
            }
            tooltip.css({
                left: pos_left,
                top: pos_top
            }).animate({
                top: '+=10',
                opacity: 1
            }, 50);
        };
        
        init_tooltip();
        $(window).resize(init_tooltip);
        
        var remove_tooltip = function() {
            tooltip.animate({
                top: '-=10',
                opacity: 0
            }, 50, function() {
                $(this).remove();
            });
            target.attr('title', tip);
        };
        
        target.bind('mouseleave', remove_tooltip);
        tooltip.bind('click', remove_tooltip);
    });
});

function cleanArray(actual){
    var newArray = new Array();
        for(var i = 0; i < actual.length; i++) {
        if (actual[i]) {
            newArray.push(actual[i]);
        }
    }
    return newArray;
}

function changeUrl(title, url) {
    if (typeof (history.pushState) != "undefined") {
        var obj = { Title: title, Url: url };
        history.pushState(obj, obj.Title, obj.Url);
    }
}

function resetFields() {
    $("#display_name").text("");
    $("#total_time").text("");
    $("#total_time").attr("title", "");
    $("#psn_name").text("");
    $("#psn_icon").attr("src", "");
    $("#psn_time").text("");
    $("#psn_time").attr("title", "");
    $("#psn_wasted").text("");
    $("#psn_wasted").attr("title", "");
    $("#psn_rank").text("");
    $("#xbl_name").text("");
    $("#xbl_icon").attr("src", "");
    $("#xbl_time").text("");
    $("#xbl_time").attr("title", "");
    $("#xbl_wasted").text("");
    $("#xbl_wasted").attr("title", "");
    $("#xbl_rank").text("");
}

function showError(json) {
    if (json.Status == "Success") {
        $("#error").html("");
    } else {
        var weight = "warning";
        if (json.Status == "Error") {
            weight = "danger";
        }
        $("#error").html("<div class='panel panel-"+weight+"'><div class='panel-body'><blockquote>"+json.Message+"</blockquote></div></div>");
    }
}

function getHours(seconds) {
    if (seconds == 0) {
        return "None";
    }
    var hours = Math.floor(seconds / (60 * 60));
    if (hours > 0) {
        hours = hours + " hours";
    } else if (hours > 0) {
        hours = hours + " hour";
    } else {
        hours = "";
    }
    return hours;
}

function getTime(seconds) {
    var weeks = Math.floor(seconds / (7 * 24 * 60 * 60));
    if (weeks > 1) {
        weeks = weeks + " weeks ";
    } else if (weeks > 0) {
        weeks = weeks + " week ";
    } else {
        weeks = "";
    }
    var days = Math.floor(seconds / (24 * 60 * 60)) % 7;
    if (days > 1) {
        days = days + " days ";
    } else if (days > 0) {
        days = days + " day ";
    } else {
        days = "";
    }
    var hours = Math.floor(seconds / (60 * 60)) % 24;
    if (hours > 1) {
        hours = hours + " hours ";
    } else if (hours > 0) {
        hours = hours + " hour ";
    } else {
        hours = "";
    }
    var minutes = Math.floor(seconds / 60) % 60;
    if (minutes > 1) {
        minutes = minutes + " minutes ";
    } else if (minutes > 0) {
        minutes = minutes + " minute ";
    } else {
        minutes = "";
    }
    var seconds = seconds % 60;
    if (seconds > 1) {
        seconds = seconds + " seconds";
    } else if (seconds > 0) {
        seconds = seconds + " second";
    } else {
        seconds = "";
    }
    return weeks + days + hours + minutes + seconds;
}
