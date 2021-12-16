<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1"
        >

        <title>ALUCONNECT</title>

        <!-- CSS -->
        <link
            href="{{ mix('css/app.css') }}"
            type="text/css"
            rel="stylesheet"
        />

        <!-- Bootstrap -->
        <link  
            rel="stylesheet"
            href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" 
            integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"
        >

        <!-- owl carousel -->
        <link  
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.css" 
        >


        <!-- General css -->
        <link
            rel="stylesheet"
            href="{{ asset('assets') }}/css/index.css"
        >

    </head>

    <body class="antialiased">
        <div id="app">
        </div>
        <script
            src="{{ mix('js/app.js') }}"
            type="text/javascript"
        ></script>

        <!-- Required Js -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.js"></script>

        <script>
            // Carousel
            $(document).ready(function() {

                $(".owl-carousel").owlCarousel({
                    items : 4,
                    itemsDesktop : [1599,3],
                    itemsDesktopSmall : [979,3],
                    center: true,
                    nav:true,
                    loop:true,
                    responsive: {
                        600: {
                            items: 4
                        }
                    }

                 });

            });

            // text area on home and post

            let textareas = document.querySelectorAll('.txta'),
            hiddenDiv = document.createElement('div'),
            content = null;

            for (let j of textareas) {
                j.classList.add('txtstuff');
            }

            hiddenDiv.classList.add('hiddendiv');
            hiddenDiv.classList.add('txta');

            for(let i of textareas) {
                (function(i) {
                    i.addEventListener('input', function() {
                    i.parentNode.appendChild(hiddenDiv);
                    i.style.resize = 'none';
                    i.style.overflow = 'hidden';
                    content = i.value;
                    // This is for old IE
                    content = content.replace(/\n/g, '<br>');
            
                    hiddenDiv.innerHTML = content + '<br style="line-height: 3px;">';
                    hiddenDiv.style.visibility = 'hidden';
                    hiddenDiv.style.display = 'block';
                    i.style.height = hiddenDiv.offsetHeight + 'px';

                    hiddenDiv.style.visibility = 'visible';
                    hiddenDiv.style.display = 'none';
                });
            })(i);
            }

            // Change like button on click

            function changelike(id,primary,secondary) {
                src=document.getElementById(id).src;
                if (src.match(primary)) {
                    document.getElementById(id).src=secondary;
                } else {
                    document.getElementById(id).src=primary;
                }
            }
        </script>

    </body>

</html>
