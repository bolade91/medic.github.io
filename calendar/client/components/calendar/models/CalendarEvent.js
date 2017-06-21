
"use strict";

angular.module('plannerx').factory('CalendarEvent', function($resource){
  //return $resource('/api/events', { id: '@id' });
  return $resource('/api/events/:id', null, {'update': { method:'PUT' } });
});

