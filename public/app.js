var routerApp = angular.module('randomNumberApp', ['ui.router']);

routerApp.config(function ($stateProvider, $urlRouterProvider) {

    $urlRouterProvider.otherwise('/home');

    $stateProvider
        .state('home', {
            url: '/home',
            templateUrl: 'template/Content/partial-home.html'
        })
        .state('home.list', {
            url: '/list',
            templateUrl: 'template/Content/partial-home-list.html',
            controller: function ($scope) {
                $scope.dogs = ['Bernese', 'Husky', 'Goldendoodle'];
            }
        })
        .state('home.paragraph', {
            url: '/paragraph',
            template: 'I could sure use a drink right now.'
        })
        .state('about', {
            url: '/about',
            views: {
                '': { templateUrl: 'template/Content/partial-about.html' },
                'columnOne@about': { template: 'Look I am a column!' },
                'columnTwo@about': {
                    templateUrl: 'template/Content/table-data.html',
                    controller: 'PlayerListController'
                }
            }

        });
});