<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Plano Interactivo</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="last-modified" content="Sat, 14 Sep 2013 08:00:00 GMT" />
    <meta name="description" content="High-end, jQuery-based, interactive maps: NBA Teams, US maps, OpenStreeMap and many other jQuery-based interactive map solutions." />
    <meta name="keywords" content="jquerymaps, jquery maps, interactive maps, dynamic maps, world map, us map, zip code map, election map, state map, county map, mall map, web map, mapping solutions, custom map, location map, territory map, area map" />
    <meta name="copyright" content="Copyright &copy; 2004-2013 jQueryMaps" />
    <meta name="robots" content="index,follow" />
    <meta name="robots" content="all" />
    <meta name="language" content="en" />
    <link type="image/x-icon" href="https://sge.securityfaircolombia.com/SGE/pafyc/images/favicon.ico" rel="icon" />
    <link type="image/x-icon" href="https://sge.securityfaircolombia.com/SGE/pafyc/images/favicon.ico" rel="shortcut icon" />     
    <link rel="stylesheet" type="text/css" href="css/custom.css">

    <!-- For IE 8 and lower, jQueryMaps uses Google ExplorerCanvas -->
    <!--[if IE]><script>if (document.documentMode < 9) document.write("<script src='jquerymaps/libs/excanvas/excanvas_tagcanvas.js'><\/script>");</script><![endif]-->

    <!-- jQuery and jQuery-UI libraries are needed by jQueryMaps -->
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" ></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js" ></script>
    <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.css" />
    <script type="text/javascript" src="https://www.youtube.com/player_api"></script>

    <!-- This library contains everything directly related to the map -->
    <script type="text/javascript" src="jquerymaps/libs/jqmMapMgmt.js" ></script>

    <!-- These libraries are not needed by jQueryMaps, but used in this evaluation pack -->
    <script type="text/javascript" src="jquerymaps/libs/chart.js" ></script>    
            <!--Bootstrap-->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <header id = "header">
            <div class = "page">
                <div class="col-sm-12 logo">
                    <img src="https://www.securityfaircolombia.com/images/CabezoteWeb2.jpg">
                </div>
            </div>
        </header>

        <div class = "page">
            <div class="box_main">
                <div class = "box span_9">
                    <!--Titulo-->
                    <div class="top"><h1 id="jqm_breadcrumbs"></h1></div>
                    <!--Espacio que ocupa el plano-->
                    <div class = "cnt">
                        <!--Barra de Carga-->
                        <div id= "jqm_loader" class= "jqm_loader"></div>
                        <!--Creación del Plano-->
                        <div id = "jqm_map" style = "z-index: 100;"></div>
                        <!--Leyenda del plano-->
                        <div id = "box_legend" class = "legend"></div>
                        <!--Este elemento DIV aparece cuando se pasa el cursor sobre un área o marcador-->
                        <div id ="jqm_popup" class = "jqm_popup">
                            <div class = "title">##label##</div>
                            <div class = "popup">##popup##</div> 
                        </div>
                        <!--Este elemento DIV aparece cuando hace clic en un área-->
                        <div id = "jqm_dialog" title = "">
                            <div id = "jqm_box_dialog">
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="span_3">
                <!--Seleccionar Empresa del Stand-->
                <div >
                </div>
            </div>
        </div>
        

    </body>
</html>
