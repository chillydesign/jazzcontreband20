// import moment from 'moment';
// // import * as _ from 'underscore';
// import clndr from 'clndr';

(function ($, root, undefined) {

	$(function () {

		'use strict';


		$('#partner_slider').bxSlider({
			minSlides:3,
			maxSlides:3,
			slideWidth:300,
			slideMargin:10,
			auto:!0,
			controls:!1,
			autoControls:!1,
			pager:!1,
			ticker:false,
			pause: 2000
		});

		$('.bxslider').bxSlider({
			auto:!0,
			controls:!1,
			autoControls:!1,
			pager:!1
		});




        french_moment();


		$('.forgottenpassword').on('click', function(){
			$('.loginform').hide();
			$('.lostpasswd').show();
		})

		$('.notforgotten').on('click', function(){
			$('.lostpasswd').hide();
			$('.loginform').show();
		})

		$('.lostpasswd, .loginform').on('click', function(event){
			event.stopPropagation();
		})

		$('a.login').on('click', function(event){
			event.preventDefault();
			$('.loginformcontainer').show();
		})

		$('.loginformcontainer').on('click', function(){
			$(this).hide();
			$('body').css({'height' : 'auto'});
		})



		var $menu_navigation = $('#menu_navigation');
		var $menu_button = $('#menu_button');

		$menu_button.on('click', function(e){
            console.log(e);
			$menu_navigation.toggleClass('show_menu');

		});

		// if press escape key, hide menu
		$(document).on('keydown', function(e){

			if(e.keyCode == 27 ){
				$menu_navigation.removeClass('show_menu');

				$('.search_box').removeClass('visible');
			}

		})



        $(".img_gallery").justifiedGallery({
			 rowHeight : 150,
			 margins: 4,
			 lastRow : 'justify'
		}).on('jg.complete', function () {
			$('a.gallery').featherlightGallery({
				previousIcon: '<',
				nextIcon: '>'
			});

		});




        // MEMBERS MAP
        if (typeof $member_locations != 'undefined') {


            // fix bug where map doesnt render sometimes
            setTimeout( function(){
                var map_theme = [{"featureType":"all","elementType":"all","stylers":[{"hue":"#ff0000"},{"saturation":-100},{"lightness":-30}]},{"featureType":"all","elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"color":"#353535"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#656565"}]},{"featureType":"landscape.natural.terrain","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"lightness":"-31"}]},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"color":"#505050"},{"lightness":"-14"}]},{"featureType":"poi","elementType":"geometry.stroke","stylers":[{"color":"#808080"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#454545"}]},{"featureType":"transit","elementType":"labels","stylers":[{"saturation":100},{"lightness":-40},{"invert_lightness":true},{"gamma":1.5},{"color":"#000000"}]},{"featureType":"transit","elementType":"labels.text.fill","stylers":[{"visibility":"on"}]},{"featureType":"transit","elementType":"labels.text.stroke","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative.country","elementType":"geometry.stroke","stylers":[{"color":"#fcea1d"}]}];

                var map_options = {
                    zoom: 13,
                    mapTypeControl: true,
                    scrollwheel: false,
                    draggable: true,
                    navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    styles: map_theme
                };


                var member_map_container = $('#member_map_container');
                member_map_container.css({
                    width : '100%',
                    //height: 560
                })

                var member_map = new google.maps.Map(member_map_container.get(0), map_options);
                var member_bounds = new google.maps.LatLngBounds();
                var member_infowindow = new google.maps.InfoWindow({content: '...'});
                var member_markers = [];

                for (var  i = 0;  i < $member_locations.length ;i++) {
                    var member_location = $member_locations[i];
                    if (member_location != null  ) {
                        addPointToMap(member_map, member_location, member_bounds, member_infowindow, member_markers);
                    }

                }

                // This is needed to set the zoom after fitbounds,
                google.maps.event.addListener(member_map, 'zoom_changed', function() {
                    if (this.getZoom() > 16 && this.initialZoom == true) {
                        // Change max/min zoom here
                        this.setZoom(16);
                        this.initialZoom = false;
                    }

                });
                member_map.initialZoom = true;
                member_map.fitBounds(member_bounds);

                google.maps.event.trigger(member_map, 'resize');
            }, 1000)

            // if ($member_locations.length == 1) {
            //     var member_location = $member_locations[0];
            //     console.log(member_location.lat, member_location.lng);
            //     member_map.setCenter(new google.maps.LatLng(member_location.lat, member_location.lng));
            // }


        };
        // END OF MAP
        // END OF MAP





        // CLNDR
        // CLNDR
        // CLNDR
        if (typeof calendar_api_url != 'undefined'){



            var $events_container = $('#events_container');
            var $show_all_events = $('#show_all_events');
            var $events_template = $('#events_template').html();




            var $calendar_template = $('#calendar_template').html();
            var $events_calendar = $('#events_calendar');
            var $events_title = $('#events_title');


            $.ajax({
                url: calendar_api_url
            }).done(function( data ) {

                // ORIGINAL SET OF EVENTS
                var events = processEvents(data);
                var original_events = events;

                var compiled =  _.template($events_template);


                displayEvents(events, $events_container, compiled)

                var cal1 = $events_calendar.clndr({
                    template: $calendar_template,
                    forceSixRows: true,
                    events: data,
                    startWithMonth: "2019-10-01",
                    // constraints: {
                    // 		startDate: '2017-12-22',
                    // 		endDate: '2018-01-09'
                    // },
                    multiDayEvents: {
                        singleDay: 'date',
                        endDate: 'endDate',
                        startDate: 'startDate'
                    },
                    clickEvents: {
                        click: function (target) {
                            var target_date = target.date._i;
                            var processed_events = processEvents(original_events, target_date);
                            displayEvents(processed_events, $events_container, compiled);

                            $events_title.html(target_date);

                            $show_all_events.show();
                        }

                    }
                });

                $show_all_events.on('click', function(e){
                    e.preventDefault();
                    displayEvents(original_events, $events_container, compiled);
                    $show_all_events.hide();
                    $events_title.html( $events_title.data('title')   );

                })

            });

        }
        // END OF CLNDR
        // END OF CLNDR
        // END OF CLNDR



	});

})(jQuery, this);


function addPointToMap(map,  location, bounds, infowindow, markers ) {
	var latitude = location.lat;
	var longitude = location.lng;

	if ( typeof latitude != 'undefined'  && typeof longitude != 'undefined'){
		console.log(latitude);


		var customMarker = {
			url: 'https://jazzcontreband.com/wp-content/themes/jazzcontreband18/img/marker.svg',
			size: new google.maps.Size(14, 20),
			origin: new google.maps.Point(0, 0),
		//	anchor: new google.maps.Point(15, 22)
			anchor: new google.maps.Point(0, 0)
		};

		var latlng = new google.maps.LatLng(  latitude , longitude);


		var marker = new google.maps.Marker({
			map: map,
			position: latlng,
			title: location.title,
			url: location.url,
			id: location.id,
			icon: customMarker
		});


		marker.addListener('click', function() {
			infowindow.setContent('<a class="map_link" href="'  + this.url + '">' + this.title + '</a>'  );
			infowindow.open(map, this);
		});

		markers.push(marker);

		bounds.extend(latlng);

	}

};



function french_moment(){
	moment.locale('fr', {
    months : 'janvier_février_mars_avril_mai_juin_juillet_août_septembre_octobre_novembre_décembre'.split('_'),
    monthsShort : 'jan._fév._mar_avr._mai_jun_jul._aoû_sep._oct._nov._déc.'.split('_'),
    monthsParseExact : true,
    weekdays : 'dimanche_lundi_mardi_mercredi_jeudi_vendredi_samedi'.split('_'),
    weekdaysShort : 'dim._lun._mar._mer._jeu._ven._sam.'.split('_'),
    weekdaysMin : 'Di_Lu_Ma_Me_Je_Ve_Sa'.split('_'),
    weekdaysParseExact : true,
    longDateFormat : {
        LT : 'HH:mm',
        LTS : 'HH:mm:ss',
        L : 'DD/MM/YYYY',
        LL : 'D MMMM YYYY',
        LLL : 'D MMMM YYYY HH:mm',
        LLLL : 'dddd D MMMM YYYY HH:mm'
    },
    calendar : {
        sameDay : '[Aujourd’hui à] LT',
        nextDay : '[Demain à] LT',
        nextWeek : 'dddd [à] LT',
        lastDay : '[Hier à] LT',
        lastWeek : 'dddd [dernier à] LT',
        sameElse : 'L'
    },
    relativeTime : {
        future : 'dans %s',
        past : 'il y a %s',
        s : 'quelques secondes',
        m : 'une minute',
        mm : '%d minutes',
        h : 'une heure',
        hh : '%d heures',
        d : 'un jour',
        dd : '%d jours',
        M : 'un mois',
        MM : '%d mois',
        y : 'un an',
        yy : '%d ans'
    },
    dayOfMonthOrdinalParse : /\d{1,2}(er|e)/,
    ordinal : function (number) {
        return number + (number === 1 ? 'er' : 'e');
    },
    meridiemParse : /PD|MD/,
    isPM : function (input) {
        return input.charAt(0) === 'M';
    },
    // In case the meridiem units are not separated around 12, then implement
    // this function (look at locale/id.js for an example).
    // meridiemHour : function (hour, meridiem) {
    //     return /* 0-23 hour, given meridiem token and hour 1-12 */ ;
    // },
    meridiem : function (hours, minutes, isLower) {
        return hours < 12 ? 'PD' : 'MD';
    },
    week : {
        dow : 1, // Monday is the first day of the week.
        doy : 4  // The week that contains Jan 4th is the first week of the year.
    }
});
}





function displayEvents(events, events_container, compiled){


	var $s_events =  processEvents(events);

	events_container.html(  compiled({ events:   $s_events  })  );


	jQuery('#back_to_top').on('click', function(e){
		e.preventDefault();
		jQuery("html, body").animate({ scrollTop: 0 }, 500);
	});


}


function processEvents(events, date){

		if (date && date != '' ){
			var events = _.filter(  events ,  function(e) {

				if ( Array.isArray(e.date)) {
					 return  e.date.indexOf( date ) > -1  ;
				} else {
					return  e.date == date ;
				}
			});
		}


	var sorted_events = _.sortBy(events, function(e) { return e.searchDate; });
	var events_array =  _.toArray(sorted_events) ;


	var $prev_date = false;
		// PROCESS ARRAY
		for (var i = 0; i < events_array.length ; i++) {
			var event = events_array[i];

				if (typeof event['startDate'] != 'undefined' ) {
					event['nice_date']   =   moment(event['startDate']).format("dddd D ") + ' - ' + moment(event['endDate']).format("dddd D MMMM ");
				} else {
					event['nice_date']   = moment(event['date']).format("dddd D MMMM ");
				}

				if(event['nice_date'] != $prev_date) {
					$prev_date = event['nice_date'];
					event['date_title'] =  event['nice_date'];
				} else {
					event['date_title'] = false;
				}

if(!event['thumbnail']){
	event['thumbnail'] = "https://jazzcontreband.com/wp-content/themes/jazzcontreband/img/placeholder.jpg";
}

		};

	return events_array;
}
