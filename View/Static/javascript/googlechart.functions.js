function load() {
    // Load the Visualization API and the piechart package.
    google.load('visualization', '1.0', {'packages': ['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawchart, true);
}

function drawchart() {
    // Create the data table.
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Marketing Kanaal');
    data.addColumn('number', 'Omzet in Euro');

    // parse em JSON!
    var piedata = JSON.parse(json);

    var index = piedata['marketing_channels'].length
    while (index--) {
        data.addRow([piedata['marketing_channels'][index]['name'], parseFloat(piedata['marketing_channels'][index]['revenue'])]);
    }

    // Add a number formatter.
    var formatter = new google.visualization.NumberFormat(
        {negativeColor: 'red', negativeParens: true, prefix: '€'});
    formatter.format(data, 1);

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.PieChart(document.getElementById('chart_div'));

    // add select listener, when you click a slice it wil load the channel dashboard.
    google.visualization.events.addListener(chart, 'select',
        selectSlice);

    // Set chart options
    var options = {
        'height': '250',
        'width': '250',
        'chartArea': {
            'width': '95%',
            'height': '95%'
        },
        'legend': {
            'position': 'right'
        },
        'allowHtml': 'true',
        'showRowNumber': 'true'
    };

    function selectSlice() {
        var selectedData = chart.getSelection();
        var row = selectedData[0].row;
        var channel = data.getValue(row, 0);
        var index = piedata['marketing_channels'].length
        while (index--) {
            if (channel === piedata['marketing_channels'][index]['name']) {
                window.location = window.location.origin+'/dashboard/channel/'+ piedata['webshop_id'] + '/' + piedata['marketing_channels'][index]['id'];
            }
        }
    }

    // Pie -em
    chart.draw(data, options);
}