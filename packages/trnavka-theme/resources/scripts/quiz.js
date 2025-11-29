export default function initializeQuiz($) {
    $("#quiz .js-quiz-answer").on('change', function () {
        const input = $(this);
        const question = input.closest(".js-quiz-question");

        if (input.val() === input.data("answer")) {
            question.find(".js-quiz-answers").addClass("d-none");
            question.find(".js-correct-answer").removeClass('d-none');
        }
        else {
            question.find(".js-wrong-answer").addClass("d-none");
            input.closest(".js-quiz-answer-holder").find(".js-wrong-answer").removeClass("d-none");
        }
    });
}
