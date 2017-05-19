<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible">
    <title>Document</title>
    <style>
        #chartdiv {
        width: 100%;
        height: 500px;
        }																	
    </style>
</head>
<body>
    <form method="post" id="formy" action="{{ action('ReportsController@readECGFile') }}" accept-charset="UTF-8" enctype="multipart/form-data">
        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
        <span>Select file:</span>
        <input type="file" name="ECGFile" class="form-class"/>
        <input type="submit" value="send" name="send"/>
    </form>
    <div id="chartdiv"></div>  
    
</body>
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
<script src="https://www.amcharts.com/lib/3/amstock.js"></script>

<script src="https://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>
<script type="text/javascript">
    var chartData = [],
    guides1 = [],
    guides2 = [],
    guides3 = [],
    guides4 = [];
    var rrrr = [
        34,
        2,
        1861,
        9251,
        -8464,
        5240,
        20,
        35,
        519
    ];
    //generateChartData(ecgData, date);

    $("#formy").on("submit", function(e){
            e.preventDefault();
            var f = $(this);
            var formData = new FormData(document.getElementById("formy"));
            //formData.append("dato", "valor");
            //formData.append(f.attr("name"), $(this)[0].files[0]);
            $.ajax({
                url: "",
                type: "post",
                dataType: "JSON",
                data: formData,
                cache: false,
                contentType: false,
	            processData: false,
                success: function(data, textStatus, jqXHR)
                {
                    generateChartData(data.ecgData, data.dates);
                },
                fail: function (jqXHR, textStatus, errorThrown)
                {
                    if ( console && console.log ) {
                        console.log( "La solicitud a fallado: " +  textStatus);
                    }
                }
            });
            //})
              //  .done(function(response){
                    //generateChartData(response.data.ecgData, response.data.date);
                //    console.log(response)
                //});
    });

    function generateChartData(ecgData, dates) {
    var firstDate = new Date(2011, 5, 1, 0, 0, 0, 0);
    //console.log(dates[0].toString().substr(0,2) + ',' + dates[0].toString().substr(3,2) + ',' + dates[0].toString().substr(6,2) + ',' + dates[0].toString().substr(9,3));
    firstDate.setHours(dates[0].toString().substr(0,2), dates[0].toString().substr(3,2), dates[0].toString().substr(6,2), dates[0].toString().substr(9,3));
    //firstDate.setHours( 12, 0, 0, 0 );
    firstDate.setDate( firstDate.getDate() - 2000 );

    for ( var i = 0; i < ecgData.length; i++ ) {
        var newDate = new Date( firstDate );
        newDate.setHours(dates[i].toString().substr(0,2), dates[i].toString().substr(3,2), dates[i].toString().substr(6,2), dates[i].toString().substr(9,3));
        //newDate.setSeconds( newDate.getSeconds() + i );
        chartData[ i ] = ( {
        "date": newDate,
        "ecg1": ecgData[i],
        } );
        if ( i == 500 ) {
        guides1.push( {
            "date": newDate,
            "lineColor": "#880063",
            "lineThickness": 2,
            "lineAlpha": 1,
            "label": "aVR"
        } );
        guides2.push( {
            "date": newDate,
            "lineColor": "#880063",
            "lineThickness": 2,
            "lineAlpha": 1,
            "label": "aVL"
        } );
        guides3.push( {
            "date": newDate,
            "lineColor": "#880063",
            "lineThickness": 2,
            "lineAlpha": 1,
            "label": "aVF"
        } );
        }
        else if ( i == 1000 ) {
        guides1.push( {
            "date": newDate,
            "lineColor": "#880063",
            "lineThickness": 2,
            "lineAlpha": 1,
            "label": "V1"
        } );
        guides2.push( {
            "date": newDate,
            "lineColor": "#880063",
            "lineThickness": 2,
            "lineAlpha": 1,
            "label": "V2"
        } );
        guides3.push( {
            "date": newDate,
            "lineColor": "#880063",
            "lineThickness": 2,
            "lineAlpha": 1,
            "label": "V3"
        } );
        }
        else if ( i == 1500 ) {
        guides1.push( {
            "date": newDate,
            "lineColor": "#880063",
            "lineThickness": 2,
            "lineAlpha": 1,
            "label": "V4"
        } );
        guides2.push( {
            "date": newDate,
            "lineColor": "#880063",
            "lineThickness": 2,
            "lineAlpha": 1,
            "label": "V5"
        } );
        guides3.push( {
            "date": newDate,
            "lineColor": "#880063",
            "lineThickness": 2,
            "lineAlpha": 1,
            "label": "V6"
        } );
        }
    }
    var chart = AmCharts.makeChart( "chartdiv", {
    "type": "stock",
    "theme": "light",

    "dataSets": [ {
        "fieldMappings": [ {
        "fromField": "ecg1",
        "toField": "ecg1"
        } ],
        "color": "#000",
        "dataProvider": chartData,
        "categoryField": "date"
    } ],


    "panels": [ {
        "title": "I",
        "showCategoryAxis": true,
        "stockGraphs": [ {
        "id": "g1",
        "title": "ECG #1",
        "valueField": "ecg1",
        "showBalloon": true
        } ],
        "guides": guides1
    } ],

    "chartScrollbarSettings": {
        "graph": "g1",
        "graphType": "line",
        "usePeriod": "mm"
    },

    "categoryAxesSettings": {
        "minPeriod": "ss",
        "gridColor": "#ff9c9c",
        "gridAlpha": 0.7,
        "gridAlpha": 1,
        "axisAlpha": 0,
        "minorGridEnabled": true,
        "minorGridAlpha": 0.4,
        "labelsEnabled": false,
        "position": "top"
    },

    "valueAxesSettings": {
        "gridColor": "#ff9c9c",
        "gridAlpha": 0.7,
        "axisAlpha": 0,
        "minorGridEnabled": true,
        "minorGridAlpha": 0.4,
        "labelsEnabled": false
    },

    "chartCursorSettings": {
        "valueLineBalloonEnabled": true,
        "valueLineEnabled": true
    }
    } );
    }

    
</script>
</html>