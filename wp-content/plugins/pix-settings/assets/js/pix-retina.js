
(function(){

    if( document.cookie.indexOf('device_pixel_ratio') == -1 && 'devicePixelRatio' in window && window.devicePixelRatio == 2 ){
        console.log('retina');
        var date = new Date();
        date.setTime( date.getTime() + 3600000 );

        document.cookie = 'device_pixel_ratio=' + window.devicePixelRatio + ';' +  ' expires=' + date.toUTCString() +'; path=/';
        //if cookies are not blocked, reload the page
        if(document.cookie.indexOf('device_pixel_ratio') != -1) {
            window.location.reload();
        }
    }
})();