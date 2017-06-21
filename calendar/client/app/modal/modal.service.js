(function() {
	'use strict';

	angular
	.module('plannerx')
	.factory('modal', modal);

	angular
	.module('plannerx')
	.controller('dialogController', dialogController);

	modal.$inject = ['$http', '$compile', '$rootScope', '$document', '$q', '$controller', '$timeout','$templateRequest'];


	dialogController.$inject = ['$scope', '$injector', '$modalInstance', 'localStorageService'];

	function dialogController($scope, $injector, $modalInstance, localStorageService) {

		this.closeMe = function() {
			$modalInstance.dismiss('cancel');
		}

		//Delete on confirm
		this.delete = function() {
			console.log('callledd');


			localStorageService.clearAll();
			localStorageService.set('data', []);
			localStorageService.set('id', 0);

			localStorageService.set('calname', "");
			localStorageService.set('by', "");
			
			localStorageService.set('levelAsssignment', 1);
			localStorageService.set('monthSettings', 1);

			this.events = [];
			$scope.$parent.$broadcast("clearall", null);
			$modalInstance.dismiss('cancel');

		};


	};

	function modal($http, $compile, $rootScope, $document, $q, $controller, $timeout,$templateRequest) {
		var service = {
			open: open
		};


		function open(options) {
			/// <summary>Opens a modal</summary>
			/// <param name="options" type="Object">
			/// ? title {string} The title of the modal.<br />
			/// ? scope {$scope} The scope to derive from. If not passed, the $rootScope is used<br />
			/// ? params {object} Objects to pass to the controller as $modalInstance.params<br />
			/// ? template {string} The HTML of the view. Overriden by @templateUrl<br />
			/// ? templateUrl {string} The URL of the view. Overrides @template<br />
			/// ? fixedFooter {boolean} TRUE if the modal should have a fixed footer<br />
			/// ? controller {string||array||function} A controller definition<br />
			/// ? controllerAs {string} the controller alias for the controllerAs sintax. Requires @controller
			/// </param>
			/// <param name="options.title" type="String">The title of the window</param>
			/// <returns type="$.when" />

			var deferred = $q.defer();

			getTemplate(options).then(function(modalBaseTemplate) {
				var modalBase = angular.element(modalBaseTemplate);

				var scope = $rootScope.$new(false, options.scope),
				modalInstance = {
					params: options.params || {},
					close: function(result) {
						deferred.resolve(result);
						closeModal(modalBase, scope);
					},
					dismiss: function(reason) {
						deferred.reject(reason);
						closeModal(modalBase, scope);
					}
				};

				scope.$close = modalInstance.close;
				scope.$dismiss = modalInstance.dismiss;

				$compile(modalBase)(scope);

				var openModalOptions = {
					//ready: function () { alert('Ready'); }, // Callback for Modal open
					complete: function() {
						modalInstance.dismiss();
						} // Callback for Modal close
					};

					runController(options, modalInstance, scope);

					modalBase.appendTo('body').openModal(openModalOptions);

				}, function(error) {
					deferred.reject({
						templateError: error
					});
				});

			return deferred.promise;
		}

		function runController(options, modalInstance, scope) {
			/// <param name="option" type="Object"></param>
			console.log(options);
			if (!options.controller) return;

			var controller = $controller(options.controller, {
				$scope: scope,
				$modalInstance: modalInstance
			});

			if (angular.isString(options.controllerAs)) {
				scope[options.controllerAs] = controller;
			}
		}

		// var getTemplate = function(options) {
		// 	var deferred = $q.defer();
		// 	if (options.template) {
		// 		deferred.resolve(options.template);
		// 	} else if (options.templateUrl) {
		// 		$templateRequest(options.templateUrl, true)
		// 		.then(function(template) {
		// 			deferred.resolve(template);
		// 		}, function(error) {
		// 			deferred.reject(error);
		// 		});
		// 	} else {
		// 		deferred.reject("No template or templateUrl has been specified.");
		// 	}
		// 	return deferred.promise;
		// };

		function getTemplate(options) {
			var deferred = $q.defer();

			if (options.templateUrl) {
				$templateRequest(options.templateUrl, true)
				.then(function(template) {
					deferred.resolve(template);
				}, function(error) {
					deferred.reject(error);
				});
			} else {
				deferred.resolve(options.template || '');
			}


			return deferred.promise.then(function(template) {

				var cssClass = options.fixedFooter ? 'modal modal-fixed-footer' : 'modal';
				var html = [];
				html.push('<div class="' + cssClass + '">');
				if (options.title) {
					html.push('<div class="modal-header">');
					html.push(options.title);
					html.push('<a class="grey-text text-darken-2 right" ng-click="$dismiss()">');
					html.push('<i class="mdi-navigation-close" />');
					html.push('</a>');
					html.push('</div>');
				}
				html.push(template);
				html.push('</div>');

				return html.join('');
			});
		}

		function closeModal(modalBase, scope) {
			/// <param name="modalBase" type="jQuery"></param>
			/// <param name="scope" type="$rootScope.$new"></param>

			modalBase.closeModal();

			$timeout(function() {
				scope.$destroy();
				modalBase.remove();
			}, 5000, true);
		}

		return service;
	}
})();