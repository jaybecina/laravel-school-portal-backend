$(document).ready(function() {
    $('.form-check-enrcurr-course-create').on('change', function () {
        var courseId = $(this).val();
        var subjectDiv = $(`#divCheckSubjGrp${courseId}`);
        var subjects = $(`.form-check-enrcurr-subject-create${courseId}`);
        
        $('[class^="form-check-enrcurr-subject-create"]').not(`[class*="form-check-enrcurr-subject-create${courseId}"]`).each(function() {
            $(this).prop('disabled', true);
        });
    
        if ($(this).is(':checked')) {
            subjectDiv.css('display', 'block');
            subjects.prop('disabled', false);
        } else {
            // // This code does not work
            // subjectDiv.css('display', 'none');
            // subjects.prop('disabled', true);
        }
    });
});

// Calculate when selecting course radio button
$(document).ready(function () {
    var courseId = 0;
    $(".form-check-enrcurr-course-create").on("change", function () {
        var courseId = $(this).val();
        var totalUnits = 0;
        $('#course-selected').val(courseId);
        // Calculate the total units of checked subjects for the specific course
        $(".form-check-enrcurr-subject-create" + courseId + ":checked:not(disabled)").each(function () {
            totalUnits += parseFloat($(this).data("units"));
        });

        // Update the "credits" input with the sum of units for the specific course
        $("#credits").val(totalUnits);
    });
});


// Update the 'credits' input when subjects are checked/unchecked:
$(document).ready(function () {
    $('[class^="form-check-enrcurr-subject-create"]').on('change', function () {
        var courseId = $('#course-selected').val();
        var creditsInput = $('#credits');
        var requiredCredits = parseFloat($("#required_credits").val());
        var totalCredits = 0;
        var sumCheckExceed = 0;
        console.log(123)
    
        $(`.form-check-enrcurr-subject-create${courseId}:checked:not(:disabled)`).each(function () {
            sumCheckExceed = totalCredits + parseInt($(this).data('units'));
            
            // Check if the total credits exceed the required credits
            // if (sumCheckExceed <= requiredCredits) {
                // Reset the input value to the required credits
                totalCredits += parseInt($(this).data('units'));
            // }
            
        });
    
        creditsInput.val(totalCredits);

        console.log("Total credits: " + totalCredits)
    });
    
});

// Ensure that the total credits do not exceed the "required_credits":
$(document).ready(function () {
    // Store the required credits value
    var requiredCredits = parseFloat($("#required_credits").val());

    $(".form-check-enrcurr-subject-create").on("change", function () {
        var $courseId = $(this).data("course-id");
        var totalUnits = 0;

        // Calculate the total units of checked subjects for the specific course
        $(".form-check-enrcurr-subject-create" + $courseId + ":checked").each(function () {
            totalUnits += parseFloat($(this).data("units"));
        });

        // Update the "credits" input with the sum of units for the specific course
        $("#credits").val(totalUnits);

        // Check if the total credits exceed the required credits
        if (totalUnits > requiredCredits) {
            // Reset the input value to the required credits
            $("#credits").val(requiredCredits);
        }
    });
});