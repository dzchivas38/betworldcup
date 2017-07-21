var routerApp = angular.module('randomNumberApp', ['ui.router']);

routerApp.config(function ($stateProvider, $urlRouterProvider) {

    $urlRouterProvider.otherwise('/home');

    $stateProvider
        .state('home', {
            url: '/home',
            templateUrl: 'template/Content/partial-home.html'
        })
        .state('syntax', {
            url: '/syntax',
            templateUrl: 'template/Content/syntax-list.html'
        });
});