<rn:meta title="#rn:msg:SHP_TITLE_HDG#" template="service_status_query.php" clickstream="home"/>

<div id="rn_ServiceStatusPageContent" class="servcie_status_main_section">
    <!-- Network Outage Template Import start here! -->
    <form action='/cc/ajaxServiceStatus/ajaxQueryServiceStatuses' id="importNOTemplate">
        <textarea cols="140" rows="5" name="noTemplate"></textarea>

        <input type="submit" value="import" />
    </form>

    <!-- the result of the search will be rendered inside this div -->
    <div id="result"></div>

    <script type="text/javascript">

        $(function() {
            console.log("ready event handler 2 called");
            /* attach a submit handler to the form */
            $("#importNOTemplate").submit(function(event) {
                /* stop form from submitting normally */
                event.preventDefault();

                /* get some values from elements on the page: */
                var $form = $( this ),
                        nwkOtgTemplate  = $form.find( 'textarea[name="noTemplate"]' ).val(),
                        url = $form.attr( 'action' );

                $.ajax({
                    type: "POST",
                    url: url,
                    data: {networkJSONTemplate: nwkOtgTemplate},
                    dataType: "json",
                    success: function (data) {
                        var data1 = JSON.stringify(data);
                        console.log("data = " + JSON.stringify(data1));
                        $("#result").empty().html(data1);
                    }
                });

                return false;

            });
        });

    </script>

     <!--  Network Outage Template Import start ends -->

</div>