/*global window, document, jQuery */

/*
 * Service Status Search JS functions..
 */
(function ($) {
    'use strict';

    var serviceStatusUrl = '/cc/ajaxServiceStatus/ajaxQueryServiceStatuses',
        //Search Condition Section
        searchConditionSection = '.service_status_content .search_condition_section',

        //Search Into Section
        searchIntroSection = '.service_status_content .search_intro_section',

        // search result list section
        searchResultListSection = '.search_result_list_section',
        searchResultPrompt = searchResultListSection + ' .search_result_prompt',



        //Unexpected Issues Section
        unexpectedIssuesPanel = '.service_status_content .unexpected_issues_panel',
        unexpectedIssueListPanel = unexpectedIssuesPanel + ' .unexpected_issues_list_panel',
        unexpectedIssueNonFoundPanel = unexpectedIssuesPanel + ' .none_found_panel',
        unexpectedIssueLoadingPanel = unexpectedIssuesPanel + ' .loading_panel',

        // Planned Issues Section
        plannedIssuePanel = '.service_status_content .planned_repairs_maintenance_panel',
        plannedIssueListPanel = plannedIssuePanel + ' .planned_repairs_maintenance_list_panel',
        plannedIssueNonFoundPanel = plannedIssuePanel + ' .none_found_panel',
        plannedIssueLoadingPanel = plannedIssuePanel + ' .loading_panel',

        // System error section
        systemErrorSection = '.system_error_section',

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

    function getServiceStatusData (jsonData) {
        // console.log('jsonData=' + JSON.stringify(jsonData));

        var unexpectedIssues = jsonData.Unexpected,
            plannedRepairs = jsonData.Planned,
            unexpectedIssuesData = [],
            plannedIssuesData = [],
            ss,
            location,
            when,
            moreInfo,
            i,
            l;

        for (i = 0, l = unexpectedIssues.length; i < l; i += 1) {
            ss = unexpectedIssues[i];
            location = ss.location + ", " + ss.state;
            moreInfo = "<a href='#" + ss.id + "'>More info ></a>";
            unexpectedIssuesData.push([location, ss.serviceAffected, ss.summary, ss.fixingStatus, moreInfo]);
        }
        //renderSearchResults(unexpectedIssueListPanel, unplannedIssueCols, aaData);

        for (i = 0, l = plannedRepairs.length; i < l; i += 1) {
            ss = plannedRepairs[i];
            location = ss.location + ", " + ss.state;
            when = ss.startTime + " - " +  ss.endTime;
            moreInfo = "<a href='#" + ss.id + "' class='detail_link'>More info ></a>";
            plannedIssuesData.push([location, ss.serviceAffected, when, moreInfo]);
        }
        //renderSearchResults(plannedIssueListPanel, plannedIssueCols, aaData);

        return {
            unexpectedIssuesData: unexpectedIssuesData,
            plannedIssuesData: plannedIssuesData
        };
    }

    function fetchServiceStatus(suburb, successCallback, errorCallback) {
        $.ajax({
            url : serviceStatusUrl,
            type : 'POST',
            dataType : 'json',
            data : {
                serviceStatusSuburb : suburb
            },
            success : successCallback,
            failure :errorCallback
        });

    }

    function initSearchPage() {
        // var suburb = $('#suburbInput').val();

        // waiting for query results
        $(unexpectedIssueLoadingPanel + ", " + plannedIssueLoadingPanel).show();

        fetchServiceStatus("", function(jsonData) {
            // Succeed
            togglePanels([unexpectedIssueLoadingPanel, plannedIssueLoadingPanel], false);

            var data = getServiceStatusData(jsonData);

            $(searchResultListSection + ", " + searchResultPrompt).show();
                togglePanels([searchResultListSection, searchResultPrompt], true);
            if (data.unexpectedIssuesData) {
                renderSearchResults(unexpectedIssueListPanel, unplannedIssueCols, data.unexpectedIssuesData);
                $(unexpectedIssueListPanel).show();
            } else {
                $(unexpectedIssueNonFoundPanel).show();
            }

            if (data.plannedIssuesData) {
                renderSearchResults(plannedIssueListPanel, plannedIssueCols, data.plannedIssuesData);
                $(plannedIssueListPanel).show();
            } else {
                $(plannedIssueNonFoundPanel).show();
            }

        },
        function(error) {
            console.error(error);
            togglePanels([searchResultListSection, unexpectedIssueLoadingPanel, plannedIssueLoadingPanel], false);
            $(systemErrorSection).html(error).show();
        });

        return false;
    }

    function searchServiceStatuses(e) {
        // Hide Search Intro Section
        /*
         //Unexpected Issues Section
         unexpectedIssuesPanel = '.service_status_content .unexpected_issues_panel',
         unexpectedIssueListPanel = unexpectedIssuesPanel + ' .unexpected_issues_list_panel',
         unexpectedIssueNonFoundPanel = unexpectedIssuesPanel + ' .none_found_panel',
         unexpectedIssueLoadingPanel = unexpectedIssuesPanel + ' .loading_panel',

         // Planned Issues Section
         plannedIssuePanel = '.service_status_content .planned_repairs_maintenance_panel',
         plannedIssueListPanel = plannedIssuePanel + ' .planned_repairs_maintenance_list_panel',
         plannedIssueNonFoundPanel = plannedIssuePanel + ' .none_found_panel',
         plannedIssueLoadingPanel = plannedIssuePanel + ' .loading_panel',
         */
        togglePanels([searchIntroSection, unexpectedIssueNonFoundPanel, plannedIssueNonFoundPanel], false);

    }

    function togglePanels(panels, show) {
        if (show) {
            $(panels.join(', ')).show();
        } else {
            $(panels.join(', ')).hide();
        }
    }

    $(document).ready(function () {
        // bind search action
        $('#service_status_search_lnk').on('click', searchServiceStatuses);

        initSearchPage();
    });

}(jQuery));
