(function ($) {
    'use strict';
    ymaps.ready(init);
    function checkNum(str, def) {
        if (!str || str === undefined || isNaN(str)) {
            return def;
        } else {
            return +options['zoom'];
        }
    }
    var options = JSON.parse($('.options').html());
    var placemarks = JSON.parse($('.placemarks').html());
    options['zoom'] = checkNum(options['zoom'], 18);
    var myMap;
    var place = {};
    var pm = [];
    var preset = 'islands#blackStretchyIcon';
    var presetSel = 'islands#redStretchyIcon';
    var nav;
    var places = [];
    placemarks.map(function (mark, i) {
        if (i < options.placemarks_num) {
            places.push({
                coords: [mark.latitude, mark.longitude],
                iconContent: mark.iconContent,
                hintContent: mark.hintContent,
                balloonContentHeader: mark.balloonContentHeader,
                balloonContentBody: mark.balloonContentBody,
                legendContent: mark.legendContent,
            })
        }
    });
    function init() {
        if (document.querySelectorAll('#map').length > 0) {
            var myCollection = new ymaps.GeoObjectCollection(null, {preset: preset});
            myMap = new ymaps.Map("map", {
                center: [options['center_x'], options['center_y']],
                zoom: options['zoom'],
                //controls: ['fullscreenControl']
            });
            myMap.behaviors.disable('scrollZoom');

            myCollection.removeAll();
            places.forEach(function (item, i, arr) {
                pm[i] = new ymaps.Placemark(item.coords, {
                    iconContent: '<b style="font-size:105%;">' + (i + 1) + '.</b>' + item.iconContent,
                    hintContent: item.hintContent,
                    balloonContentHeader: item.balloonContentHeader,
                    balloonContentBody: item.balloonContentBody,

                }, {
                    preset: preset,
                });
                myCollection.add(pm[i]);
                myMap.geoObjects.add(myCollection);
            });
            myMap.geoObjects.add(myCollection);
            var tmp = '';
            var tableL;
            places.forEach(function (item, i, arr) {
                tableL = document.createElement('table');
                tmp += "<tr><td>" + (i + 1) + "</td><td><a href='#' class='mapSelect' data=" + (i + 1) + ">" + item.legendContent + "</a></td></tr>";
            });
            tableL.innerHTML = '<tr><th colspan="2">' + options['title'] + '</th></tr>' + tmp;
            document.querySelector('div.legend').appendChild(tableL);
            nav = document.querySelectorAll('.mapSelect');
            var sel;
            for (var i = 0; i < nav.length; i++) {

                nav[i].addEventListener('click', function (e) {
                    e.preventDefault();
                    sel = e.target.getAttribute('data');
                    myCollection.removeAll();
                    places.forEach(function (item, i, arr) {

                        if (sel == (i + 1)) {
                            pm[i] = new ymaps.Placemark([item.coords[0], item.coords[1]], {
                                iconContent: '<b">' + (i + 1) + '.</b>' + item.iconContent,
                                hintContent: item.hintContent,
                                balloonContentHeader: item.balloonContentHeader,
                                balloonContentBody: item.balloonContentBody,

                            }, {
                                preset: presetSel,
                            });
                        } else {
                            pm[i] = new ymaps.Placemark(item.coords, {
                                iconContent: '<b">' + (i + 1) + '.</b>' + item.iconContent,
                                hintContent: item.hintContent,
                                balloonContentHeader: item.balloonContentHeader,
                                balloonContentBody: item.balloonContentBody,
                            }, {
                                preset: preset,
                            });
                        }
                        myCollection.add(pm[i]);
                    });
                    myMap.panTo([+places[sel - 1].coords[0], +places[sel - 1].coords[1]], {
                        flying: 1
                    });
                    var target = $('#map');
                    myMap.geoObjects.add(myCollection);
                    $('html, body').animate({
                        scrollTop: target.offset().top
                    }, 500);
                    document.querySelector('#map').scrollIntoView();
                });
            }
        }
    }

})(jQuery);
