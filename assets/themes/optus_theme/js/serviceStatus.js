/*global window, document, jQuery */

/*
 * Service Status Search JS functions..
 */
(function ($) {
    'use strict';

    var serviceStatusUrl = '/cc/ajaxServiceStatus/ajaxQueryServiceStatuses',
        serviceStatusDetailUrl = '/cc/ajaxServiceStatus/ajaxQueryServiceStatusDetails',

        serviceStatusContent = '.service_status_content',

    //Search Condition Section
        searchConditionSection = serviceStatusContent + '.search_condition_section',

    //Search Into Section
        searchIntroSection = serviceStatusContent +  ' .search_intro_section',

    // search result list section
        searchResultListSection = '.search_result_list_section',
        searchResultPrompt = searchResultListSection + ' .search_result_prompt',



    //Unexpected Issues Section
        unexpectedIssuesPanel = serviceStatusContent +  ' .unexpected_issues_panel',
        unexpectedIssueListPanel = unexpectedIssuesPanel + ' .unexpected_issues_list_panel',
        unexpectedIssueNonFoundPanel = unexpectedIssuesPanel + ' .none_found_panel',
        unexpectedIssueLoadingPanel = unexpectedIssuesPanel + ' .loading_panel',

    // Planned Issues Section
        plannedIssuePanel = serviceStatusContent + ' .planned_repairs_maintenance_panel',
        plannedIssueListPanel = plannedIssuePanel + ' .planned_repairs_maintenance_list_panel',
        plannedIssueNonFoundPanel = plannedIssuePanel + ' .none_found_panel',
        plannedIssueLoadingPanel = plannedIssuePanel + ' .loading_panel',

    // Service Status Details Section
        serviceStatusDetailsContent = '.service_status_detail_content',
        serviceStatusDetailsLoadingPanel  = serviceStatusDetailsContent + ' .loading_panel',
        serviceStatusDetailsPanel = serviceStatusDetailsContent + ' .details_panel',
        serviceStatusDetailsErrorPanel = serviceStatusDetailsContent + ' .system_error_section',
        serviceStatusDetailsBackPanel = serviceStatusDetailsContent + ' .back_link_panel',

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

        // bind 'More info' click event handler
        $("#dataTable .service_status_detail_link").on('click', function (e) {
            e.preventDefault();
            var hrefValue  = e.target.href,
                i = hrefValue.indexOf('#'),
            //l =  hrefValue.length,
                ssId = Number (hrefValue.substr(i + 1));

            console.log("serviceStatusId = " + ssId);
            // Hide Service Status Search Section
            $(serviceStatusContent).hide();
            $(serviceStatusDetailsContent).show();

            fetchServiceStatusDetails(ssId, function (jsonData) {
                    console.log("service status details = " + jsonData);
                    // Todo: to populate these details

                    populateServiceStatusDetailsPanel(jsonData);

                    $([serviceStatusDetailsPanel, serviceStatusDetailsBackPanel], true);
                    $(serviceStatusDetailsLoadingPanel).hide();
                },
                function (error) {
                    togglePanels([serviceStatusDetailsLoadingPanel, serviceStatusDetailsPanel], false);
                    togglePanels([serviceStatusDetailsErrorPanel, serviceStatusDetailsBackPanel], true);
                    // Todo: to display error message in system error panel
                }
            );
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
            moreInfo = "<a href='#" + ss.id + "' class='service_status_detail_link'>More info ></a>";
            unexpectedIssuesData.push([location, ss.serviceAffected, ss.outageType, ss.fixingStatus, moreInfo]);
        }

        for (i = 0, l = plannedRepairs.length; i < l; i += 1) {
            ss = plannedRepairs[i];
            location = ss.location + ", " + ss.state;
            when = ss.startTime + " - " +  ss.endTime;
            moreInfo = "<a href='#" + ss.id + "' class='service_status_detail_link'>More info ></a>";
            plannedIssuesData.push([location, ss.serviceAffected, when, moreInfo]);
        }

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

    function fetchServiceStatusDetails(serviceStatusId, successCallback, errorCallback) {
        $.ajax({
            url :serviceStatusDetailUrl,
            type : 'POST',
            dataType : 'json',
            data : {
                serviceStatusId : serviceStatusId
            },
            success : successCallback,
            failure :errorCallback
        });
    }

    function populateServiceStatusDetailsPanel(jsonData) {
        var detailPanel = $(serviceStatusDetailsPanel);
        $.each(jsonData, function(key, value) {
            console.log('$(#ssd_'+ key + ").text(" + value + ")");
            //detailPanel.children("#ssd_" + key).html(value);
            $('#ssd_' + key).text(value);
        });
    }

    function initSearchPage() {
        $('#service_status_search_lnk').trigger('click');

        return false;
    }

    function searchServiceStatuses(e) {
        var suburb = $('#suburbInput').val();

        e.preventDefault();

        console.log('suburb == ' + suburb);

        togglePanels([searchIntroSection, unexpectedIssueNonFoundPanel, plannedIssueNonFoundPanel,
            unexpectedIssueListPanel, plannedIssueListPanel], false);

        togglePanels([unexpectedIssueLoadingPanel, plannedIssueLoadingPanel], true);

        fetchServiceStatus(suburb, function(jsonData) {
                // Succeed
                togglePanels([unexpectedIssueLoadingPanel, plannedIssueLoadingPanel], false);

                var data = getServiceStatusData(jsonData);

                togglePanels([searchResultListSection, searchResultPrompt], true);
                //unexpectedIssueListPanel, plannedIssueListPanel
                if (data.unexpectedIssuesData.length) {
                    // found data
                    renderSearchResults(unexpectedIssueListPanel, unplannedIssueCols, data.unexpectedIssuesData);
                    $(unexpectedIssueListPanel).show();
                } else {
                    // None Found
                    $(unexpectedIssueNonFoundPanel).show();

                }

                if (data.plannedIssuesData.length) {
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
            }
        );

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

        $(serviceStatusDetailsBackPanel + ' a.back_link').on('click', function(e) {
            e.preventDefault();
            $(serviceStatusContent).show();
            $(serviceStatusDetailsContent).hide();

            return false;
        });

        initSearchPage();
    });


}(jQuery));
