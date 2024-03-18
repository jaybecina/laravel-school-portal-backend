$(document).ready(function () {
    $(".form-check-course").click(function () {
        var courseId = $(this).val();
        $(`.form-check-subject${courseId}`).prop("checked", false);

        var isChecked = $(`#inlineCheckbox${courseId}`).is(":checked");

        // if course is checked
        if (isChecked) {
            $(`#divCheckSubjGrp${courseId}`).css("display", "block");

            // // Check if an input with ID checkedCourseCurrentCredit_<courseId> not exists
            // if (!$(`#checkedCourseCurrentCredit_${courseId}`).length) {
            //     var input = $("<input>").attr({
            //         type: "number",
            //         id: `checkedCourseCurrentCredit_${courseId}`,
            //         name: `checkedCourseCurrentCredit_${courseId}`,
            //         placeholder: `checkedCourseCurrentCredit_${courseId}`,
            //         value: 0,
            //         class: "form-control",
            //         readonly: true,
            //     });

            //     // Append the input to the div
            //     $("#checkedCourseCurrentCreditDiv").append(input);
            // }

            // // subject is checked or unchecked
            // // add to the value of input text id="checkCourseCurrentCredit_<courseId>" the value of data-units of one of these multiple subject checkbox that was checked"
            // $(`.form-check-subject${courseId}`).on("click", function () {
            //     if ($(this).is(":checked")) {
            //         console.log(
            //             "parseInt($(this).data(units)): ",
            //             parseInt($(this).data("units"))
            //         );

            //         $(`#checkedCourseCurrentCredit_${courseId}`).val(
            //             parseInt(
            //                 $(`#checkedCourseCurrentCredit_${courseId}`).val()
            //             ) + parseInt($(this).data("units"))
            //         );
            //     } else {
            //         $(`#checkedCourseCurrentCredit_${courseId}`).val(
            //             parseInt(
            //                 $(`#checkedCourseCurrentCredit_${courseId}`).val()
            //             ) - parseInt($(this).data("units"))
            //         );
            //     }
            // });
        } else {
            $(`#divCheckSubjGrp${courseId}`).css("display", "none");

            // $(`#checkedCourseCurrentCredit_${courseId}`).val(0);

            // $(`#checkedCourseCurrentCredit_${courseId}`).remove();
        }
    });
});
