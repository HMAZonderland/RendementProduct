function load()
{
    // Load the Visualization API and the piechart package.
    google.load('visualization', '1.0', {'packages': ['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawchart, true);
}

function drawchart()
{
    // Create the data table.
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Marketing Kanaal');
    data.addColumn('number', 'Omzet in Euro');

    // parse em JSON!
    var piedata = JSON.parse(json);
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
        'width' : '400',
        'chartArea' : {
            'width' : '90%',
            'height' : '90%'
        },
        'legend': {
            'position': 'right'
        },
        'allowHtml': 'true',
        'showRowNumber': 'true'
    };

    // Pie -em
    chart.draw(data, options);
}