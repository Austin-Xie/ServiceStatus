/*global window, document, jQuery */

/*
 * Service Status Search JS functions..
 */
(function ($) {
    'use strict';

    var unexpectedIssueListPanel =  '.service_status_content .unexpected_issues_panel .unexpected_issues_list_panel',
        plannedIssueListPanel = '.service_status_content .planned_repairs_maintenance_panel .planned_repairs_maintenance_list_panel',
        searchIntroPanel = ".search_intro_panel",
        searchResultPrompt = ".search_result_prompt",
        unexpectedIssuesPanel = ".unexpected_issues_panel",
        plannedRepairsMaintenancePanel = ".planned_repairs_maintenance_panel",
        unplannedIssueCols = [
            {
                "sTitle" : "Location" // Group by Network
            }, {
                "sTitle" : "Service Affected"
            }, {
                "sTitle" : "Outage Type"
            }, {
                "sTitle" : "Status",
                "sClass" : "center"
            }, {
                "sTitle" : "More info", // wrap 'id'
                "sClass" : "center"
            }
        ],
        plannedIssueCols = [
            {
                "sTitle" : "Location"
            }, {
                "sTitle" : "Service Affected"
            }, {
                "sTitle" : "When",
                "sClass" : "center"
            }, {
                "sTitle" : "More info",  // wrap 'id'
                "sClass" : "center"
            }
        ];

    function renderSearchResults(dataPanel, cols, searchResult) {
        var tablePanel = $(dataPanel);
        tablePanel.empty().html('<table cellpadding="0" cellspacing="0" border="0" class="display" id="dataTable" ></table>');

        tablePanel.children('#dataTable').dataTable({
            "aaData": searchResult,
            "aoColumns": cols
        });
    }

    $(document).ready(function () {
        //cleanSearchResults();

        $('#service_status_search_lnk').on('click', function (e) {
            alert('clicked me');
            var suburb = $('#suburbInput').val(),
                aaData = [],
                url = '/cc/ajaxNetworkOutage/ajaxQueryNetworkOutages' ; //'/ci/ajaxCustom/ajaxFunctionHandler';
            //url = '/cc/ajaxNetworkOutage/ajaxQueryTest' ;
            //http://optus.custhelp.com/cc/ajaxNetworkOutage/ajaxQueryNetworkOutages?serviceStatusSuburb=Epping&site=consumer
            // url = 'http://localhost/ServiceStatus_GH/test/mockJson.php';

            e.preventDefault();

            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'json',
                //dataType : 'jsonp',
                //jsonpCallback: 'callback',
                async: false,
                data : {
                    serviceStatusSuburb : suburb
                },
                success : function (jsonData) {
                    alert('jsonData=' + JSON.stringify(jsonData));

                    var unexpectedIssues = jsonData.Unexpected,
                        plannedRepairs = jsonData.Planned,
                        no,
                        location,
                        when,
                        moreInfo,
                        i,
                        l;

                    for (i = 0, l = unexpectedIssues.length; i < l; i += 1) {
                        no = unexpectedIssues[i];
                        location = no.location + ", " + no.state;
                        moreInfo = "<a href='#" + no.id + "'>More info ></a>";
                        aaData.push([location, no.serviceAffected, no.summary, no.fixingStatus, moreInfo]);
                    }
                    renderSearchResults(unexpectedIssueListPanel, unplannedIssueCols, aaData);

                    aaData = [];
                    for (i = 0, l = plannedRepairs.length; i < l; i += 1) {
                        no = plannedRepairs[i];
                        location = no.location + ", " + no.state;
                        when = no.startTime + " - " +  no.endTime;
                        moreInfo = "<a href='#" + no.id + "' class='detail_link'>More info ></a>";
                        aaData.push([location, no.serviceAffected, when, moreInfo]);
                    }
                    renderSearchResults(plannedIssueListPanel, plannedIssueCols, aaData);

                    // To Show Search result lists
                    $(searchIntroPanel).hide();
                    $(searchResultPrompt).show();
                    $(unexpectedIssuesPanel).show();
                    $(plannedRepairsMaintenancePanel).show();

                },
                failure : function (resp) {
                    //TODO: to add error handling logic.
                    alert('error happened', resp);
                }
            });

            return false;
        });

    });

}(jQuery));
