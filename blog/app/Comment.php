<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\MyTime;
use Illuminate\Support\Facades\Mail;

class Comment extends Model
{
    public $iterations = 5;
    protected $fillable = [
        'content',
        'comment_id',
        'user_id',
        'article_id',
    ];

    public static function createComment($request)
    {
        try {
            \Log::info('Creating comment', [
                'user_id' => Auth::id(),
                'article_id' => $request->article_id,
                'comment_id' => $request->comment_id,
                'content_length' => strlen($request->content),
            ]);

            $comment = new Comment();
            // Санитизация: удаляем все HTML теги, оставляем только текст и переносы строк
            $comment->content = nl2br(htmlspecialchars(strip_tags($request->content), ENT_QUOTES, 'UTF-8'));
            $comment->user_id = Auth::id();
            $comment->article_id = (int)$request->article_id;
            $comment_id = $request->comment_id;

            // Если comment_id = '0' или пустой, устанавливаем null (для корневых комментариев)
            if ($comment_id && $comment_id != '0') {
                $comment->comment_id = (int)$request->comment_id;
            } else {
                $comment->comment_id = null; // null вместо 0 для корневых комментариев
            }

            \Log::info('Comment data before save', [
                'user_id' => $comment->user_id,
                'article_id' => $comment->article_id,
                'comment_id' => $comment->comment_id,
                'content_length' => strlen($comment->content),
            ]);

            // Сохраняем комментарий
            $saved = $comment->save();
            
            if (!$saved) {
                \Log::error('Failed to save comment - save() returned false', [
                    'user_id' => Auth::id(),
                    'article_id' => $request->article_id,
                    'comment_data' => [
                        'user_id' => $comment->user_id,
                        'article_id' => $comment->article_id,
                        'comment_id' => $comment->comment_id,
                        'content_length' => strlen($comment->content),
                    ],
                ]);
                return false;
            }

            \Log::info('Comment saved successfully', ['comment_id' => $comment->id]);

            // Отправляем уведомления
            try {
                $comment->articlesAuthorNotification();

                if ($comment->comment_id) {
                    $comment->commentsAuthorNotification();
                }
            } catch (\Exception $e) {
                // Логируем ошибку уведомлений, но не прерываем процесс
                \Log::warning('Error sending comment notifications', [
                    'comment_id' => $comment->id,
                    'error' => $e->getMessage(),
                ]);
            }

            return $comment;

        } catch (\Exception $e) {
            \Log::error('Error in createComment', [
                'user_id' => Auth::id(),
                'article_id' => $request->article_id ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return false;
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function get_nice_time_created()
    {
        return MyTime::new_time($this->created_at);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function parent_comment()
    {
        return $this->belongsTo(Comment::class, 'comment_id');
    }

    public static function getAllCommentsHtml($article)
    {
        // Оптимизация: загружаем все комментарии одним запросом с eager loading
        $allComments = Comment::with('user')
            ->where('article_id', '=', $article->id)
            ->get()
            ->keyBy('id');

        // Строим дерево комментариев в памяти
        $rootComments = $allComments->where('comment_id', null)->values();

        $resultStr = '<ol class="comments">';

        foreach ($rootComments as $comment) {
            $resultStr .= static::renderComment($comment, $allComments);
        }

        $resultStr .= '</ol>';
        return $resultStr;
    }

    /**
     * Рендерит комментарий и его дочерние комментарии
     */
    private static function renderComment($comment, $allComments)
    {
        $resultStr = '<li id="comment_' . $comment->id . '" class="comment">';
        $resultStr .= '<div class="d-flex align-items-center text-small">';
        $resultStr .= '<img src="' . $comment->user->avatar_path . '" alt="' . htmlspecialchars($comment->user->name) . '" class="avatar avatar-sm mr-2">';
        $resultStr .= '<div class="text-dark mr-1">' . htmlspecialchars($comment->user->name) . '</div>';
        $resultStr .= '<div class="text-muted">' . $comment->get_nice_time_created() . '</div>';
        // Контент уже санитизирован при сохранении:
        // - strip_tags() удалил все HTML теги
        // - htmlspecialchars() экранировал спецсимволы
        // - nl2br() преобразовал переносы строк в <br>
        // Поэтому выводим как есть, без дополнительного экранирования
        $resultStr .= '</div><div class="my-2">' . $comment->content . '</div><div>';

        if (Auth::check()) {
            $resultStr .= '<span to_give_an_answer_to_comment class="text-small answer-to-comment-link" data-answer_to_comment_id="' . $comment->id . '">Ответить</span></div>';
        } else {
            $resultStr .= '<span onclick="show_modal_sign_in();" class="text-small answer-to-comment-link">Ответить</span></div>';
        }

        // Рендерим дочерние комментарии
        $childComments = $allComments->where('comment_id', $comment->id)->values();
        if ($childComments->isNotEmpty()) {
            $resultStr .= '<ol class="comments">';
            foreach ($childComments as $childComment) {
                $resultStr .= static::renderComment($childComment, $allComments);
            }
            $resultStr .= '</ol>';
        }

        $resultStr .= '</li>';
        return $resultStr;
    }



    public function getChildsForConsole()
    {
        echo "Запустили  getChildsForConsole\n";
        $resultStr = '';

        echo "Ищем все комментарии с артикл ид " . $this->article_id . " и с коммент id " . $this->id . "\n";
        $comments = Comment::with('user')->where([
            ['article_id', '=', $this->article_id],
            ['comment_id', '=', $this->id],
        ])->get();
        echo "Получили такое количество: " . count($comments) . "\n";

        if (count($comments) > 0) {
            for ($i = 0; $i < count($comments); $i++) {
                echo "Запустили в модели итерацию: " . $i . "\n";
                if ($i == 0) {
                    $resultStr .= '<ol class="comments">';
                }
//                echo "resultStr = " . $resultStr . "\n";
                $resultStr .= '<li id="';
                $resultStr .= 'comment_';
                $resultStr .= $comments[$i]->id;
                $resultStr .= '" class="comment">';
                $resultStr .= '<div class="d-flex align-items-center text-small">'; // ok
                $resultStr .= '<img src="'; // ok
                $resultStr .= $comments[$i]->user->avatar_path; // ok
                $resultStr .= '"alt="Sarah Priestly" class="avatar avatar-sm mr-2">';
                $resultStr .= '<div class="text-dark mr-1">';
                $resultStr .= $comments[$i]->user->name;
                $resultStr .= '</div>';
                $resultStr .= '<div class="text-muted">';
                $resultStr .= $comments[$i]->get_nice_time_created();
                $resultStr .= '</div>';
                $resultStr .= '</div><div class="my-2">';
                $resultStr .= $comments[$i]->content;
                $resultStr .= '</div><div>';
                $resultStr .= '<span to_give_an_answer_to_comment class="text-small answer-to-comment-link"
                      data-answer_to_comment_id="';
                $resultStr .= $comments[$i]->id;
                $resultStr .= '">Ответить</span></div>';
                echo "Добрались до рекурсии\n";
                $resultStr .= $comments[$i]->getChildsForConsole();
                if ($i == count($comments) - 1) {
                    $resultStr .= '</ol>';
                }

            }
            $resultStr .= '</li>';
        }
        return $resultStr;

    }

    public function articlesAuthorNotification()
    {
        $article = Article::find($this->article_id);
        $articlesAuthor = User::find($article->user_id);
        
        // Проверяем, включены ли уведомления для автора статьи
        // По умолчанию уведомления включены (true), если поле null или false - отключены
        // Используем !== true чтобы учесть и false, и null
        if ($articlesAuthor->comment_notifications_enabled !== true) {
            \Log::info('Comment notification skipped: user ' . $articlesAuthor->email . ' has notifications disabled', [
                'user_id' => $articlesAuthor->id,
                'comment_notifications_enabled' => $articlesAuthor->comment_notifications_enabled
            ]);
            return; // Пользователь отписался от уведомлений
        }
        
        $commentAuthor = User::find($this->user_id);
        $data['articlesAuthorName'] = $articlesAuthor->name;
        $data['commentAuthorName'] = $commentAuthor->name;
        $data['article'] = $article;
        $data['comment'] = $this;
        $data['unsubscribeUrl'] = route('blog.unsubscribe_comment_notifications', [
            'email' => $articlesAuthor->email,
            'token' => hash_hmac('sha256', $articlesAuthor->email . $articlesAuthor->id, config('app.key'))
        ]);
        $email = $articlesAuthor->email;
        $subject = 'На Ampleev.com добавлен новый комментарий к вашей статье "';
        $subject .= $article->title;
        $subject .= '"';

        Mail::send('emails.comment_notification', $data, function ($message) use ($email, $subject) {
            $message->to($email)->subject($subject);
        });
    }

    public function commentsAuthorNotification()
    {
        $commentParent = Comment::find($this->comment_id);
        $commentsAuthor = User::find($commentParent->user_id);
        
        // Проверяем, включены ли уведомления для автора комментария
        // По умолчанию уведомления включены (true), если поле null или false - отключены
        // Используем !== true чтобы учесть и false, и null
        if ($commentsAuthor->comment_notifications_enabled !== true) {
            \Log::info('Comment notification skipped: user ' . $commentsAuthor->email . ' has notifications disabled', [
                'user_id' => $commentsAuthor->id,
                'comment_notifications_enabled' => $commentsAuthor->comment_notifications_enabled
            ]);
            return; // Пользователь отписался от уведомлений
        }
        
        $data['commentsAuthorName'] = $commentsAuthor->name;
        $data['authorName'] = User::find($this->user_id)->name;
        $article = Article::find($this->article_id);
        $data['article'] = $article;
        $data['comment'] = $this;
        $data['unsubscribeUrl'] = route('blog.unsubscribe_comment_notifications', [
            'email' => $commentsAuthor->email,
            'token' => hash_hmac('sha256', $commentsAuthor->email . $commentsAuthor->id, config('app.key'))
        ]);
        $email = $commentsAuthor->email;
        $subject = 'На Ampleev.com ответили на ваш комментарий к статье "';
        $subject .= $article->title;
        $subject .= '"';
        Mail::send('emails.comment_author_notification', $data, function ($message) use ($email, $subject) {
            $message->to($email)->subject($subject);
        });
    }
}
