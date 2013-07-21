<rn:meta title="#rn:msg:SHP_TITLE_HDG#" template="service_status_query.php" clickstream="home"/>

<div id="rn_PageContent123" class="rn_Home">
    <!-- Service Status pages start here! -->

    <div class="service_status_details_content">

        <!-- details_panel starts -->
        <div class="details_section" style="display:none">
            <h3>{Suburb}, {State}}</h3>
            <p>
                {updated time}
            </p>

            <p>Optus Network Ref</p>
            <p>{serviceId}</p>

            <div class="commencement_time_panel">
                {commencement_time_panel}
            </div>

            <div class="service_affected_panel">
                {Service affected}
            </div>

            <div class="outage_type_panel">
                {outage_type_panel}
            </div>

            <div class="description_panel">
                {description_panel}
            </div>

            <div class="resolution_panel">
                {resolution_panel}
            </div>

            <div class="restoration_time_panel">
                {restoration_time_panel}
            </div>

            <div class="back_link_panel">
                <a href="#">&lt;&nbsp;Back</a>
            </div>

        </div>
        <!-- details_panel ends -->

        <div class="system_error_section" style="display:none">
            {system_error_section}
        </div>

    </div>
    <!-- service_status_details_content -->
</div>
