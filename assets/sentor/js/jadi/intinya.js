/**
 * Number.prototype.nomornya(n, x, s, c)
 * 
 * @param integer n: length of decimal
 * @param integer x: length of whole part
 * @param mixed   s: sections delimiter
 * @param mixed   c: decimal delimiter
	12345678.9.nomornya(2, 3, '.', ',');  // "12.345.678,90"
	123456.789.nomornya(4, 4, ' ', ':');  // "12 3456:7890"
	12345678.9.nomornya(0, 3, '-');       // "12-345-679"
 */
Number.prototype.nomornya = function(n, x, s, c) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
        num = this.toFixed(Math.max(0, ~~n));

    return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
};

/*****
* CONFIGURATION
*/function setUpUrl(e){
	e = (e.indexOf("#") > -1) ? e : '#'+e ;
	$(".nav li").removeClass("active");
	$('.nav li:has(a[href="'+e+'"])').addClass("active").parent().show();
	if($('.nav li:has(a[href="'+e+'"])').find("ul").size()!=0){
		$(".opened").removeClass("opened");
		$('.nav a[href="'+e+'"]').parents("li").add(this).each(function(){$(this).addClass("opened")});
		$(".nav li").each(function(){$(this).hasClass("opened")||$(this).find("ul").slideUp()})
	}
	var link = e.split("#"),link = (typeof link[1] !== 'undefined' ) ? link[1] : link[0];
	loadPage(link)
	}
	function loadPage(e){
		$.ajax(
		{	type:"GET",
			url:$.subPagesDirectory+e,
			dataType:"html",
			cache:!1,
			async:!1,
			beforeSend:function(){
				$.mainContent.css({opacity:0.3})
				},
			success:function(data){
				Pace.restart();
				//$("html, body").animate({scrollTop:0},0);
				//$.mainContent.load($.subPagesDirectory+e,null,function(t){window.location.hash=e}).delay(250).animate({opacity:1},750)
				window.location.hash=e;
				$.mainContent.html(data ).delay(250).animate({opacity:1},750);
				},
			error:function(){window.location.href=$.page404}
		});
	}
	function init(){
		$(".panel-minimized").find(".panel-actions i."+$.panelIconOpened).removeClass($.panelIconOpened).addClass($.panelIconClosed);
		$('[rel="tooltip"],[data-rel="tooltip"]').tooltip({placement:"bottom",delay:{show:400,hide:200}});
		$('[rel="popover"],[data-rel="popover"],[data-toggle="popover"]').popover()
	}
	function dropSidebarShadow(){
		if($(".nav-sidebar").length)var e=$(".nav-sidebar").offset().top-$(".sidebar").offset().top;e<60?$(".sidebar-header").addClass("drop-shadow"):$(".sidebar-header").removeClass("drop-shadow");
		var t=$(window).height()-$(".nav-sidebar").outerHeight()-e;t<130?$(".sidebar-footer").addClass("drop-shadow"):$(".sidebar-footer").removeClass("drop-shadow")
	}
	function browser(){
		function i(e){return e in document.documentElement.style}
		var e=!!window.opera&&!!window.opera.version,t=i("MozBoxSizing"),n=Object.prototype.toString.call(window.HTMLElement).indexOf("Constructor")>0,r=!n&&i("WebkitTransform");return e?!1:n||r?!0:!1
	}
	function retina(){retinaMode=window.devicePixelRatio>1;return retinaMode}
	function activeCharts(){
		if($(".boxchart").length)if(retina()){
			$(".boxchart").sparkline("html",{type:"bar",height:"60",barWidth:"8",barSpacing:"2",barColor:"#ffffff",negBarColor:"#eeeeee"});
			if(jQuery.browser.mozilla)if(!navigator.userAgent.match(/Trident\/7\./)){
				$(".boxchart").css("MozTransform","scale(0.5,0.5)").css("height","30px;");
				$(".boxchart").css("height","30px;").css("margin","-15px 15px -15px -5px")
			}else{
				$(".boxchart").css("zoom",.5);
				$(".boxchart").css("height","30px;").css("margin","0px 15px -15px 17px")
			}else $(".boxchart").css("zoom",.5)
		}else $(".boxchart").sparkline("html",{type:"bar",height:"30",barWidth:"4",barSpacing:"1",barColor:"#ffffff",negBarColor:"#eeeeee"});
		
		if($(".linechart").length)if(retina()){
			$(".linechart").sparkline("html",{width:"130",height:"60",lineColor:"#ffffff",fillColor:!1,spotColor:!1,maxSpotColor:!1,minSpotColor:!1,spotRadius:2,lineWidth:2});
			if(jQuery.browser.mozilla)if(!navigator.userAgent.match(/Trident\/7\./)){
				$(".linechart").css("MozTransform","scale(0.5,0.5)").css("height","30px;");
				$(".linechart").css("height","30px;").css("margin","-15px 15px -15px -5px")
				}else{$(".linechart").css("zoom",.5);$(".linechart").css("height","30px;").css("margin","0px 15px -15px 17px")}
			else $(".linechart").css("zoom",.5)
		}else $(".linechart").sparkline("html",{width:"65",height:"30",lineColor:"#ffffff",fillColor:!1,spotColor:!1,maxSpotColor:!1,minSpotColor:!1,spotRadius:2,lineWidth:1});
		
		$(".chart-stat").length&&(retina()?$(".chart-stat > .chart").each(function(){var e=$(this).css("color");$(this).sparkline("html",{width:"180%",height:80,lineColor:e,fillColor:!1,spotColor:!1,maxSpotColor:!1,minSpotColor:!1,spotRadius:2,lineWidth:2});if(jQuery.browser.mozilla)if(!navigator.userAgent.match(/Trident\/7\./)){$(this).css("MozTransform","scale(0.5,0.5)");$(this).css("height","40px;").css("margin","-20px 0px -20px -25%")}else $(this).css("zoom",.5);else $(this).css("zoom",.5)}):$(".chart-stat > .chart").each(function(){var e=$(this).css("color");$(this).sparkline("html",{width:"90%",height:40,lineColor:e,fillColor:!1,spotColor:!1,maxSpotColor:!1,minSpotColor:!1,spotRadius:2,lineWidth:2})}))
	}
	function todoList(){
		$(".todo-list-tasks").sortable({connectWith:".todo-list-tasks",cancel:".disabled"});
		$(".todo-list-tasks").on("change",".custom-checkbox",function(){$(this).parent().parent().clone().appendTo(".completed").hide().slideToggle().addClass("disabled").find(".custom-checkbox").attr("disabled",!0);$(this).parent().parent().slideUp("slow",function(){$(this).remove();$(".todo-list-tasks li").length==0&&$(".todo-list-tasks").html("<!--empty-->")})});
		$(".todo-list").disableSelection();
		$("#add-task").click(function(){$("#todo-1").append('<li><label class="custom-checkbox-item pull-left"><input class="custom-checkbox" type="checkbox"/><span class="custom-checkbox-mark"></span></label><span class="desc">'+$("#task-description").val()+"</span>")})
	}
	function buat_modal(elemen){
		var a = $('#'+elemen);
		if( a.length == 0){
			$('body').prepend('<div id="'+elemen+'" class="modal fade" role="dialog" data-backdrop="static" ><div class="modal-dialog modal-lg" ><div class="modal-content"> <div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button> </div> <div class="modal-body" > </div> <div class="modal-footer"> <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> </div> </div> </div> </div>');
		}
		a=null;
	}
	function startTime(){var e=new Date,t=e.getHours(),n=e.getMinutes(),r=e.getSeconds();n=checkTime(n);r=checkTime(r);document.getElementById("clock").innerHTML=t+":"+n+":"+r;var i=setTimeout(function(){startTime()},500)}
	function checkTime(e){e<10&&(e="0"+e);return e}
	function widthFunctions(e){var t=$(".navbar").outerHeight(),n=$("footer").outerHeight(),r=$(window).height(),i=$(window).width();if(!$("body").hasClass("static-sidebar")){var s=$(".sidebar-header").outerHeight(),o=$(".sidebar-footer").outerHeight();if(i<992)var u=s+o;else var u=t+s+o;$(".sidebar-menu").css("height",r-u)}if(i<992){$("body").hasClass("sidebar-hidden")&&$("body").removeClass("sidebar-hidden").addClass("sidebar-hidden-disabled");$("body").hasClass("sidebar-minified")&&$("body").removeClass("sidebar-minified").addClass("sidebar-minified-disabled");$("#sidebar-minify i").removeClass("fa-list").addClass("fa-ellipsis-v")}else{$("body").hasClass("sidebar-hidden-disabled")&&$("body").removeClass("sidebar-hidden-disabled").addClass("sidebar-hidden");$("body").hasClass("sidebar-minified-disabled")&&$("body").removeClass("sidebar-minified-disabled").addClass("sidebar-minified")}i>768&&$(".main").css("min-height",r-n)}
	
	$.ajaxLoad=!0;
	$.defaultPage="dashboard.html";
	$.subPagesDirectory=helmi.current +"pages/";
	$.page404=helmi.home ;
	$.mainContent=$(".main");
	$.panelIconOpened="icon-arrow-up";
	$.panelIconClosed="icon-arrow-down";
	if($.ajaxLoad){
	  paceOptions={elements:!1,restartOnRequestAfter:!1};
	  url=location.hash.replace(/^#/,"");
	  url!=""?setUpUrl(url):setUpUrl($.defaultPage);
	  $(document).on("click",'.nav a[href!="#"]',function(e){
		
	    if($(this).parent().parent().hasClass("nav-tabs")) /*||$(this).parent().parent().hasClass("nav-pills")*/
		 e.preventDefault();
		else if($(this).attr("target")=="_top"){
		 e.preventDefault();
		 $this=$(e.currentTarget);
		 window.location=$this.attr("href")
		}else if($(this).attr("target")=="_blank"){
		 e.preventDefault();
		 $this=$(e.currentTarget);
		 window.open($this.attr("href"))
		}else{
		 e.preventDefault();
		 var t=$(e.currentTarget);
		 setUpUrl(t.attr("href"))
		 }
	  });
	  $(document).on("click",'a[href="#"]',function(e){e.preventDefault()});
	  $(document).on("click",'a[data-klik]',function(e){
		e.preventDefault(); loadPage($(this).attr('data-klik') );
	  });
	  $(document).on("click",'[data-tombolz]',function(e){
		e.preventDefault();
		switch( $(this).attr('data-tombolz') ){
			case 'msg-notif':
				if(typeof $(this).attr('status') !== 'undefined' )break;
				var aa =$(this); aa.html('<i class="fa fa-warning"></i> '); $(this).attr('status','status');
				$.ajax({
					url:helmi.current+'ajax',data:{controller:'sys-notif',mode:'get-notif'},type:'POST',dataType:'json'
					,beforeSend:function(){
						aa.parent('li.dropdown').find('ul.dropdown-menu').html('<li class="pointer"> <div class="pointer-inner"> <div class="arrow"></div> </div> </li><li class="item "><div style="min-height:70px; text-align:center;margin:50px 0;"><img src="'+helmi.asset+'loading.gif"></div></li>');
					}
					,success:function(a){
						if(a.berhasil){
							var c='<li class="pointer"> <div class="pointer-inner"> <div class="arrow"></div> </div> </li>';
							$.each(a.berhasil,function(k,v){
								if(v.photo.indexOf('.jpgupload') > -1){
									var z = v.photo.split('.jpg');
									v.photo = z[1] + z[0]+'.jpg';
								}
								c += '<li class="item "><a ><img style="width:35px;height:35px; border-radius:10px;" src="'+( (v.photo) ? helmi.asset+v.photo : '' )+'" alt=""/><span class="content"> <span class="content-headline">'+v.nama+'</span> <span class="content-text">Transaksi '+(v.tipe==1 ? '<span class="label label-danger">Pengeluaran</span>':'<span class="label label-success">Pendapatan</span>')+' <br/> nota : '+v.code+'/'+v.tanggal+'</span> </span> <span class="time"><i class="fa fa-clock-o"></i>'+v.n_waktu+'.</span></a></li>';
							});
							c += '<li class="item-footer"> <a href="#" data-klik="list-nota.html" > Semua List Transaksi </a> </li>';
							aa.parent('li.dropdown').find('ul.dropdown-menu').html(c);
						}
					}
				});
				break;
			default : break;
		}
	  });
	}
	
	helmi.notif_run = function(){
		if( $('[data-tombolz="msg-notif"]').is(':visible') ){
				$.ajax({
					url:helmi.current+'ajax',data:{controller:'sys-notif',mode:'check-notif'},type:'POST',dataType:'json'
					,success:function(a){
						if(a.berhasil){
							if(typeof $('[data-tombolz="msg-notif"]').attr('status') !== 'undefined' ){
								$('[data-tombolz="msg-notif"]').removeAttr('status').html('<i class="fa fa-warning"></i><span class="count">'+ a.berhasil +'</span>');
							}
						}
					},complete:function(){
						helmi.notif = setTimeout( helmi.notif_run ,61000);
					}
				});
			}
	};
	if(typeof  helmi.notif !== 'undefined' && helmi.notif ){
		helmi.notif_run();
	}
	
	$(document).ready(function(e){
	   e("body").hasClass("rtl")&&loadCSS(helmi.asset +"sentor/css/bootstrap-rtl.min.css",loadCSS(helmi.asset +"sentor/css/style.rtl.min.css",1,0));
	   e("#clock").length&&startTime();
	   e("ul.nav-sidebar").find("a").each(function(){
	     var t=String(window.location);
		 t.substr(t.length-1)=="#"&&(t=t.slice(0,-1));
		 if(e(e(this))[0].href==t){
		   e(this).parent().addClass("active");
		   e(this).parents("ul").add(this).each(function(){
		     e(this).show().parent().addClass("opened")})
			}
		});
	  e(".nav-sidebar").on("click","a",function(t){
	    e.ajaxLoad&&t.preventDefault();
		if(!e(this).parent().hasClass("hover"))
		 if(e(this).parent().find("ul").size()!=0){
		    e(this).parent().hasClass("opened")?e(this).parent().removeClass("opened"):e(this).parent().addClass("opened");
			e(this).parent().find("ul").first().slideToggle("slow",function(){dropSidebarShadow()});
			e(this).parent().parent().find("ul").each(function(){e(this).parent().hasClass("opened")||e(this).slideUp()});
			e(this).parent().parent().parent().hasClass("opened")||e(".nav a").not(this).parent().find("ul").slideUp("slow",function(){e(this).parent().removeClass("opened").find(".opened").each(function(){e(this).removeClass("opened")})})
		}else e(this).parent().parent().parent().hasClass("opened")||e(".nav a").not(this).parent().find("ul").slideUp("slow",function(){e(this).parent().removeClass("opened").find(".opened").each(function(){e(this).removeClass("opened")})})
	});
	e(".nav-sidebar > li").hover(
	  function(){e("body").hasClass("sidebar-minified")&&e(this).addClass("opened hover")},
	  function(){e("body").hasClass("sidebar-minified")&&e(this).removeClass("opened hover")}
	 );
	e("#main-menu-toggle").click(function(){
	 e("body").hasClass("sidebar-hidden")?e("body").removeClass("sidebar-hidden"):e("body").addClass("sidebar-hidden")}
	);
	e("#sidebar-menu").click(function(){e(".sidebar").trigger("open")});
	e("#sidebar-minify").click(function(){
	  if(e("body").hasClass("sidebar-minified")){
	      e("body").removeClass("sidebar-minified");
		  e("#sidebar-minify i").removeClass("fa-list").addClass("fa-ellipsis-v")
	 }else{
	      e("body").addClass("sidebar-minified");
		  e("#sidebar-minify i").removeClass("fa-ellipsis-v").addClass("fa-list")
	}});
	widthFunctions();
	dropSidebarShadow();
	init();
	e(".sidebar").mmenu();
	e('a[href="#"][data-top!=true]').click(function(e){e.preventDefault()})
	});
	
	/* $(document).ready(function(){
		loadCSS(helmi.asset +"sentor/plugins/gritter/css/jquery.gritter.css");
		loadCSS(helmi.asset +"sentor/plugins/gritter/css/aku-gritter.css");
		function pemberitahuan() {
			$.ajax({
				url: helmi.home +"user/autojs/bz",
				type:'GET', 
				success: function(data){
				 
				},
				timeout: 5000  
			});
			setTimeout(pemberitahuan, 60000);
		}
		setTimeout(pemberitahuan, 60000);
	}); */
	$(document).on("click",".panel-actions a",function(e){e.preventDefault();if($(this).hasClass("btn-close"))$(this).parent().parent().parent().fadeOut();else if($(this).hasClass("btn-minimize")){var t=$(this).parent().parent().next(".panel-body");t.is(":visible")?$("i",$(this)).removeClass($.panelIconOpened).addClass($.panelIconClosed):$("i",$(this)).removeClass($.panelIconClosed).addClass($.panelIconOpened);t.slideToggle("slow",function(){widthFunctions()})}else $(this).hasClass("btn-setting")&&$("#myModal").modal("show")});$(".sidebar-menu").scroll(function(){dropSidebarShadow()});$(window).bind("resize",widthFunctions);