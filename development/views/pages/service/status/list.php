<rn:meta title="#rn:msg:SHP_TITLE_HDG#" template="service_status_query.php" clickstream="home"/>

<div id="rn_PageContent123" class="rn_Home">
            <!-- Service Status pages start here! -->

            <div class="service_status_content">

                <div class="search_condition_list_container">
                    <div  class="search_head">
                        <h1>Live Service Status</h1>
                        <p>
                            Enter a suburb name to see if there are any known issues:
                        </p>
                        <div class="search_panel">
                            <input id="suburbInput" name="serviceStatusSuburb" />
                            <a href="#" id="service_status_search_lnk">Search</a>
                        </div>
                        <div class="service_status_SubNote">
                            <p>E.g. Darlinghurst</p>
                        </div>
                    </div>

                    <div class="search_intro_panel" sytle="display: none">
                        <p>
                            {service status search intro panel}
                        </p>
                    </div>

                    <div class="search_result_prompt" style="display:none">
                        <h2>What's happening in your area?</h2>
                        <p>Below are the results found for your area.</p>
                    </div>

                    <div class="unexpected_issues_panel" style="display:none">
                        <h2>Unexpected Issues</h2>
                        <div class="not_found_panel">
                            None found
                        </div>
                        <div class="unexpected_issues_list_panel">
                            <!-- unexpected issues list shown in table here -->
                        </div>

                    </div>

                    <br/>
                    <br/>

                    <div class="planned_repairs_maintenance_panel" style="display:none">
                        <h2>Planned Repairs and Maintenance</h2>
                        <div class="not_found_panel">
                            None found
                        </div>
                        <div class="planned_repairs_maintenance_list_panel">
                            <!-- planned repairs maintenance shown in table here -->
                        </div>
                    </div>
                </div>

                <div class="details_panel" style="display:none">
                    <h3>{Suburb}, {State}}</h3>
                    <p>
                        {updated time}
                    </p>

                    <p>Optus Network Ref</p>
                    <p>{serviceId}</p>


                    <div class="service_affected_panel">
                        {Service affected}
                    </div>

                    <div class="outage_type_panel">
                        {Outage Type}
                    </div>

                    <div class="description_panel">
                        {Description}
                    </div>

                    <div class="back_link_panel">
                        <a href="#">&lt;&nbsp;Back</a>
                    </div>

                </div>

            </div>
            <!-- service_status_content -->

            <!-- Service Status pages stop here! -->

</div>