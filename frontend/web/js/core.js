/* Logo Color Changes */


/*Loader*/
if ((".loader").length) {
	// show Preloader until the website ist loaded
	$(window).on('load', function () {
	$(".loader").fadeOut("slow");
	});
}
	
/* Stat Section*/

$(document).ready(function(){

    var li = [$('#project-stat'), $('#pipline-stat'), $('#hour-stat'), $('#coffee-stat')];

    
    var waypoint = new Waypoint({
      element: document.getElementById('stat-sec'),
      handler: function(down) {

        $.each(li, function(k, val) {

      var value = val.attr('data-nums');
      var options = {};
      options['toValue'] = value;
      options['duration'] = 5000;
      val.numerator( options );

    });
        
      },
      offset:'80%'
    });

  });

/* App Screen Slider */

var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        effect: 'coverflow',
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: 'auto',
        coverflow: {
            rotate: 50,
            stretch: 0,
            depth: 100,
            modifier: 1,
            slideShadows : true
        }
    });

/* Onpage linkng smooth effect */

$('a[href^="#"]').on('click', function(event) {

    var target = $( $(this).attr('href') );

    if( target.length ) {
        event.preventDefault();
        $('html, body').animate({
            scrollTop: target.offset().top
        }, 1000);
    }

});