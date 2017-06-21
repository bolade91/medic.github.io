'use strict';

angular.module('plannerx')
.config(function($stateProvider) {
	$stateProvider
	.state('main', {
		url: '/calendar',
		templateUrl: 'app/main/main.html',
		controller: 'MainController',
		controllerAs: 'main'
	});
});
