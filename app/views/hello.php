<!DOCTYPE html>
<html ng-app="Traksuit">
<head>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="bower_components/angular-material/angular-material.css">
    <link rel="stylesheet" href="traksuit.css">
    <link rel="shortcut icon" href="favicon.png" />
    <link rel="apple-touch-icon" href="favicon.png" />
</head>
<body ng-controller="TraksuitController">
    <md-toolbar layout="row" id="header-bar">
        <button ng-click="toggleSidenav('left')" hide-gt-sm class="menuBtn">
            <span class="visuallyhidden">Menu</span>
        </button>
        <h1><img ng-src="img/Traksuit3.png" width="293" height="98"/></h1>
    </md-toolbar>
    <div layout="row" flex class="content-wrapper">
        <md-sidenav layout="column" class="md-sidenav-left md-whiteframe-z2" md-component-id="left" md-is-locked-open="$media('gt-sm')">
            <md-list class="chart-list">
                <md-item ng-repeat="it in charts">
                    <md-item-content>
                            <md-button ng-click="selectChart(it)" ng-class="{'selected' : it === selected }">
                                <img ng-src="{{it[0].iconurl}}" class="face" alt="">
                                <img ng-src="{{it[1].iconurl}}" class="face" alt="">
                                {{it[0].shortname}} / {{it[1].shortname}}
                            </md-button>
                    </md-item-content>
                </md-item>
            </md-list>
        </md-sidenav>
        <div layout="column" flex class="content-wrapper" id="primary-col">
            <md-content layout="column" flex class="md-padding">
                <h2>{{selected[0].name}} vs. {{selected[1].name}}</h2>
                <div class="cell">
                    <linechart data="sensorData" options="chartOptions" mode="" width="" height=""></linechart>
                </div>
            </md-content>
        </div>
    </div>

    <script src="bower_components/angular/angular.js"></script>
    <script src="bower_components/angular-aria/angular-aria.js"></script>
    <script src="bower_components/angular-animate/angular-animate.js"></script>
    <script src="bower_components/hammerjs/hammer.js"></script>
    <script src="bower_components/angular-material/angular-material.js"></script>
    <!--<script src="bower_components/chartjs/Chart.min.js"></script>
    <script src="bower_components/angular-chart.js/angular-chart.js"></script>-->
    <script src="bower_components/d3/d3.min.js"></script>
    <script src="bower_components/n3-line-chart/dist/line-chart.min.js"></script>
    <script src="bower_components/angular-retina/dist/angular-retina.min.js"></script>
    <script src="traksuit.js"></script>

</body>
</html>