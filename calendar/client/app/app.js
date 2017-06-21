'use strict';

angular.module('plannerx', [
  'plannerx.constants',
  'ngCookies',
  'ngResource',
  'ngSanitize',
  'btford.socket-io',
  'ui.router',
  'ui.materialize',
  'perfect_scrollbar',
  'LocalStorageModule',
  'angularModalService'
  ])
.config(function($urlRouterProvider, $locationProvider,localStorageServiceProvider) {
  $urlRouterProvider
  .otherwise('/calendar');

  $locationProvider.html5Mode(true);
  localStorageServiceProvider.setPrefix('plannerx').setNotify(true, true);
});
