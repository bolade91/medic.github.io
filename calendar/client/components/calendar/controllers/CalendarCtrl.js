'use strict';

angular.module('plannerx').controller('CalendarCtrl', function($scope, $log, $timeout, localStorageService) {

	$scope.userInfo = {}
	$scope.$watch("events", function(newValue, oldValue) {
		if ($scope.events && $scope.events.length) {
			Init();
			$scope.events.forEach(function(element) {
				element.hour = parseFloat(element.hour);
			}, this);
		} else {
			Init();
		}
	}, true);

	function weeksInYear(year) {
		return Math.max(
			moment(new Date(year, 11, 31)).isoWeek(), moment(new Date(year, 11, 31 - 7)).isoWeek()
			);
	}

	$scope.newEvent = {};
	$scope.isFruit = false;
	$scope.isAddon=false;
	$scope.IsInit = true;
	$scope.isEventSelect = false;

	
	$scope.specifications = [{
		name: "Client call",
		color: "#FFC107",
		checked: false
	}, {
		name: "Doctor Appointment",
		color: "#FF5722",
		checked: false
	}, {
		name: "Birthday Party",
		color: "#03A9F4",
		checked: false
	}, {
		name: "Meeting with Team",
		color: "#9E9E9E",
		checked: false
	}];

	function Init() {
		$scope.additionalEvents = {
			"Client call": 0,
			"Doctor Appointment": 0,
			"Birthday Party": 0,
			"Meeting with Team": 0
		};
		$("#calendar").fullCalendar('refetchEvents');
	}

$scope.newObject = {};
$scope.disable = {};

	//Only one checkbox should be selected
	$scope.checkBoxSelection = function(position, entities) {
		//$scope.objSelected.fruitOption = first($scope.options2)
		angular.forEach(entities, function(spec, index) {
			if (position != index) {
				spec.checked = false;
			} else {
				$scope.newEvent.title = spec.name;
				$scope.newEvent.eventBackgroundColor = spec.color;
				$scope.newEvent.className = spec.color;
				$scope.isEventSelect = spec.checked;

				if (spec.checked) {

					$("div[event-id=" + $scope.newEvent._id + "]").find('.fc-event-inner').css("background-color", spec.color);
					$("div[event-id=" + $scope.newEvent._id + "]").find('.ui-resizable-handle').siblings().css("background-color", spec.color);
					$("div[event-id=" + $scope.newEvent._id + "]").find('.ui-resizable-handle').siblings().children('.fc-event-title').html(spec.name);

					$('.new-event').find('.fc-event-inner').css("background-color", spec.color);
					$('.new-event').find('.ui-resizable-handle').siblings().css("background-color", spec.color);
					$('.new-event').find('.ui-resizable-handle').siblings().children('.fc-event-title').html(spec.name);

				} else {
					$('.new-event').find('.fc-event-inner').css("background-color", "#ec5e2f");
					$('.new-event').find('.fc-event-inner').children('.fc-event-title').html('');
				}
			}
		});
	}

	$scope.checkOpacity = function(currentChecked) {
		var isChecked = false;
		angular.forEach($scope.specifications, function(spec, index) {
			if (spec.checked) {
				isChecked = true;
			}
		});
		return isChecked ? currentChecked !== isChecked : isChecked;
	}

	$scope.addEvent = function() {
		console.log($scope.objSelected);
		var newEventDefaults = {
			title: "Client call",
			description: "",
			className: "",
			icon: "",
			eventBackgroundColor: "#ccbfed",
			allDay: false
		};

		$scope.newEvent = angular.extend(newEventDefaults, $scope.newEvent);



		//check logic for midnight
		var checkMidnight = moment($scope.newEvent.end).format("HH:mm");
		if(checkMidnight === "23:59")
		{
			$scope.newEvent.end = moment($scope.newEvent.end).format("YYYY-MM-DD").toString() + ' ' + "00:00:00";
		}
		var diff = Math.abs(new Date($scope.newEvent.start) - new Date($scope.newEvent.end));
		var minutes = Math.floor((diff / 1000) / 60);

		var result = null;
		var currentDate = moment($scope.newEvent.start).format("YYYY-MM-DD");
		var startTime = moment($scope.newEvent.start).format("HH:mm");
		var endTime = moment($scope.newEvent.end).format("HH:mm");
		
		$scope.newEvent.start = currentDate.toString() + ' ' + startTime.toString();
		$scope.newEvent.end = moment($scope.newEvent.end).format("YYYY-MM-DD").toString() + ' ' + endTime.toString();

		delete $scope.newEvent.source;
		if ($scope.newEvent._id && $scope.newEvent._id == -1) {
			delete $scope.newEvent._id;
		}
		//$('#calendar').fullCalendar('removeEvents', "_fc1");

		if ($scope.newEvent.className == "new-event") {
			return;
		}

		if ($scope.newEvent._id) {

			$scope.events = localStorageService.get('data');
			var updateObj = _.find($scope.events, {
				_id: $scope.newEvent._id
			});
			updateObj = angular.extend($scope.newEvent)
			$scope.events = _.without($scope.events, _.findWhere($scope.events, {
				_id: $scope.newEvent._id
			}));
			$scope.events.push(updateObj)
			localStorageService.remove('data');
			localStorageService.set('data', $scope.events);
			Materialize.toast('Event updated.', 2000, '', function() {});
			reset();
		} else {
			$scope.newEvent._id = localStorageService.get('id') + 1
			$scope.events = localStorageService.get('data');
			$scope.events.push($scope.newEvent)
			localStorageService.remove('data');
			localStorageService.set('data', $scope.events);
			localStorageService.set('id', $scope.newEvent._id);
			Materialize.toast('Event added.', 2000, '', function() {});
			reset();
		}

		$timeout(function() {
			$('#calendar').fullCalendar('removeEvents');
			$scope.events = localStorageService.get('data');
			$scope.newEvent = {};
			$scope.IsInit = true;
		});
	};

	$scope.deleteEvent = function() {
		if (!$scope.newEvent._id) return;

		$scope.events = localStorageService.get('data');
		$scope.events = _.without($scope.events, _.findWhere($scope.events, {
			_id: $scope.newEvent._id
		}));

		localStorageService.remove('data');
		localStorageService.set('data', $scope.events);
		Materialize.toast('Event deleted.', 2000, '', function() {});
		reset();
	}

	function resetOpacityForOtherEvents() {
		var array = $scope.events;
		for (var i in $scope.events) {
			if (array[i]._id) {
				if (array[i].originalColor) {
					array[i].eventBackgroundColor = array[i].originalColor;
					delete array[i].originalColor;
				}
			}
		}
	}

	function reset() {
		$scope.newEvent = {};
		$scope.newObject = {};
		$scope.disable = {};
		$scope.isEventSelect = false;
		$scope.IsInit = true;
		angular.forEach($scope.specifications, function(spec, index) {
			spec.checked = false;
		});
		resetOpacityForOtherEvents();
		Init();
	}
	Init();
});