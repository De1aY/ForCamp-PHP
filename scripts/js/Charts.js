google.charts.load('current', {'packages':['corechart']});
google.charts.load('current', {packages: ['table']});
google.charts.setOnLoadCallback(drawSeriesChart);
google.charts.setOnLoadCallback(drawChart);
google.charts.setOnLoadCallback(drawTable);
function drawChart() {
var data = google.visualization.arrayToDataTable([
    ['Номер отряда', 'Балл', { role: 'style' } ],
    ['Отряд 1', 11, '#b87333'],
    ['Отряд 2', 10.49, 'silver'],
    ['Отряд 3', 19.30, 'gold'],
    ['Отряд 4', 21.45, 'color: #e5e4e2'],
    ['Отряд 5', 5, 'black'],
    ['Отряд 6', 15, 'blue'],
    ['Отряд 7', 18, 'brown'],
    ['Отряд 8', 9, 'red'],
    ['Отряд 9', 13, 'lime'],
    ['Отряд 10', 20, 'color: #0015ff']
]);

var view = new google.visualization.DataView(data);
view.setColumns([0, 1,
                { calc: 'stringify',
                    sourceColumn: 1,
                    type: 'string',
                    role: 'annotation' },
                2]);

var options = {
    title: 'Спорт',
    bar: {groupWidth: '100%'},
    legend: { position: 'none' },
};
var chart = new google.visualization.ColumnChart(document.getElementById('SportChart'));
chart.draw(view, options);
}
function drawSeriesChart() {

var data = google.visualization.arrayToDataTable([
    ['Название отряда', 'Общий балл', 'Средний балл', 'Цвет',     'Population'],
    ['Отряд 1',    $Results[0],              $Middle[0],      '1',    $Counts[0]],
    ['Отряд 2',    $Results[1],              $Middle[1],      '2',    $Counts[1]],
    ['Отряд 3',    $Results[2],              $Middle[2],      '3',    $Counts[2]],
    ['Отряд 4',    $Results[3],              $Middle[3],      '4',    $Counts[3]],
    ['Отряд 5',    $Results[4],              $Middle[4],      '5',    $Counts[4]],
    ['Отряд 6',    $Results[5],              $Middle[5],      '6',    $Counts[5]],
    ['Отряд 7',    $Results[6],              $Middle[6],      '7',    $Counts[6]],
    ['Отряд 8',    $Results[7],              $Middle[7],      '8',    $Counts[7]],
    ['Отряд 9',    $Results[8],              $Middle[8],      '9',    $Counts[8]],
    ['Отряд 10',    $Results[9],             $Middle[9],      '10',   $Counts[9]]
]);

var options = {
    hAxis: {title: 'Общий балл'},
    vAxis: {title: 'Средний балл'},
    bubble: {textStyle: {fontSize: 11}}
};
}
function drawTable() {
var data = new google.visualization.DataTable();
data.addColumn('string', 'Номер отряда');
data.addColumn('string', 'Спорт');
data.addColumn('string', 'Учёба');
data.addColumn('string', 'Искусство');
data.addColumn('string', 'Дисциплина');
data.addRows([
['1', '$Sports[0]', '$Studies[0]', '$Arts[0]', '$Disciplines[0]' ],
['2', '$Sports[1]', '$Studies[1]', '$Arts[1]', '$Disciplines[1]' ],
['3', '$Sports[2]', '$Studies[2]', '$Arts[2]', '$Disciplines[2]' ],
['4', '$Sports[3]', '$Studies[3]', '$Arts[3]', '$Disciplines[3]' ],
['5', '$Sports[4]', '$Studies[4]', '$Arts[4]', '$Disciplines[4]' ],
['6', '$Sports[5]', '$Studies[5]', '$Arts[5]', '$Disciplines[5]' ],
['7', '$Sports[6]', '$Studies[6]', '$Arts[6]', '$Disciplines[6]' ],
['8', '$Sports[7]', '$Studies[7]', '$Arts[7]', '$Disciplines[7]' ],
['9', '$Sports[8]', '$Studies[8]', '$Arts[8]', '$Disciplines[8]' ],
['10', '$Sports[9]', '$Studies[9]', '$Arts[9]', '$Disciplines8[9]' ]
]);

var table1 = new google.visualization.Table(document.getElementById('TableChart'));

table1.draw(data, {showRowNumber: true, width: '100%', height: '100%'});
}