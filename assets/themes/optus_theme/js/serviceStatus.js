/*global window, document, jQuery */

/*
 * Service Status Search JS functions..
 */
( function($) {
    'use strict';

    var unexpectedIssueListPanel =  '.service_status_content .unexpected_issues_panel .unexpected_issues_list_panel',
        plannedIssueListPanel = '.service_status_content .planned_repairs_maintenance_panel .planned_repairs_maintenance_list_panel',
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

        var oTable = tablePanel.children('#dataTable').dataTable( {
            "aaData": searchResult,
            "aoColumns":cols
        } );
    };

    function cleanSearchResults() {
        $.each(arguments, function(panel) {
            panel.empty();
        });
    };

    $(document).ready(function() {
        //cleanSearchResults();

        $( '#service_status_search_lnk').on('click', function(e){
            var suburb = $('#suburbInput').val();

            var aaData = [],
                url = 'http://localhost/ServiceStatus_GH/test/mockJson.php'; // '/cc/ajaxNetworkOutage/ajaxQueryNetworkOutages';

            $.ajax({
                url : url,
                type : 'get',
                dataType : 'json',
                data : {
                    'serviceStatusSuburb' : suburb
                },
                success : function(data) {
                    var unexpectedIssues = data['Unexpected'],
                        plannedRepairs = data['Planned'];
                    for (var i = 0; i < unexpectedIssues.length; i++) {
                        var no = unexpectedIssues[i],
                            location = no['location'] + ", " + no['state'],
                            moreInfo = "<a href='#" + no['id'] + "'>More info ></a>";
                        aaData.push([location, no['serviceAffected'], no['summary'], no['fixingStatus'], moreInfo]);
                    }
                    renderSearchResults(unexpectedIssueListPanel, unplannedIssueCols, aaData);

                    aaData = [];
                    for (var i = 0; i < plannedRepairs.length; i++) {
                        var no = plannedRepairs[i],
                            location = no['location'] + ", " + no['state'],
                            when = no['startTime'] + " - " +  no['endTime'],
                            moreInfo = "<a href='#" + no['id'] + "'>More info ></a>";
                        aaData.push([location, no['serviceAffected'], when, moreInfo]);
                    }
                    renderSearchResults(plannedIssueListPanel, plannedIssueCols, aaData);
                },
                failure : function(resp) {
                    alert(resp);
                }
            });

            return false;
        });

    });

}(jQuery));
