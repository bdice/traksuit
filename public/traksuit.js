var app = angular.module('Traksuit', ['ngMaterial', 'ngRetina', 'n3-line-chart']);

app.controller('TraksuitController', ['$scope', '$mdSidenav', 'DataService', '$timeout','$log', function($scope, $mdSidenav, DataService, $timeout, $log) {
  var allCharts = [];
  
  $scope.selected = null;
  $scope.sensorData = [];
  $scope.charts = allCharts;
  $scope.selectChart = selectChart;
  $scope.toggleSidenav = toggleSidenav;

  var timeChartOptions = {
    axes: {
      x: {key: 'time', labelFunction: function(value) {return value.toLocaleTimeString();}, type: 'date', ticks: 5},
      y: {type: 'linear'}
    },
    series: [
      {y: 'value', color: '#2c3e50', thickness: '2px', type: 'area', striped: true, label: 'Temperature'}
    ],
    lineMode: 'linear',
    tension: 0.7,
    tooltip: {mode: 'scrubber', formatter: function(x, y, series) {return "("+x+", "+y+")";}},
    drawLegend: false,
    drawDots: true,
    columnsHGap: 5
  };

  var correlationChartOptions = {
    axes: {
      x: {key: 'value1', labelFunction: function(value) {return value;}, type: 'linear', ticks: 5},
      y: {type: 'linear'}
    },
    series: [
      {y: 'value2', color: '#3498db', thickness: '2px', type: 'line', striped: true, label: 'Temperature'}
    ],
    lineMode: 'linear',
    tension: 0.7,
    tooltip: {mode: 'scrubber', formatter: function(x, y, series) {return "("+x+", "+y+")";}},
    drawLegend: false,
    drawDots: true,
    columnsHGap: 5
  };

  $scope.chartOptions = timeChartOptions;
  
  loadCharts();
  
  function loadCharts() {
    DataService.loadCharts()
      .then(function(chartResponse){
        allCharts = chartResponse.data;
        $scope.charts = [].concat(chartResponse.data);
        $scope.selected = $scope.charts[0];
        loadSensorData();
      });
  }

  function loadSensorData() {
    $scope.sensorData = [];
    if($scope.selected[1].name == "Time"){
      console.log("Time");
      DataService.loadSensorData($scope.selected[0].name).then(function(sensorDataResponse){
        console.log(sensorDataResponse);
        for(var i = 0; i < sensorDataResponse.data.length; i++){
          var observation = {
            "time": new Date(sensorDataResponse.data[i]['created_at']),
            "value": sensorDataResponse.data[i]['value']
          };
          $scope.sensorData.push(observation);
        }
        $scope.chartOptions = timeChartOptions;
      });
    }else{
      DataService.loadMultipleSensorData($scope.selected[0].name, $scope.selected[1].name).then(function(sensorMultiDataResponse){
        var sensorDataResponse1 = sensorMultiDataResponse[0];
        var sensorDataResponse2 = sensorMultiDataResponse[1];
        for(var i = 0; i < Math.min(sensorDataResponse1.data.length, sensorDataResponse2.data.length); i++){
          var observation = {
            "value1": sensorDataResponse1.data[i]['value'],
            "value2": sensorDataResponse2.data[i]['value']
          };
          $scope.sensorData.push(observation);
        }
        $scope.chartOptions = correlationChartOptions;
      });
    }
  }
  
  function toggleSidenav(name) {
    $mdSidenav(name).toggle();
  }
  
  function selectChart(chart) {
    $scope.selected = angular.isNumber(chart) ? $scope.charts[chart] : chart;
    $scope.toggleSidenav('left');
    loadSensorData();
  }


}])


app.service('DataService', ['$q', '$http', function($q, $http) {
  return {
    loadCharts: function(){
      return $http.get('api/v1/chart');
    },
    loadSensorData: function(key){
      // Pulls data for a given key
      return $http.get('api/v1/data/'+key);
    },
    loadMultipleSensorData: function(key1, key2){
      return $q.all([
        $http.get('api/v1/data/'+key1),
        $http.get('api/v1/data/'+key2)
      ]);
    }
  };
}]);