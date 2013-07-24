<rn:meta title="#rn:msg:SHP_TITLE_HDG#" template="service_status_query.php" clickstream="home"/>

<div id="rn_PageContent123" class="rn_Home">
     <!-- Service Status pages start here! -->

     <div class="search_title_panel">
         <h1 class="search_title">Network Status</h1>
     </div>

     <div class="service_status_content">

         <div class="search_condition_section">
             <div class="search_head_panel">
                 <p class="search_prompt">
                     Enter a suburb name to see if there are any known issues:
                 </p>

                 <div class="search_panel">
                     <table>
                         <tr>
                             <td class="search_input">
                                 <input type="text" name="serviceStatusSuburb" id="suburbInput"  autocomplete="off" role="textbox"
                                        aria-autocomplete="list" aria-haspopup="true">
                             </td>
                             <td class="search_action_lnk">
                                 <div><a href="#" id="service_status_search_lnk">Search</a></div>
                             </td>
                         </tr>
                     </table>

                    <!-- <input id="serviceStatusSuburb" name="serviceStatusSuburb"/>-->

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
                     <img alt="clock" src="../assets/themes/optus_theme/images/ajax-loader.gif"/>
                 </div>
                 <div class="none_found_panel" style="display:none">
                     <p>None found.</p>
                 </div>
                 <div class="unexpected_issues_list_panel" style="display:none">
                     <!-- unexpected issues list shown in table here -->
                 </div>
             </div>

             <div class="planned_repairs_maintenance_panel">
                 <h2>Planned Repairs and Maintenance</h2>

                 <div class="loading_panel" style="display:none">
                     <div class="loading_panel" style="display:none">
                         <img alt="clock" src="../assets/themes/optus_theme/images/ajax-loader.gif"/>
                     </div>
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
             <p>Sorry! The query service is temporarily unavailable now.</p>
         </div>

     </div>
     <!-- service_status_content -->

     <!-- service_status_detail_content starts -->
     <div class="service_status_detail_content" style="display:none">
         <div class="loading_panel" style="display:none">
             <img alt="clock" src="../assets/themes/optus_theme/images/ajax-loader.gif"/>
         </div>
         <div class="details_panel" style="display:none">
             <h2><span id="ssd_location"></span>, <span id="ssd_state"></span></h2>
             <p>
                 Updated at: <span id="ssd_updatedTime"></span>
             </p>

             <div>
                 <h5>Optus Network Ref</h5>
                 <p><span id="ssd_serviceId"></span></p>
             </div>

             <div>
                 <h5>Estimated Time of Commencement</h5>
                 <p><span id="ssd_startTime"></span></p>
             </div>

             <div>
                 <h5>Service Affected</h5>
                 <p><span id="ssd_serviceAffected"></span></p>
             </div>

             <div>
                 <h5>Outage Type</h5>
                 <p><span id="ssd_outageType"></span></p>
             </div>

             <div>
                 <h5>Description</h5>
                 <p><span id="ssd_description"></span></p>
             </div>

             <div>
                 <h5>Resolution</h5>
                 <p><span id="ssd_resolution"></span></p>
             </div>

             <div>
                 <h5>Estimated Time of Commencement</h5>
                 <p><span id="ssd_endTime"></span></p>
             </div>
         </div>

         <div class="back_link_panel" >
             <a href="#" class="back_link">&lt;&nbsp;Back</a>
         </div>

         <div class="system_error_section" style="display:none">
             <p>Sorry! The query service is temporarily unavailable now.</p>
         </div>

     </div>
     <!-- service_status_detail_content ends -->


</div>