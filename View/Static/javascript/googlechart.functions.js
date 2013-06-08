function load(json_objects)
{
    // Load the Visualization API and the piechart package.
    google.load('visualization', '1.0', {'packages': ['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawchart(json_objects));
}

function drawchart(json_objects)
{
    // Create the data table.
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Marketing Kanaal');
    data.addColumn('number', 'Omzet in Euro');

    // parse em JSON!
    var piedata = JSON.parse(json_objects);
    jQuery.each(piedata, function(marketingchannel, revenue) {
        data.addRow([marketingchannel, parseFloat(revenue)]);
    });

    // Add a number formatter.
    var formatter = new google.visualization.NumberFormat(
        {negativeColor: 'red', negativeParens: true, prefix: '€'});
    formatter.format(data, 1);

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.PieChart(document.getElementById('chart_div'));

    // Set chart options
    var options = {
        'height' : '400',
        'width' : '600',
        'chartArea' : {
            'width' : '75%',
            'height' : '75%'
        },
        'legend': {
            'position': 'bottom'
        },
        'allowHtml': 'true',
        'showRowNumber': 'true'
    };

    // Pie -em
    chart.draw(data, options);
}