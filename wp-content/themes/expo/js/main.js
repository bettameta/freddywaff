/*
* Main Expo JS
*/

jQuery( document ).ready( function( $ ) {

    // Show and hide posts on home
    // set up some variables for future use
    var container = $( 'body' ),
        trigger   = $( '.post-trigger' ),
        close     = $( '.genericon-close-alt' );

    $( container ).fitVids();

    // set body to top position
    $( container ).scrollTop( 0 );

    // add class to body when trigger is clicked
    $( trigger ).click( function() {
        if ( $( container ).hasClass( 'container-open' ) ) {
            $( container).removeClass( 'container-open' );
        } else {
            $( container).addClass( 'container-open' );
        }
    });

    // Zoom effect for sell media
    $( '.archive .item-inner' ).addClass( 'zoom-effect' );


    // Remove class from body when close is clicked
    $( close ).click( function() {
        if ( $( container ).hasClass( 'container-open' ) ) {
             $( container).removeClass( 'container-open' );
        }
    });

    // Homepage site description design
    $( '.site-description' ).lettering( 'words' );

    // Viewport height for header images
    $(window).resize(function () {
        $( '.has-featured-image .intro' ).height( $(window).height() );
    });
    $( '.has-header-image .intro' ).height( $(window).height() );

    // Trigger Menu
    $( '#menu-trigger' ).click(function(){
        $( 'body' ).toggleClass( 'menu-open' );
        if ( ! $( '#overlay' ).length ) {
            $( '#masthead' ).append( '<div id="overlay" class="post-overlay"></div>' );
        }

        // hide scrollbar (fix double scrollbars when menu is open)
        if( $( 'body' ).hasClass( 'menu-open') ) {
            $( 'html, body' ).css({ 'overflow':'hidden' });
        } else {
            $( 'html, body' ).css({ 'overflow':'auto' });
            $( '#overlay' ).remove();
        }
    });

    // Smooth Horizontal Scroll with Mouse
    this.$container = $('.items-wrap');
    var self = this;
    this.$container.on('mousewheel', function(event) {
        self.$container.scrollLeft( self.$container.scrollLeft() - ( event.deltaY * event.deltaFactor ) );
    });

    // Smooth Anchor Link Scroll
    $('a[href*=#]:not([href=#])').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
            if (target.length) {
                $('html,body').animate({
                  scrollTop: target.offset().top
                }, 500);
                return false;
            }
        }
    });
});