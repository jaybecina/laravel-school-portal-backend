$(document).ready(function () {
    $(".form-check-course-edit").click(function () {
        var courseId = $(this).val();

        // $(`.form-check-subject${courseId}`).prop('checked', false);

        var isChecked = $(`#inlineEditCourseCheckbox${courseId}`).is(
            ":checked"
        );

        if (isChecked) {
            $(`#divCheckSubjGrp${courseId}`).css("display", "block");
            $(this).prop("checked", true);
            $(`.form-check-course-edit${courseId}`).prop("disabled", false);
            $(`.form-check-subject${courseId}`).prop("disabled", false);
        } else {
            // $(`#divCheckSubjGrp${courseId}`).css("display", "none");
            $(this).removeAttr("checked");
            $(`.form-check-course-edit${courseId}`).prop("disabled", true);
            $(`.form-check-subject${courseId}`).prop("disabled", true);
        }
    });

    $(".form-check-course-edit:checked").each(function () {
        var courseId = $(this).val();
        // console.log(courseId);

        // $(`.form-check-subject${courseId}`).prop('checked', false);

        var isChecked = $(`#inlineEditCourseCheckbox${courseId}`).is(
            ":checked"
        );

        if (isChecked) {
            $(`#divCheckSubjGrp${courseId}`).css("display", "block");
            $(this).prop("checked", true);
            $(`.form-check-course-edit${courseId}`).prop("disabled", false);
            $(`.form-check-subject${courseId}`).prop("disabled", false);
        } else {
            // $(`#divCheckSubjGrp${courseId}`).css("display", "none");
            $(this).removeAttr("checked");
            $(`.form-check-course-edit${courseId}`).prop("disabled", true);
            $(`.form-check-subject${courseId}`).prop("disabled", true);
        }

        console.log(`.form-check-subject${courseId}:checked`);

        $(`.form-check-subject${courseId}:checked`).each(function () {
            // Get the corresponding value (assuming the value is stored in a data attribute called "data-value")
            var value = $(this).val();

            // Log the value to the console
            console.log(value);
        });
    });
});
