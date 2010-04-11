/**
 * Mark-a-Spot marker.js
 *
 * Main Map-Application File
 *
 * Copyright (c) 2010 Holger Kreis
 * http://www.mark-a-spot.org
 *
 *
 * PHP version 5
 * CakePHP version 1.2
 *
 * @copyright  2010 Holger Kreis <holger@markaspot.org>
 * @license    http://www.gnu.org/licenses/agpl-3.0.txt GNU Affero General Public License
 * @link       http://mark-a-spot.org/
 * @version    0.98
 */
var markersArray = [];
var map;
var geocoder;
var newAddress;
var saveUrlAddress;
var saveId; 
var catCond;
var allVotes;
var getMarkerId ="";
var processCond;
var markersidebar = document.getElementById('markersidebar');
var geocoder = new GClientGeocoder();

/*
var conf = {
	masDir		:	'/',
	//masDir : '/markaspot/',
	townString : 'Köln',
	townZip : '50676',
	townStreet : 'Dom',
	townCenter : '50.82968607835879,6.8939208984375', // http://www.getlatlon.com/ << there
	Text : {
		NotCountry : 'This location is not in Germany',
		NotTown	 : 'This address is not in Berlin, Germany',
		NewAdress : 'New position: ',
		NoMarkers : 'No Markers in this Category'

	},
	Infwin:	{
		TabCommon : 'Overview',
		TabDetail :	'Details',
		TabAdmin : 'Administration',
		TabCommonSubject : 'Subject',
		TabCommonCategory :	'Category',
		TabCommonStatus : 'Status',
		TabCommonRating : 'Rating',
		TabCommonDetails : 'View details',
		TabCommonNewDescr : 'Add Marker here',
		TabCommonLinkText : 'Jump to detailed page'
	},
	Sidebar: {
		h3Views : 'Views',
		h3Search : 'Search address',
		SearchLabel : 'Street',
		ViewsLabelCat : 'Category',
		ViewsLabelStatus : 'Status',
		ViewsLabelRatings : 'Rating',
		ViewsList : 'List of Markers',
	},
	Url: {
		controllerActionAdmin : 'admin',
		controllerActionMap : 'karte',
		controllerActionAdd: 'markers/add',
		controllerActionView : 'view',
		controllerActionEdit : 'edit',
		controllerActionStartup : 'startup'
	}

};
*/
var conf = {
    masDir		:	'/',
	//masDir		:	'/markaspot/',
	townString	:	'Köln',
	townZip		:	'50676',
	townStreet	:	'Dom',
	townCenter	:	'50.82968607835879, 6.8939208984375', // http://www.getlatlon.com/ << there
	Text	:	{
		NotCountry :'Dieser Punkt liegt nicht in Deutschland',
		NotTown : 'Dieser Punkt liegt nicht in Köln',
		NewAdress : 'Neue Position'
	},
	Infwin:	{
		TabCommon : 'Allgemein',
		TabDetail : 'Beschreibung',
		TabCommonSubject : 'Neue Position',
		TabCommonCategory : 'Kategorie',
		TabCommonStatus : 'Status',
		TabCommonRating : 'Bewertung',
		TabCommonDetails : 'Details zu diesem Hinweis',
		TabCommonNewDescr : 'Ein neuer Hinweis',
		TabCommonLinkText : 'zu den Details'
	},
	Sidebar: {
		h3Views : 'Anzeige',
		h3Search : 'Suche',
		SearchLabel : 'Straße und Hausnummer',
		ViewsLabelCat : 'Kategorie',
		ViewsLabelStatus : 'Status',
		ViewsLabelRatings : 'Bewertung',
		ViewsList : 'Tabellenansicht',
		TabCommonNewDescr : 'Ein neuer Hinweis',
		TabCommonLinkText : 'zu den Details'
	},
	Url: {
		controllerActionAdmin : 'admin',
		controllerActionMap : 'karte',
		controllerActionAdd : 'add',
		controllerActionView : 'view',
		controllerActionEdit : 'edit',
		controllerActionStartup : 'startup'
	}

};



$(document).ready(function () {

	/**
	 * Split URL and read MarkerID
	 *
	 */
	var urlParts = $.url.attr("path").split("/");
	var lastPart = urlParts.length -1;
	//alert(lastPart);
	if ($.url.attr("path").indexOf(conf.Url.controllerActionView) != -1) {
		
		// view certain marker
		var getMarkerId = urlParts[lastPart];
		$('#map_wrapper_small').append('<div id="map"></div>'); 
		
	} else if ($.url.attr("path").indexOf(conf.masDir + conf.Url.controllerActionAdd) != - 1 
		|| $.url.attr("path").indexOf(conf.masDir + conf.Url.controllerActionStartup) != - 1) {

		// add marker
		var getMarkerId = 9999999;
		$('#map_wrapper_add').append('<div id="map"></div>');
		
	} else if ($.url.attr("path").indexOf(conf.masDir + conf.Url.controllerActionEdit) != - 1 
		|| $.url.attr("path").indexOf(conf.masDir + conf.Url.controllerActionAdmin) != - 1) {

		$('#map_wrapper_add').append('<div id="map"></div>');
		var getMarkerId = urlParts[lastPart];
		
	} else if ($.url.attr("path") == conf.masDir) {
		
		// splashpage view
		var getMarkerId = '';
		$('#map_wrapper_splash').append('<div id="map"></div>');
	} else if ($.url.attr("path").indexOf(conf.masDir + conf.Url.controllerActionMap) != -1) {
				
		// main-application view
		var getMarkerId = '';
		$(window).resize(resizeMap);
		$('#content').addClass("app");
		$('#views').append('<h3>' + conf.Sidebar.h3Views + '</h3><div id="mapMenue"><form id="changeViews"><fieldset></fieldset></form></div>'); 
		$('#search').append('<h3>' + conf.Sidebar.h3Search + '</h3><div id="searchAdress"><form id="MarkersGeofindForm" method="post" action="'+ conf.masDir + 'markers/geofind"><fieldset style="display:none;"><input type="hidden" name="_method" value="POST" /></fieldset><div class="input text"><label for="MarkerStreet">' + conf.Sidebar.SearchLabel + '</label><br/><input name="data[Marker][street]" type="text" maxlength="256" value="" id="MarkerStreet" /> <input type="submit" class="mas-btn ui-state-default" /></div></form></div></div>'); 
	    $('#changeViews>fieldset').append('<div><label for="catColor">' + conf.Sidebar.ViewsLabelCat + '</label><input type="checkbox" checked="checked" id="catColor"/></div>');
		$('#changeViews>fieldset').append('<div><label for="catStatus">' + conf.Sidebar.ViewsLabelStatus + '</label><input type="checkbox" id="catStatus" /></div>');
		$('#changeViews>fieldset').append('<div><label for="catRateCounts">' + conf.Sidebar.ViewsLabelRatings + '</label><input type="checkbox" id="catRateCounts"/></div>');		
		$('#changeViews>fieldset').append('<div class="tabView"><label for="toggletab">' + conf.Sidebar.ViewsList + '</label><input type="checkbox" name="toggletab" id="toggletab"/></div>');
		
		
		$('#tab').hide();
		$('#map_wrapper_xl').append('<div id="map"></div>');
		resizeMap(); 
		$('#descrslist').append('<ul id="markersidebar"></ul>'); 
			
		// View-Logic Sidebar

		 
		$('#toggletab').click(function() {
			//e.preventDefault(); 
			if($(this).attr("checked")) {
				$("#tabAll").fadeIn('slow');
			} else { 
				$("#tabAll").fadeOut('slow');
			}
		}
		);

		$('#catColor').click(function(){
			if($(this).attr("checked")) { 	
				readData(1,getMarkerId);
				$('#catStatus').attr("checked", false);
				$('#catRateCounts').attr("checked", false);	
			} else{
				hideMarkers();
			}
		});

		$('#catStatus').click(function(){
			if($(this).attr("checked")) {
				readData(2,getMarkerId);
				$('#catColor').attr("checked", false);
				$('#catRateCounts').attr("checked", false);	
			} else {
				hideMarkers();
			}
		});

		$('#catRateCounts').click(function(){
			if($(this).attr("checked")) { 	
				readData(3,getMarkerId);
				$('#catStatus').attr("checked", false);	
				$('#catColor').attr("checked", false);
			} else {
			hideMarkers();
			}
		});
	
		$("#sidebar").accordion({ 
			header: "h3",
			active: 0,
			autoHeight: false  
		});

	} /**endif*/
	

	
	
	map = new GMap2(document.getElementById("map"));
	initLatlon = conf.townCenter.split(",");

    map.setCenter(new GLatLng(initLatlon[0],initLatlon[1]), 12);
	var customUI = map.getDefaultUI();
    customUI.maptypes.physical = true;
    map.setUI(customUI);
   
    
    /**Copyright line-break*/
    GEvent.addListener(map, "tilesloaded", function() {
  		$('.gmnoprint').next('div').css('white-space', 'normal');
	}); 


		/**
		 *  search from splashpage?
		 *
		 */
		if ($.url.param("data[Search][q]")){
			showLocation($.url.param("data[Search][q]"));
		}


	/**Sidebar Marker-functions*/

	$('#MarkersGeofindForm').submit(function(e){
	  e.preventDefault();
      showLocation();
 	}); 
	
	$("#catSelect>li").children().click(function(e){
		readData(1, getMarkerId, this.id,processCond);
		return false;
	});
	$("#processcatSelect>li").children().click(function(e){
		readData(1, getMarkerId, catCond, this.id);
		return false;
	});
	 
    $('#disctrictSelect').change(function(){
		latlon=$(this).val();
		districtlatlon = latlon.split(",");
		map.setCenter(new GLatLng(districtlatlon[0],districtlatlon[1]),14);
	});
	/**Sidebar Functions End*/
	
	/*
	 * List Markers via AJAX
	 */
	function loadPiece(href,divName) {     
	    $(divName).load(href, {}, function(){ 
	        var divPaginationLinks = divName+" #pagination a"; 
	        $(divPaginationLinks).click(function() {      
	            var thisHref = $(this).attr("href"); 
	            loadPiece(thisHref,divName); 
	            return false; 
	        }); 
	        var divSortLinks = divName+" #sortUser th a"; 
	        $(divSortLinks).click(function() {      
	            var thisHref = $(this).attr("href"); 
	            loadPiece(thisHref,divName); 
	            return false; 
	        }); 
	        var divChooseCat = divName+" #listCatSelect"; 
	        $(divChooseCat).click(function() {      
	            var thisHref = $(this).val(); 
	            loadPiece(thisHref,divName); 
	            return false; 
	        }); 
	      	var divChooseProcesscat = divName+" #listProcesscatSelect"; 
	        $(divChooseProcesscat).change(function() {
	            var thisHref = $(this).val(); 
	            loadPiece(thisHref,divName); 
	            return false; 
	        }); 
	
	    }); 
	} 
	loadPiece(conf.masDir + 'markers/ajaxlist', '#markerList'); 
	loadPiece(conf.masDir + 'markers/ajaxmylist', '#markerMyList'); 
	
	function readData(getToggle,getMarkerId,catCond,processCond) {
		map.closeInfoWindow();
		if (catCond) {
			//valide IDs der Links in Ids umwandeln
			catCond = catCond.split("_");
			catCond	= catCond[1];
		}
		if (processCond) {
			//valide IDs der Links in Ids umwandeln
			processCond = processCond.split("_");
			processCond	= processCond[1];
		}
		if (getToggle) {
			// wenn nicht initial, sondern nach click radiobox, 
			// leeren des markerArrays	
			$("#markersidebar >*").remove();
			hideMarkers();
			delete markersArray;
			markersArray = new Array();
			points = new Array;
			markerOptions={};
		} else {
			getToggle=1;	
		}
		
		//case add Marker
		if (getMarkerId == 9999999) {
			showLocation(conf.townStreet + ' ' + conf.townString + ' ' + conf.townZip);
			return;
		}
		
		//case other pages exclude login and stuff

		switch (getMarkerId) {
			case "":
				getMarkerId = "";
				break;
			case undefined:
				return false;
				break;
		}

		

		// get data via Ajax
		$.get(conf.masDir + 'markers/ratesum/', function(data){
		 	allVotes = data;
		});

		$.getJSON(conf.masDir + 'markers/json/'+ getMarkerId + '/cat:' + catCond + '/processcat:' + processCond, function(data){
	
    		if (!data) {
    			$("#content").append('<div id="flashMessage" class="flash_success">' + conf.Text.NoMarkers + '</div>');
   			    $('.flash_success').animate({opacity: 1.0}, 2000).fadeOut();  
    			return;
    		}
    		$.each(data, function(i, item){
    			var markers = i;
				var id 				= item.Marker.id;
				if (item.Attachment[0]) {
					var imagePath 		= item.Attachment[0].dirname;
					var imageBasename 	= item.Attachment[0].basename;
					if(imageBasename) {
						var imageName			= imageBasename.split('.');
					}
					var imageId 		= item.Attachment[0].id;
					var imageAlt 		= item.Attachment[0].alternative;
				}	
				var votes 			= item.Marker.votes;
				var label_color		= "#000000";
				if (item.Marker.rating <= 2) {
					var rate_color 	= "#cccccc";
				} 
				if (item.Marker.rating >= 2) {
					var rate_color 	= "#cccc99";
				}
				if (item.Marker.rating >= 3) {
					var rate_color 	= "#ffff33";
				}
				if (item.Marker.rating >= 3.5) {
					var rate_color 	= "#ffcc33";
				}
				if (item.Marker.rating >= 4) {
					var rate_color 	= "#ff6600";
				}
				if (item.Marker.rating >= 4.5) {
					var rate_color 	= "#b7090a";
					var label_color = "#ffffff";
				}
				if (imageId) {
					var htmlImg = '<span class="thumb"><a title="' + conf.Infwin.TabCommonLinkText + '" href="' + conf.masDir + 'markers/view/'+ id +'"><img src="/media/filter/s/'+ imagePath + '/' + imageName[0] +'.png" alt="'+ imageAlt +'" style="width:100px; float:right; border: 1px solid #ddd; padding: 2px;"/></a></span>';
				} else { 
					var htmlImg = '';
				}
				var html1 = '<span class="infomarker"><div class="marker_subject"><h3>' + item.Marker.subject + "</h3></div>";
				var html2 = htmlImg + '<h4>' +conf.Infwin.TabCommonCategory + '</h4>' + '<div class="marker_kat">' + item.Cat.Name + '</div>';
				var html3 = '<h4>' + conf.Infwin.TabCommonStatus + '</h4><div class="color_' + item.Processcat.Hex + '">' + item.Processcat.Name +"</div>";
				var html4 = '<h4>' + conf.Infwin.TabCommonRating + '</h4><div id="rates"></div><h4>' + conf.Infwin.TabCommonDetails + '</h4><div><a class="" href="' + conf.masDir + 'markers/view/'+ id + '">' + conf.Infwin.TabCommonLinkText + '</a></span>';
				var latlon = new GLatLng(item.Marker.lat,item.Marker.lon);
				points.push(latlon);
				if (getToggle == 1) {
					/**
					 * Category view
					 *
					 */
					var newIcon1 = MapIconMaker.createMarkerIcon({width: 32, height: 32, primaryColor: item.Cat.Hex });
					var markerOptions = {draggable:true, icon:newIcon1}; 
				}
				if (getToggle == 2 || processCond) {
					/**
					 * Process view
					 *
					 */
					var newIcon2 = MapIconMaker.createMarkerIcon({width: 32, height: 32, primaryColor: item.Processcat.Hex });
					var markerOptions = {draggable:true,icon:newIcon2}; 
				}
				if (getToggle == 3){	
					/**
					 * Ratings view
					 *
					 */
		
					var percent = allVotes/30*votes;
					//alert(percent);
					var iconOptions = {};
					iconOptions.width = parseInt(percent/2+35);
					iconOptions.height = parseInt(percent/2+35);
					iconOptions.primaryColor = rate_color;
					iconOptions.label = votes;
					iconOptions.labelSize = parseInt(percent/4+20);;
					iconOptions.labelColor = label_color;
					iconOptions.shape = "circle";
					var newIcon3 = MapIconMaker.createFlatIcon(iconOptions);
					var markerOptions = {text:"Zieh mich!", draggable:true, icon:newIcon3}; 
				}
							
				
				var marker= new GMarker(latlon, markerOptions);
				var fn  = markerClickFn(markers[item], html1, html2, html3, html4, item.Marker.descr, latlon,id);
				var fn1 = markerDragFn(markers[item], html1, html2, id);

				
				if (!getMarkerId) {
					GEvent.addListener(marker, "click", fn);
					GEvent.addListener(marker, 'dragend', fn1);
				}
				
				if ($("#markersidebar")){
					var li = document.createElement('li');
					var html = "<a>"+ item.Marker.subject +"</a>";
					li.innerHTML = html;
					li.style.cursor = 'pointer';
					$("#markersidebar").append(li);
					GEvent.addDomListener(li, "click", fn);
				}
				markersArray.push(marker);
				map.addOverlay(marker);
				
				/**
				 * set Position of Map depending on Map Modus (one or more markers)
				 *
				 */
				if (getMarkerId) {	
					map.setCenter(latlon, 15);
					GEvent.addListener(marker, 'dragend', fn1);
				} else {
					var bounds = new GLatLngBounds();
					//alert(points.length);
					for (var i=0; i< points.length; i++) {
						bounds.extend(points[i]);
					}
					map.setZoom(map.getBoundsZoomLevel(bounds));
					if(!points) {
						alert('keine Marker');
					} else if(!$.url.param("data[Search][q]")) { 
						map.setCenter(bounds.getCenter());
					}
				}
			}); // $.each
		});	// AJAX 
	};
	

	/**
	 * Call view
	 *
	 */
	readData(1,getMarkerId,catCond,processCond);
		




	/**
	 * all other functions following 
	 *
	 */	
	function markerClickFn(marker, html1, html2, html3, html4, descr,latlon,id) {
		return function() {
			map.panTo(latlon); 				
			var url = conf.masDir + 'markers/maprate?id=' + id;		
			var htmlmarker = [];
			htmlmarker.push(new GInfoWindowTab(conf.Infwin.TabCommon, '<div class="inf"' + html1 + html2 + html3 + html4 + '</div>'));
			//htmlmarker.push(new GInfoWindowTab(conf.Infwin.TabDetail, '<div class="inf"><h4>'+ conf.Infwin.TabCommonDetails + '</h4>'+descr+'</div>'));
			map.openInfoWindowTabs(latlon, htmlmarker);
			//hol das rating
			 $.get(url, function(data){
	 			$('#rates').append(data);
			});	
		};
	};


	
	function hideMarkers(){
		for (i = 0; i < markersArray.length; i++) {
			markersArray[i].hide();
		}
		return;
	};
	
	
	function markerDragFn(marker, html1, html2, id) {
		return function() {
			newlatlng = this.getLatLng();
			map.panTo(newlatlng); 	
			var url = conf.masDir + 'markers/maprate?id=' + id;	
			var htmlmarker = [];
			htmlmarker.push(new GInfoWindowTab(conf.Infwin.TabCommon, '<div class="inf"' + html1 + html2 + '</div>'));	
			if ($.cookie('CakeCookie[admin]')) {	
				htmlmarker.push(new GInfoWindowTab(conf.Infwin.TabAdmin, '<div><h4>' + conf.Text.NewAdress + '</h4><div id="newPos"></div></div>'));
			}
			// Write new Position to DB
			saveId=id;
			geocoder.getLocations(newlatlng, saveAddress);
			map.openInfoWindowTabs(newlatlng, htmlmarker, {selectedTab:1});
		};
	};

	function markerDragFnAdd(marker, address) {
		return function() { 
			map.closeInfoWindow();
			newlatlng = this.getLatLng();
			map.panTo(newlatlng);
			html = "<h4>'+ conf.Text.NewAdress +'</h4>"+ '<div id="newPos"></div>';
			geocoder.getLocations(newlatlng, saveAddress);	
		};
	};


	function saveAddress(response) {
		if (!response || response.Status.code != 200) {
			alert("Status Code:" + response.Status.code);
		} else {
			place = response.Placemark[0];
			point = new GLatLng(place.Point.coordinates[1],place.Point.coordinates[0]);
			newAddress = place.address;
			var addressArray = place.address.split(",");
			var townArray	 = addressArray[1].split(" ");
			$('#MarkerStreet').val(addressArray[0]);
			$('#MarkerZip').val(townArray[1]);
			
			if (place.AddressDetails.Country.CountryNameCode != "DE") {
				alert(conf.Text.NotCountry);
				return;
			}
			if (place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.LocalityName != conf.townString) {
				alert(conf.Text.NotTown);
				showLocation(conf.townStreet + ' ' + conf.townString + ' ' + conf.townZip);
				$('#MarkerStreet').val("");
				$('#MarkerZip').val("");
			}
			
			saveUrlAddress = newlatlng.lat() + "/" + newlatlng.lng() + "/" + newAddress;
			if ($.cookie('CakeCookie[admin]')){	
				$.get(conf.masDir + 'markers/geosave/' + saveId + '/' + saveUrlAddress, function(data){
					$('#newPos').append(conf.Text.NewAdress + newAddress + '<br/><span style="color:green">Position wurde aktualisiert.</span></p>');
				});
			};
		};
	
	};
	
	function addAddressToMap(response) {
		geoCodedZip 	= "";
		geoCodedStreet= "";
		//map.clearOverlays();
		
		if (!response || response.Status.code != 200) {
			alert("Diese Adresse kann nicht gefunden werden");
		} else {
			place = response.Placemark[0];
			point = new GLatLng(place.Point.coordinates[1],place.Point.coordinates[0]);
			var newAddIcon= MapIconMaker.createMarkerIcon({width: 32, height: 32});
			var markerOptions = {text:"Zieh mich!", draggable:true, icon:newAddIcon}; 
			marker = new GMarker(point,markerOptions);
			
			if (place.AddressDetails.Country.CountryNameCode != "DE") {
				alert(conf.Text.NotCountry);
			return;
			}
		
			if (place.address.search(conf.townString) == - 1) {
				alert(place.address);
				alert(conf.Text.NotTown);
				showLocation(conf.townStreet + ' ' + conf.townString + ' ' + conf.townZip);
				$('#MarkerStreet').val("");
				$('#MarkerZip').val("");
			}
			
			var zip = "";
			var addressArray = place.address.split(",");
			var townArray	 = addressArray[1].split(" ");
			
			// Check if Sessionbased AddAdress is not set yet
			if (townArray[1].match(/^[0-9]+$/)){
				var zip = townArray[1];
				$('#MarkerZip').val(townArray[1]);
			}
			
			if ($('#MarkerStreet').val() == "") {
				$('#MarkerStreet').val(addressArray[0]);
			}
			
			map.panTo(point);
			map.addOverlay(marker);
			marker.openInfoWindowHtml('<h4>Position</h4>' + '<div id="newPos">'+ place.address + '</div>' + '<div><a href="' + conf.masDir + 'markers/startup/new/'+ addressArray[0]+'/'+ zip +'">'+ conf.Infwin.TabCommonNewDescr +' </a></div>',{maxWidth:250});
			
			if (getMarkerId == 9999999){
				//map.panTo(point); 				
				marker.openInfoWindowHtml('<h4>Position</h4>' + '<div id="newPos">'+ place.address + '</div>',{maxWidth:250});
			}
			// drag to new position
			var updateAddress = markerDragFnAdd(marker,place.address);
			GEvent.addListener(marker, 'dragend', updateAddress);
		}
		
	};
	
	
	
	function showLocation(address) {
		
		// map.closeInfoWindow();
		// search address from sidebar
	 
		if (!address) {
			var address = $('#MarkerStreet').val() + " " + conf.townString;
		} else {
			// search address from URL
			var address = address + " " + conf.townString;
		}
		geocoder.getLocations(address, addAddressToMap);
	};
	
	function getAddress(newlatlng) {
		if (newlatlng != null) {
			geocoder.getLocations(newlatlng, addAddressToMap);
		}
	};
	
	function resizeMap() {
		var MasHeight = $(window).height(); 
		var MasWidth = $(window).width(); 
		$('#wrapper').css( {height: MasHeight-10, width: MasWidth-80} ); 
		$('#footer_app').css( {height: MasHeight-10, width: MasWidth-80} ); 
		$('#content').css( {height: MasHeight-110, width: MasWidth-330} ); 
		$('#map').css( {height: MasHeight-110, width: MasWidth-330} ); 
		$('#breadcrump > div').css( {height: MasHeight-110, width: MasWidth-330} ); 
		$('#sidebar').css( {height: MasHeight-110} ); 
	};
	
});