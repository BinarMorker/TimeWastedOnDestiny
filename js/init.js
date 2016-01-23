$("document").ready(function () {
	var images = 50;
	$('#index-banner').css({'background-image': 'url(/img/background/' +pad(Math.floor(Math.random() * images), 3) + '.jpg)'});
	leaderboard();
	
	$(document).scroll(function() {
		var y = $(this).scrollTop();
		if (y > 0) {
			$('#returnToTopElem').removeClass("hide").fadeIn();
		} else {
			$('#returnToTopElem').addClass("hide");
		}
	});

	$(".social").on('click', function (event) {
		event.preventDefault();
		window.open($(this).attr('href'), "_blank", "toolbar=no, scrollbars=no, resizable=yes, top=0, left=0, width=500, height=300");
	});
	
	$("#returnToTop").on('click', function (event) {
		scrollTo('#index-banner');
	})
	
	$("#choice-playstation").on('click', function (event) {
		event.preventDefault();
		$("#choice").addClass("hide");
		$("#input-playstation").removeClass("hide");
		$("#search-playstation").focus();
	});
	
	$("#choice-xbox").on('click', function (event) {
		event.preventDefault();
		$("#choice").addClass("hide");
		$("#input-xbox").removeClass("hide");
		$("#search-xbox").focus();
	});
	
	$(".return-button").on('click', function (event) {
		event.preventDefault();
		$("#choice").removeClass("hide");
		$("#input-playstation").addClass("hide");
		$("#input-xbox").addClass("hide");
	});
	
	$("#form-playstation").on('submit', function (event) {
        event.preventDefault();
        search(event, $("#search-playstation").val(), 2);
    });
	
	$("#form-xbox").on('submit', function (event) {
        event.preventDefault();
        search(event, $("#search-xbox").val(), 1);
    });
	
	function leaderboard () {
        var jsonUrl = "/api?leaderboard&"+new Date().getTime();
		$("#leaderboard").html("");
        $.getJSON(jsonUrl, function (json) {
        	if (json.Info.Status != "Error") {
        		$("#leaderboard").append('<span class="collection-header">Leaderboard</span>');
        		var count = 0;
        		for (row in json.Response.leaderboard) {
        			count++;
            		$("#leaderboard").append('<a href="/'+(json.Response.leaderboard[row].membershipType==1?"xbox":"playstation")+'/'+json.Response.leaderboard[row].displayName.toLowerCase()+'" class="collection-item row"><span class="col s2">'+count+'</span><span class="col s7"><img style="margin-bottom:-3px" height="18" width="18" src="/img/'+(json.Response.leaderboard[row].membershipType==1?"xbox":"playstation")+'-icon-black.svg" /> '+json.Response.leaderboard[row].displayName+'</span><span class="col s3 right-align">'+getHours(json.Response.leaderboard[row].timePlayed)+'</span></a>');
        		}
        		$("#leaderboard").append('<span class="collection-footer">Players: <span id="player-count">'+json.Response.totalPlayers+'</span></span>');
        	}
        });
	}
	
	function search (event, user, platform) {
        if (user === undefined || user == "") {
            $("#error").html("<div class='card-panel red lighten-2'>You must enter a username</div>");
        } else {
        	loading();
            var jsonUrl = "/api?console="+platform+"&user="+user;
            $.getJSON(jsonUrl, function (json) {
            	resetFields();
            	showError(json.Info);
                if (json.Info.Status != "Error") {
                    $("#displayName").text(json.Response.displayName);
                    $("#totalTime").text(getHours(json.Response.totalTimePlayed));
                    $("#totalWasted").html("- " + getHours(json.Response.totalTimeWasted));
                    if ('playstation' in json.Response && 'xbox' in json.Response) {
                    	var psChars = json.Response.playstation.characters.total - json.Response.playstation.characters.deleted;
                    	var xbChars = json.Response.xbox.characters.total - json.Response.xbox.characters.deleted;
                        var actChars = psChars + xbChars;
                        var delChars = json.Response.playstation.characters.deleted + json.Response.xbox.characters.deleted;
                    } else if ('playstation' in json.Response) {
                    	var actChars = json.Response.playstation.characters.total - json.Response.playstation.characters.deleted;
                        var delChars = json.Response.playstation.characters.deleted;
                    } else if ('xbox' in json.Response) {
                    	var actChars = json.Response.xbox.characters.total - json.Response.xbox.characters.deleted;
                        var delChars = json.Response.xbox.characters.deleted;
                    }
                    $("#characters").html((actChars>0?actChars:"no") + " active characters and " + (delChars>0?delChars:"no") + " deleted characters.");
                    $("#formatTime").html("Makes up " + getTime(json.Response.totalTimePlayed) + ".");
                    if ('playstation' in json.Response) {
                    	$("#yesPlaystation").removeClass("hide");
                    	$("#noPlaystation").addClass("hide");
                        $("#playstationName").text(json.Response.playstation.displayName);
                        $("#playstationIcon").attr("src", "https://www.bungie.net" + json.Response.playstation.iconPath);
                        $("#playstationTime").text(getHours(json.Response.playstation.timePlayed));
                        $("#playstationWasted").html("- " + getHours(json.Response.playstation.timeWasted));
                        $("#playstationPlayed").html("Last played " + new Date(json.Response.playstation.lastPlayed * 1000).toDateString());
                        console.log(Math.ceil(json.Response.playstation.leaderboardPosition / parseInt($("#player-count").text()) * 100));
                        $("#playstationRank").text("Top " + Math.ceil(json.Response.playstation.leaderboardPosition / parseInt($("#player-count").text()) * 100) + "%");
                        $("#playstationBNGLink").attr("href", "http://bungie.net/en/Profile/" + json.Response.playstation.membershipType + "/" + json.Response.playstation.membershipId);
                        $("#playstationDNKLink").attr("href", "http://dinklebot.net/" + json.Response.playstation.membershipType + "/" + json.Response.playstation.displayName.toLowerCase());
                        $("#playstationDDBLink").attr("href", "http://destinydb.com/guardians/playstation/" + json.Response.playstation.membershipId + "-" + json.Response.playstation.displayName.toLowerCase());
                        $("#playstationDTCLink").attr("href", "http://destinytracker.com/destiny/player/ps/" + json.Response.playstation.displayName.toLowerCase());
                        $("#playstationGGGLink").attr("href", "http://guardian.gg/en/profile/" + json.Response.playstation.membershipType + "/" + json.Response.playstation.displayName.toLowerCase());
                        $("#playstationDTRLink").attr("href", "http://my.destinytrialsreport.com/ps/" + json.Response.playstation.displayName.toLowerCase());
                    } else {
                    	resetPlaystation();
                    }
                    if ('xbox' in json.Response) {
                    	$("#yesXbox").removeClass("hide");
                    	$("#noXbox").addClass("hide");
                        $("#xboxName").text(json.Response.xbox.displayName);
                        $("#xboxIcon").attr("src", "https://www.bungie.net" + json.Response.xbox.iconPath);
                        $("#xboxTime").text(getHours(json.Response.xbox.timePlayed));
                        $("#xboxWasted").html("- " + getHours(json.Response.xbox.timeWasted));
                        $("#xboxPlayed").html("Last played " + new Date(json.Response.xbox.lastPlayed * 1000).toDateString());
                        $("#xboxRank").text("Top " + Math.ceil(json.Response.xbox.leaderboardPosition / parseInt($("#player-count").text()) * 100) + "%");
                        $("#xboxBNGLink").attr("href", "http://bungie.net/en/Profile/" + json.Response.xbox.membershipType + "/" + json.Response.xbox.membershipId);
                        $("#xboxDNKLink").attr("href", "http://dinklebot.net/" + json.Response.xbox.membershipType + "/" + json.Response.xbox.displayName.toLowerCase());
                        $("#xboxDDBLink").attr("href", "http://destinydb.com/guardians/xbox/" + json.Response.xbox.membershipId + "-" + json.Response.xbox.displayName.toLowerCase());
                        $("#xboxDTCLink").attr("href", "http://destinytracker.com/destiny/player/xb/" + json.Response.xbox.displayName.toLowerCase());
                        $("#xboxGGGLink").attr("href", "http://guardian.gg/en/profile/" + json.Response.xbox.membershipType + "/" + json.Response.xbox.displayName.toLowerCase());
                        $("#xboxDTRLink").attr("href", "http://my.destinytrialsreport.com/xb/" + json.Response.xbox.displayName.toLowerCase());
                    } else {
                    	resetXbox();
                    }
                    if (json.Response.newEntry == true) {
                    	leaderboard();
                    }
                    $("#panels").removeClass("hide");
                    scrollTo("#panels");
                    
                    if (platform == 1 && 'xbox' in json.Response) {
                        var name = encodeURI(json.Response.xbox.displayName).toLowerCase();
                        changeUrl(json.Response.displayName, "http://" + window.location.hostname + "/" + (platform==1?"xbox":"playstation") + "/" + name);
                    } else if (platform == 2 && 'playstation' in json.Response) {
                        var name = encodeURI(json.Response.playstation.displayName).toLowerCase();
                        changeUrl(json.Response.displayName, "http://" + window.location.hostname + "/" + (platform==1?"xbox":"playstation") + "/" + name);
                    }
                }
            });
        }
    }
	
    var params = cleanArray(window.location.pathname.split('/'));
    
    if (params.length > 0) {
        if (params[0] == "xbox") {
        	$("#choice").addClass("hide");
        	$("#search-xbox").val(decodeURI(params[1]));
        	$("#input-xbox").removeClass("hide");
            search(event, decodeURI(params[1]), 1);
        } else {
        	$("#choice").addClass("hide");
        	$("#search-playstation").val(decodeURI(params[1]));
        	$("#input-playstation").removeClass("hide");
            search(event, decodeURI(params[1]), 2);
        }
    }
});

function scrollTo(elem) {
    $("html, body").animate({ scrollTop: $(elem).offset().top }, 1000);
}

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

function resetPlaystation() {
	$("#yesPlaystation").addClass("hide");
	$("#noPlaystation").removeClass("hide");
    $("#playstationName").text("");
    $("#playstationIcon").attr("src", "");
    $("#playstationTime").text("");
    $("#playstationWasted").html("");
    $("#playstationPlayed").html("");
    $("#playstationRank").text("");
    $("#playstationBNGLink").attr("href", "");
    $("#playstationDNKLink").attr("href", "");
    $("#playstationDDBLink").attr("href", "");
    $("#playstationDTRLink").attr("href", "");
}

function resetXbox() {
	$("#yesXbox").addClass("hide");
	$("#noXbox").removeClass("hide");
    $("#xboxName").text("");
    $("#xboxIcon").attr("src", "");
    $("#xboxTime").text("");
    $("#xboxWasted").html("");
    $("#xboxPlayed").html("");
    $("#xboxRank").text("");
    $("#xboxBNGLink").attr("href", "");
    $("#xboxDNKLink").attr("href", "");
    $("#xboxDDBLink").attr("href", "");
    $("#xboxDTRLink").attr("href", "");
}

function resetFields() {
    $("#panels").addClass("hide");
    $("#displayName").text("");
    $("#totalTime").text("");
    $("#totalWasted").html("");
    $("#characters").html("");
    $("#formatTime").html("");
	resetPlaystation();
	resetXbox();
}

function loading() {
	$("#error").html("<div class='preloader-wrapper big active'><div class='spinner-layer spinner-blue-only'><div class='circle-clipper left'><div class='circle'></div></div><div class='gap-patch'><div class='circle'></div></div><div class='circle-clipper right'><div class='circle'></div></div></div></div>");
}

function showError(json) {
    if (json.Status == "Success") {
        $("#error").html("");
    } else {
        var weight = "yellow";
        if (json.Status == "Error") {
            weight = "red";
        }
        $("#error").html("<div class='card-panel "+weight+"'>"+json.Message+"</div>");
    }
}

function getHours(seconds) {
    if (seconds == 0) {
        return "None";
    }
    
    var hours = Math.floor(seconds / (60 * 60));
    
    if (hours > 0) {
        return hours + "h";
    } else {
        return "None";
    }
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

function pad(num, size) {
    var s = num+"";
    while (s.length < size) s = "0" + s;
    return s;
}
