@extends('layouts.app')

@section('title', 'Статистика ответов по статьям')

@section('content')
    @php
        use App\ArticleFeedbackAnswer;

        $questions = ArticleFeedbackAnswer::questions('ru');
        $answersLabels = ArticleFeedbackAnswer::answerLabels('ru');
    @endphp

    <section class="bg-primary-alt header-inner o-hidden">
        <div class="container">
            <div class="row my-4">
                <div class="col">
                    <h1>Статистика ответов по статьям</h1>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            @include('admin.partials.nav')

            <form method="get" action="{{ route('admin.article_feedback.index') }}" class="card card-body mb-4">
                <div class="form-row align-items-center">
                    <div class="col-md-4">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="include_owner" name="include_owner" value="1" @checked($includeOwner)>
                            <label class="custom-control-label" for="include_owner">Показывать мои устройства</label>
                        </div>
                    </div>
                    <div class="col-md-2 mt-3 mt-md-0">
                        <button type="submit" class="btn btn-primary btn-block">Показать</button>
                    </div>
                </div>
            </form>

            <h3 class="mb-3">Сводка</h3>
            <div class="table-responsive mb-5">
                <table class="table table-sm table-striped">
                    <thead>
                    <tr>
                        <th>Статья</th>
                        <th>Вопрос</th>
                        <th>Ответ</th>
                        <th class="text-right">Количество</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($summaryRows as $row)
                        <tr>
                            <td>{{ optional($row->article)->title ?? 'Статья удалена' }}</td>
                            <td>{{ $questions[$row->question_key] ?? $row->question_key }}</td>
                            <td>{{ $answersLabels[$row->answer] ?? $row->answer }}</td>
                            <td class="text-right">{{ $row->answers_count }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Ответов пока нет.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <h3 class="mb-3">Все ответы</h3>
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead>
                    <tr>
                        <th>Дата</th>
                        <th>Статья</th>
                        <th>Вопрос</th>
                        <th>Ответ</th>
                        <th>Я</th>
                        <th>Пользователь</th>
                        <th>View ID</th>
                        <th>IP</th>
                        <th>Язык</th>
                        <th>Referer</th>
                        <th>User-Agent</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($answers as $answer)
                        <tr>
                            <td>{{ $answer->created_at }}</td>
                            <td>{{ optional($answer->article)->title ?? 'Статья удалена' }}</td>
                            <td>{{ $questions[$answer->question_key] ?? $answer->question_key }}</td>
                            <td>{{ $answersLabels[$answer->answer] ?? $answer->answer }}</td>
                            <td>
                                @if($answer->is_owner)
                                    <span class="badge badge-info">Я</span>
                                    <div class="small text-muted">{{ $answer->owner_device_label ?: 'owner' }}</div>
                                @else
                                    <span class="badge badge-light">Нет</span>
                                @endif
                            </td>
                            <td>
                                @if($answer->user)
                                    {{ $answer->user->name }}<br>
                                    <span class="text-muted">{{ $answer->user->email }}</span>
                                @else
                                    <span class="text-muted">Гость</span>
                                @endif
                            </td>
                            <td>{{ $answer->view_article_id ?: '—' }}</td>
                            <td>{{ $answer->ip }}</td>
                            <td>{{ $answer->locale }}</td>
                            <td class="text-break">{{ $answer->referer }}</td>
                            <td class="text-break">{{ $answer->user_agent }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11">Ответов пока нет.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{ $answers->links('pagination::bootstrap-4') }}
        </div>
    </section>
@endsection
