/*global window, document, jQuery */

/*
 * Service Status Search JS functions..
 */
(function ($) {
    'use strict';

    var searchController = {
        unexpectedIssueListPanel: '.service_status_content .unexpected_issues_panel .unexpected_issues_list_panel',
        plannedIssueListPanel: '.service_status_content .planned_repairs_maintenance_panel .planned_repairs_maintenance_list_panel',
        searchIntroPanel: ".search_intro_panel",
        searchResultListPanel: '.search_result_list_section',
        unexpectedIssuesPanel: ".unexpected_issues_panel",
        plannedRepairsMaintenancePanel: ".planned_repairs_maintenance_panel",
        isSuburbSearched: false,
        unplannedIssueCols: [
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
        plannedIssueCols: [
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
        ],

        searchSuburb: function(e) {
            var self = this,
                suburb = $('#suburbInput').val(),
            // '/cc/ajaxNetworkOutage/ajaxQueryNetworkOutages';
                url = 'http://localhost/ServiceStatus_GH/test/mockJson.php';

            $.ajax({
                url : url,
                type : 'get',
                dataType : 'json',
                data : {
                    'serviceStatusSuburb' : suburb
                },
                success : searchController.showServiceStatusList,
                failure : function (resp) {
                    //TODO: to add error handling logic.
                }
            });

            return false;

        },

        showServiceStatusList: function (data) {
            var self = searchController,
                unexpectedIssues = data.Unexpected,
                plannedRepairs = data.Planned,
                aaData = [],
                no,
                location,
                when,
                moreInfo,
                i,
                l;

            $(self.searchIntroPanel).hide();
            $(self.searchResultListPanel).show();

            for (i = 0, l = plannedRepairs.length; i < l; i += 1) {
                no = unexpectedIssues[i];
                location = no.location + ", " + no.state;
                moreInfo = "<a href='#" + no.id + "'>More info ></a>";
                aaData.push([location, no.serviceAffected, no.summary, no.fixingStatus, moreInfo]);
            }
            renderSearchResults(self.unexpectedIssueListPanel, self.unplannedIssueCols, aaData);

            aaData = [];
            for (i = 0, l = plannedRepairs.length; i < l; i += 1) {
                no = plannedRepairs[i];
                location = no.location + ", " + no.state;
                when = no.startTime + " - " +  no.endTime;
                moreInfo = "<a href='#" + no.id + "' class='detail_link'>More info ></a>";
                aaData.push([location, no.serviceAffected, when, moreInfo]);
            }
            renderSearchResults(self.plannedIssueListPanel, self.plannedIssueCols, aaData);
            // To Show Search result lists
        }

    };



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

        $('#service_status_search_lnk').on('click', searchController.searchSuburb);

    });

}(jQuery));
