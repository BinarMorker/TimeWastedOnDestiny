<?php

/* index.twig */
class __TwigTemplate_38891dc7b24eb5c4dc3fc6a1665261662b3f6b6169b72b856c2c55f28fbf5f8a extends Twig_Template
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
<html lang=\"en\">
<head>
    <title>";
        // line 4
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("application", "title")), "html", null, true);
        echo "</title>
    <link rel=\"stylesheet\" href=\"";
        // line 5
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('resource')->getCallable(), array("bower_components/uikit/dist/css/uikit.min.css")), "html", null, true);
        echo "\">
    <script src=\"";
        // line 6
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('resource')->getCallable(), array("bower_components/jquery/dist/jquery.min.js")), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 7
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('resource')->getCallable(), array("bower_components/uikit/dist/js/uikit.min.js")), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 8
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('resource')->getCallable(), array("bower_components/uikit/dist/js/uikit-icons.min.js")), "html", null, true);
        echo "\"></script>
</head>
<body>
    <div class=\"uk-height-viewport uk-section-media\" style=\"
        background: url(";
        // line 12
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('resource')->getCallable(), array("resources/public/assets/background.jpg")), "html", null, true);
        echo ");
        background-size: cover;
    \">
        <div class=\"uk-position-center uk-position-medium\">
            ";
        // line 17
        echo "            <img src=\"";
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('resource')->getCallable(), array("resources/public/assets/logo.svg")), "html", null, true);
        echo "\">
            <nav class=\"nav-overlay uk-navbar-container uk-navbar-transparent uk-margin uk-position-relative\" uk-navbar style=\"
                border: 1px solid #ccc;
            \">
                <div class=\"uk-navbar-left uk-flex-1\">
                    <div class=\"uk-navbar-item uk-width-expand\">
                        <form class=\"uk-search uk-search-navbar uk-width-1-1\">
                            <input class=\"uk-search-input\" type=\"search\" placeholder=\"Search...\" autofocus style=\"
                                color: #ccc;
                            \">
                        </form>
                    </div>
                    <a class=\"uk-navbar-toggle\" uk-search-icon href=\"#\"></a>
                </div>
            </nav>
        </div>

        <div class=\"uk-position-bottom-center uk-position-small\">
            <span class=\"uk-text-lead uk-text-muted\">13397h - G-Money876</span>
        </div>
    </div>
    <div class=\"uk-height-viewport uk-section-secondary\"></div>
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
        return array (  54 => 17,  47 => 12,  40 => 8,  36 => 7,  32 => 6,  28 => 5,  24 => 4,  19 => 1,);
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
<html lang=\"en\">
<head>
    <title>{{ translate('application', 'title') }}</title>
    <link rel=\"stylesheet\" href=\"{{ 'bower_components/uikit/dist/css/uikit.min.css'|resource }}\">
    <script src=\"{{ 'bower_components/jquery/dist/jquery.min.js'|resource }}\"></script>
    <script src=\"{{ 'bower_components/uikit/dist/js/uikit.min.js'|resource }}\"></script>
    <script src=\"{{ 'bower_components/uikit/dist/js/uikit-icons.min.js'|resource }}\"></script>
</head>
<body>
    <div class=\"uk-height-viewport uk-section-media\" style=\"
        background: url({{ 'resources/public/assets/background.jpg'|resource }});
        background-size: cover;
    \">
        <div class=\"uk-position-center uk-position-medium\">
            {#<h1>{{ translate(\"application\", \"title\") }}</h1>#}
            <img src=\"{{ 'resources/public/assets/logo.svg'|resource }}\">
            <nav class=\"nav-overlay uk-navbar-container uk-navbar-transparent uk-margin uk-position-relative\" uk-navbar style=\"
                border: 1px solid #ccc;
            \">
                <div class=\"uk-navbar-left uk-flex-1\">
                    <div class=\"uk-navbar-item uk-width-expand\">
                        <form class=\"uk-search uk-search-navbar uk-width-1-1\">
                            <input class=\"uk-search-input\" type=\"search\" placeholder=\"Search...\" autofocus style=\"
                                color: #ccc;
                            \">
                        </form>
                    </div>
                    <a class=\"uk-navbar-toggle\" uk-search-icon href=\"#\"></a>
                </div>
            </nav>
        </div>

        <div class=\"uk-position-bottom-center uk-position-small\">
            <span class=\"uk-text-lead uk-text-muted\">13397h - G-Money876</span>
        </div>
    </div>
    <div class=\"uk-height-viewport uk-section-secondary\"></div>
</body>
</html>", "index.twig", "C:\\wamp64\\www\\wod2\\views\\index.twig");
    }
}
