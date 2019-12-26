@if($article->get_comments_counter() > 0)
    <hr>
    <h5 class="my-4">Всего комментариев: {{$article->get_comments_counter()}}</h5>
@endif
{!! $commentsHtml !!}
<script>
    document.addEventListener('click', e => {
        let element = e.target;
        let parent_element = element.parentNode.parentNode;
        // console.log('parent', parent_element);
        if (element.hasAttribute('to_give_an_answer_to_comment')) {
            element.style.display = 'none'; // скрываем кнопку ответить
            let form = document.getElementById('form_for_answer');// получили форму
            parent_element.append(form);
            form.style.display = 'block';
            let element_comment_id = form.firstElementChild.firstElementChild.nextElementSibling.firstElementChild.nextElementSibling.nextElementSibling;
            element_comment_id.setAttribute('value', element.dataset.answer_to_comment_id)
        }
    });
</script>
