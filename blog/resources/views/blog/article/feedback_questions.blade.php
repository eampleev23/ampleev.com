@php
    use App\ArticleFeedbackAnswer;
    use App\Support\SiteLocale;

    $locale = $site_locale ?? 'ru';
    $questions = ArticleFeedbackAnswer::questions($locale);
    if (!$article->show_feedback_questions) {
        $questions = array_intersect_key($questions, [
            ArticleFeedbackAnswer::QUESTION_INTERESTING => true,
        ]);
    }
    $answerLabels = ArticleFeedbackAnswer::answerLabels($locale);
    $feedbackRoute = route(SiteLocale::routeNameForLocale('blog.article_feedback_store', $locale));
    $selectedAnswers = $articleFeedbackAnswers ?? collect();
@endphp

@if(!empty($questions))
    <div class="article-feedback my-4 p-4 rounded">
        @foreach($questions as $questionKey => $questionText)
            @php
                $selectedAnswer = $selectedAnswers->get($questionKey);
            @endphp
            <div class="article-feedback-question {{ !$loop->last ? 'mb-4' : '' }}" data-feedback-question="{{ $questionKey }}">
                <h5 class="mb-3">{{ $questionText }}</h5>
                <div class="btn-group btn-group-toggle" role="group" aria-label="{{ $questionText }}">
                    @foreach($answerLabels as $answerKey => $answerText)
                        <button type="button"
                                class="btn article-feedback-answer {{ $selectedAnswer === $answerKey ? 'btn-primary is-selected' : 'btn-outline-primary' }}"
                                data-feedback-answer="{{ $answerKey }}"
                                {{ $selectedAnswer ? 'disabled' : '' }}>
                            {{ $answerText }}
                        </button>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <style>
        .article-feedback {
            background: #f7f9fc;
            border: 1px solid rgba(0, 113, 255, 0.14);
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
        }

        .article-feedback h5 {
            font-size: 1rem;
            line-height: 1.35;
        }

        .article-feedback-answer {
            min-width: 72px;
        }

        .article-feedback-answer:disabled {
            opacity: 1;
            cursor: default;
        }
    </style>

    <script>
        (function () {
            var feedbackBlock = document.querySelector('.article-feedback');
            if (!feedbackBlock || !window.fetch) return;

            feedbackBlock.addEventListener('click', function (event) {
                var button = event.target.closest('.article-feedback-answer');
                if (!button || button.disabled) return;

                var question = button.closest('[data-feedback-question]');
                if (!question) return;

                var buttons = question.querySelectorAll('.article-feedback-answer');
                buttons.forEach(function (item) {
                    item.disabled = true;
                });

                fetch(@json($feedbackRoute), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': @json(csrf_token())
                    },
                    body: JSON.stringify({
                        article_id: @json($article->id),
                        question_key: question.getAttribute('data-feedback-question'),
                        answer: button.getAttribute('data-feedback-answer')
                    })
                }).then(function (response) {
                    if (!response.ok) {
                        throw new Error('Feedback request failed');
                    }
                    return response.json();
                }).then(function (data) {
                    buttons.forEach(function (item) {
                        item.classList.remove('btn-primary', 'is-selected');
                        item.classList.add('btn-outline-primary');
                    });

                    var selected = question.querySelector('[data-feedback-answer="' + data.answer + '"]');
                    if (selected) {
                        selected.classList.remove('btn-outline-primary');
                        selected.classList.add('btn-primary', 'is-selected');
                    }
                }).catch(function () {
                    buttons.forEach(function (item) {
                        item.disabled = false;
                    });
                });
            });
        })();
    </script>
@endif
