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
        searchResultListPanel: '.search_result_list_section .search_result_list_section',
        unexpectedIssuesPanel: '.search_result_list_section .unexpected_issues_panel',

        unexpectedNonFoundPanel: ".search_result_list_section .none_found_panel",
        plannedNonFoundPanel: ".planned_repairs_maintenance_panel .loading_panel",

        plannedRepairsMaintenancePanel: ".planned_repairs_maintenance_panel",

        searchLoadingPanels: ".search_result_list_section .loading_panel, .planned_repairs_maintenance_panel .loading_panel",

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

            $(self.searchLoadingPanels).show();
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

            $(self.searchLoadingPanels).hide();

            //$(self.plannedIssueListPanel + "," + self.unexpectedIssuesPanel).show();

            l = plannedRepairs.length;
            if (l == 0) {
                $(self.unexpectedNonFoundPanel).show();
                $(self.unexpectedIssueListPanel).hide();
            } else {
                for (i = 0; i < l; i += 1) {
                    no = unexpectedIssues[i];
                    location = no.location + ", " + no.state;
                    moreInfo = "<a href='#" + no.id + "'>More info ></a>";
                    aaData.push([location, no.serviceAffected, no.summary, no.fixingStatus, moreInfo]);
                }
                renderSearchResults(self.unexpectedIssueListPanel, self.unplannedIssueCols, aaData);
                $(self.unexpectedIssueListPanel).show();
            }

            aaData = [];
            l = l = plannedRepairs.length;
            if (l == 0 ) {
                $(self.plannedNonFoundPanel).show();
                $(self.plannedIssueListPanel).hide();
            } else {
                for (i = 0; i < l; i += 1) {
                    no = plannedRepairs[i];
                    location = no.location + ", " + no.state;
                    when = no.startTime + " - " +  no.endTime;
                    moreInfo = "<a href='#" + no.id + "' class='detail_link'>More info ></a>";
                    aaData.push([location, no.serviceAffected, when, moreInfo]);
                }
                renderSearchResults(self.plannedIssueListPanel, self.plannedIssueCols, aaData);
                $(self.plannedIssueListPanel).show();
            }
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
