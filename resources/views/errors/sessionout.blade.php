<!DOCTYPE html>
<html>
    <head>
        <title>Seesion Out</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #RRGGBB;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 36px;
                margin-bottom: 130px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Sorry. Session is expired...!!!</div>
                <p> Please <a href="{{ url('/') }}"  target="_blank" >Click Here</a> if redirection fails with in next 2 secounds ...</p>
            </div>
        </div>
	<script language="javascript" type="text/javascript">
	     
	     window.setTimeout('window.location="{{ url('/') }} "; ',3000);
	     
	 </script>
    </body>
</html>
