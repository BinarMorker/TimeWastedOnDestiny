<?php

/* index.twig */
class __TwigTemplate_e75cbbf5d7c0e926d30bcc1e293f4e4d294ddf116685eabc7731ddb9fb603356 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"";
        // line 2
        echo twig_escape_filter($this->env, $this->getAttribute(($context["apine"] ?? null), "language_short", array()), "html", null, true);
        echo "\">
<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1.0\"/>
    <meta name=\"description\" content=\"";
        // line 7
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("application", "description")), "html", null, true);
        echo "\">
    <meta property=\"og:title\" content=\"";
        // line 8
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("application", "title")), "html", null, true);
        echo "\"/>
    <meta property=\"og:description\" content=\"";
        // line 9
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("application", "description")), "html", null, true);
        echo "\"/>
    <meta property=\"og:type\" content=\"website\"/>
    <meta property=\"og:url\" content=\"";
        // line 11
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('resource')->getCallable(), array("")), "html", null, true);
        echo "\"/>
    <meta property=\"og:image\" content=\"";
        // line 12
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('path')->getCallable(), array("resources/public/assets/opengraph.jpg")), "html", null, true);
        echo "\"/>
    <title>";
        // line 13
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("application", "title")), "html", null, true);
        echo "</title>
    <link rel=\"stylesheet\" href=\"";
        // line 14
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('resource')->getCallable(), array("bower_components/uikit/dist/css/uikit.min.css")), "html", null, true);
        echo "\">
    <link rel=\"stylesheet\" href=\"";
        // line 15
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('resource')->getCallable(), array("resources/public/css/stylesheet.css")), "html", null, true);
        echo "\">
</head>
<body>
    <div class=\"uk-height-viewport uk-section-media\" id=\"background\" data-bind=\"visible: mainVisible\">
        <div class=\"clock\">
            <div id=\"clockBackground\"></div>
            <div id=\"clockRadial\"></div>
            <div id=\"clockBigHand\"></div>
            <div id=\"clockLittleHand\"></div>
        </div>
        <div class=\"uk-position-center uk-position-medium\">
            <img src=\"";
        // line 26
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('resource')->getCallable(), array("resources/public/assets/logo.svg")), "html", null, true);
        echo "\">
            <nav class=\"nav-overlay uk-navbar-container uk-navbar-transparent uk-margin uk-position-relative\" uk-navbar>
                <div class=\"uk-navbar-left uk-flex-1\">
                    <div class=\"uk-navbar-item uk-width-expand\">
                        <form class=\"uk-search uk-search-navbar uk-width-1-1\" data-bind=\"submit: fetchAccounts\">
                            <input class=\"uk-search-input\" type=\"search\" data-bind=\"textInput: input\" placeholder=\"Search...\" autofocus>
                        </form>
                    </div>
                    <a class=\"uk-navbar-toggle\" uk-icon=\"icon: search\" data-bind=\"click: fetchAccounts\" href=\"#\"></a>
                </div>
            </nav>

            ";
        // line 48
        echo "
            <div id=\"adBottom\">
                <br/>
                <script async src=\"//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js\"></script>
                <ins class=\"adsbygoogle\"
                     style=\"display:block\"
                     data-ad-client=\"ca-pub-6332373031553935\"
                     data-ad-slot=\"7124654099\"
                     data-ad-format=\"auto\"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
        </div>

        <div id=\"adBottomMobile\" style=\"height: 90px\">
        </div>
    </div>
    <div class=\"uk-height-viewport uk-section-secondary uk-preserve-color\" data-bind=\"visible: statsVisible\" id=\"stats\">
        <div class=\"sticky\">
            <nav id=\"sticky-navbar\" class=\"uk-navbar-container uk-navbar-inverse\" uk-navbar style=\"position: relative; z-index: 980;\">
                <div class=\"uk-navbar-left\">
                    <a class=\"uk-navbar-toggle\" uk-navbar-toggle-icon href=\"#\"></a>
                    <div uk-dropdown=\"mode: click\" class=\"uk-navbar-dropdown\">
                        <ul class=\"uk-nav uk-navbar-dropdown-nav\">
                            <li>
                                <a href=\"#about-modal\" uk-toggle>
                                    <span uk-icon=\"icon: question; ratio: 1\"></span> About
                                </a>
                            </li>
                            <li>
                                <a href=\"#\" data-bind=\"click: toggleDetailedView\">
                                    <span uk-icon=\"icon: bolt; ratio: 1\"></span> <span data-bind=\"text: detailedView() ? 'Detailed view [On]' : 'Detailed view [Off]'\">Detailed view [On]</span>
                                </a>
                            </li>
                            <li>
                                <a href=\"#\" data-bind=\"click: toggleTimeFormat\">
                                    <span uk-icon=\"icon: clock; ratio: 1\"></span> <span data-bind=\"text: hoursMode() ? 'Time format [Hours]' : 'Time format [Full]'\">Time format [Hours]</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <a href=\"";
        // line 90
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('path')->getCallable(), array("")), "html", null, true);
        echo "\" class=\"uk-navbar-item uk-logo\"><img src=\"";
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('resource')->getCallable(), array("resources/public/assets/logo.svg")), "html", null, true);
        echo "\"></a>
                </div>
                <div class=\"uk-navbar-right\">
                    <ul class=\"uk-navbar-nav\">
                        <div class=\"uk-navbar-item\">
                            <form class=\"uk-search uk-search-navbar uk-width-1-1\" data-bind=\"submit: fetchAccounts\">
                                <input class=\"uk-search-input\" type=\"search\" data-bind=\"textInput: input\" placeholder=\"Search...\" autofocus>
                            </form>
                        </div>
                        <a class=\"uk-navbar-toggle\" uk-icon=\"icon: plus-circle\" data-bind=\"click: fetchAccounts, attr: { 'uk-icon': accounts().length > 0 ? 'icon: plus-circle' : 'icon: search' }\" href=\"#\"></a>
                        ";
        // line 101
        echo "                    </ul>
                </div>
            </nav>
        </div>

        <div class=\"uk-container uk-container-large\">
            <div class=\"uk-child-width-1-1@s uk-child-width-1-3@m uk-margin-large-bottom\" uk-grid id=\"grid\">
                <!-- ko foreach: accounts -->
                ";
        // line 158
        echo "                <!-- ko if: \$data.constructor.name == \"Account\" -->
                <div class=\"uk-grid-selector\" data-bind=\"fadeVisible: visible, css: { 'smallCard': !\$root.detailedView() }\">
                    <div class=\"uk-card uk-box-shadow-small\">
                        <button type=\"button\" uk-close class=\"uk-icon-button\" data-bind=\"click: \$root.removeAccount\"></button>
                        <!-- ko ifnot: loading -->
                        <div class=\"uk-card-header uk-card-default\" data-bind=\"css: { 'd1': gameVersion == 1, 'd2': gameVersion == 2 }\">
                            <div class=\"uk-grid-small uk-flex-middle\" uk-grid>
                                <div class=\"uk-width-auto\">
                                    <img width=\"50\" height=\"50\" data-bind=\"attr: { src: iconPath }\">
                                </div>
                                <div class=\"uk-width-expand\">
                                    <h3 class=\"uk-card-title uk-margin-remove-bottom\" data-bind=\"text: displayName\"></h3>
                                    <strong class=\"uk-margin-remove-top\" data-bind=\"text: gameVersion == 1 ? 'Destiny 1' : 'Destiny 2'\"></strong>
                                    <p class=\"uk-margin-remove-top\">Last played: <time data-bind=\"attr: { datetime: lastPlayed }, text: formattedLastPlayed\"></time></p>
                                </div>
                            </div>
                        </div>
                        <!-- ko ifnot: message -->
                        <div class=\"uk-card-body uk-card-default\">
                            <!-- ko ifnot: \$root.detailedView -->
                            <h3 class=\"uk-margin-remove-vertical\">Played: <strong data-bind=\"formatTime: timePlayed\"></strong></h3>
                            <h4 class=\"uk-margin-remove-vertical\">Wasted: <em data-bind=\"formatTime: timeWasted\"></em></h4>
                            <!-- /ko -->
                            <!-- ko if: \$root.detailedView -->
                            <div class=\"pop-top\">
                                <!-- ko if: bungieNetMembershipId -->
                                <a href=\"#\" class=\"bungieAccountPill\" data-bind=\"click: function() { \$root.fetchAccount(-1, bungieNetMembershipId()) }\">
                                    <img src=\"";
        // line 185
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('resource')->getCallable(), array("resources/public/assets/BungieLogo.png")), "html", null, true);
        echo "\"><span data-bind=\"text: bungieNetDisplayName\"></span>
                                </a>
                                <!-- /ko -->
                                <h3 class=\"uk-margin-remove-vertical\">Played: <strong data-bind=\"formatTime: timePlayed\"></strong></h3>
                                <h4 class=\"uk-margin-remove-vertical\">Wasted: <em data-bind=\"formatTime: timeWasted\"></em></h4>
                            </div>
                            <!-- ko foreach: characters -->
                            <!-- ko ifnot: deleted -->
                            <div data-bind=\"style: { 'background-image': 'url(\\'https://bungie.net' + backgroundPath + '\\')' }\" class=\"emblem uk-grid-collapse\" uk-grid>
                                <!-- ko if: \$parent.gameVersion == 1 -->
                                <img data-bind=\"attr: { src: 'https://www.bungie.net' + emblemPath }\" class=\"uk-width-auto imgHolder\">
                                <!-- /ko -->
                                <!-- ko if: \$parent.gameVersion == 2 -->
                                <div class=\"uk-width-auto imgHolder\"></div>
                                <!-- /ko -->
                                <div class=\"uk-width-expand\">
                                    <strong class=\"characterName\" data-bind=\"text: race + ' ' + charClass\"></strong>
                                    <span class=\"timePlayed\" data-bind=\"formatTime: timePlayed\"></span>
                                    ";
        // line 204
        echo "                                </div>
                                <div class=\"uk-width-auto infoRight\">
                                    <i class=\"powerLevel\" data-bind=\"text: level, css: { 'd1': \$parent.gameVersion == 1, 'd2': \$parent.gameVersion == 2 }\"></i>
                                </div>
                            </div>
                            <!-- /ko -->
                            <!-- ko if: deleted -->
                            <div class=\"uk-grid-collapse deletedChar\" uk-grid>
                                <span uk-icon=\"icon: trash; ratio: 2\" class=\"uk-width-auto deletedIcon\"></span>
                                <div class=\"uk-width-expand\">
                                    <strong class=\"characterName\">Deleted</strong>
                                    <span class=\"timePlayed\" data-bind=\"formatTime: timePlayed\"></span>
                                </div>
                            </div>
                            <!-- /ko -->
                            <!-- /ko -->
                            <!-- /ko -->
                        </div>
                        <!-- /ko -->
                        <!-- ko if: message -->
                        <div class=\"uk-card-body uk-card-default\">
                            <p class=\"uk-text-danger\" data-bind=\"text: message\"></p>
                        </div>
                        <!-- /ko -->
                        <!-- /ko -->
                        <!-- ko if: loading -->
                        <div class=\"uk-card-body uk-card-primary uk-flex\">
                            <div class=\"uk-align-center\" uk-spinner></div>
                        </div>
                        <!-- /ko -->
                    </div>
                </div>
                <!-- /ko -->
                <!-- /ko -->
            </div>
        </div>

        <div class=\"uk-container uk-container-large uk-margin-small-bottom\">
            <span>Made with <i uk-icon=\"icon: heart\"></i> by <a href=\"#\" data-bind=\"click: function() { fetchAccount(-1, 664856) }\">";
        // line 242
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('config')->getCallable(), array("application", "author")), "html", null, true);
        echo "</a></span>
            <span> | </span>
            <a href=\"#about-modal\" uk-toggle>About</a>
        </div>

        <div class=\"uk-clearfix\"></div>
    </div>

    <div id=\"about-modal\" uk-modal>
        <div class=\"uk-modal-dialog uk-modal-body\">
            <button class=\"uk-modal-close-default\" type=\"button\" uk-close></button>
            <h2 class=\"uk-modal-title\">About</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        </div>
    </div>

    <script src=\"";
        // line 258
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('resource')->getCallable(), array("bower_components/jquery/dist/jquery.js")), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 259
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('resource')->getCallable(), array("bower_components/uikit/dist/js/uikit.js")), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 260
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('resource')->getCallable(), array("bower_components/uikit/dist/js/uikit-icons.js")), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 261
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('resource')->getCallable(), array("bower_components/requirejs/require.js")), "html", null, true);
        echo "\" data-main=\"";
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('resource')->getCallable(), array("resources/public/scripts/application.js")), "html", null, true);
        echo "\"></script>
    <script>
        requirejs.config({
            baseUrl: '/resources/public/scripts',
            paths: {
                text: '/bower_components/requirejs-plugins/lib/text',
                async: '/bower_components/requirejs-plugins/src/async',
                font: '/bower_components/requirejs-plugins/src/font',
                goog: '/bower_components/requirejs-plugins/src/goog',
                image: '/bower_components/requirejs-plugins/src/image',
                json: '/bower_components/requirejs-plugins/src/json',
                noext: '/bower_components/requirejs-plugins/src/noext',
                mdown: '/bower_components/requirejs-plugins/src/mdown',
                propertyParser : '/bower_components/requirejs-plugins/src/propertyParser',
                markdownConverter : '/bower_components/requirejs-plugins/lib/Markdown.Converter',
                jquery: '/bower_components/jquery/dist/jquery',
                uikit: '/bower_components/uikit/dist/js/uikit',
                'uikit-icons': '/bower_components/uikit/dist/js/uikit-icons',
                knockout: '/bower_components/knockout/dist/knockout',
                masonry: '/bower_components/masonry/dist/masonry.pkgd'
            }
        });

        require([
            'knockout',
            'application',
            'jquery',
            'uikit',
            'ko.formatTime',
            'ko.fadevisible'
        ], function(ko, Application) {
            ko.applyBindings(new Application('";
        // line 292
        echo twig_escape_filter($this->env, ((array_key_exists("search", $context)) ? (_twig_default_filter(($context["search"] ?? null))) : ("")), "html", null, true);
        echo "'));
        });
    </script>
    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
        ga('create', 'UA-52347626-4', 'auto');
        ga('send', 'pageview');
    </script>
</body>
</html>";
    }

    public function getTemplateName()
    {
        return "index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  314 => 292,  278 => 261,  274 => 260,  270 => 259,  266 => 258,  247 => 242,  207 => 204,  186 => 185,  157 => 158,  147 => 101,  132 => 90,  88 => 48,  73 => 26,  59 => 15,  55 => 14,  51 => 13,  47 => 12,  43 => 11,  38 => 9,  34 => 8,  30 => 7,  22 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!DOCTYPE html>
<html lang=\"{{ apine.language_short }}\">
<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1.0\"/>
    <meta name=\"description\" content=\"{{ translate(\"application\", \"description\") }}\">
    <meta property=\"og:title\" content=\"{{ translate(\"application\", \"title\") }}\"/>
    <meta property=\"og:description\" content=\"{{ translate(\"application\", \"description\") }}\"/>
    <meta property=\"og:type\" content=\"website\"/>
    <meta property=\"og:url\" content=\"{{ ''|resource }}\"/>
    <meta property=\"og:image\" content=\"{{ 'resources/public/assets/opengraph.jpg'|path }}\"/>
    <title>{{ translate('application', 'title') }}</title>
    <link rel=\"stylesheet\" href=\"{{ 'bower_components/uikit/dist/css/uikit.min.css'|resource }}\">
    <link rel=\"stylesheet\" href=\"{{ 'resources/public/css/stylesheet.css'|resource }}\">
</head>
<body>
    <div class=\"uk-height-viewport uk-section-media\" id=\"background\" data-bind=\"visible: mainVisible\">
        <div class=\"clock\">
            <div id=\"clockBackground\"></div>
            <div id=\"clockRadial\"></div>
            <div id=\"clockBigHand\"></div>
            <div id=\"clockLittleHand\"></div>
        </div>
        <div class=\"uk-position-center uk-position-medium\">
            <img src=\"{{ 'resources/public/assets/logo.svg'|resource }}\">
            <nav class=\"nav-overlay uk-navbar-container uk-navbar-transparent uk-margin uk-position-relative\" uk-navbar>
                <div class=\"uk-navbar-left uk-flex-1\">
                    <div class=\"uk-navbar-item uk-width-expand\">
                        <form class=\"uk-search uk-search-navbar uk-width-1-1\" data-bind=\"submit: fetchAccounts\">
                            <input class=\"uk-search-input\" type=\"search\" data-bind=\"textInput: input\" placeholder=\"Search...\" autofocus>
                        </form>
                    </div>
                    <a class=\"uk-navbar-toggle\" uk-icon=\"icon: search\" data-bind=\"click: fetchAccounts\" href=\"#\"></a>
                </div>
            </nav>

            {#<a href=\"#\" data-bind=\"click: showLeaderboard\" class=\"uk-animation-fade uk-text-center uk-link-reset\">
                <!-- ko with: leaderboard -->
                <!-- ko with: entries -->
                <!-- ko with: \$data[0] -->
                <h3 class=\"uk-text-muted uk-margin-remove\">1st: <span data-bind=\"text: displayName\"></span> - <small data-bind=\"formatTime: timePlayed\"></small></h3>
                <!-- /ko -->
                <!-- /ko -->
                <!-- /ko -->
                <h4 class=\"uk-text-muted uk-margin-remove\">See leaderboard</h4>
            </a>#}

            <div id=\"adBottom\">
                <br/>
                <script async src=\"//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js\"></script>
                <ins class=\"adsbygoogle\"
                     style=\"display:block\"
                     data-ad-client=\"ca-pub-6332373031553935\"
                     data-ad-slot=\"7124654099\"
                     data-ad-format=\"auto\"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
        </div>

        <div id=\"adBottomMobile\" style=\"height: 90px\">
        </div>
    </div>
    <div class=\"uk-height-viewport uk-section-secondary uk-preserve-color\" data-bind=\"visible: statsVisible\" id=\"stats\">
        <div class=\"sticky\">
            <nav id=\"sticky-navbar\" class=\"uk-navbar-container uk-navbar-inverse\" uk-navbar style=\"position: relative; z-index: 980;\">
                <div class=\"uk-navbar-left\">
                    <a class=\"uk-navbar-toggle\" uk-navbar-toggle-icon href=\"#\"></a>
                    <div uk-dropdown=\"mode: click\" class=\"uk-navbar-dropdown\">
                        <ul class=\"uk-nav uk-navbar-dropdown-nav\">
                            <li>
                                <a href=\"#about-modal\" uk-toggle>
                                    <span uk-icon=\"icon: question; ratio: 1\"></span> About
                                </a>
                            </li>
                            <li>
                                <a href=\"#\" data-bind=\"click: toggleDetailedView\">
                                    <span uk-icon=\"icon: bolt; ratio: 1\"></span> <span data-bind=\"text: detailedView() ? 'Detailed view [On]' : 'Detailed view [Off]'\">Detailed view [On]</span>
                                </a>
                            </li>
                            <li>
                                <a href=\"#\" data-bind=\"click: toggleTimeFormat\">
                                    <span uk-icon=\"icon: clock; ratio: 1\"></span> <span data-bind=\"text: hoursMode() ? 'Time format [Hours]' : 'Time format [Full]'\">Time format [Hours]</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <a href=\"{{ ''|path }}\" class=\"uk-navbar-item uk-logo\"><img src=\"{{ 'resources/public/assets/logo.svg'|resource }}\"></a>
                </div>
                <div class=\"uk-navbar-right\">
                    <ul class=\"uk-navbar-nav\">
                        <div class=\"uk-navbar-item\">
                            <form class=\"uk-search uk-search-navbar uk-width-1-1\" data-bind=\"submit: fetchAccounts\">
                                <input class=\"uk-search-input\" type=\"search\" data-bind=\"textInput: input\" placeholder=\"Search...\" autofocus>
                            </form>
                        </div>
                        <a class=\"uk-navbar-toggle\" uk-icon=\"icon: plus-circle\" data-bind=\"click: fetchAccounts, attr: { 'uk-icon': accounts().length > 0 ? 'icon: plus-circle' : 'icon: search' }\" href=\"#\"></a>
                        {#<li><a uk-icon=\"icon: world\" href=\"#\" data-bind=\"click: showLeaderboard\"></a></li>#}
                    </ul>
                </div>
            </nav>
        </div>

        <div class=\"uk-container uk-container-large\">
            <div class=\"uk-child-width-1-1@s uk-child-width-1-3@m uk-margin-large-bottom\" uk-grid id=\"grid\">
                <!-- ko foreach: accounts -->
                {#<!-- ko if: \$data.constructor.name == \"Leaderboard\" -->
                <div class=\"uk-grid-selector\" data-bind=\"fadeVisible: visible, css: { 'smallCard': !\$root.detailedView() }\">
                    <div class=\"uk-card uk-box-shadow-small\">
                        <button type=\"button\" uk-close class=\"uk-icon-button\" data-bind=\"click: \$root.removeAccount\"></button>
                        <!-- ko ifnot: loading -->
                        <div class=\"uk-card-header uk-card-default leaderboard\">
                            <div class=\"uk-grid-small uk-flex-middle\" uk-grid>
                                <div class=\"uk-width-auto\">
                                    <img width=\"50\" height=\"50\" src=\"{{ 'resources/public/assets/LeaderboardLogo.png'|resource }}\">
                                </div>
                                <div class=\"uk-width-expand\">
                                    <h3 class=\"uk-card-title uk-margin-remove-bottom\">Leaderboard</h3>
                                    <p class=\"uk-text-meta uk-margin-remove-top\">Total players: <span data-bind=\"text: totalPlayers\"></span></p>
                                </div>
                            </div>
                        </div>
                        <!-- ko ifnot: message -->
                        <div class=\"uk-card-body uk-card-default\">
                            <!-- ko foreach: entries -->
                            <a href=\"#\" data-bind=\"click: function() { \$root.fetchAccount(membershipType, membershipId) }\" class=\"uk-grid-collapse uk-link-reset deletedChar\" uk-grid>
                                <span data-bind=\"text: \$index() + 1 + ((\$root.leaderboard.page() - 1) * \$root.leaderboard.count)\" class=\"uk-width-1-6\"></span>
                                <img data-bind=\"attr: { src: iconPath }\" class=\"uk-width-auto\" style=\"height: 16px\">
                                <div class=\"uk-width-expand\" style=\"margin-left: 5px\">
                                    <strong class=\"characterName\" data-bind=\"text: displayName\"></strong>
                                </div>
                                <span data-bind=\"formatTime: timePlayed\" class=\"uk-width-auto\"></span>
                            </a>
                            <!-- /ko -->
                            <ul class=\"uk-pagination\">
                                <li><a href=\"#\" data-bind=\"click: previous\"><span class=\"uk-margin-small-right\" uk-pagination-previous></span> Previous</a></li>
                                <li class=\"uk-align-center uk-margin-remove-vertical\">Page <span class=\"uk-display-inline\" data-bind=\"text: page\"></span></li>
                                <li><a href=\"#\" data-bind=\"click: next\">Next <span class=\"uk-margin-small-left\" uk-pagination-next></span></a></li>
                            </ul>
                        </div>
                        <!-- /ko -->
                        <!-- ko if: message -->
                        <div class=\"uk-card-body uk-card-default\">
                            <p class=\"uk-text-danger\" data-bind=\"text: message\"></p>
                        </div>
                        <!-- /ko -->
                        <!-- /ko -->
                        <!-- ko if: loading -->
                        <div class=\"uk-card-body uk-card-primary uk-flex\">
                            <div class=\"uk-align-center\" uk-spinner></div>
                        </div>
                        <!-- /ko -->
                    </div>
                </div>
                <!-- /ko -->#}
                <!-- ko if: \$data.constructor.name == \"Account\" -->
                <div class=\"uk-grid-selector\" data-bind=\"fadeVisible: visible, css: { 'smallCard': !\$root.detailedView() }\">
                    <div class=\"uk-card uk-box-shadow-small\">
                        <button type=\"button\" uk-close class=\"uk-icon-button\" data-bind=\"click: \$root.removeAccount\"></button>
                        <!-- ko ifnot: loading -->
                        <div class=\"uk-card-header uk-card-default\" data-bind=\"css: { 'd1': gameVersion == 1, 'd2': gameVersion == 2 }\">
                            <div class=\"uk-grid-small uk-flex-middle\" uk-grid>
                                <div class=\"uk-width-auto\">
                                    <img width=\"50\" height=\"50\" data-bind=\"attr: { src: iconPath }\">
                                </div>
                                <div class=\"uk-width-expand\">
                                    <h3 class=\"uk-card-title uk-margin-remove-bottom\" data-bind=\"text: displayName\"></h3>
                                    <strong class=\"uk-margin-remove-top\" data-bind=\"text: gameVersion == 1 ? 'Destiny 1' : 'Destiny 2'\"></strong>
                                    <p class=\"uk-margin-remove-top\">Last played: <time data-bind=\"attr: { datetime: lastPlayed }, text: formattedLastPlayed\"></time></p>
                                </div>
                            </div>
                        </div>
                        <!-- ko ifnot: message -->
                        <div class=\"uk-card-body uk-card-default\">
                            <!-- ko ifnot: \$root.detailedView -->
                            <h3 class=\"uk-margin-remove-vertical\">Played: <strong data-bind=\"formatTime: timePlayed\"></strong></h3>
                            <h4 class=\"uk-margin-remove-vertical\">Wasted: <em data-bind=\"formatTime: timeWasted\"></em></h4>
                            <!-- /ko -->
                            <!-- ko if: \$root.detailedView -->
                            <div class=\"pop-top\">
                                <!-- ko if: bungieNetMembershipId -->
                                <a href=\"#\" class=\"bungieAccountPill\" data-bind=\"click: function() { \$root.fetchAccount(-1, bungieNetMembershipId()) }\">
                                    <img src=\"{{ 'resources/public/assets/BungieLogo.png'|resource }}\"><span data-bind=\"text: bungieNetDisplayName\"></span>
                                </a>
                                <!-- /ko -->
                                <h3 class=\"uk-margin-remove-vertical\">Played: <strong data-bind=\"formatTime: timePlayed\"></strong></h3>
                                <h4 class=\"uk-margin-remove-vertical\">Wasted: <em data-bind=\"formatTime: timeWasted\"></em></h4>
                            </div>
                            <!-- ko foreach: characters -->
                            <!-- ko ifnot: deleted -->
                            <div data-bind=\"style: { 'background-image': 'url(\\'https://bungie.net' + backgroundPath + '\\')' }\" class=\"emblem uk-grid-collapse\" uk-grid>
                                <!-- ko if: \$parent.gameVersion == 1 -->
                                <img data-bind=\"attr: { src: 'https://www.bungie.net' + emblemPath }\" class=\"uk-width-auto imgHolder\">
                                <!-- /ko -->
                                <!-- ko if: \$parent.gameVersion == 2 -->
                                <div class=\"uk-width-auto imgHolder\"></div>
                                <!-- /ko -->
                                <div class=\"uk-width-expand\">
                                    <strong class=\"characterName\" data-bind=\"text: race + ' ' + charClass\"></strong>
                                    <span class=\"timePlayed\" data-bind=\"formatTime: timePlayed\"></span>
                                    {#<small class=\"topRank\" data-bind=\"text: 'Top 5%'\"></small>#}
                                </div>
                                <div class=\"uk-width-auto infoRight\">
                                    <i class=\"powerLevel\" data-bind=\"text: level, css: { 'd1': \$parent.gameVersion == 1, 'd2': \$parent.gameVersion == 2 }\"></i>
                                </div>
                            </div>
                            <!-- /ko -->
                            <!-- ko if: deleted -->
                            <div class=\"uk-grid-collapse deletedChar\" uk-grid>
                                <span uk-icon=\"icon: trash; ratio: 2\" class=\"uk-width-auto deletedIcon\"></span>
                                <div class=\"uk-width-expand\">
                                    <strong class=\"characterName\">Deleted</strong>
                                    <span class=\"timePlayed\" data-bind=\"formatTime: timePlayed\"></span>
                                </div>
                            </div>
                            <!-- /ko -->
                            <!-- /ko -->
                            <!-- /ko -->
                        </div>
                        <!-- /ko -->
                        <!-- ko if: message -->
                        <div class=\"uk-card-body uk-card-default\">
                            <p class=\"uk-text-danger\" data-bind=\"text: message\"></p>
                        </div>
                        <!-- /ko -->
                        <!-- /ko -->
                        <!-- ko if: loading -->
                        <div class=\"uk-card-body uk-card-primary uk-flex\">
                            <div class=\"uk-align-center\" uk-spinner></div>
                        </div>
                        <!-- /ko -->
                    </div>
                </div>
                <!-- /ko -->
                <!-- /ko -->
            </div>
        </div>

        <div class=\"uk-container uk-container-large uk-margin-small-bottom\">
            <span>Made with <i uk-icon=\"icon: heart\"></i> by <a href=\"#\" data-bind=\"click: function() { fetchAccount(-1, 664856) }\">{{ config('application', 'author') }}</a></span>
            <span> | </span>
            <a href=\"#about-modal\" uk-toggle>About</a>
        </div>

        <div class=\"uk-clearfix\"></div>
    </div>

    <div id=\"about-modal\" uk-modal>
        <div class=\"uk-modal-dialog uk-modal-body\">
            <button class=\"uk-modal-close-default\" type=\"button\" uk-close></button>
            <h2 class=\"uk-modal-title\">About</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        </div>
    </div>

    <script src=\"{{ 'bower_components/jquery/dist/jquery.js'|resource }}\"></script>
    <script src=\"{{ 'bower_components/uikit/dist/js/uikit.js'|resource }}\"></script>
    <script src=\"{{ 'bower_components/uikit/dist/js/uikit-icons.js'|resource }}\"></script>
    <script src=\"{{ 'bower_components/requirejs/require.js'|resource }}\" data-main=\"{{ 'resources/public/scripts/application.js'|resource }}\"></script>
    <script>
        requirejs.config({
            baseUrl: '/resources/public/scripts',
            paths: {
                text: '/bower_components/requirejs-plugins/lib/text',
                async: '/bower_components/requirejs-plugins/src/async',
                font: '/bower_components/requirejs-plugins/src/font',
                goog: '/bower_components/requirejs-plugins/src/goog',
                image: '/bower_components/requirejs-plugins/src/image',
                json: '/bower_components/requirejs-plugins/src/json',
                noext: '/bower_components/requirejs-plugins/src/noext',
                mdown: '/bower_components/requirejs-plugins/src/mdown',
                propertyParser : '/bower_components/requirejs-plugins/src/propertyParser',
                markdownConverter : '/bower_components/requirejs-plugins/lib/Markdown.Converter',
                jquery: '/bower_components/jquery/dist/jquery',
                uikit: '/bower_components/uikit/dist/js/uikit',
                'uikit-icons': '/bower_components/uikit/dist/js/uikit-icons',
                knockout: '/bower_components/knockout/dist/knockout',
                masonry: '/bower_components/masonry/dist/masonry.pkgd'
            }
        });

        require([
            'knockout',
            'application',
            'jquery',
            'uikit',
            'ko.formatTime',
            'ko.fadevisible'
        ], function(ko, Application) {
            ko.applyBindings(new Application('{{ search|default() }}'));
        });
    </script>
    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
        ga('create', 'UA-52347626-4', 'auto');
        ga('send', 'pageview');
    </script>
</body>
</html>", "index.twig", "C:\\wamp64\\www\\wod2\\views\\index.twig");
    }
}
