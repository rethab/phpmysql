function TaskListCtrl($scope, Task) {
        $scope.tasks = Task.all();
        $scope.orderProp = 'when';

        $scope.add = function() {
                console.log($scope.task);
                Task.save($scope.task);
        }

        $scope.isAddDisabled = function() {
                return $scope.newtask.$invalid;
        };
}
