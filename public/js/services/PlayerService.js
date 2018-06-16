/**
 * Created by Dev-1 on 21/07/2017.
 */
(function () {
    'use strict';

    angular
        .module('randomNumberApp')
        .factory('PlayerSvc', pl);

    pl.$inject = ['$http', '$q'];

    function pl($http, $q) {
        var service = {
            getById: getById,
            getAll:getAll,
            createPlayer:createPlayer,
            updateCashOutApi:updateCashOutApi,
            getCashOutByPlayerId:getCashOutByPlayerId,
            modalGetCashOutPostId:modalGetCashOutPostId,
            createCashOutApi:createCashOutApi,
            deleteItem:deleteItem,
            updateItem:updateItem,
        };

        return service;
        function getAll() {
            var url = 'api-get-player';
            return getMethodService(url,null);
        }
        function getCashOutByPlayerId(playerId) {
            var url = 'api-get-cash-out-by-pid/' + playerId;
            return getMethodService(url,null);
        }
        function modalGetCashOutPostId(data) {
            var url = 'api-modal-get-cash-out-post-id/';
            return postMethodService(url,data);
        }
        function createCashOutApi(data) {
            var url = 'api-create-cash-out/';
            return postMethodService(url,data);
        }
        function updateCashOutApi(data) {
            var url = 'api-modal-update-cash-out/';
            return postMethodService(url,data);
        }
        function getById(data) {
            var url = "api-get-player-by-id/";
            return postMethodService(url,data)
        }
        function createPlayer(data) {
            var url = 'api-create-player/';
            return postMethodService(url,data);
        }
        function deleteItem(data) {
            var url = 'api-delete-player/';
            return postMethodService(url,data);
        }
        function updateItem(data) {
            var url = 'api-update-player/';
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
                    if (_.get(response,"data.d")){
                        dfd.resolve(_.get(response, "data"));
                    }
                    dfd.resolve(_.get(response, "data"));
                })
                .catch(function onError(response) {
                    console.log(response);
                    dfd.resolve(null);
                });
            return dfd.promise;
        }
    }
})();