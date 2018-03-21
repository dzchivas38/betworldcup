(function () {
    'use strict';

    angular
        .module('randomNumberApp')
        .factory('SyntaxSvc', pl);

    pl.$inject = ['$http', '$q'];

    function pl($http, $q) {
        var service = {
            getById: getById,
            getAll:getAll,
        };

        return service;
        function getAll() {
            var url = 'api-get-syntax';
            return getMethodService(url,null);
        }
        function getById(id) {

        }
        function getMethodService(restUrl,data) {
            var dfd = $q.defer();
            $http.get(restUrl, data,
                {
                    headers: {
                        "Accept": "application/json;odata=verbose",
                        "Content-Type": "application/json"
                    },
                })
                .then(function onSuccess(response) {
                    dfd.resolve(_.get(response, "data"));
                })
                .catch(function onError(response) {
                    console.log(response);
                    dfd.resolve(null);
                });
            return dfd.promise;
        }
        function postMethodService(restUrl,data) {
            var dfd = $q.defer();
            $http.post(restUrl, data,
                {
                    headers: {
                        "Accept": "application/json;odata=verbose",
                        "Content-Type": "application/json"
                    },
                })
                .then(function onSuccess(response) {
                    dfd.resolve(_.get(response, "data.d"));
                })
                .catch(function onError(response) {
                    console.log(response);
                    dfd.resolve(null);
                });
            return dfd.promise;
        }
    }
})();