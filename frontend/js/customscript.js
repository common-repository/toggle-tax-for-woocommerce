jQuery(document).ready(function($) {
    var toggleState = Cookies.get('my-toggle-state');
    if(toggleState === undefined){
        var toggleState = (ajax_url.taxdisplay === 'excl') ? 'off' : 'on';
        Cookies.set('my-toggle-state', toggleState);
    }else{
        CookieCheck();
    }

    $('#gt-toggle-button').click(function() {
        $(this).toggleClass('active');
        toggleState = $(this).hasClass('active') ? 'on' : 'off';
        Cookies.set('my-toggle-state', toggleState);
        CookieCheck();
    });

    $(document.body).on('updated_cart_totals', function() {
        if (toggleState === 'on') {
            $('.cart_totals  .tax-rate').show();
            $('.cart_totals  .order-total').show(); 
        }else{
            $('.cart_totals  .tax-rate').hide();
            $('.cart_totals  .order-total').hide(); 
        }
    });

  });

function CookieCheck(){
    toggleState = Cookies.get('my-toggle-state');
    if (toggleState === 'on') {
        jQuery('#gt-toggle-button').addClass('active');
        jQuery('.tax-toggle-prices .price-including-tax').hide();
        jQuery('.tax-toggle-prices .price-excluding-tax').show();
        jQuery('.price-tax-incl').show();
        jQuery('.price-tax-excl').hide();
        jQuery('.cart_totals').find('.tax-rate, .order-total').show();
    } else {
        jQuery('#gt-toggle-button').removeClass('active');
        jQuery('.tax-toggle-prices .price-including-tax').show();
        jQuery('.tax-toggle-prices .price-excluding-tax').hide();
        jQuery('.price-tax-incl').hide();
        jQuery('.price-tax-excl').show();
        jQuery('.cart_totals').find('.tax-rate, .order-total').hide();
    }
}

