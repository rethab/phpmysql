tasklist.factory('Task', function($resource) {
        return $resource('tasks.php', {}, {
                all:  { method: 'GET', isArray: true },
                save: { method: 'PUT' }
        });
});
