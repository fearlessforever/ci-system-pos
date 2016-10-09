var __ajax_p=false; var opsi_extra={};
$(document).off('click','[data-tombol]');
$(document).off('submit','#modalnya-bro form');

opsi_extra.ajax =function(){
	return $.ajax({
		url:helmi.current +'ajax',type:'POST',dataType:'json',data:{controller:helmi.controller ,mode:'view'},
		success:function(a){
			if(a.berhasil)opsi_extra.data = a.berhasil;
		}
	});
};
opsi_extra.overview =function(){
	if(typeof opsi_extra.data === 'undefined' || !opsi_extra.data.bulan_ini)return false;
	var b = $('#dash-bulan-ini');
	if(b.length > 0){
		//var a = opsi_extra.data.bulan_ini ;
		var a='',ai='',ah='',as='';
		$.each(opsi_extra.data.bulan_ini ,function(k,v){
			switch(k){
				case 'trans_pendapatan': ai='fa-shopping-cart emerald-bg'; ah='Penjualan'; break;
				case 'trans_pengeluaran': ai='fa-shopping-cart red-bg'; ah='Pembelian'; break;
				case 'pendapatan': ai='fa-money green-bg'; ah='Pemasukan'; break;
				case 'pengeluaran': ai='fa-money yellow-bg'; ah='Pengeluaran'; break;
				default : break;
			}
			v =parseInt(v);
			as = Math.floor( (v / 100) ); as = (as == 0) ? 1 : as ;
			a += '<div class="col-lg-3 col-sm-6 col-xs-12"> <div class="main-box infographic-box"> <i class="fa '+ai+'"></i> <span class="headline">'+ah+'</span> <span class="value"> <span class="timer" data-from="'+( as == 1 ? 1 : (as) )+'" data-to="'+v+'" data-speed="'+as+'" data-refresh-interval="50">   </span> </span> </div> </div>';
		});
		b.html( a );
		$('.infographic-box .value .timer').countTo({});
	}
	
};
opsi_extra.latest =function(){
	if(typeof opsi_extra.data === 'undefined' || !opsi_extra.data.latest)return false;
	var b = $('#dash-latest');
	if(b.length > 0){
		var a='',ai='',ah='',as='';
		$.each(opsi_extra.data.latest ,function(k,v){
			a += '<tr><td><a target="_blank" href="'+helmi.home+'print-nota/'+v.nota+'/'+v.tanggal+'"> '+v.nota+' </a></td><td>'+v.waktu_e+'</td><td>'+(v.tipe == 0 ? '<span class="label label-success">Pendapatan</span>' : '<span class="label label-danger">Pengeluaran</span>')+'</td><td>'+v.total_h+'</td></tr>';
		});
		a = '<table class="table table-hover"><thead><tr><th>Nota</th><th>Waktu</th><th>Transaksi</th><th>Total</th></tr></thead><tbody>'+a+'</tbody></table>';
		b.html( a );
	}
	
};
opsi_extra.info =function(){
	if(typeof opsi_extra.data === 'undefined' || !opsi_extra.data.info)return false;
	var b = $('#dash-info-data');
	if(b.length > 0){
		var a='',ai='',ah='',as='';
		$.each(opsi_extra.data.info ,function(k,v){
			switch(k){
				case 'barang': ai='fa-database'; ah='Barang'; as='facebook'; break;
				case 'supplier':  ai='fa-car'; ah='Supplier'; as='twitter';  break;
				case 'tipe':  ai='fa-building'; ah='Tipe Barang'; as='google';  break;
				default: break;
			}
			a += '<div class="social-box col-md-12 col-sm-4 '+as+'"> <i class="fa '+ai+'"></i> <div class="clearfix"> <span class="social-count">'+v+'</span> <span class="social-action">data</span> </div> <span class="social-name">'+ah+'</span> </div>';
		});
		
		b.html( a );
	}
	
};
opsi_extra.grapik =function(){
	if(typeof opsi_extra.data === 'undefined' || !opsi_extra.data.graph){
		opsi_extra.data.graph =[]; opsi_extra.data.graph.ykey = []; opsi_extra.data.graph.label=[];
	}
	var b = $('#dash-graph-line');
	if(b.length > 0){
		b.html('');
		graphLine = Morris.Line({
			element: 'dash-graph-line',
			data: opsi_extra.data.graph.detail ,
			lineColors: ['#ffffff'],
			xkey: 'periode',
			ykeys: opsi_extra.data.graph.ykey ,
			labels: opsi_extra.data.graph.label,
			pointSize: 3,
			hideHover: 'auto',
			gridTextColor: '#060606',
			gridLineColor: 'rgba(255, 255, 255, 0.3)',
			resize: true
		});
	}
	
};

$(document).ready(function() {
		$.when( opsi_extra.ajax() ).then( function(){ opsi_extra.overview(); opsi_extra.latest(); opsi_extra.info();  setTimeout(opsi_extra.grapik , 5000); } );
		
		/* initialize the external events
		-----------------------------------------------------------------*/
	
		$('#external-events div.external-event').each(function() {
		
			// create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
			// it doesn't need to have a start or end
			var eventObject = {
				title: $.trim($(this).text()) // use the element's text as the event title
			};
			
			// store the Event Object in the DOM element so we can get to it later
			$(this).data('eventObject', eventObject);
			
			// make the event draggable using jQuery UI
			$(this).draggable({
				zIndex: 999,
				revert: true,      // will cause the event to go back to its
				revertDuration: 0  //  original position after the drag
			});
			
		});
	
	
		/* initialize the calendar
		-----------------------------------------------------------------*/
		
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();

		var calendar = $('#calendar').fullCalendar({
			header: {
				left: '',
				center: 'title',
				right: 'prev,next'
			},
			isRTL: $('body').hasClass('rtl'), //rtl support for calendar
			selectable: true,
			selectHelper: true,
			select: function(start, end, allDay) {
				var title = prompt('Event Title:');
				if (title) {
					calendar.fullCalendar('renderEvent',
						{
							title: title,
							start: start,
							end: end,
							allDay: allDay
						},
						true // make the event "stick"
					);
				}
				calendar.fullCalendar('unselect');
			},
			editable: true,
			droppable: true, // this allows things to be dropped onto the calendar !!!
			drop: function(date, allDay) { // this function is called when something is dropped
			
				// retrieve the dropped element's stored Event Object
				var originalEventObject = $(this).data('eventObject');
				
				// we need to copy it, so that multiple events don't have a reference to the same object
				var copiedEventObject = $.extend({}, originalEventObject);
				
				// assign it the date that was reported
				copiedEventObject.start = date;
				copiedEventObject.allDay = allDay;
				
				// copy label class from the event object
				var labelClass = $(this).data('eventclass');
				
				if (labelClass) {
					copiedEventObject.className = labelClass;
				}
				
				// render the event on the calendar
				// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
				$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
				
				// is the "remove after drop" checkbox checked?
				if ($('#drop-remove').is(':checked')) {
					// if so, remove the element from the "Draggable Events" list
					$(this).remove();
				}
				
			},
			buttonText: {
				prev: '<i class="fa fa-chevron-left"></i>',
				next: '<i class="fa fa-chevron-right"></i>'
			},
			events: [
				{
					title: 'All Day Event',
					start: new Date(y, m, 1),
					className: 'label-success'
				},
				{
					title: 'Long Event',
					start: new Date(y, m, d-5),
					end: new Date(y, m, d-2)
				},
				{
					id: 999,
					title: 'Repeating Event',
					start: new Date(y, m, d-3, 16, 0),
					allDay: false,
					className: 'label-danger'
				},
				{
					id: 999,
					title: 'Repeating Event',
					start: new Date(y, m, d+4, 16, 0),
					allDay: false
				},
				{
					title: 'Meeting',
					start: new Date(y, m, d, 10, 30),
					allDay: false,
					className: 'label-info'
				},
				{
					title: 'Lunch',
					start: new Date(y, m, d, 12, 0),
					end: new Date(y, m, d, 14, 0),
					allDay: false,
					className: 'label-success'
				},
				{
					title: 'Birthday Party',
					start: new Date(y, m, d+1, 19, 0),
					end: new Date(y, m, d+1, 22, 30),
					allDay: false,
					className: 'label-info'
				},
				{
					title: 'Click for Google',
					start: new Date(y, m, 28),
					end: new Date(y, m, 29),
					url: 'http://google.com/',
					className: 'label-danger'
				}
			]
		});
		
		
	    //CHARTS
		/* graphLine = Morris.Line({
			element: 'graph-line',
			data: [
				{period: '2014-01-01', iphone: 2666, ipad: null, itouch: 2647},
				{period: '2014-01-02', iphone: 9778, ipad: 2294, itouch: 2441},
				{period: '2014-01-03', iphone: 4912, ipad: 1969, itouch: 2501},
				{period: '2014-01-04', iphone: 3767, ipad: 3597, itouch: 5689},
				{period: '2014-01-05', iphone: 6810, ipad: 1914, itouch: 2293},
				{period: '2014-01-06', iphone: 5670, ipad: 4293, itouch: 1881},
				{period: '2014-01-07', iphone: 4820, ipad: 3795, itouch: 1588},
				{period: '2014-01-08', iphone: 15073, ipad: 5967, itouch: 5175},
				{period: '2014-01-09', iphone: 10687, ipad: 4460, itouch: 2028},
				{period: '2014-01-10', iphone: 8432, ipad: 5713, itouch: 1791}
			],
			lineColors: ['#ffffff'],
			xkey: 'period',
			ykeys: ['iphone', 'ipad', 'itouch'],
			labels: ['iPhone', 'iPad', 'iPod Touch'],
			pointSize: 3,
			hideHover: 'auto',
			gridTextColor: '#ffffff',
			gridLineColor: 'rgba(255, 255, 255, 0.3)',
			resize: true
		}); */
		
		
		
		
	});
	