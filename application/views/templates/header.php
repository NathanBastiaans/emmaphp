<!DOCTYPE html>
<html>
<head>
    <title><?= TITLE ?></title>

    <meta name="viewport" content="width=device-width, user-scalable=yes">

    <!--css-->
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Didact+Gothic' rel='stylesheet' type='text/css'>
    <style>
        /*#DD1144;*/

        * {

            margin: 0;
            padding: 0;
            border: 0;
            outline: 0;

        }

        html {

            height: 100%;

        }

        body {

            /*border-top: #FAFAFA 6px solid;*/
            font-family: "Lobster";


        }

        .section {

            width: 100%;
            min-width: 600px;
            min-height: 600px;

        }

        #section_1 {

            background-color: #DD1144;
            color: #FAFAFA;
            height: 100vh;
            
        }

        .content {

            position: absolute;
            width: 100%;

        }

        .center {

            text-align: center;

        }

        #section_1_content {

            margin-top: 20vh;
            position: fixed;
            z-index: 100;

        }

        #title {

            width: 100%;
            text-shadow: 0px 3px 5px #222;
            font-size: 80px;

        }

        #description {

            /*margin-top: 290px;*/
            font-size: 20px;
            font-family: "Didact Gothic";

        }

        #download {

            width: 100%;
            margin-top: 30px;
            text-align: center;

        }

        #download_button {

            padding: 15px;
            height: 50px;
            width: 200px;
            background-color: #FF0040;
            color: #EEE;
            text-shadow: 1px 1px 1px #222;
            border-radius: 5px;
            border: #CC1144 1px solid;

        } #download_button:hover {

              background-color: #CC1144;

          }

        #section_2 {

            position: relative;
            font-family: arial;
            /*font-size: 50vh;*/
            background-color: #FFF;
            z-index: 9999;
            height: border-box;

        }

        a {

            text-decoration: none;
            color: #222;

        }

        #section_2_content {

            margin-left: 10vw;
            margin-top: 100px;
            width: 80vw;
            height: auto;
            background-color: #FFF;

        }

        ul {

            margin-top: 10px;
            margin-left: 40px;

        }

        .pink {

            color: #DD1144;

        }

        .ug_item {

            margin-top: 40px;
            margin-left: 40px;

        }

        pre {

            background-color: #FAFAFA;
            border: #E0E0E0 thin solid;
            padding: 15px;
            width: 50%;
            overflow: auto;

        }

        #dwnlwd {

            color: #FAFAFA;

        }
    </style>
    <!--css end-->

    <!--jquery-->
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <!--jquery end-->

</head>
<body>

<!--wrapper-->
<div id="wrapper">