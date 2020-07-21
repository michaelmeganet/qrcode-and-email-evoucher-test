<!-- jQuery -->
                <script type="text/javascript" src="libs/jquery/jquery.js"></script>
            <!--    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>-->
                <!-- SmartMenus jQuery plugin -->
                <script type="text/javascript" src="libs/jquery/jquery,smartmenus.js"></script>

                <!-- SmartMenus jQuery init -->
                <script type="text/javascript">
                $(function () {
                    $('#main-menu').smartmenus({
                        subMenusSubOffsetX: 1,
                        subMenusSubOffsetY: -8
                    });
                });
                </script>
                <!-- Jquery reload nav menu -->

                <script language=" JavaScript" >

                    function LoadOnce()
                    {
                        window.location.reload();
                    }

                </script>


                <!-- YOU DO NOT NEED THIS - demo page themes switcher -->
                <script type="text/javascript" src="libs/demo-assets/themes-switcher.js"></script>

                <script>
                    $(function () { // DOM Ready (shorthand)

                        window.onpopstate = function (dss) {
                            if (dss.state) {
                                $("#content").html(dss.state.html);
                                document.title = dss.state.pageTitle;
                            }
                        };

                        $('#nav a').click(function (dss) {

                            dss.preventDefault();                // prevent default anchor behavior
                            var URL = $(this).attr('href');    // get page URL
                            $('#page').html('');               // empty old HTML content.
                            // Target URL and get the #content element
                            // and put it into #page of this page
                            $('#page').load(URL + ' #content', function (data) {
                                // Load callback function.
                                // Everything here will be performed once the load is done.
                                // Put here whatever you need.
                                // ...

                                // Also, let's handle history and  browser's AddressBar
                                var $data = $(data),
                                        content = $data.find('#content').html(),
                                        pageTitle = $data.find('h1').text();
                                window.history.pushState({"html": content, "pageTitle": pageTitle}, "", URL);
                            });

                        });
                    });
                </script>




            </body>
        </div>
    </div>
</html>