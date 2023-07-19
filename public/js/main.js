$(document).ready(function () {
	 
 	$(".ts-sidebar-menu li").children().each(function () {
 		if ($(this).next().length > 0) {
 			$(this).addClass("parent");
 		};
 	})
 	var menux = $('.ts-sidebar-menu li a.parent');
 	$('<div class="more"><i class="fas fa-angle-down"></i></div>').insertBefore(menux);
 	$('.more').click(function () {
 		$(this).parent('li').toggleClass('open');
 	});
	$('.parent').click(function (e) {
		e.preventDefault();
 		$(this).parent('li').toggleClass('open');
 	});
 	$('.menu-btn').click(function () {
 		$('nav.ts-sidebar').toggleClass('menu-open');
 	});
     
     $('#clist').DataTable({
         searching: true,
         "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Finnish.json"
            }
     });
     $('#loanTable').DataTable({
         searching: true,
         "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Finnish.json"
            }
     });

 });
