/*global window, document, jQuery */

/*
 * Todo: to add comments here.
 */
( function($) {'use strict';

        /* Data set - can contain whatever information you want */
        // var aDataSet = [['Trident', 'Internet Explorer 4.0', 'Win 95+', '4', 'X']];

        var queryType, columns, grpCol;

        var oTable;

        function renderSearchResults(searchResult) {

            cleanSearchResults();

            $('#dynamic').html('<table cellpadding="0" cellspacing="0" border="0" class="display" id="example"></table>');
            queryType = $('#queryType').val();
            grpCol = queryType == "Suburb" ? 2 : 4;

            columns = [{
                "sTitle" : "&nbsp;" // ICON Column
            }, {
                "sTitle" : "ID" // Hidden Column
            }, {
                "sTitle" : "Network" // Group by Network
            }, {
                "sTitle" : "Optus Network Ref"
            }, {
                "sTitle" : "Areas"
            }, {
                "sTitle" : "State",
                "sClass" : "center"
            }, {
                "sTitle" : "Start",
                "sClass" : "center"
            }, {
                "sTitle" : "Estimated Time to Resolve",
                "sClass" : "center"
            }/*, {
                "sTitle" : "Summary",
            }*/];

            oTable = $('#example').dataTable({

                "fnDrawCallback" : function(oSettings) {
                    if (oSettings.aiDisplay.length == 0) {
                        return;
                    }

                    var nTrs = $('tbody tr', oSettings.nTable);
                    var iColspan = nTrs[0].getElementsByTagName('td').length;

                    var sLastGroup = "";
                    for (var i = 0; i < nTrs.length; i++) {
                        var iDisplayIndex = oSettings._iDisplayStart + i;
                        nTrs[iDisplayIndex].childNodes[0].innerHTML = '<img src="../optus_theme/images/datatable/details_open.png" />';
                        var sGroup = oSettings.aoData[ oSettings.aiDisplay[iDisplayIndex] ]._aData[grpCol];
                        if (sGroup != sLastGroup) {

                            var nGroup = document.createElement('tr');
                            var nCell = document.createElement('td');
                            nCell.colSpan = iColspan;
                            // one more column for holding detail icon.
                            nCell.className = "group";
                            nCell.innerHTML = sGroup;
                            nGroup.appendChild(nCell);
                            nTrs[i].parentNode.insertBefore(nGroup, nTrs[i]);

                            sLastGroup = sGroup;
                        }
                    }

                },
                "aoColumnDefs" : [
                 // ICON column
                {
                "bSortable" : false,
                "aTargets" : [0]
                },
                // Hide 'ID' Column
                {
                    "bSearchable" : false,
                    "bVisible" : false,
                    "aTargets" : [1]
                },
                // Set Group Column
                {
                    "bVisible" : false,
                    "aTargets" : [grpCol]
                }],
                "aaSortingFixed" : [[grpCol, 'asc']],
                // "aaSorting" : [[2, 'asc']],
                "sDom" : 'lfr<"giveHeight"t>ip',
                "aaData" : searchResult,
                "aoColumns" : columns
            });
        };

        function cleanSearchResults() {
            $('#dynamic').html('');
        };

        /* Formating function for row details */
        function fnFormatDetails(oTable, nTr) {
            var aData = oTable.fnGetData(nTr);
            var sOut = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
            sOut += '<tr><td>Summary:</td><td>' + aData[8] + '</td></tr>';
            sOut += '<tr><td>Description:</td><td>' + aData[9] + '</td></tr>';
            sOut += '</table>';

            return sOut;
        }

        /* Add event listener for opening and closing details
         * Note that the indicator for showing which row is open is not controlled by DataTables,
         * rather it is done here
         */
        $('#example tbody td img').live('click', function() {
            var nTr = $(this).parents('tr')[0];
            if (oTable.fnIsOpen(nTr)) {
                /* This row is already open - close it */
                this.src = "../optus_theme/images/datatable/details_open.png";
                oTable.fnClose(nTr);
            } else {
                /* Open this row */
                this.src = "../optus_theme/images/datatable/details_close.png";
                oTable.fnOpen(nTr, fnFormatDetails(oTable, nTr), 'details');
            }
        });

        $(document).ready(function() {
            //cleanSearchResults();

            $('#target').submit(function() {
                var aaData = [];

                $.ajax({
                    url : '/cc/ajaxNetworkOutage/ajaxQueryNetworkOutages',
                    type : 'post',
                    dataType : 'json',
                    data : {
                        'paramType' : $('#queryType').val(),
                        'paramValue' : $('#searchParam').val()
                    },
                    success : function(data) {
                        var a1 = data['networkOutages'];
                        for (var i = 0; i < a1.length; i++) {
                            var no = a1[i];
                            aaData.push([' ', no['ID'], no['Network'], no['OptusNetworkRef'], no['Areas'], no['State'], no['Start'], no['EstimatedTimeToResolve'], no['Summary'], no['Description']]);
                        }
                        renderSearchResults(aaData);

                    },
                    failure : function(resp) {
                        alert(resp);
                    }
                });

                return false;
            });

            $('#network_outage_preview_form').submit(function() {
                cleanSearchResults();
                var aaData = [];

                $.ajax({
                    url : '/cc/ajaxNetworkOutage/ajaxPreviewNetworkOutage',
                    type : 'post',
                    dataType : 'json',
                    data : {
                        'paramType' : $('#queryType').val(),
                        'paramValue' : $('#searchParam').val()
                    },
                    success : function(data) {
                        var a1 = data['networkOutages'];
                        for (var i = 0; i < a1.length; i++) {
                            var no = a1[i];
                            aaData.push([no['OptusNetworkRef'], no['Network'], no['Areas'], no['Start'], no['EstimatedTimeToResolve'], no['Summary']]);
                        }
                        renderSearchResults(aaData);
                    },
                    failure : function(resp) {
                        alert(resp);
                    }
                });

                return false;
            });

        });

    }(jQuery));
