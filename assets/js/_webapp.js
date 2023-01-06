const openNav = () => {
	$('.menu_mm').addClass('active');
	$("#_menu_backdrop").toggleClass('menu-backdrop');
}
$(".menu_close").on('click', function(){
	$('.menu_mm').toggleClass('active');
	$("#_menu_backdrop").toggleClass('menu-backdrop');
})
$("#_menu_backdrop").on('click', function(){
	$('.menu_mm').toggleClass('active');
	$(this).toggleClass('menu-backdrop');
})