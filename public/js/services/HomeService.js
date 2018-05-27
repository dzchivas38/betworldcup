/**
 * Created by Dev-1 on 07/08/2017.
 */
(function () {
    'use strict';

    angular
        .module('randomNumberApp')
        .factory('HomeSvc', pl);

    pl.$inject = ['$http', '$q'];

    function pl($http, $q) {
        var service = {
            getResultScheduce:getResultScheduce,
            createKq:createKq,
        };

        return service;
        function getResultScheduce(pubDate) {
            var url = 'api-get-result-resource/' + pubDate;
            return getMethodService(url,null);
        }
        function createKq(data) {
            var url = 'api-insert-item-kq/';
            return postMethodService(url,data);
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
                    if (_.get(data,"d")){
                        dfd.resolve(_.get(response, "data.d"));
                    }else{
                        dfd.resolve(_.get(response, "data"));
                    }
                })
                .catch(function onError(response) {
                    console.log(response);
                    dfd.resolve(null);
                });
            return dfd.promise;
        }
    }
})();