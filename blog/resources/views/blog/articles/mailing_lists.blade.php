<div class="mb-4">
    <h5>Новости о новых публикациях</h5>
    <form action="/forms/mailchimp.php" data-form-email novalidate>
        <div class="form-row">
            <div class="col-12">
                <input type="email" class="form-control mb-2" placeholder="Email" name="email"
                       required>
            </div>
            <div class="col-12">
                <div class="d-none alert alert-success" role="alert" data-success-message>
                    Спасибо за ваш интерес, мы отправили вам на почту ссылку для подтверждения Она актуальна в течение
                    24 часов.
                </div>
                <div class="d-none alert alert-danger" role="alert" data-error-message>
                    Пожалуйста, используйте валидный email.
                </div>
                <div data-recaptcha data-sitekey="INSERT_YOUR_RECAPTCHA_V2_SITEKEY_HERE"
                     data-size="invisible" data-badge="bottomleft">
                </div>
                <button type="submit" class="btn btn-primary btn-loading btn-block"
                        data-loading-text="Sending">
                    <img class="icon" src="assets/img/icons/theme/code/loading.svg"
                         alt="loading icon"
                         data-inject-svg/>
                    <span>Подписаться</span>
                </button>
            </div>
        </div>
    </form>
    <small class="text-muted form-text">Мы никогда не раскроем ваши данные. Смотрите наши <a target="_blank"
                                                                                             href="{{route('docs.terms_of_use')}}">Пользовательское
            соглашение</a> и <a
                target="_blank"
                href="{{route('docs.terms_of_use')."#support"}}">Политику Конфиденциальности</a>
    </small>
</div>