<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
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
                font-size: 96px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Laravel 5</div>

		<div class="visible-print text-center">
		    {!! QrCode::size(400)->generate('http://lookout.ig2i.fr'); !!}
		    <p>Scan me to return to the original page.</p>
		</div>
		<div class="visible-print text-center">
		    
		    <p>Conversion avec le webService 1000 USD : {{ $convert }} AUD le 2014-06-05  </p>
		</div>
            </div>
        </div>
    </body>
</html>
