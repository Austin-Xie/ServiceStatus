<rn:meta title="#rn:msg:SHP_TITLE_HDG#" template="service_status_query.php" clickstream="home"/>

<div id="rn_PageContent123" class="rn_Home">
    <!-- Service Status pages start here! -->

    <div class="service_status_content">

        <div class="search_condition_section">
            <div class="search_head_panel">
                <h1>Live Service Status</h1>

                <p>
                    Enter a suburb name to see if there are any known issues:
                </p>

                <div class="search_panel">
                    <input id="suburbInput" name="serviceStatusSuburb"/>
                    <a href="#" id="service_status_search_lnk">Search</a>
                </div>
                <div class="service_status_SubNote">
                    <p>E.g. Darlinghurst</p>
                </div>
            </div>
        </div>

        <div class="search_intro_section ">
            <p>
                {service status search intro panel}
            </p>
        </div>

        <div class="search_result_list_section">

            <div class="search_result_prompt " style="display:none">
                <h2>What's happening in your area?</h2>

                <p>Below are the results found for your area.</p>
            </div>

            <div class="unexpected_issues_panel ">
                <h2>Unexpected Issues</h2>

                <div class="loading_panel" style="display:none">
                    {loading_panel}
                </div>
                <div class="none_found_panel" style="display:none">
                    <p>None found.</p>
                </div>
                <div class="unexpected_issues_list_panel" style="display:none">
                    <!-- unexpected issues list shown in table here -->
                </div>
            </div>

            <br/>
            <br/>

            <div class="planned_repairs_maintenance_panel">
                <h2>Planned Repairs and Maintenance</h2>

                <div class="loading_panel" style="display:none">
                    {loading_panel}
                </div>
                <div class="none_found_panel" style="display:none">
                    <p>None found.</p>
                </div>
                <div class="planned_repairs_maintenance_list_panel" style="display:none">
                    <!-- planned repairs maintenance shown in table here -->
                </div>
            </div>
        </div>

        <div class="system_error_section" style="display:none">
            {system_error_section}
        </div>

    </div>
    <!-- service_status_content -->

</div>
<!-- Service Status pages stop here! -->

</div>

        <script type='text/javascript'>
            $(document).ready(function () {
                // bind search action
                $('#service_status_search_lnk').on('click', searchServiceStatuses);

                initSearchPage();
            });

        </script>