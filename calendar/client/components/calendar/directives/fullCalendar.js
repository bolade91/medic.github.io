"use strict";
angular.module('plannerx').directive('fullCalendar', function ($timeout, localStorageService) {

	var lnk = function (scope, element) {
		var $calendar = $("#calendar");
		var calendar = null;
		scope.isEventClick = false;

		$(document).ready(function () {
			$('select').material_select();
		});

		function RGBA(rgb, alpha) {

			this.rgb = rgb.split(',')
			this.red = this.rgb[0];
			this.green = this.rgb[1];
			this.blue = this.rgb[2];
			this.alpha = alpha;
			this.getCSS = function () {
				return "rgba(" + this.red + "," + this.green + "," + this.blue + "," + this.alpha + ")";
			}
		}

		function hexToRgb(hex) {
			hex = hex.replace("#", '');
			var bigint = parseInt(hex, 16);
			var r = (bigint >> 16) & 255;
			var g = (bigint >> 8) & 255;
			var b = bigint & 255;

			return r + "," + g + "," + b;
		}

		scope.objSelected = {
			fruitOption: '',
			addOnSelectedOption: ''
		};

		scope.resetAll = function () {
			scope.newEvent = {};
			scope.newObject = {};
			scope.disable = {};
			scope.isEventSelect = false;
			scope.isFruit = false;
			scope.isAddon = false;
			scope.IsInit = true;

			angular.forEach(scope.specifications, function (spec, index) {
				spec.checked = false;
			});
			$('#calendar').fullCalendar('removeEvents');
			scope.events = localStorageService.get('data');
			resetOpacityForOtherEvents();
		}

		function resetOpacityForOtherEvents() {
			var array = calendar.fullCalendar('clientEvents');
			for (var i in array) {
				if (array[i]._id) {
					if (array[i].originalColor) {
						array[i].eventBackgroundColor = array[i].originalColor;
						delete array[i].originalColor;
					}
				}
			}
		}


		function setOpacityForOtherEvents(event, opcaity) {
			var array = calendar.fullCalendar('clientEvents');
			for (var i in array) {
				if (array[i]._id != event._id) {
					if (array[i].originalColor) {
						array[i].eventBackgroundColor = array[i].originalColor;
						array[i].originalColor = undefined;
					} else {
						var bgColor = new RGBA(hexToRgb(array[i].eventBackgroundColor), opcaity);
						array[i].originalColor = array[i].eventBackgroundColor;
						array[i].eventBackgroundColor = bgColor.getCSS();
					}
				}
			}
		}

		scope.$on('clearall', function (event, args) {
			scope.resetAll();
			Materialize.toast('All data cleared.', 2000, '', function () { });
		});

		//scope.select = { top: "fruits" };
		var alertOnEventClick = function (date, jsEvent, view) {
			if (!scope.isEventSelect && scope.newEvent._id != -1) {
				calendar.fullCalendar('unselect');
				console.log(date);
				scope.IsInit = false;
				scope.isEventSelect = true;
				setOpacityForOtherEvents(date, 0.5)

				var ele = $(jsEvent.target)
				$(jsEvent.currentTarget).find('.fc-event-bg').after("<div class='ui-resizable-handle ui-resizable-s'></div>");
				$(jsEvent.currentTarget).find('.fc-event-inner').before("<div class='ui-resizable-handle ui-resizable-n'></div>");


				$timeout(function () {
					scope.newEvent = angular.copy(date);
					scope.newEvent.className = date.className.join(' ');


					scope.eve = {
						name: date.title,
						start: moment(date.start).format('MMM, D dddd'),
						from: moment(date.start).format('h:mma'),
						to: moment(date.end || date.start).format('h:mma')
					};

					var endDate = moment(date.end || date.start).format('h:mm')
					if (endDate === "11:59") {
						scope.eve.to = "12:00am"
						scope.newEvent.end = moment(scope.newEvent.end).format("YYYY-MM-DD").toString() + ' ' + "00:00:00";
					}

					angular.forEach(scope.specifications, function (spec, index) {
						if (spec.name == scope.newEvent.title) {
							spec.checked = true;
						}
					});
					calendar.fullCalendar('render');
				});
			}
		};

		function isOverlapping(event) {
			var array = calendar.fullCalendar('clientEvents');
			console.log(array);
			for (var i in array) {
				if (array[i]._id != event._id && event.end != null && array[i].end != null) {
					if (!(moment(array[i].start).format() >= moment(event.end).format() || moment(array[i].end).format() <= moment(event.start).format())) {
						return true;
					}
				}
			}
			return false;
		}



		function initCalendar() {

			calendar = $calendar.fullCalendar({
				lang: 'en',
				editable: true,
				draggable: true,
				selectable: true,
				selectHelper: true,
				unselectAuto: false,
				disableResizing: false,
				droppable: true,
				eventLimit: true, // allow "more" link when too many events
				header: true,
				defaultView: 'agendaWeek',
				allDaySlot: false,
				slotEventOverlap: false,
				//eventStartEditable: true,
				//disableDragging:true,
				contentHeight: '9999',
				columnFormat: 'dddd',
				firstDay: 1,
				eventClick: alertOnEventClick,

				eventAfterRender: function (event, element, view) {
					var width = $(element).width() + 6;
					var height = $(element).height() + 2;
					$(element).css('height', height + 'px');
					$(element).css('width', width + 'px');
					$(element).css('margin', '-2px');
				},
				eventDrop: function (event, dayDelta, minuteDelta, allDay, revertFunc, jsEvent, ui, view) {


					if (event.end && moment(event.start).format('DD') < moment(event.end).format('DD') && moment(event.end).format('hh:mm') != "12:00") {
						revertFunc();
					} else if (scope.isEventSelect && event._id == scope.newEvent._id) {
						//$(jsEvent.target).prepend("<div class='ui-resizable-handle' style='cursor:s-resize'><span></span></div>");
						event.title = scope.newEvent.title;
						event.title = scope.newEvent.title;


						event.eventBackgroundColor = scope.newEvent.eventBackgroundColor;
						event.className = scope.newEvent.className;

						// if (dayDelta != 0) {
						//     revertFunc();
						// }
						// else {
						var start = moment(event.start);
						var end = moment(event.end);
						var overlap = calendar.fullCalendar('clientEvents', function (ev) {
							if (ev == event)
								return false;
							var estart = moment(ev.start);
							var eend = moment(ev.end);
							return estart.unix() < end.unix() && eend.unix() > start.unix();
						});
						if (overlap.length) {
							overlap = overlap[0];
							var estart = moment(overlap.start);
							var eend = moment(overlap.end);
							var duration = eend - estart;
							start = eend.clone();
							end = start.clone();
							end.add(duration);
							event.start = start.toDate();
							event.end = end.toDate();
							calendar.fullCalendar('updateEvent', event);
						}



						//we need timeout to update scope
						$timeout(function () {
							console.dir({
								start: start,
								end: end
							});
							scope.eve = {
								start: moment(start).format('MMM, D dddd'),
								from: moment(start).format('h:mma'),
								to: moment(end || start).format('h:mma')
							};
							scope.newEvent = angular.copy(event);
							scope.newEvent.className = typeof (event.className) === "string" ? event.className : event.className.join(' ');
							console.log(scope.newEvent);
						});


						//}
					}


					if (!scope.isEventSelect) {

						// if (dayDelta != 0) {
						//     revertFunc();
						// }
						// else {
						var start = moment(event.start);
						var end = moment(event.end);
						var overlap = calendar.fullCalendar('clientEvents', function (ev) {
							if (ev == event)
								return false;
							var estart = moment(ev.start);
							var eend = moment(ev.end);
							return estart.unix() < end.unix() && eend.unix() > start.unix();
						});
						if (overlap.length) {
							overlap = overlap[0];
							var estart = moment(overlap.start);
							var eend = moment(overlap.end);
							var duration = eend - estart;
							start = eend.clone();
							end = start.clone();
							end.add(duration);
							event.start = start.toDate();
							event.end = end.toDate();
							calendar.fullCalendar('updateEvent', event);
						}
						console.dir({
							start: start,
							end: end
						});
						scope.newEvent = angular.copy(event);
						scope.newEvent.className = event.className.join(' ');
						if (scope.newEvent._id && scope.newEvent._id != -1) {
							scope.addEvent();
						}
						//}
						//event.model.save({start: start.unix(), end: end.unix()});
					} else {
						if (scope.isEventSelect && event._id != scope.newEvent._id) {
							revertFunc();
						}
					}
				},

				eventResize: function (event, dayDelta, minuteDelta, revertFunc, jsEvent, ui, view) {

					if (moment(event.start).format('DD') < moment(event.end).format('DD') && moment(event.end).format('hh:mm') != "12:00") {
						revertFunc();
					} else if (isOverlapping(event)) {
						revertFunc();
					} else {
						if (event._id == -1) {
							$timeout(function () {
								scope.newEvent._id = event._id; // = angular.copy(event);
								scope.newEvent.start = event.start
								scope.newEvent.end = event.end
								scope.eve = {
									start: moment(scope.newEvent.start).format('MMM, D dddd'),
									from: moment(scope.newEvent.start).format('h:mma'),
									to: moment(scope.newEvent.end || scope.newEvent.start).format('h:mma')
								};
							});
						} else {
							$timeout(function () {
								scope.newEvent.start = event.start
								scope.newEvent.end = event.end
								scope.eve = {
									start: moment(scope.newEvent.start).format('MMM, D dddd'),
									from: moment(scope.newEvent.start).format('h:mma'),
									to: moment(scope.newEvent.end || scope.newEvent.start).format('h:mma')
								};
							});
						}
					}
				},
				timeFormat: 'H(:mm)',
				select: function (start, end, allDay, jsEvent, view) {

					var eventObj = {
						_id: -1,
						start: start,
						end: end
					}

					if (isOverlapping(eventObj)) {
						calendar.fullCalendar('unselect');
					} else if (scope.IsInit) {
						calendar.fullCalendar('renderEvent', {
							_id: -1,
							title: '',
							start: start,
							end: end,
							allDay: allDay,
							className: 'new-event'
						},
							true // make the event "stick"
						);
						calendar.fullCalendar('unselect');
						//view.element.children('div').find('.fc-event-draggable').find('.fc-event-inner').css({ 'background-color': '#b73309' })
						$timeout(function () {
							scope.eve = {
								start: moment(start).format('MMM, D dddd'),
								from: moment(start).format('h:mma'),
								to: moment(end || start).format('h:mma')
							};
							scope.newEvent._id = -1;
							scope.newEvent.start = moment(start) //start,//moment(start).format('DD MMM YYYY hh:mm a');
							scope.newEvent.end = moment(end)
							scope.IsInit = false;

						});
					} else {
						calendar.fullCalendar('unselect');
					}


				},
				//events: scope.events,
				events: function (start, end, callback) {
					callback(scope.events);
				},
				eventRender: function (event, element, icon) {

					if ((!scope.isEventSelect && event.className != "new-event") ||
						(scope.isEventSelect && event.className != "new-event" && scope.newEvent._id != event._id)
					) {
						$(element).find(".fc-event-time").remove();
						$(element).find(".ui-resizable-n").remove();
						$(element).find(".ui-resizable-s").remove();
					}


					if (event._id != -1) {
						if (scope.newEvent._id === undefined || scope.newEvent._id == -1) {
							element.children('.fc-event-inner').css({
								'background-color': event.eventBackgroundColor
							});
							$(element).attr('event-id', event._id);
						} else if (event._id != scope.newEvent._id) {
							$(element).removeClass('fc-event');
							$(element).css({
								'border': '1px solid white',
								'color': '#fff',
								'font-size': '.85em'
							});
							element.children('.fc-event-inner').css({
								'background-color': event.eventBackgroundColor
							});
							$(element).attr('event-id', event._id);

						} else {
							element.children('.fc-event-inner').css({
								'background-color': scope.newEvent.eventBackgroundColor
							});
							element.children('.fc-event-inner').find('.fc-event-title').html(scope.newEvent.title);
							$(element).attr('event-id', scope.newEvent._id);
						}
					} else {
						element.children('.fc-event-inner').css({
							'background-color': scope.newEvent.eventBackgroundColor
						});
						element.children('.fc-event-inner').find('.fc-event-title').html(scope.newEvent.title);
						$(element).attr('event-id', scope.newEvent._id);
					}
				}
			});
		}


		initCalendar();
	};

	return {
		restrict: 'E',
		replace: true,
		templateUrl: 'components/calendar/views/full-calendar.tpl.html',
		scope: {
			events: "=events"
		},
		controller: 'CalendarCtrl',
		link: lnk
	};
});