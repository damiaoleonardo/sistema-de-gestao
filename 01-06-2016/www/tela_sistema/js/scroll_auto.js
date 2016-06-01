
            ScrollRate = 20;
            function scrollDiv_init() {
                DivElmnt = document.getElementById('tela_right');
                ReachedMaxScroll = false;

                DivElmnt.scrollTop = 0;
                PreviousScrollTop = 0;

                ScrollInterval = setInterval('scrollDiv()', ScrollRate);
            }
            function scrollDiv() {
                if (!ReachedMaxScroll) {
                    DivElmnt.scrollTop = PreviousScrollTop;
                    PreviousScrollTop++;

                    ReachedMaxScroll = DivElmnt.scrollTop >= (DivElmnt.scrollHeight - DivElmnt.offsetHeight);
                } else {
                    ReachedMaxScroll = (DivElmnt.scrollTop == 0) ? false : true;

                    DivElmnt.scrollTop = PreviousScrollTop;
                    PreviousScrollTop--;
                }
            }

            function pauseDiv() {
                clearInterval(ScrollInterval);
            }

            function resumeDiv() {
                PreviousScrollTop = DivElmnt.scrollTop;
                ScrollInterval = setInterval('scrollDiv()', ScrollRate);
            }
 
            jQuery(document).ready(function ($) {
                var options = {$AutoPlay: true};
                var jssor_slider1 = new $JssorSlider$('container', options);
            });



