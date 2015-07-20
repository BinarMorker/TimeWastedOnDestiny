<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="How much time have you wasted on Destiny?">
    <meta property="og:title" content="Time Wasted on Destiny" />
    <meta property="og:description" content="How much time have you wasted on Destiny?" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="http://wastedondestiny.com" />
    <meta property="og:image" content="http://wastedondestiny.com/img/background.jpg" />

    <link rel="icon" href="favicon.ico">
    <title>Time wasted on Destiny</title>

    <!-- CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://bootswatch.com/cosmo/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-switch.min.css">
    <link rel="stylesheet" href="css/stylesheet.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <div class="container vert-middle">
        <div class="panel panel-default text-center">
            <div class="panel-body">
                <h1>Time Wasted on Destiny</h1>
                <h2 style="visibility: hidden; height: 0;"><small>Find out just how much time you have wasted on this game by choosing your console and entering your username below.</small></h2>
                <form role="form" id="search">
                    
                    <div class="input-group">
                        <span class="input-group-btn">
                            <input id="console" type="checkbox" name="console" data-on-text='<img width="20" height="20" src="img/xbox-icon.svg" />' data-on-color="success" data-off-text='<img width="20" height="20" src="img/playstation-icon.svg" />' data-off-color="primary" data-size="large">
                        </span>
                        <input id="username" type="text" class="form-control" name="username" placeholder="Username">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">Go!</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <div id="error"></div>
        <div class="row hide" id="fields">
            <div class="col-md-4">
                <div class="panel panel-fixed panel-primary text-center">
                    <div class="panel-heading">
                        <h3 class="panel-title"><img width="20" height="20" src="img/playstation-icon.svg" />&nbsp;Playstation</h3>
                    </div>
                    <div class="panel-body">
                        <img class="icon" id="psn_icon" />
                        <h4 class="display-name" id="psn_name"></h4>
                        <span class="played-time" rel="tooltip" id="psn_time"></span>
                        <span class="wasted-time" rel="tooltip" id="psn_wasted"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-fixed panel-info text-center">
                    <div class="panel-heading">
                        <h3 class="panel-title"><img width="20" height="20" src="img/destiny-icon.svg" />&nbsp;Total time spent</h3>
                    </div>
                    <div class="panel-body">
                        <h4 class="display-name" id="display_name"></h4>
                        <span class="played-time" rel="tooltip" id="total_time"></span>
                        <span class="wasted-time" rel="tooltip" id="total_wasted"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-fixed panel-success text-center">
                    <div class="panel-heading">
                        <h3 class="panel-title"><img width="20" height="20" src="img/xbox-icon.svg" />&nbsp;Xbox</h3>
                    </div>
                    <div class="panel-body">
                        <img class="icon" id="xbl_icon" />
                        <h4 class="display-name" id="xbl_name"></h4>
                        <span class="played-time" rel="tooltip" id="xbl_time"></span>
                        <span class="wasted-time" rel="tooltip" id="xbl_wasted"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <blockquote>
                    <p class="disclaimer"><strong>Disclaimer: </strong>The time displayed does not include idle time spent in the Tower, Reef, or wating in orbit. It does, however, include time spent on deleted characters. If you find any major difference in what time should be displayed and the actual time displayed on this website, please <a href="https://github.com/BinarMorker/TimeWastedOnDestiny/issues">submit a bug</a>.</p>
                </blockquote>
            </div>
        </div>
        <div class="row" id="ads">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                        <ins class="adsbygoogle"
                             style="display:block"
                             data-ad-client="ca-pub-6332373031553935"
                             data-ad-slot="7124654099"
                             data-ad-format="auto"></ins>
                        <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                        <ins class="adsbygoogle"
                             style="display:block"
                             data-ad-client="ca-pub-6332373031553935"
                             data-ad-slot="7124654099"
                             data-ad-format="auto"></ins>
                        <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                    </div>
                </div>
            </div>
        </div>
        <div class="well text-center">
            <span>Made with <span class="glyphicon glyphicon-heart"></span> by <a href="https://www.facebook.com/BinarMorker">François Allard (BinarMorker)</a></span>
            <br/>
            <span><a href="https://github.com/BinarMorker/TimeWastedOnDestiny/issues">Submit a bug</a> | <a href="https://github.com/BinarMorker/TimeWastedOnDestiny">Get the source code</a></span>
            <br/>
            <span class="text-muted">You can also use my simple API located <a href="request.php?help">here</a>.</span>
        </div>
    </div>
    <!-- JavaScript -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="js/bootstrap-switch.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-52347626-4', 'auto');
        ga('send', 'pageview');
    </script>
</body>

</html>