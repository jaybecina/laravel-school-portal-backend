$(document).ready(function() {
    var isEditCurr = false;

    $("#currEditBtn").click(function() {
        isEditCurr = true;

        handleEditCurr(isEditCurr);
    });

    function handleEditCurr(isEditCurr) {
        if(isEditCurr) {
            $("#currEditSelectDiv").removeClass("d-none");
            $("#currEditSelectDiv").addClass("d-block");

            $("#currCancelEditBtn").removeClass("d-none");
            $("#currCancelEditBtn").addClass("d-block");

            $("#currentCurrDiv").removeClass("d-block");
            $("#currentCurrDiv").addClass("d-none");

            $("#currEditBtn").removeClass("d-block");
            $("#currEditBtn").addClass("d-none");
        }
    }

    $("#currEditSelect").on("change", function() {
        let selectedCurriculumId = $(this).val();
        $("#currCancelEditBtn").removeClass("d-block");
        $("#currCancelEditBtn").addClass("d-none");

        var pathname = window.location.pathname; // Returns path only (/path/example.html)
        var url      = window.location.href;     // Returns full URL (https://example.com/path/example.html)
        var origin   = window.location.origin;   // Returns base URL (https://example.com)

        

        let searchParams = new URLSearchParams(window.location.search);

        let historyParamCurriculum = searchParams.get('curriculum'); // get to know the value if curriculum
        let updatedURL = url.replace(`curriculum=${historyParamCurriculum}`, `curriculum=${selectedCurriculumId}&edit_curriculum=true`);
        window.location.href = `${updatedURL}`;
    });


    // The checking of courses and subjects JS functions are in the create.js of enrollments page
});