// ----------------------------------------------------------------------------
// Copyright (c) Microsoft Corporation.
// Licensed under the MIT license.
// ----------------------------------------------------------------------------

// Cache logged in user's info
const loggedInUser = {
    accessToken: undefined
};

$(function() {
    // Cache DOM objects
    UserOwnsData.workspaceSelect = $("#workspace-select");
    UserOwnsData.workspaceDefaultOption = $("#workspace-default-option").get(0);
    UserOwnsData.reportDiv = $("#report-div");
    UserOwnsData.dashboardDiv = $("#dashboard-div");
    UserOwnsData.tileDiv = $("#tile-div");
    UserOwnsData.reportSelect = $("#report-select");
    UserOwnsData.dashboardSelect = $("#dashboard-select");
    UserOwnsData.reportWrapper = $(".report-wrapper");
    UserOwnsData.dashboardWrapper = $(".dashboard-wrapper");
    UserOwnsData.tileWrapper = $(".tile-wrapper");
    UserOwnsData.reportDisplayText = $(".report-display-text");
    UserOwnsData.dashboardDisplayText = $(".dashboard-display-text");
    UserOwnsData.tileDisplayText = $(".tile-display-text");
    UserOwnsData.embedButton = $(".embed-button");
    UserOwnsData.tileSelect = $("#tile-select");
    UserOwnsData.reportContainer = $("#report-container");
    UserOwnsData.dashboardContainer = $("#dashboard-container");
    UserOwnsData.tileContainer = $("#tile-container");
    UserOwnsData.reportSpinner = $("#report-spinner");
    UserOwnsData.dashboardSpinner = $("#dashboard-spinner");
    UserOwnsData.tileSpinner = $("#tile-spinner");

    // Set default state of isPreviousReportRDL flag
    UserOwnsData.isPreviousReportRDL = false;

    // Cache base endpoint for Power BI REST API
    UserOwnsData.powerBiApi = "https://api.powerbi.com/v1.0/myorg/";
});
