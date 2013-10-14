'use strict';

angular.module('tasklist', [
        'tasklist.services'
]);

angular.module('tasklist.services', ['ngResource'])
        .factory('Task', function($resource) {
                return $resource('tasks.php', {}, {
                        remove: { method: 'POST' }
                });
        })
        .config(function($routeProvider) {
                $routeProvider.
                        when('/', { controller: ListCtrl,
                                    templateUrl: 'list.html'}).
                        when('/edit/:taskId', { controller: EditCtrl,
                                    templateUrl: 'detail.html'}).
                        when('/new', { controller: CreateCtrl,
                                    templateUrl: 'detail.html'}).
                        otherwise({redirectTo: '/'});
        })
        .directive('confirmationNeeded', function () {
                return {
                        priority: 1,
                        terminal: true,
                        link: function (scope, element, attr) {
                                var msg = attr.confirmationNeeded || "Are you sure?";
                                var clickAction = attr.ngClick;
                                element.bind('click',function () {
                                        if ( window.confirm(msg) ) {
                                                scope.$eval(clickAction)
                                        }
                                });
                        }
                };
        });
;

function CreateCtrl($scope, $timeout, $location, Task) {
        $scope.save = function() {
                var task = new Task();
                task.what = $scope.task.what;
                task.when = $scope.task.when;
                task.$save(function(task) {
                        $timeout(function() { $location.path('/'); });
                });
        }
}

function ListCtrl($scope, Task) {
        $scope.tasks = {};
        $scope.orderProp = 'when';

        Task.query(function(resp) {
                $scope.tasks = resp;
        });

        $scope.remove = function(id) {
                Task.remove({}, {remove: true,
                                 id: id});
        };
}

function EditCtrl($scope, $location, $routeParams, $timeout, Task) {
        var task = Task.get({id: $routeParams.taskId}, function() {
                $scope.task = task;
        });
        $scope.save = function() {
                $scope.task.$save(function(task) {
                        $timeout(function() { $location.path('/'); });
                });
        };
}
